<?php
/**
 * @package     Redgit.Module
 * @subpackage  Admin.mod_redgit_commit
 *
 * @copyright   Copyright (C) 2015 redCOMPONENT.com. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE
 */

defined('_JEXEC') or die;

require_once __DIR__ . '/helper.php';

$moduleclass_sfx = htmlspecialchars($params->get('moduleclass_sfx'));

$git = ModRedgit_RemoteHelper::getGit();
$stationConfiguration = ModRedgit_RemoteHelper::getStationConfiguration();
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
