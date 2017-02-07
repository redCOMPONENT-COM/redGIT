<?php
/**
 * @package     Redgit.Backend
 * @subpackage  Controller
 *
 * @copyright   Copyright (C) 2015 - 2017 redcomponent.com. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE
 */

defined('_JEXEC') or die;

use Redgit\Application;
use Redgit\Helper\AjaxHelper;

/**
 * Database Controller.
 *
 * @since  1.0.0
 */
class RedgitControllerDatabase extends JControllerLegacy
{
	/**
	 * Perform a dump through an AJAX request
	 *
	 * @return  void
	 *
	 * @since   1.0.5
	 */
	public function ajaxDump()
	{
		AjaxHelper::validateAjaxRequest();

		$app = JFactory::getApplication();

		if (!JFactory::getUser()->authorise('core.admin'))
		{
			Application::setHeader('status', 403);
			Application::sendHeaders();
			echo JText::_('JLIB_APPLICATION_ERROR_ACCESS_FORBIDDEN');
			$app->close();
		}

		$dispatcher = Application::getDispatcher();
		JPluginHelper::importPlugin('redgit');

		$result = $dispatcher->trigger('onRedgitDumpDatabase', array('com_redgit.admin.dump'));

		if (in_array(false, $result, true))
		{
			Application::setHeader('status', 500);
			Application::sendHeaders();
			echo $dispatcher->getError();
			$app->close();
		}

		Application::sendHeaders();
		echo 1;
		$app->close();
	}

	/**
	 * Restore database throuh an AJAX request
	 *
	 * @return  void
	 *
	 * @since   1.0.5
	 */
	public function ajaxRestore()
	{
		AjaxHelper::validateAjaxRequest();

		$app = JFactory::getApplication();

		if (!JFactory::getUser()->authorise('core.admin'))
		{
			Application::setHeader('status', 403);
			Application::sendHeaders();
			echo JText::_('JLIB_APPLICATION_ERROR_ACCESS_FORBIDDEN');
			$app->close();
		}

		$dispatcher = Application::getDispatcher();
		JPluginHelper::importPlugin('redgit');

		$result = $dispatcher->trigger('onRedgitRestoreDatabase', array('com_redgit.admin.restore'));

		if (in_array(false, $result, true))
		{
			Application::setHeader('status', 500);
			Application::sendHeaders();
			echo $dispatcher->getError();
			$app->close();
		}

		Application::sendHeaders();
		echo 1;
		$app->close();
	}

	/**
	 * Dump the database.
	 *
	 * @return  void
	 *
	 * @since   1.0.5
	 */
	public function dump()
	{
		JSession::checkToken() or jexit(JText::_('JINVALID_TOKEN'));

		if (!JFactory::getUser()->authorise('core.admin'))
		{
			throw new Exception(JText::_('JLIB_APPLICATION_ERROR_ACCESS_FORBIDDEN'), 403);
		}

		$dispatcher = Application::getDispatcher();
		JPluginHelper::importPlugin('redgit');

		$result = $dispatcher->trigger('onRedgitDumpDatabase', array('com_redgit.admin.dump'));

		if (in_array(false, $result, true))
		{
			JFactory::getApplication()->enqueueMessage($dispatcher->getError(), 'error');
		}

		$this->setRedirect('index.php?option=com_redgit&view=dashboard');
	}

	/**
	 * Restore the database.
	 *
	 * @return  void
	 */
	public function restore()
	{
		JSession::checkToken() or jexit(JText::_('JINVALID_TOKEN'));

		if (!JFactory::getUser()->authorise('core.admin'))
		{
			throw new Exception(JText::_('JLIB_APPLICATION_ERROR_ACCESS_FORBIDDEN'), 403);
		}

		$dispatcher = Application::getDispatcher();
		JPluginHelper::importPlugin('redgit');

		$result = $dispatcher->trigger('onRedgitRestoreDatabase', array('com_redgit.admin.restore'));

		if (in_array(false, $result, true))
		{
			JFactory::getApplication()->enqueueMessage($dispatcher->getError(), 'error');
		}

		$this->setRedirect('index.php?option=com_redgit&view=dashboard');
	}
}
