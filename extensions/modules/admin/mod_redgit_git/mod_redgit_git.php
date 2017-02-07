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

if (!$git)
{
	echo RedgitLayoutHelper::render('redgit.station.missing-setup');

	return;
}

require JModuleHelper::getLayoutPath('mod_redgit_git', $params->get('layout', 'default'));
