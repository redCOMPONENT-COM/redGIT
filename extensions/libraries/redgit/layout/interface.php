<?php
/**
 * @package     Joomla.Libraries
 * @subpackage  Layout
 *
 * @copyright   Copyright (C) 2015 - 2021 redWEB.dk. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('JPATH_PLATFORM') or die;

/**
 * Interface to handle display layout
 *
 * @see    https://docs.joomla.org/Sharing_layouts_across_views_or_extensions_with_JLayout
 * @since  3.0
 */
interface RedgitLayoutInterface
{
	/**
	 * Method to escape output.
	 *
	 * @param   string  $output  The output to escape.
	 *
	 * @return  string  The escaped output.
	 *
	 * @since   3.0
	 */
	public function escape($output);

	/**
	 * Method to render the layout.
	 *
	 * @param   object  $displayData  Object which properties are used inside the layout file to build displayed output
	 *
	 * @return  string  The rendered layout.
	 *
	 * @since   3.0
	 */
	public function render($displayData);
}
