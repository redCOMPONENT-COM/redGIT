<?php
/**
 * @package     Redgit.Backend
 * @subpackage  Controller
 *
 * @copyright   Copyright (C) 2015 redCOMPONENT.com. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE
 */

defined('_JEXEC') or die;

use Redgit\Application;

/**
 * Git Controller.
 *
 * @since  1.0.0
 */
class RedgitControllerGit extends JControllerLegacy
{
	/**
	 * Dump the database with the flow scripts
	 *
	 * @return  void
	 */
	public function commit()
	{
		JSession::checkToken() or jexit(JText::_('JINVALID_TOKEN'));

		if (!JFactory::getUser()->authorise('core.admin'))
		{
			throw new Exception(JText::_('JLIB_APPLICATION_ERROR_ACCESS_FORBIDDEN'), 403);
		}

		try
		{
			$app = JFactory::getApplication();

			$git = Application::getGit();

			if ($git->hasChanges())
			{
				$git ->add('.');

				$message = $app->input->getString(
					'message',
					Application::getStationConfiguration()->get('default_commit_message', '[server] Latest version online')
				);

				$git->commit($message);
			}

			$git->push('origin', Application::getStationConfiguration()->get('git_branch', 'master'));
		}
		catch (Exception $e)
		{
			JFactory::getApplication()->enqueueMessage($e->getMessage(), 'error');

			$this->setRedirect('index.php?option=com_redgit&view=dashboard');

			return false;
		}

		JFactory::getApplication()->enqueueMessage('Changes committed successfully: ' . $git->getOutput());

		$this->setRedirect('index.php?option=com_redgit&view=dashboard');
	}

	/**
	 * Pull latest changes
	 *
	 * @return  boolean
	 */
	public function pull()
	{
		JSession::checkToken() or jexit(JText::_('JINVALID_TOKEN'));

		if (!JFactory::getUser()->authorise('core.admin'))
		{
			throw new Exception(JText::_('JLIB_APPLICATION_ERROR_ACCESS_FORBIDDEN'), 403);
		}

		try
		{
			$app = JFactory::getApplication();

			$git = Application::getGit();

			if ($git->hasChanges())
			{
				throw new Exception("You have changes not committed", 403);
			}

			$git->pull('origin', Application::getStationConfiguration()->get('git_branch', 'master'));
		}
		catch (Exception $e)
		{
			JFactory::getApplication()->enqueueMessage($e->getMessage(), 'error');

			$this->setRedirect('index.php?option=com_redgit&view=dashboard');

			return false;
		}
	}
}
