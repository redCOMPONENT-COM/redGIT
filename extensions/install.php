<?php
/**
 * @package     Redgit.Package
 * @subpackage  Installer
 *
 * @copyright   Copyright (C) 2015 redcomponent.com. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE
 */

defined('_JEXEC') or die;

/**
 * Package installer
 *
 * @since  1.0.0
 *
 */
class Pkg_RedgitInstallerScript
{
	/**
	 * Installer instance
	 *
	 * @var  JInstaller
	 */
	public $installer = null;

	/**
	 * Manifest of the extension being processed
	 *
	 * @var  SimpleXMLElement
	 */
	protected $manifest;

	/**
	 * Get the common JInstaller instance used to install all the extensions
	 *
	 * @return JInstaller The JInstaller object
	 */
	public function getInstaller()
	{
		if (null === $this->installer)
		{
			$this->installer = new JInstaller;
		}

		return $this->installer;
	}

	/**
	 * Getter with manifest cache support
	 *
	 * @param   JInstallerAdapter  $parent  Parent object
	 *
	 * @return  SimpleXMLElement
	 */
	protected function getManifest($parent)
	{
		if (null === $this->manifest)
		{
			$this->loadManifest($parent);
		}

		return $this->manifest;
	}

	/**
	 * Shit happens. Patched function to bypass bug in package uninstaller
	 *
	 * @param   JInstallerAdapter  $parent  Parent object
	 *
	 * @return  void
	 */
	protected function loadManifest($parent)
	{
		$element = strtolower(str_replace('InstallerScript', '', get_called_class()));
		$elementParts = explode('_', $element);

		// Type not properly detected or not a package
		if (count($elementParts) != 2 || strtolower($elementParts[0]) != 'pkg')
		{
			$this->manifest = $parent->get('manifest');

			return;
		}

		$rootPath = $parent->getParent()->getPath('extension_root');
		$manifestPath = dirname($rootPath);
		$manifestFile = $manifestPath . '/' . $element . '.xml';

		// Package manifest found
		if (file_exists($manifestFile))
		{
			$this->manifest = JFactory::getXML($manifestFile);

			return;
		}

		$this->manifest = $parent->get('manifest');
	}

	/**
	 * Method to run after an install/update/discover method
	 *
	 * @param   object  $type    type of change (install, update or discover_install)
	 * @param   object  $parent  class calling this method
	 *
	 * @return void
	 */
	public function postflight($type, $parent)
	{
		// Next changes will be applied only to new installations
		if ($type == 'update')
		{
			return;
		}

		return $this->enablePlugins($parent);
	}

	/**
	 * Enable plugins if desired
	 *
	 * @param   object  $parent  class calling this method
	 *
	 * @return  void
	 */
	private function enablePlugins($parent)
	{
		// Required objects
		$installer = $this->getInstaller();
		$manifest  = $this->getManifest($parent);
		$src       = $parent->getParent()->getPath('source');

		if ($nodes = $manifest->files)
		{
			foreach ($nodes->file as $node)
			{
				$extType = (string) $node->attributes()->type;

				if ($extType != 'plugin')
				{
					continue;
				}

				$enabled = (string) $node->attributes()->enabled;

				if ($enabled !== 'true')
				{
					continue;
				}

				$extName  = (string) $node->attributes()->id;
				$extGroup = (string) $node->attributes()->group;

				$db = JFactory::getDBO();
				$query = $db->getQuery(true);
				$query->update($db->quoteName("#__extensions"));
				$query->set("enabled=1");
				$query->where("type='plugin'");
				$query->where("element=" . $db->quote($extName));
				$query->where("folder=" . $db->quote($extGroup));
				$db->setQuery($query);
				$db->query();
			}
		}
	}
}
