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

try
{
	$git = Application::getGit();
}
catch (Exception $e)
{
	echo RedgitLayoutHelper::render('redgit.error', array('message' => $e->getMessage()));

	return;
}

$moduleclass_sfx = htmlspecialchars($params->get('moduleclass_sfx'));

$stationConfiguration = Application::getStationConfiguration();

if (!$git || !$stationConfiguration)
{
	echo RedgitLayoutHelper::render('redgit.station.missing-setup');

	return;
}

if ((int) $stationConfiguration->get('git_push_enabled', 0) === 0)
{
	echo JText::_('LIB_REDGIT_STATION_MSG_NO_ACTIONS_AVAILABLE');

	return;
}

require JModuleHelper::getLayoutPath('mod_redgit_commit', $params->get('layout', 'default'));
