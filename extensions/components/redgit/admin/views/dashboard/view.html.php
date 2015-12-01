<?php
/**
 * @package     Redgit.Backend
 * @subpackage  View
 *
 * @copyright   Copyright (C) 2015 redCOMPONENT.com. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE
 */

defined('_JEXEC') or die;

use Redgit\Application;

/**
 * Dashboard View.
 *
 * @since  1.0.0
 */
class RedgitViewDashboard extends JViewLegacy
{
	/**
	 * Enviroment options
	 *
	 * @var  array
	 */
	protected $envopts = array();

	/**
	 * Git log
	 *
	 * @var  string
	 */
	public $gitLog;

	/**
	 * Display the view
	 *
	 * @param   string  $tpl  The template file to use
	 *
	 * @return  string
	 */
	public function display($tpl = null)
	{
		$git = Application::getGit();

		$git->log("-15", "--pretty=format:'%h - %s (%cr) | %an'", "--abbrev-commit", "--date=relative");

		$this->gitLog = $git->getOutput();

		$this->addToolbar();

		return parent::display($tpl);
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
