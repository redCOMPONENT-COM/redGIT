<?php
/**
 * @package     Redgit.Library
 * @subpackage  Plugin
 *
 * @copyright   Copyright (C) 2015 - 2017 redcomponent.com. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE
 */

namespace Redgit\Station;

defined('_JEXEC') or die;

/**
 * Station entity.
 *
 * @since  1.0
 */
class Configuration
{
	/**
	 * @var  string
	 */
	protected $hostname;

	/**
	 * Configuration
	 *
	 * @var  stdClass
	 */
	protected $config;

	/**
	 * Constructor
	 *
	 * @param   string  $hostname  Identifier of the active station
	 */
	public function __construct($hostname = null)
	{
		if (null === $hostname)
		{
			$hostname = gethostname();
		}

		$hostname = \JFile::makeSafe($hostname);

		if (!$hostname)
		{
			throw new \UnexpectedArgumentException("Invalid hostname: " . $hostname);
		}

		$this->hostname = $hostname;

		$this->loadConfig();
	}

	/**
	 * Magic method to transparently use registry methods on config
	 *
	 * @param   string  $name       Name of the function.
	 * @param   array   $arguments  [0] The name of the variable [1] The default value.
	 *
	 * @return  mixed   The filtered input value.
	 */
	public function __call($name, $arguments)
	{
		if (method_exists($this->config, $name))
		{
			return call_user_func_array(array($this->config, $name), $arguments);
		}

		trigger_error('Call to undefined method ' . __CLASS__ . '::' . $name . '()', E_USER_ERROR);
	}

	/**
	 * Get the path to this station configuration file
	 *
	 * @return  string
	 */
	protected function getConfigurationFilePath()
	{
		return JPATH_SITE . '/redgit/conf/' . (string) $this->hostname . '.conf';
	}

	/**
	 * Get this host name
	 *
	 * @return  string
	 */
	public function getHostname()
	{
		return $this->hostname;
	}

	/**
	 * Default loading is trying to use the associated table
	 *
	 * @return  self
	 */
	public function loadConfig()
	{
		$this->config = new \JRegistry;

		if (!file_exists($this->getConfigurationFilePath()))
		{
			return $this;
		}

		$this->config->loadFile($this->getConfigurationFilePath(), 'INI');

		return $this;
	}

	/**
	 * Save configuration to file
	 *
	 * @param   mixed  $config  Null to avoid binding any data | JRegistry to binf config and save
	 *
	 * @return  boolean
	 */
	public function save($config = null)
	{
		if ($config instanceof \JRegistry || $config instanceof \Joomla\Registry\Registry)
		{
			$this->config->merge($config);
		}

		$content = $this->config->toString('ini');
		$configFolder = dirname($this->getConfigurationFilePath());

		if (!is_dir($configFolder) && !mkdir($configFolder, 0755, true))
		{
			throw new \Exception('Unable to create configuration folder');
		}

		$file = fopen($this->getConfigurationFilePath(), 'w');

		if ($file === false)
		{
			throw new \Exception('Unable to save station configuration');
		}

		$result = fwrite($file, $content);

		if ($result === false)
		{
			throw new \Exception('Unable to save station configuration');
		}

		fclose($file);

		return true;
	}
}
