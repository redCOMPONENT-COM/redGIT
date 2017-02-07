<?php
/**
 * @package     Redgit.Library
 * @subpackage  Helper
 *
 * @copyright   Copyright (C) 2015 - 2017 redcomponent.com. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE
 */

defined('_JEXEC') or die;

use Redgit\Application;

/**
 * Layout helper.
 *
 * @since  1.0.0
 */
class RedgitLayoutHelper
{
	/**
	 * Fast method to debug the layout.
	 *
	 * @param   string  $layoutId  Identifier of the layout to load
	 * @param   object  $data      Object which properties are used inside the layout file to build displayed output
	 *
	 * @return  string
	 */
	public static function debug($layoutId, $data = array())
	{
		return Application::getRenderer($layoutId)->debug($data);
	}

	/**
	 * Fast method to render a layout.
	 *
	 * @param   string  $layoutId  Identifier of the layout to load
	 * @param   object  $data      Object which properties are used inside the layout file to build displayed output
	 *
	 * @return  string
	 */
	public static function render($layoutId, $data = array())
	{
		return Application::getRenderer($layoutId)->render($data);
	}
}
