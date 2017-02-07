<?php
/**
 * @package     Redgit.Backend
 * @subpackage  Table
 *
 * @copyright   Copyright (C) 2015 - 2017 redcomponent.com. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE
 */

defined('_JEXEC') or die;

use Redgit\Table\RedgitTable;

/**
 * Callback table
 *
 * @since  1.0.0
 */
class RedgitTableCallback extends RedgitTable
{
	/**
	 * @var  integer
	 */
	public $id;

	/**
	 * @var  string
	 */
	public $type;

	/**
	 * @var  string
	 */
	public $remote_ip;

	/**
	 * @var  string
	 */
	public $data;

	/**
	 * @var  integer
	 */
	public $state;

	/**
	 * @var  string
	 */
	public $created_date;

	/**
	 * The table name without the prefix
	 *
	 * @var  string
	 */
	protected $_tableName = 'redgit_callback';
}
