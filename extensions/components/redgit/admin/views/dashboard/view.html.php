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

/**
 * Dashboard View.
 *
 * @since  1.0.0
 */
class RedgitViewDashboard extends AbstractView
{
	/**
	 * Get the data that is going to be passed to the layout
	 *
	 * @return  array
	 */
	public function getLayoutData()
	{
		$data = parent::getLayoutData();

		$data['mainModules'] = JModuleHelper::getModules('redgit-dashboard-main');
		$data['sidebarModules'] = JModuleHelper::getModules('redgit-dashboard-sidebar');

		return $data;
	}

	/**
	 * Add the page title and toolbar.
	 *
	 * @return  void
	 *
	 * @since   1.6
	 */
	protected function addToolbar()
	{
		$canDo = JHelperContent::getActions('com_redgit');

		JToolbarHelper::title(JText::_('COM_REDGIT_VIEW_DASHBOARD_TITLE'), 'database featured');

		if ($canDo->get('core.admin') || $canDo->get('core.options'))
		{
			JToolbarHelper::preferences('com_redgit');
		}
	}
}
