<?php
/**
 * @package     Redgit.Module
 * @subpackage  Admin.mod_redgit_commit
 *
 * @copyright   Copyright (C) 2015 - 2016 redcomponent.com. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE
 */

defined('_JEXEC') or die;

use Redgit\Application;

/**
 * Module Helper.
 *
 * @since  1.0.0
 */
abstract class ModRedgit_RemoteHelper
{
	/**
	 * Can this station pull files?
	 *
	 * @return  boolean
	 */
	public static function canPull()
	{
		$stationConfig = Application::getStationConfiguration();

		return ((int) $stationConfig->get('git_pull_enabled') === 1);
	}

	/**
	 * Can this station push files?
	 *
	 * @return  boolean
	 */
	public static function canPush()
	{
		$stationConfig = Application::getStationConfiguration();

		return ((int) $stationConfig->get('git_push_enabled') === 1);
	}

	/**
	 * Get the git instance
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

	/**
	 * Get the station configuration
	 *
	 * @return  \Redgit\Station\Configuration
	 */
	public static function getStationConfiguration()
	{
		return Application::getStationConfiguration();
	}
}
