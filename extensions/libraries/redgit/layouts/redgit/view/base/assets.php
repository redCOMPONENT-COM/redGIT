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

$view  = $displayData['view'];
$app   = JFactory::getApplication();
$input = $app->input;
$doc   = JFactory::getDocument();

// Load a custom CSS option for this component if exists
if ($comOption = $input->get('option', null))
{
	AssetHelper::load(($app->isAdmin() ? 'admin' : 'site') . '.min.css', $comOption);
}

// Move the message to the specified position
$doc->addScriptDeclaration("
	(function( $ ) {
		$(function(){
			$('.message-sys').append($('#system-message-container'));
		});
	})( jQuery );
");
