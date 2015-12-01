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
	 * @return  void
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
	 * @param   string                      $context  Context that describes where this has been triggered from
	 * @param   \Redgit\Git\GitWorkingCopy  $git      Git stream
	 *
	 * @return  boolean
	 */
	public function onRedgitBeforePush($context, $git)
	{
		$params = $this->getParams();

		if (!$params->get('dump_enabled'))
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
}
