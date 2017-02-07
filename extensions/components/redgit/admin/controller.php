<?php
/**
 * @package     Redgit.Backend
 * @subpackage  Controller
 *
 * @copyright   Copyright (C) 2015 - 2017 redcomponent.com. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE
 */

defined('_JEXEC') or die;

/**
 * Front controller.
 *
 * @since  1.0.0
 */
class RedgitController extends JControllerLegacy
{
	/**
	 * Constructor.
	 *
	 * @param   array  $config  An optional associative array of configuration settings.
	 *
	 * @throws  Exception
	 */
	public function __construct($config = array())
	{
		parent::__construct($config);

		// J2.5 compatibility
		if (empty($this->input))
		{
			$this->input = JFactory::getApplication()->input;
		}

		// Add spport for singular named folders
		$this->addPath('view', $this->basePath . '/view');

		JModelLegacy::addIncludePath($this->basePath . '/model');
	}

	/**
	 * Typical view method for MVC based architecture
	 *
	 * This function is provide as a default implementation, in most cases
	 * you will need to override it in your own controllers.
	 *
	 * @param   boolean  $cachable   If true, the view output will be cached
	 * @param   array    $urlparams  An array of safe url parameters and their variable types, for valid values see {@link JFilterInput::clean()}.
	 *
	 * @return  JControllerLegacy  A JControllerLegacy object to support chaining.
	 */
	public function display($cachable = false, $urlparams = array())
	{
		$app = JFactory::getApplication();
		$input = $app->input;

		$input->set('view', $input->get('view', 'dashboard'));
		$input->set('task', $input->get('task', 'display'));

		return parent::display($cachable, $urlparams);
	}
}
