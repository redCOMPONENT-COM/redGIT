<?php
/**
 * @package     Redgit.Cli
 * @subpackage  Joomla Required
 *
 * @copyright   Copyright (C) 2015 - 2016 redcomponent.com. All rights reserved.
 * @license     GNU General Public License version 2 or later, see LICENSE.
 */

// Must be called from the command line
('cli' === php_sapi_name()) or die;

error_reporting(E_ALL);
ini_set('display_errors', 1);

require_once dirname(__FILE__) . '/bootstrap.php';

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
		$dispatcher = JEventDispatcher::getInstance();
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
