<?php
/**
 * @package     Redgit.Plugin
 * @subpackage  Redgit.Bitbucket
 *
 * @copyright   Copyright (C) 2015 - 2017 redcomponent.com. All rights reserved.
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
	 * @throws  RuntimeException  Database config was not found or there was an error
	 */
	protected function dumpDatabase()
	{
		$dbName = JFactory::getConfig()->get('db');
		$oldDump = $this->getDumpFolder() . '/' . $dbName . '.sql';

		if (file_exists($oldDump) && !unlink($oldDump))
		{
			throw new RuntimeException("Unable to delete old db dump");
		}

		$dbStructureFile = $this->getDumpFolder() . '/' . $dbName . '_structure.sql';
		$dbDataFile = $this->getDumpFolder() . '/' . $dbName . '_data.sql';

		$this->dumpDatabaseStructure($dbStructureFile);
		$this->dumpDatabaseData($dbDataFile);

		return true;
	}

	/**
	 * Dump database structure.
	 *
	 * @param   string  $dumpPath  Path to the file where to store information
	 *
	 * @return  boolean
	 *
	 * @throws  RuntimeException
	 *
	 * @since   1.1.0
	 */
	private function dumpDatabaseStructure($dumpPath)
	{
		$config = JFactory::getConfig();

		$dbHost     = $config->get('host');
		$dbUser     = $config->get('user');
		$dbPassword = $config->get('password');
		$dbName     = $config->get('db');

		if (!$dbHost || !$dbUser || !$dbPassword || !$dbName)
		{
			throw new RuntimeException("Could not load database information");
		}

		$command = "mysqldump -h " . $dbHost . " -u " . $dbUser
				. " -p'" . $dbPassword . "'"
				. " --default-character-set=utf8"
				. " --routines --no-data"
				. " " . $dbName . " --result-file=" . $dumpPath;

		exec($command, $output, $result);

		if ($result)
		{
			throw new RuntimeException("Could not dump database: (" . $result . '): ' . implode("\n", $output));
		}

		return true;
	}

	/**
	 * Dump database data.
	 *
	 * @param   string  $dumpPath  Path to the file where to store information
	 *
	 * @return  boolean
	 *
	 * @throws  RuntimeException
	 *
	 * @since   1.1.0
	 */
	private function dumpDatabaseData($dumpPath)
	{
		$config = JFactory::getConfig();
		$params = $this->getParams();

		$dbHost     = $config->get('host');
		$dbUser     = $config->get('user');
		$dbPassword = $config->get('password');
		$dbName     = $config->get('db');

		if (!$dbHost || !$dbUser || !$dbPassword || !$dbName)
		{
			throw new RuntimeException("Could not load database information");
		}

		$command = "mysqldump -h " . $dbHost . " -u " . $dbUser
				. " -p'" . $dbPassword . "'"
				. " --default-character-set=utf8"
				. " --no-create-info"
				. " " . $dbName . " --result-file=" . $dumpPath;

		$excludedTablesData = array_filter((array) $params->get('db_exclude_tables_data', array()));

		foreach ($excludedTablesData as $tableName)
		{
			$command .= " --ignore-table=" . $dbName . '.' . $tableName;
		}

		exec($command, $output, $result);

		if ($result)
		{
			throw new RuntimeException("Could not dump database: (" . $result . '): ' . implode("\n", $output));
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

			$git->add($this->getDumpFolder());

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
	 * @param   boolean  $commit   Commit database after creating the dump?
	 * @param   boolean  $push     Push changes to remote server?
	 *
	 * @return  boolean
	 */
	public function onRedgitDumpDatabase($context, $commit = true, $push = false)
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

			if ($commit)
			{
				$git = Application::getGit();

				$git->add($this->getDumpFolder());

				$git->commit($this->getParams()->get('dump_commit_message', '[sql] Latest database'));

				if ($push)
				{
					$git->push('origin', $stationConfig->get('git_branch', 'master'));
				}
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
		// Empty database before
		try
		{
			$this->emptyDatabase();
		}
		catch (Exception $e)
		{
			throw new RuntimeException($e->getMessage());
		}

		$dbName = JFactory::getConfig()->get('db');
		$oldDump = $this->getDumpFolder() . '/' . $dbName . '.sql';

		if (file_exists($oldDump))
		{
			return $this->restoreDatabaseDump($oldDump);
		}

		$dbStructureFile = $this->getDumpFolder() . '/' . $dbName . '_structure.sql';
		$dbDataFile = $this->getDumpFolder() . '/' . $dbName . '_data.sql';

		$this->restoreDatabaseDump($dbStructureFile);
		$this->restoreDatabaseDump($dbDataFile);

		return true;
	}

	/**
	 * Restore a database dump
	 *
	 * @param   string  $dumpFile  File to restore
	 *
	 * @return  boolean
	 *
	 * @throws  RuntimeException
	 *
	 * @since   1.1.0
	 */
	private function restoreDatabaseDump($dumpFile)
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

		if (!file_exists($dumpFile))
		{
			throw new RuntimeException("Dump file does not exist");
		}

		$command = "mysql -h " . $dbHost . " -u " . $dbUser
				. " -p'" . $dbPassword . "'"
				. " --default-character-set=utf8"
				. " " . $dbName . " < " . $dumpFile;

		exec($command, $output, $result);

		if ($result)
		{
			throw new RuntimeException("Could not restore database dump: (" . $dumpFile . '): ' . implode("\n", $output));
		}

		return true;
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

	/**
	 * Get the base dump folder.
	 *
	 * @return  string
	 *
	 * @throws  RuntimeException
	 *
	 * @since   1.1.0
	 */
	private function getDumpFolder()
	{
		$dumpFolder = JPATH_SITE . '/redgit/sql';

		if (!is_dir($dumpFolder) && !mkdir($dumpFolder, 0755, true))
		{
			throw new RuntimeException("Dump folder does not exist");
		}

		return $dumpFolder;
	}
}
