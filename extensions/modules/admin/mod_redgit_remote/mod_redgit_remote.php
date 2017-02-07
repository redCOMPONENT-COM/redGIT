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

require_once __DIR__ . '/helper.php';

$moduleclass_sfx = htmlspecialchars($params->get('moduleclass_sfx'));

$stationConfiguration = Application::getStationConfiguration();
$canPull = ModRedgit_RemoteHelper::canPull();
$canPush = ModRedgit_RemoteHelper::canPush();

if (!$git || !$stationConfiguration)
{
	echo RedgitLayoutHelper::render('redgit.station.missing-setup');

	return;
}

if (!$canPull && !$canPush)
{
	echo JText::_('LIB_REDGIT_STATION_MSG_NO_ACTIONS_AVAILABLE');

	return;
}

require JModuleHelper::getLayoutPath('mod_redgit_remote', $params->get('layout', 'default'));
