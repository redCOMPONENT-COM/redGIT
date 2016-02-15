<?php
/**
 * @package     Redgit.Module
 * @subpackage  Admin.mod_redgit_log
 *
 * @copyright   Copyright (C) 2015 - 2016 redcomponent.com. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE
 */

defined('_JEXEC') or die;

require_once __DIR__ . '/helper.php';

$moduleclass_sfx = htmlspecialchars($params->get('moduleclass_sfx'));

$canDump    = ModRedgit_DatabaseHelper::canDump();
$canRestore = ModRedgit_DatabaseHelper::canRestore();
$git        = ModRedgit_DatabaseHelper::getGit();

if (!$git)
{
	echo RedgitLayoutHelper::render('redgit.station.missing-setup');

	return;
}

if (!$canRestore && !$canDump)
{
	echo JText::_('LIB_REDGIT_STATION_MSG_NO_ACTIONS_AVAILABLE');

	return;
}

require JModuleHelper::getLayoutPath('mod_redgit_database', $params->get('layout', 'default'));
