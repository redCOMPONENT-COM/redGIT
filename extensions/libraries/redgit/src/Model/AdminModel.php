<?php
/**
 * @package     Redgit.Library
 * @subpackage  Model
 *
 * @copyright   Copyright (C) 2015 - 2017 redcomponent.com. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE
 */

namespace Redgit\Model;

defined('_JEXEC') or die;

use Redgit\Application;

\JLoader::import('joomla.application.component.modeladmin');

/**
 * Base admin model.
 *
 * @since  1.1.0
 */
abstract class AdminModel extends \JModelAdmin
{
	/**
	 * Method to allow derived classes to preprocess the data.
	 *
	 * @param   string  $context  The context identifier.
	 * @param   mixed   &$data    The data to be processed. It gets altered directly.
	 *
	 * @return  void
	 */
	protected function preprocessData($context, &$data)
	{
		// Get the dispatcher and load the users plugins.
		$dispatcher = Application::getDispatcher();
		\JPluginHelper::importPlugin('content');

		// Trigger the data preparation event.
		$results = $dispatcher->trigger('onContentPrepareData', array($context, &$data));

		// Check for errors encountered while preparing the data.
		if (count($results) > 0 && in_array(false, $results, true))
		{
			$this->setError($dispatcher->getError());
		}
	}
}
