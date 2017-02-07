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
class RedgitViewStation extends AbstractView
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

		$data['form'] = $model->getForm();
		$data['config'] = $model->getItem();

		return $data;
	}

	/**
	 * Get the tool-bar to render.
	 *
	 * @return  \Redgit\Toolbar\Toolbar
	 */
	public function getToolbar()
	{
		if ($this->getLayout() === 'edit')
		{
			return  $this->getEditToolbar();
		}

		return $this->getDefaultToolbar();
	}

	/**
	 * Get the default view toolbar.
	 *
	 * @return  \Redgit\Toolbar\Toolbar
	 */
	protected function getDefaultToolbar()
	{
		$user = JFactory::getUser();

		$firstGroup  = new ButtonGroup;

		if ($user->authorise('core.admin'))
		{
			$new = ToolbarBuilder::createStandardButton('station.edit', 'JTOOLBAR_EDIT', '', 'icon-edit', false);
			$firstGroup->addButton($new);
		}

		$toolbar = new Toolbar;
		$toolbar
			->addGroup($firstGroup);

		return $toolbar;
	}

	/**
	 * Get the edit view toolbar.
	 *
	 * @return  \Redgit\Toolbar\Toolbar
	 */
	protected function getEditToolbar()
	{
		$user = JFactory::getUser();

		$group1  = new ButtonGroup;
		$group2  = new ButtonGroup;

		if ($user->authorise('core.admin'))
		{
			$new = ToolbarBuilder::createSaveButton('station.save');
			$group1->addButton($new);
			$new = ToolbarBuilder::createCancelButton('station.cancel');
			$group2->addButton($new);
		}

		$toolbar = new Toolbar;
		$toolbar
			->addGroup($group1)
			->addGroup($group2);

		return $toolbar;
	}

	/**
	 * Get the view title.
	 *
	 * @return  string  The view title.
	 */
	public function getTitle()
	{
		$config = Application::getStationConfiguration();

		return JText::sprintf('COM_REDGIT_STATION_LABEL_CONFIGURATION', $config->getHostname());
	}
}
