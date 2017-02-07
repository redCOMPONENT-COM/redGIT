<?php
/**
 * @package     Joomla.Administrator
 * @subpackage  com_content
 *
 * @copyright   Copyright (C) 2015 - 2017 redcomponent.com. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_JEXEC') or die;

use Redgit\Model\ListModel;

/**
 * Callbacks model
 *
 * @since  1.0.2
 */
class RedgitModelCallbacks extends ListModel
{
	/**
	 * Constructor.
	 *
	 * @param   array  $config  An optional associative array of configuration settings.
	 */
	public function __construct($config = array())
	{
		if (empty($config['filter_fields']))
		{
			$config['filter_fields'] = array(
				'id'           , 'c.id',
				'created_date' , 'c.created_date',
				'state'        , 'c.state',
				'plugin'       , 'c.plugin',
				'type'         , 'c.type'
			);
		}

		parent::__construct($config);
	}

	/**
	 * Method to auto-populate the model state.
	 *
	 * Note. Calling getState in this method will result in recursion.
	 *
	 * @param   string  $ordering   An optional ordering field.
	 * @param   string  $direction  An optional direction (asc|desc).
	 *
	 * @return  void
	 */
	protected function populateState($ordering = null, $direction = null)
	{
		parent::populateState('c.id', 'desc');
	}

	/**
	 * Method to get a list of articles.
	 * Overridden to add a check for access levels.
	 *
	 * @return  array  An array of data items.
	 */
	public function getItems()
	{
		$items = parent::getItems();

		return $items ? $items : array();
	}

	/**
	 * Build an SQL query to load the list data.
	 *
	 * @return  JDatabaseQuery
	 */
	protected function getListQuery()
	{
		$db = $this->getDbo();

		$query = $db->getQuery(true)
			->select($db->quoteName('c') . '.*')
			->from($db->quoteName('#__redgit_callback', 'c'));

		// Ordering
		$orderCol = $this->state->get('list.ordering', 'c.id');
		$orderDirn = $this->state->get('list.direction', 'desc');

		$query->order($db->escape($orderCol . ' ' . $orderDirn));

		return $query;
	}
}
