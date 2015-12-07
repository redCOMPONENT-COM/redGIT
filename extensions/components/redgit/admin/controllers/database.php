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
 * Database Controller.
 *
 * @since  1.0.0
 */
class RedgitControllerDatabase extends JControllerLegacy
{
	/**
	 * Dump the database with the flow scripts
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

		$dispatcher = JEventDispatcher::getInstance();
		JPluginHelper::importPlugin('redgit');

		$result = $dispatcher->trigger('onRedgitRestoreDatabase', array('com_redgit.admin.restore', $data));

		if (in_array(false, $result, true))
		{
			throw new Exception($dispatcher->getError(), 500);
		}

		$this->setRedirect('index.php?option=com_redgit&view=dashboard');
	}
}
