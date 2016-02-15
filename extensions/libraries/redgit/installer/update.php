<?php
/**
 * @package     Redgit.Library
 * @subpackage  Update
 *
 * @copyright   Copyright (C) 2008 - 2016 redCOMPONENT.com. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE
 */

defined('_JEXEC') or die;

/**
 * Update script class.
 * Note: This class doesn't use autoloading naminb conventions to allow to use always the latest version
 *
 * @since  1.1.0
 */
abstract class RedgitInstallerUpdateScript
{
	/**
	 * The installer.
	 *
	 * @var  JInstaller
	 */
	protected $installer;

	/**
	 * Constructor.
	 *
	 * @param   JInstaller  $installer  The installer
	 */
	public function __construct(JInstaller $installer)
	{
		$this->installer = $installer;
	}

	/**
	 * Do something before the update happens.
	 *
	 * @param   object  $parent  class calling this method
	 *
	 * @return  boolean
	 *
	 * @throws  RuntimeException  If something goes wrong
	 */
	public function preflight($parent)
	{
	}

	/**
	 * Do something after the update happens.
	 *
	 * @param   object  $parent  class calling this method
	 *
	 * @return  boolean
	 *
	 * @throws  RuntimeException  If something goes wrong
	 */
	public function postflight($parent)
	{
	}

	/**
	 * Create a module
	 *
	 * @param   array    $moduleData  Data to bind to the module table
	 * @param   integer  $itemId      Menu item id to attach the module. 0 for backend
	 *
	 * @return  boolean
	 */
	private function createModule($moduleData, $itemId = 0)
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
	 * Empty a table from the database.
	 *
	 * @param   string  $tableName  Name of the table to empty
	 *
	 * @return  boolean
	 *
	 * @throws  RuntimeException  Executing query failed
	 */
	protected function emptyTable($tableName)
	{
		$db = JFactory::getDbo();

		$query = $db->getQuery(true)
			->delete($tableName);

		$db->setQuery($query);

		if ($db->execute())
		{
			return true;
		}

		return false;
	}

	/**
	 * Search a extension in the database.
	 *
	 * @param   string  $type     Type of extension (component, file, language, library, module, plugin)
	 * @param   string  $element  Extension technical name/alias
	 * @param   string  $folder   Folder name used mainly in plugins
	 *
	 * @return  integer           Extension identifier
	 */
	protected function searchExtension($type, $element, $folder = null)
	{
		$db = JFactory::getDBO();
		$query = $db->getQuery(true)
			->select('extension_id')
			->from($db->quoteName("#__extensions"))
			->where("type = " . $db->quote($type))
			->where("element = " . $db->quote($element));

		if (!is_null($folder))
		{
			$query->where("folder = " . $db->quote($folder));
		}

		$db->setQuery($query);

		return $db->loadResult();
	}

	/**
	 * Uninstall an extension.
	 *
	 * @param   string  $type     Type of extension (component, file, language, library, module, plugin)
	 * @param   string  $element  Extension technical name/alias
	 * @param   string  $folder   Folder name used mainly in plugins
	 *
	 * @return  boolean
	 */
	protected function uninstallExtension($type, $element, $folder = null)
	{
		$extensionId = $this->searchExtension($type, $element, $folder);

		if (!$extensionId)
		{
			return true;
		}

		$installer = new JInstaller;

		return $installer->uninstall($type, $extensionId);
	}
}
