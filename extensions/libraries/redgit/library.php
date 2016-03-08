<?php
/**
 * @package    Redgit.Library
 *
 * @copyright  Copyright (C) 2015 redCOMPONENT.com. All rights reserved.
 * @license    GNU General Public License version 2 or later; see LICENSE
 */

defined('_JEXEC') or die;

$composerAutoload = __DIR__ . '/vendor/autoload.php';

if (file_exists($composerAutoload))
{
	require_once $composerAutoload;
}

JLoader::setup();
JLoader::registerPrefix('Redgit', __DIR__);

if (version_compare(JVERSION, '3.0', 'lt'))
{
	JLoader::import('joomla.database.table');
}

// Html helpers
JHtml::addIncludePath(__DIR__ . '/html');

// Fields
JFormHelper::addFieldPath(__DIR__ . '/form/field');

// Make available the booking form rules
JFormHelper::addRulePath(__DIR__ . '/form/rule');

JTable::addIncludePath(JPATH_ADMINISTRATOR . '/components/com_redgit/tables');

JLog::addLogger(
	array(
		'text_file' => 'redgit.log.php'
	),
	JLog::ALL,
	array('redgit')
);

// Load library language
$lang = JFactory::getLanguage();
$lang->load('lib_redgit', __DIR__);
