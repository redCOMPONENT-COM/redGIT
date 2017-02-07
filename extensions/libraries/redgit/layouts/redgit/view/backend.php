<?php
/**
 * @package     Redgit.Backend
 * @subpackage  Layout
 *
 * @copyright   Copyright (C) 2015 - 2017 redcomponent.com. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE
 */

defined('_JEXEC') or die;

extract($displayData);

/**
 * Avaliable variables
 * --------------------
 * 	$content : (string) HTML content to embed
 * 	$title   : (string) Component title
 * 	$view    : (JViewLegacy) View to render
 */

$app = JFactory::getApplication();
$input = $app->input;
$format = $input->getString('format');

/**
 * Raw format
 */
if ('raw' === $format)
{
	// Get the view render.
	return $content;
}

// Assets
echo RedgitLayoutHelper::render(
	'redgit.view.base.assets',
	array(
		'view' => $view
	)
);

$toolbar = $view->getToolbar();

// Render the view
if ($content instanceof Exception)
{
	return $content;
}

// Layout for modal view
if ($view->getLayout() === 'modal')
{
	echo RedgitLayoutHelper::render(
		'redgit.view.base.modal',
		array(
			'view' => $view,
			'content' => $content
		)
	);
}

// Component view
else
{
	echo RedgitLayoutHelper::render(
		'redgit.view.base.main',
		array(
			'view' => $view,
			'content' => $content
		)
	);
}
