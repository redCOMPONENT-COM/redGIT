<?php
/**
 * @package     Redgit.Library
 * @subpackage  Helper
 *
 * @copyright   Copyright (C) 2015 - 2017 redcomponent.com. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE
 */

defined('_JEXEC') or die;

JLoader::import('joomla.form.formfield');
JFormHelper::loadFieldClass('list');

/**
 * Database table field.
 *
 * @since  __DEPLOY_VERSION__
 */
class RedgitFormFieldDatabase_Table extends \JFormFieldList
{
	/**
	 * The form field type.
	 *
	 * @var		string
	 */
	protected $type = 'Database_Table';

	/**
	 * Cached array of options.
	 *
	 * @var    array
	 */
	protected static $options = array();

	/**
	 * Method to get the field options.
	 *
	 * @return  array  Options to populate the select field
	 */
	public function getOptions()
	{
		$hash = md5($this->name . $this->element);

		if (isset(static::$options[$hash]))
		{
			return static::$options[$hash];
		}

		$options = array();

		$db = JFactory::getDbo();

		$db->setQuery("SHOW TABLES");

		$tables = $db->loadColumn();

		if (!$tables)
		{
			$tables = array();
		}

		foreach ($tables as $table)
		{
			$options[] = (object) array(
				'text' => $table,
				'value' => $table
			);
		}

		static::$options[$hash] = array_merge(parent::getOptions(), $options);

		return static::$options[$hash];
	}
}
