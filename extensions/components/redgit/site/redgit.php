<?php
/**
 * @package     Redgit.Frontend
 * @subpackage  Entry
 *
 * @copyright   Copyright (C) 2015 - 2017 redcomponent.com. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE
 */

defined('_JEXEC') or die;

JLoader::import('redgit.library');

// Register component prefix
JLoader::registerPrefix('Redgit', __DIR__);

$lang = JFactory::getLanguage();
$lang->load('com_redgit', __DIR__);

$app = JFactory::getApplication();

// Instanciate and execute the front controller
$controller = JControllerLegacy::getInstance('Redgit');
$controller->execute($app->input->get('task'));
$controller->redirect();
