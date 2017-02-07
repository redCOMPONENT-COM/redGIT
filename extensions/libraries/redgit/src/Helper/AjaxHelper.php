<?php
/**
 * @package     Redgit.Library
 * @subpackage  Helper
 *
 * @copyright   Copyright (C) 2015 - 2017 redcomponent.com. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE
 */

namespace Redgit\Helper;

defined('_JEXEC') or die;

use Redgit\Application;

/**
 * AJAX helper.
 *
 * @since  1.0.5
 */
abstract class AjaxHelper
{
	/**
	 * Check if we have received an AJAX request for security reasons
	 *
	 * @return  boolean
	 */
	public static function isAjaxRequest()
	{
		$app = \JFactory::getApplication();

		return strtolower($app->input->server->get('HTTP_X_REQUESTED_WITH', '')) == 'xmlhttprequest';
	}

	/**
	 * Verify that an AJAX request has been received
	 *
	 * @param   string  $method  Method to validate the ajax request
	 *
	 * @return  void
	 *
	 * @throws   \Exception
	 */
	public static function validateAjaxRequest($method = 'post')
	{
		if (!\JSession::checkToken($method) || !static::isAjaxRequest())
		{
			$app = \JFactory::getApplication();

			Application::setHeader('status', 403);
			Application::sendHeaders();

			echo \JText::_('JLIB_APPLICATION_ERROR_ACCESS_FORBIDDEN');
			$app->close();
		}
	}
}
