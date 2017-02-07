<?php
/**
 * @package     Redgit.Package
 * @subpackage  Installer
 *
 * @copyright   Copyright (C) 2015 - 2017 redcomponent.com. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE
 */

defined('_JEXEC') or die;

/**
 * Package installer
 *
 * @since  1.0.0
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
	 * Is this an update installation?
	 *
	 * @var    boolean
	 * @since  1.1.2
	 */
	private $is25Update;

	/**
	 * Manifest of the extension being processed
	 *
	 * @var  SimpleXMLElement
	 */
	protected $manifest;

	/**
	 * Version installed.
	 *
	 * @var    string
	 * @since  1.1.0
	 */
	protected $installedVersion;

	/**
	 * List of update scripts
	 *
	 * @var    array
	 * @since  1.1.0
	 */
	private $updateScripts;

	/**
	 * Creates a dashboard mod_redgit_git module.
	 *
	 * @return  boolean
	 *
	 * @since   1.1.0
	 */
	private function createDasboardCommitModule()
	{
		$moduleData = array(
			'title'     => 'Commit',
			'content'   => '',
			'module'    => 'mod_redgit_commit',
			'access'    => '1',
			'showtitle' => '1',
			'position'  => 'redgit-dashboard-sidebar',
			'params'    => '',
			'client_id' => 1,
			'published' => 1,
			'language'  => '*',
			'ordering'  => 1,
			'params'    => array(
				'header_tag' => 'h4',
				'moduleclass_sfx' => ''
			)
		);

		return $this->createModule($moduleData, 0);
	}

	/**
	 * Creates a dashboard mod_redgit_dashboard module.
	 *
	 * @return  boolean
	 *
	 * @since   1.1.0
	 */
	private function createDasboardDatabaseModule()
	{
		$moduleData = array(
			'title'     => 'Database',
			'content'   => '',
			'module'    => 'mod_redgit_database',
			'access'    => '1',
			'showtitle' => '1',
			'position'  => 'redgit-dashboard-sidebar',
			'params'    => '',
			'client_id' => 1,
			'published' => 1,
			'language'  => '*',
			'ordering'  => 1,
			'params'    => array(
				'header_tag' => 'h4',
				'moduleclass_sfx' => ''
			)
		);

		return $this->createModule($moduleData, 0);
	}

	/**
	 * Creates a dashboard mod_redgit_git module.
	 *
	 * @return  boolean
	 *
	 * @since   1.1.0
	 */
	private function createDasboardGitModule()
	{
		$moduleData = array(
			'title'     => 'Git',
			'content'   => '',
			'module'    => 'mod_redgit_git',
			'access'    => '1',
			'showtitle' => '1',
			'position'  => 'redgit-dashboard-main',
			'params'    => '',
			'client_id' => 1,
			'published' => 1,
			'language'  => '*',
			'ordering'  => 1,
			'params'    => array(
				'header_tag' => 'h4',
				'moduleclass_sfx' => ''
			)
		);

		return $this->createModule($moduleData, 0);
	}

	/**
	 * Creates the default dashboard modules
	 *
	 * @return  boolean
	 *
	 * @since   1.1.0
	 */
	private function createDashboardModules()
	{
		return $this->createDasboardGitModule() && $this->createDasboardCommitModule() && $this->createDasboardDatabaseModule();
	}

	/**
	 * Create a module
	 *
	 * @param   array    $moduleData  Data to bind to the module table
	 * @param   integer  $itemId      Menu item id to attach the module. null for none | 0 for backend
	 *
	 * @return  boolean
	 *
	 * @since   1.1.0
	 */
	private function createModule($moduleData, $itemId = null)
	{
		$table = JTable::getInstance('module');

		if (!$table->save($moduleData))
		{
			return false;
		}

		if (null !== $itemId)
		{
			return $this->createModuleMenu($table->id, $itemId);
		}

		return true;
	}

	/**
	 * Creates a link for a module on specific itemId.
	 *
	 * @param   integer  $moduleId  Module identifier
	 * @param   integer  $itemId    Menu item id. 0 for backend
	 *
	 * @return  boolean
	 *
	 * @since   1.1.0
	 */
	private function createModuleMenu($moduleId, $itemId = 0)
	{
		$db = JFactory::getDbo();

		$query = $db->getQuery(true)
			->insert($db->quoteName('#__modules_menu'))
			->columns(
				array(
					$db->quoteName('moduleid'),
					$db->quoteName('menuid')
				)
			)
			->values(
				(int) $moduleId . ','
				. $itemId
			);

		$db->setQuery($query);

		return $db->execute() ? true : false;
	}

	/**
	 * Get the element of this extension from class name.
	 *
	 * @return  string
	 *
	 * @since   1.1.0
	 */
	private function getElement()
	{
		return strtolower(str_replace('InstallerScript', '', get_called_class()));
	}

	/**
	 * Get the current installed version.
	 *
	 * @return  string
	 *
	 * @since   1.1.0
	 */
	private function getInstalledVersion()
	{
		if (null === $this->installedVersion)
		{
			$this->loadInstalledVersion();
		}

		return $this->installedVersion;
	}

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
	 * Get the path to the base updates folder
	 *
	 * @param   object  $parent  class calling this method
	 *
	 * @return  string
	 *
	 * @since   1.1.0
	 */
	private function getUpdatesFolder($parent)
	{
		$element = $this->getManifest($parent)->xpath('//update');

		if (!$element)
		{
			return null;
		}

		$element = reset($element);

		$updatesFolder = $parent->getParent()->getPath('source');

		$folder = (string) $element->attributes()->folder;

		if ($folder && file_exists($updatesFolder . '/' . $folder))
		{
			$updatesFolder = $updatesFolder . '/' . $folder;
		}

		return $updatesFolder;
	}

	/**
	 * Get the instances of applicable update scripts
	 *
	 * @param   object  $parent  class calling this method
	 *
	 * @return  array
	 *
	 * @since   1.1.0
	 */
	private function getUpdateScripts($parent)
	{
		if (null !== $this->updateScripts)
		{
			return $this->updateScripts;
		}

		$this->updateScripts = array();

		// Require the base script installer if it doesn't exist. Only there from v1.1.0.
		$baseScript = $parent->getParent()->getPath('source') . '/libraries/redgit/installer/update.php';

		if (file_exists($baseScript))
		{
			require_once $baseScript;
		}

		$manifest = $this->getManifest($parent);

		$newVersion = (string) $manifest->version;

		$baseUpdatesFolder = $this->getUpdatesFolder($parent);

		if (!$baseUpdatesFolder)
		{
			return $this->updateScripts;
		}

		$updateFolders = $manifest->xpath('//update/scripts/folder');

		$updateFiles = array();

		// Collects all update files from the update folders
		foreach ($updateFolders as $updateFolder)
		{
			$updateFolder = (string) $updateFolder;

			$updateFolderPath = $baseUpdatesFolder . '/' . $updateFolder;

			if (!$fileNames = JFolder::files($updateFolderPath))
			{
				continue;
			}

			foreach ($fileNames as $fileName)
			{
				$version = basename($fileName, '.php');
				$updateFiles[$version] = $updateFolderPath . '/' . $fileName;
			}
		}

		// Sort the files in ascending order
		uksort($updateFiles, 'version_compare');

		$currentVersion = $this->getInstalledVersion();

		foreach ($updateFiles as $version => $path)
		{
			if (version_compare($version, $currentVersion) <= 0)
			{
				continue;
			}

			require_once $path;

			$updateClassName = 'UpdateTo' . str_replace('.', '', $version);

			if (class_exists($updateClassName))
			{
				$this->updateScripts[] = new $updateClassName($this->getInstaller());
			}

			$currentVersion = $version;
		}

		return $this->updateScripts;
	}

	/**
	 * Joomla 2.5 always sends $type = 'install' so we need an alternative way to detect updates.
	 *
	 * @return  boolean
	 *
	 * @since   1.1.2
	 */
	private function is25update()
	{
		if (null === $this->is25Update)
		{
			if (!version_compare(JVERSION, '3.0', 'lt'))
			{
				$this->is25Update = false;

				return $this->is25Update;
			}

			$extension = JTable::getInstance('extension');
			$eid = $extension->load(array('element' => 'pkg_redgit', 'type' => 'package'));

			$this->is25Update = $eid ? true : false;
		}

		return $this->is25Update;
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

		$manifestFile = __DIR__ . '/' . $element . '.xml';

		// Package manifest found
		if (file_exists($manifestFile))
		{
			$this->manifest = JFactory::getXML($manifestFile);

			return;
		}

		$this->manifest = $parent->get('manifest');
	}

	/**
	 * Load the installed version from the database.
	 *
	 * @return  self
	 *
	 * @since   1.1.0
	 */
	private function loadInstalledVersion()
	{
		// Reads current (old) version from manifest
		$db = JFactory::getDbo();

		$query = $db->getQuery(true)
			->select($db->quoteName('e.manifest_cache'))
			->from($db->quoteName('#__extensions', 'e'))
			->where('e.element = ' . $db->quote($this->getElement()));

		$db->setQuery($query);

		$manifest = $db->loadResult();

		if (!$manifest)
		{
			return $this;
		}

		$manifest = json_decode($manifest);

		if (!is_object($manifest) || !property_exists($manifest, 'version'))
		{
			return $this;
		}

		$this->installedVersion = (string) $manifest->version;
	}

	/**
	 * Method to run after an install/update/discover method
	 *
	 * @param   object  $type    type of change (install, update or discover_install)
	 * @param   object  $parent  class calling this method
	 *
	 * @return  void
	 */
	public function postflight($type, $parent)
	{
		$this->createConfigFolders();

		// Next changes will be applied only to new installations
		if ($type === 'update' || $this->is25update())
		{
			// Run update scripts
			$this->runUpdateScriptsMethod($parent, 'postflight');

			return;
		}

		// Create default dashboard modules
		$this->createDashboardModules();

		return $this->enablePlugins($parent);
	}

	/**
	 * Method to run before an install/update/uninstall method
	 *
	 * @param   object  $type    type of change (install, update or discover_install)
	 * @param   object  $parent  class calling this method
	 *
	 * @return  boolean
	 *
	 * @since   1.1.0
	 */
	public function preflight($type, $parent)
	{
		$this->registerNamespace($parent);

		if ($type == "update" || $this->is25update())
		{
			// Run update scripts
			$this->runUpdateScriptsMethod($parent, 'preflight');
		}
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

	/**
	 * Create folders required by redGIT
	 *
	 * @return  boolean
	 */
	private function createConfigFolders()
	{
		$configFolder = JPATH_SITE . '/redgit/conf';

		if (!is_dir($configFolder))
		{
			mkdir($configFolder, 0755, true);
		}

		$sqlFolder = JPATH_SITE . '/redgit/sql';

		if (!is_dir($sqlFolder))
		{
			mkdir($sqlFolder, 0755, true);
		}

		$htaccessFile = JPATH_SITE . '/redgit/.htaccess';

		if (!file_exists($htaccessFile))
		{
			$file = fopen($htaccessFile, 'w');

			fwrite($file, 'deny from all');

			fclose($file);
		}
	}

	/**
	 * Register our namespace if it does not exist
	 *
	 * @param   object  $parent  class calling this method
	 *
	 * @return  void
	 *
	 * @since   1.1.0
	 */
	private function registerNamespace($parent)
	{
		$installFolder = $parent->getParent()->getPath('source');

		if (!class_exists('\Composer\Autoload\ClassLoader'))
		{
			$composerAutoload = $installFolder . '/libraries/redgit/vendor/autoload.php';

			if (!file_exists($composerAutoload))
			{
				throw new Exception("redGIT: Unable to load composer");
			}

			require_once $composerAutoload;
		}

		$path = $parent->getParent()->getPath('source') . '/libraries/redgit/src';

		$loader = new \Composer\Autoload\ClassLoader;

		$loader->setPsr4('Redgit\\', $path);
		$loader->register(true);
	}

	/**
	 * Runs the update for the given version.
	 *
	 * @param   object  $parent  class calling this method
	 * @param   string  $method  Method to run from the update scripts
	 *
	 * @return  boolean
	 *
	 * @since   1.1.0
	 *
	 * @throws  RuntimeException  If something goes wrong in the method
	 */
	private function runUpdateScriptsMethod($parent, $method)
	{
		$updateScripts = $this->getUpdateScripts($parent);

		foreach ($updateScripts as $updateScript)
		{
			if (!method_exists($updateScript, $method))
			{
				continue;
			}

			$updateScript->$method($parent);
		}

		return true;
	}
}
