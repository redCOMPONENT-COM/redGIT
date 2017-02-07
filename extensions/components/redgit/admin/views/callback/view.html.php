<?php
/**
 * @package     Redgit.Backend
 * @subpackage  View
 *
 * @copyright   Copyright (C) 2015 - 2017 redcomponent.com. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE
 */

defined('_JEXEC') or die;

use Redgit\Application;
use Redgit\View\AbstractView;
use Redgit\Toolbar\Button\ButtonGroup;
use Redgit\Toolbar\ToolbarBuilder;
use Redgit\Toolbar\Toolbar;

/**
 * Station View.
 *
 * @since  1.0.0
 */
class RedgitViewCallback extends AbstractView
{
	/**
	 * Get the data that is going to be passed to the layout
	 *
	 * @return  array
	 */
	public function getLayoutData()
	{
		$data = parent::getLayoutData();

		$model = $this->getModel();

		$data['item'] = $model->getItem();

		return $data;
	}

	/**
	 * Get the default view toolbar
	 *
	 * @return  \Redgit\Toolbar\Toolbar
	 */
	public function getToolbar()
	{
		$user = JFactory::getUser();

		$group1  = new ButtonGroup;

		if ($user->authorise('core.admin'))
		{
			$new = ToolbarBuilder::createCancelButton('callback.cancel');
			$group1->addButton($new);
		}

		$toolbar = new Toolbar;
		$toolbar
			->addGroup($group1);

		return $toolbar;
	}
}
