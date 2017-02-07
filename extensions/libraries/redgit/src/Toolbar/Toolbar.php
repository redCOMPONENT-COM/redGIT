<?php
/**
 * @package     Redgit.Library
 * @subpackage  Toolbar
 *
 * @copyright   Copyright (C) 2015 - 2017 redcomponent.com. All rights reserved.
 * @license     GNU General Public License version 2 or later, see LICENSE.
 */

namespace Redgit\Toolbar;

defined('_JEXEC') or die;

use Redgit\Toolbar\Button\ButtonGroup;
use Redgit\Application;

/**
 * Represents a toolbar.
 *
 * @since  1.0
 */
class Toolbar
{
	/**
	 * The buttons in the group.
	 *
	 * @var  \Redgit\Toolbar\Button\ButtonGroup[]
	 */
	protected $groups = array();

	/**
	 * A css class attribute for the toolbar.
	 *
	 * @var  string
	 */
	protected $class;

	/**
	 * Constructor.
	 *
	 * @param   string  $class  The css class attribute.
	 */
	public function __construct($class = 'toolbar')
	{
		$this->class = $class;
	}

	/**
	 * Get the toolbar css class attribute.
	 *
	 * @return  string  The css class attribute.
	 */
	public function getClass()
	{
		return $this->class;
	}

	/**
	 * Add a button group to the toolbar.
	 *
	 * @param   \Redgit\Toolbar\Button\ButtonGroup  $group  The group to add.
	 *
	 * @return  self
	 */
	public function addGroup(ButtonGroup $group)
	{
		$this->groups[] = $group;

		return $this;
	}

	/**
	 * Debug the toolbar rendering.
	 *
	 * @param   string  $layoutId  Layout identifier. Layout to render
	 * @param   array   $data      Optional data for the layout
	 *
	 * @return  string  The rendered toolbar.
	 */
	public function debug($layoutId = 'redgit.toolbar.toolbar', $data = array())
	{
		return $this->getRenderer($layoutId)->debug(array_merge($this->getLayoutData(), $data));
	}

	/**
	 * Get the groups forming the toolbar.
	 *
	 * @return  \Redgit\Toolbar\Button\ButtonGroup[]
	 */
	public function getGroups()
	{
		return $this->groups;
	}

	/**
	 * Get the data for the layouts
	 *
	 * @return  array
	 */
	protected function getLayoutData()
	{
		return array(
			'toolbar' => $this
		);
	}

	/**
	 * Get the renderer of this toolbar
	 *
	 * @param   string  $layoutId  Layout identifier
	 *
	 * @return  RedgitLayoutInterface
	 */
	protected function getRenderer($layoutId)
	{
		return Application::getRenderer($layoutId);
	}

	/**
	 * Render the toolbar.
	 *
	 * @param   string  $layoutId  Layout identifier. Layout to render
	 * @param   array   $data      Optional data for the layout
	 *
	 * @return  string  The rendered toolbar.
	 */
	public function render($layoutId = 'redgit.toolbar.toolbar', $data = array())
	{
		return $this->getRenderer($layoutId)->render(array_merge($this->getLayoutData(), $data));
	}

	/**
	 * Check if the toolbar is empty.
	 *
	 * @return  boolean  True if the toolbar is empty, false otherwise.
	 */
	public function isEmpty()
	{
		foreach ($this->groups as $group)
		{
			if (!$group->isEmpty())
			{
				return false;
			}
		}

		return true;
	}
}
