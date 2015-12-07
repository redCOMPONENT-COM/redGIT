<?php
/**
 * @package     Redgit.Module
 * @subpackage  Admin.mod_redgit_log
 *
 * @copyright   Copyright (C) 2015 redCOMPONENT.com. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE
 */

defined('_JEXEC') or die;

use Redgit\Application;

/**
 * Module Helper.
 *
 * @since  1.0.0
 */
abstract class ModRedgit_DatabaseHelper
{
	/**
	 * Get the git log
	 *
	 * @return  string
	 */
	public static function getGitLog()
	{
		try
		{
			$git = Application::getGit();
			$git->log("-15", "--pretty=format:'%h - %s (%cr) | %an'", "--abbrev-commit", "--date=relative");
			$log = $git->getOutput();
		}
		catch (Exception $e)
		{
			$log = $e->getMessage();
		}

		return $log;
	}
}
