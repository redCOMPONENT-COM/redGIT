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

/**
 * ACL helper.
 *
 * @since  1.0.0
 */
class AclHelper
{
	/**
	 * Gets a list of the actions that can be performed.
	 *
	 * @param   string  $section    The section.
	 * @param   mixed   $component  The component name (auto = automatic)
	 * @param   mixed   $assetName  The asset name (auto = automatic)
	 *
	 * @return  \JObject  The actions
	 *
	 * @throws  \RuntimeException
	 */
	public static function getActions($section = 'component', $component = 'auto', $assetName = 'auto')
	{
		if ('auto' === $component)
		{
			$component = \JApplicationHelper::getComponentName();
		}

		if (empty($component))
		{
			throw new \RuntimeException('Cannot detect the component name in getActions()');
		}

		if ('auto' === $assetName)
		{
			$assetName = $component;
		}

		$user = \JFactory::getUser();
		$result	= new \JObject;
		$actions = \JAccess::getActions($component, $section);

		foreach ($actions as $action)
		{
			$result->set($action->name,	$user->authorise($action->name, $assetName));
		}

		return $result;
	}
}
