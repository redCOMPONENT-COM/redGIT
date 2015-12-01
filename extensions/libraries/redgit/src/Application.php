<?php
/**
 * @package     Redgit.Library
 * @subpackage  Application
 *
 * @copyright   Copyright (C) 2015 redcomponent.com. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE
 */

namespace Redgit;

defined('_JEXEC') or die;

use Redgit\Git\GitWrapper;
use Monolog\Logger;
use Redgit\Monolog\PhpfileHandler;

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
	 * Initialise the git connection
	 *
	 * @return  void
	 *
	 * @throws  \Exception  Something when wrong trying to initialise the repo
	 */
	protected static function initGit()
	{
		$config = static::getConfig();
		$log    = static::getLog();

		$repository = $config->get('git_repository');

		if (!$repository || !is_dir($repository))
		{
			$message = \JText::sprintf("LIB_REDGIT_GIT_ERROR_INVALID_REPOSITORY", $repository);

			$log->addError($message);

			throw new \Exception($message);
		}

		$branch = $config->get('git_branch');

		if (!$branch)
		{
			$message = "Missing Git branch name. Check component settings.";

			$log->addError($message);

			throw new \Exception($message);
		}

		$privateKey = $config->get('ssh_private_key');

		if (!$privateKey || !file_exists($privateKey))
		{
			$message = "Missing or not valid private SSH KEY. Check component settings.";

			$log->addError($message);

			throw new \Exception($message);
		}

		$gitWrapper = new GitWrapper;
		$gitWrapper->setPrivateKey($privateKey);

		$git = $gitWrapper->workingCopy($repository);

		// User configuration not set try to set it from settings
		if (empty($git->config('user.name')) || empty($git->config('user.email')))
		{
			$userName  = $config->get('git_user');
			$userEmail = $config->get('git_email');

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
