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
abstract class ModRedgit_GitHelper
{
	/**
	 * Get the git log
	 *
	 * @return  string
	 */
	public static function getGit()
	{
		try
		{
			$git = Application::getGit();
		}
		catch (Exception $e)
		{
			return null;
		}

		return $git;
	}
}
