<?php
/**
 * @package     Redgit.Frontend
 * @subpackage  Controller
 *
 * @copyright   Copyright (C) 2015 - 2017 redcomponent.com. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE
 */

defined('_JEXEC') or die;

use Redgit\Application;
use Redgit\Table\RedgitTable;

/**
 * Callback Controller.
 *
 * @since  1.0.0
 */
class RedgitControllerCallback extends JControllerLegacy
{
	/**
	 * Receive the bitbucket push callback
	 *
	 * @return  boolean
	 *
	 * @throws  Exception                 Forbidden access
	 * @throws  InvalidArgumentException  When returned data is not the expected
	 */
	public function receive()
	{
		$app = JFactory::getApplication();

		$callback = JTable::getInstance('Callback', 'RedgitTable');

		$data = file_get_contents('php://input');

		$tableData = array(
			'data'      => $data,
			'remote_ip' => $app->input->server->get('REMOTE_ADDR'),
			'state'     => RedgitTable::STATE_UNPUBLISHED
		);

		$plugin = JFactory::getApplication()->input->getCmd('plugin');

		if (!$plugin)
		{
			$tableData['error_message'] = JText::_("LIB_REDGIT_ERROR_CALLBACK_MISSING_PLUGIN");

			$callback->save($tableData);

			Application::getLog()->addError($tableData['error_message']);

			throw new InvalidArgumentException($tableData['error_message']);
		}

		$tableData['plugin'] = $plugin;

		$type = JFactory::getApplication()->input->getCmd('type');

		if (!$type)
		{
			$tableData['error_message'] = JText::_("LIB_REDGIT_ERROR_CALLBACK_MISSING_TYPE");

			$callback->save($tableData);

			Application::getLog()->addError($tableData['error_message']);

			throw new InvalidArgumentException($tableData['error_message']);
		}

		$tableData['type'] = $type;

		$dispatcher = Application::getDispatcher();
		JPluginHelper::importPlugin('redgit', $plugin);

		$method = 'onRedgitReceive' . ucfirst($type) . 'Callback';

		$result = $dispatcher->trigger($method, array('com_redgit.site.callback', $data));

		if (in_array(false, $result, true))
		{
			$tableData['error_message'] = JText::sprintf("LIB_REDGIT_ERROR_PROCESSING_CALLBACK", $dispatcher->getError());

			$callback->save($tableData);

			Application::getLog()->addError($tableData['error_message']);

			throw new Exception($tableData['error_message'], 500);
		}

		$tableData['state'] = RedgitTable::STATE_PUBLISHED;

		$callback->save($tableData);

		Application::sendHeaders();
		echo 'Ok';
		$app->close();
	}
}
