<?php
/**
 * @package     Redgit.Backend
 * @subpackage  View
 *
 * @copyright   Copyright (C) 2015 redCOMPONENT.com. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE
 */

defined('_JEXEC') or die;

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
		$this->gitLog = $this->runCommand("git log -15 --pretty=format:'%h - %s (%cr) | %an' --abbrev-commit --date=relative");

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

	/**
	 * Run a command in the git repository. Accepts a shell command to run.
	 *
	 * @param   string  $command  Command to run
	 *
	 * @return  string
	 */
	protected function runCommand($command)
	{
		$descriptorspec = array(
			1 => array('pipe', 'w'),
			2 => array('pipe', 'w'),
		);

		$pipes = array();

		/* Depending on the value of variables_order, $_ENV may be empty.
		 * In that case, we have to explicitly set the new variables with
		 * putenv, and call proc_open with env=null to inherit the reset
		 * of the system.
		 *
		 * This is kind of crappy because we cannot easily restore just those
		 * variables afterwards.
		 *
		 * If $_ENV is not empty, then we can just copy it and be done with it.
		 */
		if (count($_ENV) === 0)
		{
			$env = null;

			foreach ($this->envopts as $k => $v)
			{
				putenv(sprintf("%s=%s", $k, $v));
			}
		}
		else
		{
			$env = array_merge($_ENV, $this->envopts);
		}

		$cwd = JPATH_SITE;
		$resource = proc_open($command, $descriptorspec, $pipes, $cwd, $env);

		$stdout = stream_get_contents($pipes[1]);
		$stderr = stream_get_contents($pipes[2]);

		foreach ($pipes as $pipe)
		{
			fclose($pipe);
		}

		$status = trim(proc_close($resource));

		if ($status)
		{
			throw new Exception($stderr);
		}

		return $stdout;
	}
}
