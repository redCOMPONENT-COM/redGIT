<?php
/**
 * @package     Redgit.Cli
 * @subpackage  Joomla Required
 *
 * @copyright   Copyright (C) 2015 - 2021 redWEB.dk. All rights reserved.
 * @license     GNU General Public License version 2 or later, see LICENSE.
 */

// Must be called from the command line
('cli' === php_sapi_name()) or die;

error_reporting(E_ALL);
ini_set('display_errors', 1);

require_once dirname(__FILE__) . '/bootstrap.php';

JLoader::import('joomla.application.component.helper');

use Redgit\Application;

/**
 * Application to restore database
 *
 * @since  1.0.7
 */
class RedgitCliRestore extends RedgitCliApp
{
	/**
	 * Entry point for the script
	 *
	 * @return  void
	 */
	public function doExecute()
	{
		$dispatcher = Application::getDispatcher();
		JPluginHelper::importPlugin('redgit');

		$result = $dispatcher->trigger('onRedgitRestoreDatabase', array('com_redgit.cli.restore'));

		if (in_array(false, $result, true))
		{
			$this->out($dispatcher->getError());

			return false;
		}

		$this->out("Database successfully restored");

		return true;
	}
}

$app = JApplicationCli::getInstance('RedgitCliRestore');
JFactory::$application = $app;
$app->execute();
