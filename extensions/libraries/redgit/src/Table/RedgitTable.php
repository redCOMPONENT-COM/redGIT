<?php
/**
 * @package     Redgit.Library
 * @subpackage  Table
 *
 * @copyright   Copyright (C) 2015 - 2017 redcomponent.com. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE
 */

namespace Redgit\Table;

defined('_JEXEC') or die;

/**
 * Base table for redGIT
 *
 * @since  1.0.0
 */
abstract class RedgitTable extends \JTable
{
	/**
	 * @const
	 */
	const STATE_UNPUBLISHED = 0;

	/**
	 * @const
	 */
	const STATE_PUBLISHED = 1;

	/**
	 * The table name without the prefix
	 *
	 * @var  string
	 */
	protected $_tableName;

	/**
	 * The table key column. Usually: id
	 *
	 * @var  string
	 */
	protected $_tableKey = 'id';

	/**
	 * Constructor
	 *
	 * @param   JDatabase  &$db  A database connector object
	 *
	 * @throws  UnexpectedValueException
	 */
	public function __construct(&$db)
	{
		// Keep checking _tbl value for standard defined tables
		if (empty($this->_tbl) && !empty($this->_tableName))
		{
			// Add the table prefix
			$this->_tbl = '#__' . $this->_tableName;
		}

		// Keep checking _tbl_key for standard defined tables
		if (empty($this->_tbl_key) && !empty($this->_tableKey))
		{
			$this->_tbl_key = $this->_tableKey;
		}

		if (empty($this->_tbl) || empty($this->_tbl_key))
		{
			throw new UnexpectedValueException(sprintf('Missing data to initialize %s table | id: %s', $this->_tbl, $this->_tbl_key));
		}

		parent::__construct($this->_tbl, $this->_tbl_key, $db);
	}

	/**
	 * Method to bind an associative array or object to the JTable instance.This
	 * method only binds properties that are publicly accessible and optionally
	 * takes an array of properties to ignore when binding.
	 *
	 * @param   mixed  $src     An associative array or object to bind to the JTable instance.
	 * @param   mixed  $ignore  An optional array or space separated list of properties to ignore while binding.
	 *
	 * @return  boolean  True on success.
	 *
	 * @throws  InvalidArgumentException
	 */
	public function bind($src, $ignore = array())
	{
		if (isset($src['params']) && is_array($src['params']))
		{
			$registry = new JRegistry;
			$registry->loadArray($src['params']);
			$src['params'] = (string) $registry;
		}

		if (isset($src['metadata']) && is_array($src['metadata']))
		{
			$registry = new JRegistry;
			$registry->loadArray($src['metadata']);
			$src['metadata'] = (string) $registry;
		}

		if (isset($src['rules']) && is_array($src['rules']))
		{
			$rules = new JAccessRules($src['rules']);
			$this->setRules($rules);
		}

		// Autogenerate aliases
		if (property_exists($this, 'alias') && empty($this->alias) && empty($src['alias']))
		{
			if (!empty($src['name']))
			{
				$src['alias'] = $src['name'];
			}
			elseif (!empty($src['title']))
			{
				$src['alias'] = $src['title'];
			}

			if (!empty($src['alias']))
			{
				$src['alias'] = \JApplication::stringURLSafe($src['alias']);

				// Ensure that we don't automatically generate duplicated aliases
				$table = clone $this;

				while ($table->load(array('alias' => $src['alias'])) && $table->id != $this->id)
				{
					$src['alias'] = \JString::increment($src['alias'], 'dash');
				}
			}
		}

		// Autofill created_by and modified_by information
		$now = \JDate::getInstance();
		$nowFormatted = $now->toSql();
		$userId = \JFactory::getUser()->get('id');

		if (property_exists($this, 'created_by') && empty($src['created_by']))
		{
			$src['created_by']   = $userId;
		}

		if (property_exists($this, 'created_date') && empty($src['created_date']))
		{
			$src['created_date'] = $nowFormatted;
		}

		if (property_exists($this, 'modified_by') && empty($src['modified_by']))
		{
			$src['modified_by']   = $userId;
		}

		if (property_exists($this, 'modified_date') && empty($src['modified_date']))
		{
			$src['modified_date'] = $nowFormatted;
		}

		return parent::bind($src, $ignore);
	}

	/**
	 * Override the shit JObject getProperties method
	 *
	 * @param   boolean  $public  Load only public properties?
	 *
	 * @return  array
	 */
	public function getProperties($public = true)
	{
		if ($public)
		{
			$vars = call_user_func('get_object_vars', $this);

			// For B/C we will keep the shit underscore private identification
			foreach ($vars as $key => $value)
			{
				if ('_' == substr($key, 0, 1))
				{
					unset($vars[$key]);
				}
			}

			return $vars;
		}

		return get_object_vars($this);
	}
}
