<?php
/**
 * @package     Redgit.Library
 * @subpackage  Layout
 *
 * @copyright   Copyright (C) 2015 - 2017 redcomponent.com. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE
 */

defined('_JEXEC') or die;

use Redgit\Helper\AssetHelper;
use Redgit\Application;

$view  = $displayData['view'];
$app   = JFactory::getApplication();
$input = $app->input;
$doc   = Application::getDocument();

// Load a custom CSS option for this component if exists
if ($comOption = $input->get('option', null))
{
	AssetHelper::load(($app->isAdmin() ? 'backend' : 'site') . '.min.css', $comOption);
	$doc->addTopScript(JUri::root(true) . '/media/com_redgit/js/backend.js');
}

// Move the message to the specified position
$doc->addScriptDeclaration("
	(function( $ ) {
		$(function(){
			$('.message-sys').append($('#system-message-container'));
		});
	})( jQuery );
");

// Disable template shit
$template = JFactory::getApplication()->getTemplate();

$doc->disableStylesheet('administrator/templates/' . $template . '/css/template.css');
$doc->disableStylesheet('templates/' . $template . '/css/template.css');
$doc->disableScript('administrator/templates/' . $template . '/js/template.js');
$doc->disableScript('templates/' . $template . '/js/template.js');

// Disable core things
$doc->disableScript('media/jui/js/jquery.min.js');
$doc->disableScript('media/jui/js/jquery-noconflict.js');
$doc->disableScript('media/jui/js/jquery-migrate.min.js');
$doc->disableScript('media/jui/js/bootstrap.min.js');
$doc->disableScript('media/system/js/mootools-core.js');
