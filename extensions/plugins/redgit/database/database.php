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

		$this->dumpPath = $this->getSqlFolder() . '/' . $dbName . '.sql';

		$command = "mysqldump -h " . $dbHost . " -u " . $dbUser
				. " -p'" . $dbPassword . "'"
				. " --default-character-set=utf8"
				. " " . $dbName . " --result-file=" . $this->dumpPath;

		exec($command, $output, $result);

		if ($result)
		{
			throw new Exception("Could not dump database: (" . $result . '): ' . implode("\n", $output));
		}

		return true;
	}

	/**
	 * Get the folder where SQL files will be stored.
	 *
	 * @return  string
	 *
	 * @since   1.0.3
	 */
	protected function getSqlFolder()
	{
		return JPATH_SITE . '/redgit/sql';
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

			$git->commit($this->getParams()->get('dump_commit_message', '[sql] Latest database'));
		}
		catch (Exception $e)
		{
			$this->_subject->setError($e->getMessage());

			return false;
		}

		return true;
	}

	/**
	 * Event to dump current database
	 *
	 * @param   string   $context  Context where this event is called from
	 * @param   boolean  $push     Push changes to remote server?
	 *
	 * @return  boolean
	 */
	public function onRedgitDumpDatabase($context, $push = false)
	{
		$stationConfig = Application::getStationConfiguration();

		if (!$stationConfig->get('db_dump_enabled', false))
		{
			$this->_subject->setError(JText::_('PLG_REDGIT_DATABASE_ERROR_DUMP_IS_DISABLED_FOR_THIS_STATION'));

			return false;
		}

		try
		{
			$this->dumpDatabase();

			$git = Application::getGit();

			$git->commit(
				$this->dumpPath,
				array(
					'm' => $this->getParams()->get('dump_commit_message', '[sql] Latest database')
				)
			);

			if ($push)
			{
				$git->push('origin', $stationConfig->get('git_branch', 'master'));
			}
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

		// Empty database first to
		try
		{
			$this->emptyDatabase();
		}
		catch (Exception $e)
		{
			throw new Exception($e->getMessage());
		}

		$this->dumpPath = $this->getSqlFolder() . '/' . $dbName . '.sql';

		$command = "mysql -h " . $dbHost . " -u " . $dbUser
				. " -p'" . $dbPassword . "'"
				. " --default-character-set=utf8"
				. " " . $dbName . " < " . $this->dumpPath;

		exec($command, $output, $result);

		if ($result)
		{
			throw new Exception("Could not dump database: (" . $result . '): ' . implode("\n", $output));
		}
	}

	/**
	 * Drop all the database tables
	 *
	 * @return  boolean
	 *
	 * @throws  RuntimeException  Something went wrong
	 */
	private function emptyDatabase()
	{
		$db = JFactory::getDbo();

		$db->setQuery('SET foreign_key_checks = 0;')->execute();

		// Get the tables in the database.
		$tables = $db->getTableList();

		if ($tables)
		{
			foreach ($tables as $table)
			{
				try
				{
					$db->dropTable($table);
				}
				catch (RuntimeException $e)
				{
					$message = JText::sprintf('PLG_REDGIT_DATABASE_ERROR_DROPPING_TABLE', $table);

					throw new RuntimeException($message);

					return false;
				}
			}
		}

		$db->setQuery('SET foreign_key_checks = 1;')->execute();

		return true;
	}
}
