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

$git = ModRedgit_CommitHelper::getGit();
$stationConfiguration = ModRedgit_CommitHelper::getStationConfiguration();

if (!$git || !$stationConfiguration)
{
	echo RedgitLayoutHelper::render('redgit.station.missing-setup');

	return;
}

require JModuleHelper::getLayoutPath('mod_redgit_commit', $params->get('layout', 'default'));
