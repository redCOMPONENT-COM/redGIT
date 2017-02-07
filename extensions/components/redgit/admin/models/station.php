<?php
/**
 * @package     Joomla.Administrator
 * @subpackage  com_content
 *
 * @copyright   Copyright (C) 2015 - 2017 redcomponent.com. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_JEXEC') or die;

use Joomla\Registry\Registry;
use Redgit\Application;
use Redgit\Model\AdminModel;

/**
 * Station model.
 *
 * @since  1.0.0
 */
class RedgitModelStation extends AdminModel
{
	/**
	 * Method to get the record form.
	 *
	 * @param   array    $data      Data for the form.
	 * @param   boolean  $loadData  True if the form is to load its own data (default case), false if not.
	 *
	 * @return  mixed  A JForm object on success, false on failure
	 */
	public function getForm($data = array(), $loadData = true)
	{
		// Get the form.
		$form = $this->loadForm('com_redgit.station', 'station', array('control' => 'jform', 'load_data' => $loadData));

		if (empty($form))
		{
			return false;
		}

		return $form;
	}

	/**
	 * Method to get a single record.
	 *
	 * @param   integer  $pk  The id of the primary key.
	 *
	 * @return  mixed  Object on success, false on failure.
	 */
	public function getItem($pk = null)
	{
		return Application::getStationConfiguration();
	}

	/**
	 * Method to get the data that should be injected in the form.
	 *
	 * @return  mixed  The data for the form.
	 */
	protected function loadFormData()
	{
		// Check the session for previously entered form data.
		$app = JFactory::getApplication();
		$data = $app->getUserState('com_redgit.edit.station.data', array());

		if (empty($data))
		{
			$data = $this->getItem()->toObject();
		}

		$this->preprocessData('com_redgit.station', $data);

		return $data;
	}

	/**
	 * Method to save the form data.
	 *
	 * @param   array  $data  The form data.
	 *
	 * @return  boolean  True on success.
	 */
	public function save($data)
	{
		$stationConfig = Application::getStationConfiguration();

		try
		{
			$stationConfig->save(new JRegistry($data));
		}
		catch (Exception $e)
		{
			$this->setError($e->getMessage());

			return false;
		}

		return true;
	}
}
