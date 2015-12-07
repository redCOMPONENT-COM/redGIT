<?php
/**
 * @package     Redgit.Plugin
 * @subpackage  Redgit.Bitbucket
 *
 * @copyright   Copyright (C) 2015 redCOMPONENT.com. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE
 */

defined('_JEXEC') or die;

require_once JPATH_LIBRARIES . '/redgit/library.php';

use Redgit\Plugin\RedgitPlugin;
use Redgit\Application;

/**
 * Bitbucket plugin for redGIT.
 *
 * @since  1.0.0
 */
class PlgRedgitDatabase extends RedgitPlugin
{
	/**
	 * Path to the DB dump
	 *
	 * @var  string
	 */
	protected $dumpPath;

	/**
	 * Dump the MySQL database
	 *
	 * @return  boolean
	 *
	 * @throws  Exception  Database config was not found or there was an error
	 */
	protected function dumpDatabase()
	{
		$config = JFactory::getConfig();

		$dbHost     = $config->get('host');
		$dbUser     = $config->get('user');
		$dbPassword = $config->get('password');
		$dbName     = $config->get('db');

		if (!$dbHost || !$dbUser || !$dbPassword || !$dbName)
		{
			throw new Exception("Could not load database information");
		}

		$this->dumpPath = JPATH_SITE . '/flow/sql/' . $dbName . '.sql';

		$command = "mysqldump -h " . $dbHost . " -u " . $dbUser
				. " -p'" . $dbPassword . "'"
				. " " . $dbName . " > " . $this->dumpPath;

		exec($command, $output, $result);

		if ($result)
		{
			throw new Exception("Could not dump database: (" . $result . '): ' . implode("\n", $output));
		}

		return true;
	}

	/**
	 * Event triggered before a commit is sent
	 *
	 * @param   string                      $context    Context that describes where this has been triggered from
	 * @param   \Redgit\Git\GitWorkingCopy  $git        Git stream
	 * @param   array                       $arguments  Arguments of the push command
	 *
	 * @return  boolean
	 */
	public function onRedgitBeforePush($context, $git, $arguments)
	{
		$stationConfig = Application::getStationConfiguration();

		if (!$stationConfig->get('db_dump_enabled', false))
		{
			return true;
		}

		try
		{
			$this->dumpDatabase();
			$git->add($this->dumpPath);

			$git->commit($params->get('dump_commit_message', '[sql] Latest database'));
		}
		catch (Exception $e)
		{
			$this->_subject->setError($e->getMessage());

			return false;
		}

		return true;
	}

	/**
	 * Event to restore current database
	 *
	 * @param   string  $context  Context where this event is called from
	 *
	 * @return  boolean
	 */
	public function onRedgitRestoreDatabase($context)
	{
		$stationConfig = Application::getStationConfiguration();

		if (!$stationConfig->get('db_restore_enabled', false))
		{
			$this->_subject->setError(JText::_('PLG_REDGIT_DATABASE_ERROR_RESTORE_IS_DISABLED_FOR_THIS_STATION'));

			return false;
		}

		try
		{
			$this->restoreDatabase();
		}
		catch (Exception $e)
		{
			$this->_subject->setError($e->getMessage());

			return false;
		}

		return true;
	}

	/**
	 * Restore joomla database from the latest dump
	 *
	 * @return  boolean
	 *
	 * @throws  Exception  Error found restoring database
	 */
	protected function restoreDatabase()
	{
		$config = JFactory::getConfig();

		$dbHost     = $config->get('host');
		$dbUser     = $config->get('user');
		$dbPassword = $config->get('password');
		$dbName     = $config->get('db');

		if (!$dbHost || !$dbUser || !$dbPassword || !$dbName)
		{
			throw new Exception("Could not load database information");
		}

		$this->dumpPath = JPATH_SITE . '/flow/sql/' . $dbName . '.sql';

		$command = "mysql -h " . $dbHost . " -u " . $dbUser
				. " -p'" . $dbPassword . "'"
				. " " . $dbName . " < " . $this->dumpPath;

		exec($command, $output, $result);

		if ($result)
		{
			throw new Exception("Could not dump database: (" . $result . '): ' . implode("\n", $output));
		}
	}
}
