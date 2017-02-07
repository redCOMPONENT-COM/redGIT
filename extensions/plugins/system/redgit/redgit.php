<?php
/**
 * @package     Redgit.Plugin
 * @subpackage  System.Redgit
 *
 * @copyright   Copyright (C) 2015 - 2017 redcomponent.com. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE
 */

defined('_JEXEC') or die;

JLoader::import('redgit.library');

use Redgit\Application;

/**
 * redGIT system plugin system.
 *
 * @since  1.0.0
 */
class PlgSystemRedgit extends JPlugin
{
	/**
	 * This event is triggered before the framework creates the Head section of the Document.
	 *
	 * @return  void
	 */
	public function onBeforeCompileHead()
	{
		$doc = Application::getDocument();
		$doc->cleanHeader();
	}
}
