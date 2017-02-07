<?php
/**
 * @package     Redgit.Library
 * @subpackage  Plugin
 *
 * @copyright   Copyright (C) 2015 - 2017 redcomponent.com. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE
 */

defined('_JEXEC') or die;

/**
 * Redgit layout renderer.
 *
 * @since  1.0.0
 */
class RedgitLayout extends RedgitLayoutFile
{
	/**
	 * Get the options
	 *
	 * @return  Registry  Object with the options
	 *
	 * @since   1.1.1
	 */
	public function getOptions()
	{
		// Always return a Registry instance
		if (!$this->options instanceof \Joomla\Registry\Registry && !$this->options instanceof JRegistry)
		{
			$this->resetOptions();
		}

		return $this->options;
	}

	/**
	 * Change the debug mode
	 *
	 * @param   boolean  $debug  Enable / Disable debug
	 *
	 * @return  void
	 *
	 * @since   1.1.1
	 */
	public function setDebug($debug)
	{
		$this->options->set('debug', (boolean) $debug);

		return $this;
	}
}
