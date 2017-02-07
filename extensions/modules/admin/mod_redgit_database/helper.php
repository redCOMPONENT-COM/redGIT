<?php
/**
 * @package     Redgit.Module
 * @subpackage  Admin.mod_redgit_log
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
abstract class ModRedgit_DatabaseHelper
{
	/**
	 * Can this station restore database?
	 *
	 * @return  boolean
	 */
	public static function canDump()
	{
		$stationConfig = Application::getStationConfiguration();

		return ((int) $stationConfig->get('db_dump_enabled') === 1);
	}

	/**
	 * Can this station restore database?
	 *
	 * @return  boolean
	 */
	public static function canRestore()
	{
		$stationConfig = Application::getStationConfiguration();

		return ((int) $stationConfig->get('db_restore_enabled') === 1);
	}
}
