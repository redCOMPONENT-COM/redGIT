<?php
/**
 * @package     Redgit.Library
 * @subpackage  Plugin
 *
 * @copyright   Copyright (C) 2015 - 2017 redcomponent.com. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE
 */

namespace Redgit\Plugin;

defined('_JEXEC') or die;

/**
 * Base plugin for redGIT.
 *
 * @since  1.0.0
 */
class RedgitPlugin extends \JPlugin
{
	/**
	 * Load the language file on instantiation.
	 *
	 * @var    boolean
	 */
	protected $autoloadLanguage = true;

	/**
	 * Plugin parameters
	 *
	 * @var  JRegistry
	 */
	public $params = null;

	/**
	 * function to get the plugin parameters
	 *
	 * @return  \JRegistry  The plugin parameters object
	 */
	protected function getParams()
	{
		if (is_null($this->params))
		{
			$plugin = \JPluginHelper::getPlugin($this->_type, $this->_name);
			$this->params = new \JRegistry($plugin->params);
		}

		return $this->params;
	}

	/**
	 * Check if this plugin has a public method
	 *
	 * @param   string  $method  Method name
	 *
	 * @return  boolean
	 */
	protected function hasPlublicMethod($method)
	{
		$reflection = new \ReflectionMethod($this, $sMethod);

		return $reflection->isPublic();
	}

	/**
	 * Check if received plugin is this
	 *
	 * @param   string  $name  Plugin name
	 *
	 * @return  boolean
	 */
	protected function isPlugin($name)
	{
		return ($this->_name === $name);
	}
}
