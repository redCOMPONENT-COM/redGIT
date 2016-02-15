<?php
/**
 * @package     Redgit.Library
 * @subpackage  Application
 *
 * @copyright   Copyright (C) 2015 - 2016 redcomponent.com. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE
 */

namespace Redgit;

defined('_JEXEC') or die;

use Redgit\Git\GitWrapper;
use Monolog\Logger;
use Redgit\Monolog\PhpfileHandler;
use Redgit\Station\Configuration;
use Redgit\Document;

/**
 * Application class
 *
 * @since  1.0.0
 */
abstract class Application
{
	/**
	 * Component option.
	 *
	 * @var  string
	 */
	protected static $component = 'com_redgit';

	/**
	 * Component configuration
	 *
	 * @var  JRegistry
	 */
	protected static $config;

	/**
	 * Document handling class
	 *
	 * @var  \Redgit\Document
	 */
	protected static $document = null;

	/**
	 * Git repository connection
	 *
	 * @var  \Redgit\Git;
	 */
	protected static $git;

	/**
	 * Get the log
	 *
	 * @var  \Monolog\Logger
	 */
	protected static $log;

	/**
	 * Current station configuration
	 *
	 * @var  \Redgit\Station\Configuration
	 */
	protected static $stationConfiguration;

	/**
	 * Get the configuration
	 *
	 * @return  mixed  \Joomla\Registry\Registry | JRegistry depending on the Joomla! version
	 */
	public static function getConfig()
	{
		if (null === static::$config)
		{
			static::$config = \JComponentHelper::getParams(static::$component);
		}

		return static::$config;
	}

	/**
	 * Get the active document or instance it if not loaded
	 *
	 * @return  \Redgit\Document
	 */
	public static function getDocument()
	{
		if (null === static::$document)
		{
			static::$document = new Document;
		}

		return static::$document;
	}

	/**
	 * Get the git connection
	 *
	 * @return  \Redgit\Git
	 *
	 * @throws  Exception  Something when wrong initialising the repo
	 */
	public static function getGit()
	{
		if (null === static::$git)
		{
			static::initGit();
		}

		return static::$git;
	}

	/**
	 * Get the log
	 *
	 * @return  \Monolog\Logger
	 *
	 * @throws  Exception   Log folder does not exist or is not writable
	 */
	public static function getLog()
	{
		if (null === static::$log)
		{
			$logDir = \JFactory::getConfig()->get('log_path');

			if (!is_writable($logDir))
			{
				throw new \Exception("redGIT: Cannot write to log folder. Check configuration: " . $logDir, 500);
			}

			$log = new Logger('redgit');
			$log->pushHandler(new PhpfileHandler($logDir . '/redgit.error.php', Logger::ERROR));

			static::$log = $log;
		}

		return static::$log;
	}

	/**
	 * Get an instance of the active renderer
	 *
	 * @param   string  $layoutId  Layout identifier
	 *
	 * @return  RedgitLayout
	 */
	public static function getRenderer($layoutId = 'default')
	{
		$renderer = new \RedgitLayout($layoutId);

		$renderer->setIncludePaths(static::getLayoutPaths());

		return $renderer;
	}

	/**
	 * Get the default layout search paths.
	 *
	 * @return  array
	 */
	public static function getLayoutPaths()
	{
		$app = \JFactory::getApplication();

		$template  = $app->getTemplate();

		return array(
			JPATH_THEMES . '/' . $template . '/html/layouts/' . static::$component,
			($app->isSite() ? JPATH_SITE : JPATH_ADMINISTRATOR) . '/components/' . static::$component . '/layouts',
			JPATH_THEMES . '/' . $template . '/html/layouts',
			JPATH_LIBRARIES . '/redgit/layouts',
			JPATH_ROOT . '/layouts'
		);
	}

	/**
	 * Gets the current station configuration
	 *
	 * @return  \Redgit\Station\Configuration
	 */
	public static function getStationConfiguration()
	{
		if (null === static::$stationConfiguration)
		{
			static::$stationConfiguration = new Configuration;
		}

		return static::$stationConfiguration;
	}

	/**
	 * Initialise the git connection
	 *
	 * @return  void
	 *
	 * @throws  \Exception  Something when wrong trying to initialise the repo
	 */
	protected static function initGit()
	{
		static::$git = false;

		$config = static::getConfig();
		$stationConfig = static::getStationConfiguration();
		$log    = static::getLog();

		$repository = $stationConfig->get('git_repository');

		if (!$repository || !is_dir($repository))
		{
			$message = \JText::sprintf("LIB_REDGIT_GIT_ERROR_INVALID_REPOSITORY", $repository);

			$log->addError($message);

			throw new \Exception($message);
		}

		$branch = $stationConfig->get('git_branch');

		if (!$branch)
		{
			$message = "Missing Git branch name. Check component settings.";

			$log->addError($message);

			throw new \Exception($message);
		}

		$privateKey = $stationConfig->get('ssh_private_key');

		if (!$privateKey || !file_exists($privateKey))
		{
			$message = "Missing or not valid private SSH KEY. Check component settings.";

			$log->addError($message);

			throw new \Exception($message);
		}

		$sshPort = (int) $stationConfig->get('ssh_port');

		if (!$sshPort)
		{
			$sshPort = 22;
		}

		$binWrapperPath = $stationConfig->get('ssh_wrapper_folder');

		if (empty($binWrapperPath))
		{
			$binWrapperPath = null;
		}
		else
		{
			$binWrapperPath .= '/git-ssh-wrapper.sh';
		}

		try
		{
			$gitWrapper = new GitWrapper;
			$gitWrapper->setPrivateKey($privateKey, $sshPort, $binWrapperPath);

			$git = $gitWrapper->workingCopy($repository);
		}
		catch (\GitWrapper\GitException $e)
		{
			$message = 'Exception initialising Git: ' . $e->getMessage();

			$log->addError($message);

			throw new \Exception($message);
		}

		$gitUserName  = $git->getConfigSetting('user.name');
		$gitUserEmail = $git->getConfigSetting('user.email');

		// User configuration not set try to set it from settings
		if (empty($gitUserName) || empty($gitUserEmail))
		{
			$userName  = $stationConfig->get('git_user');
			$userEmail = $stationConfig->get('git_email');

			if (!$userName || !$userEmail)
			{
				$message = "Missing Git user name or email. Check component settings.";

				$log->addError($message);

				throw new \Exception($message);
			}

			$git->config('user.name', $userName);
			$git->config('user.email', $userEmail);
		}

		static::$git = $git;
	}
}
