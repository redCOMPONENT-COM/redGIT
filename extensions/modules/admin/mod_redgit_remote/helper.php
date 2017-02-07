<?php
/**
 * @package     Redgit.Module
 * @subpackage  Admin.mod_redgit_commit
 *
 * @copyright   Copyright (C) 2015 - 2017 redcomponent.com. All rights reserved.
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
}
