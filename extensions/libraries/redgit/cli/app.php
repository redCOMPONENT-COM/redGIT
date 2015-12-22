<?php
/**
 * @package     Redgit.Cli
 * @subpackage  Joomla Required
 *
 * @copyright   Copyright (C) 2012 - 2015 redCOMPONENT.com. All rights reserved.
 * @license     GNU General Public License version 2 or later, see LICENSE.
 */

defined('_JEXEC') or die;

/**
 * Base Cli application.
 *
 * @since  1.0.7
 */
class RedgitCliApp extends JApplicationCli
{
	/**
	 * Gets the value of a user state variable.
	 *
	 * @param   string  $key      The key of the user state variable.
	 * @param   string  $request  The name of the variable passed in a request.
	 * @param   string  $default  The default value for the variable if not found. Optional.
	 * @param   string  $type     Filter for the variable, for valid values see {@link JFilterInput::clean()}. Optional.
	 *
	 * @return  object  The request user state.
	 */
	public function getUserStateFromRequest($key, $request, $default = null, $type = 'none')
	{
		return $default;
	}

	/**
	 * Gets the template.
	 *
	 * @return  string  The template
	 */
	public function getTemplate()
	{
		return 'system';
	}

	/**
	 * Stub method for allow cache.
	 *
	 * @return  void
	 */
	public function allowCache()
	{
	}

	/**
	 * Stub method for set header.
	 *
	 * @return  void
	 */
	public function setHeader()
	{
	}

	/**
	 * Sets the body.
	 *
	 * @param   string  $data  The data
	 *
	 * @return  void
	 */
	public function setBody($data)
	{
		$this->body = $data;
	}

	/**
	 * Returns a string representation of the app.
	 *
	 * @return  string  The string
	 */
	public function toString()
	{
		return $this->body;
	}
}
