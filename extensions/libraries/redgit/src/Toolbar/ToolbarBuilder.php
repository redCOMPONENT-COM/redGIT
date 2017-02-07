<?php
/**
 * @package     Redgit.Library
 * @subpackage  Toolbar
 *
 * @copyright   Copyright (C) 2015 - 2017 redcomponent.com. All rights reserved.
 * @license     GNU General Public License version 2 or later, see LICENSE.
 */

namespace Redgit\Toolbar;

defined('_JEXEC') or die;

use Redgit\Toolbar\Button\ButtonLink;
use Redgit\Toolbar\Button\ButtonModal;
use Redgit\Toolbar\Button\ButtonStandard;

/**
 * Class helping to build toolbars.
 *
 * @since  1.0
 */
final class ToolbarBuilder
{
	/**
	 * Create an edit button.
	 *
	 * @param   string  $task   The task name.
	 * @param   string  $class  A css class to add to the button.
	 *
	 * @return  \Redgit\Toolbar\Button\ButtonStandard  The button.
	 */
	public static function createEditButton($task, $class = '')
	{
		return new ButtonStandard('JTOOLBAR_EDIT', $task, $class, 'icon-edit');
	}

	/**
	 * Create a copy button.
	 *
	 * @param   string  $task   The task name.
	 * @param   string  $class  A css class to add to the button.
	 *
	 * @return  \Redgit\Toolbar\Button\ButtonStandard  The button.
	 */
	public static function createCopyButton($task, $class = '')
	{
		return new ButtonStandard('RTOOLBAR_COPY', $task, $class, 'icon-copy');
	}

	/**
	 * Create a new button.
	 *
	 * @param   string  $task        The task name.
	 * @param   string  $class       A css class to add to the button.
	 * @param   string  $classAddOn  A css class add on.
	 *
	 * @return  \Redgit\Toolbar\Button\ButtonStandard  The button.
	 */
	public static function createNewButton($task, $class = '', $classAddOn = 'btn-success')
	{
		$class = !empty($class) ? $class . ' ' . $classAddOn : $classAddOn;

		return new ButtonStandard('JTOOLBAR_NEW', $task, $class, 'icon-file-text', '', false);
	}

	/**
	 * Create a publish button.
	 *
	 * @param   string  $task   The task name.
	 * @param   string  $class  A css class to add to the button.
	 *
	 * @return  \Redgit\Toolbar\Button\ButtonStandard  The button.
	 */
	public static function createPublishButton($task, $class = '')
	{
		return new ButtonStandard('JTOOLBAR_PUBLISH', $task, $class, 'icon-plus');
	}

	/**
	 * Create an unpublish button.
	 *
	 * @param   string  $task   The task name.
	 * @param   string  $class  A css class to add to the button.
	 *
	 * @return  \Redgit\Toolbar\Button\ButtonStandard  The button.
	 */
	public static function createUnpublishButton($task, $class = '')
	{
		return new ButtonStandard('JTOOLBAR_UNPUBLISH', $task, $class, 'icon-minus');
	}

	/**
	 * Create a trash button.
	 *
	 * @param   string  $task   The task name.
	 * @param   string  $class  A css class to add to the button.
	 *
	 * @return  \Redgit\Toolbar\Button\ButtonStandard  The button.
	 */
	public static function createTrashButton($task, $class = '')
	{
		return new ButtonStandard('JTOOLBAR_TRASH', $task, $class, 'icon-trash');
	}

	/**
	 * Create an archive button.
	 *
	 * @param   string  $task   The task name.
	 * @param   string  $class  A css class to add to the button.
	 *
	 * @return  \Redgit\Toolbar\Button\ButtonStandard  The button.
	 */
	public static function createArchiveButton($task, $class = '')
	{
		return new ButtonStandard('JTOOLBAR_ARCHIVE', $task, $class, 'icon-archive');
	}

	/**
	 * Create a featured button.
	 *
	 * @param   string  $task   The task name.
	 * @param   string  $class  A css class to add to the button.
	 *
	 * @return  \Redgit\Toolbar\Button\ButtonStandard  The button.
	 */
	public static function createFeaturedButton($task, $class = '')
	{
		return new ButtonStandard('JFEATURED', $task, $class, 'icon-featured');
	}

	/**
	 * Create a delete button.
	 *
	 * @param   string  $task        The task name.
	 * @param   string  $class       A css class to add to the button.
	 * @param   string  $classAddOn  A css class add on.
	 *
	 * @return  \Redgit\Toolbar\Button\ButtonStandard  The button.
	 */
	public static function createDeleteButton($task, $class = '', $classAddOn = 'btn-danger')
	{
		$class = !empty($class) ? $class . ' ' . $classAddOn : $classAddOn;

		return new ButtonStandard('JTOOLBAR_DELETE', $task, $class, 'icon-remove');
	}

	/**
	 * Create a checkin button.
	 *
	 * @param   string  $task   The task name.
	 * @param   string  $class  A css class to add to the button.
	 *
	 * @return  \Redgit\Toolbar\Button\ButtonStandard  The button.
	 */
	public static function createCheckinButton($task, $class = '')
	{
		return new ButtonStandard('JTOOLBAR_CHECKIN', $task, $class, 'icon-check');
	}

	/**
	 * Create a cancel button.
	 *
	 * @param   string  $task        The task name.
	 * @param   string  $class       A css class to add to the button.
	 * @param   string  $classAddOn  A css class add on.
	 *
	 * @return  \Redgit\Toolbar\Button\ButtonStandard  The button.
	 */
	public static function createCancelButton($task, $class = '', $classAddOn = 'btn-danger')
	{
		$class = !empty($class) ? $class . ' ' . $classAddOn : $classAddOn;

		return new ButtonStandard('JTOOLBAR_CANCEL', $task, $class, 'icon-remove', false);
	}

	/**
	 * Create a close button.
	 *
	 * @param   string  $task        The task name.
	 * @param   string  $class       A css class to add to the button.
	 * @param   string  $classAddOn  A css class add on.
	 *
	 * @return  \Redgit\Toolbar\Button\ButtonStandard  The button.
	 */
	public static function createCloseButton($task, $class = '', $classAddOn = 'btn-danger')
	{
		$class = !empty($class) ? $class . ' ' . $classAddOn : $classAddOn;

		return new ButtonStandard('JTOOLBAR_CLOSE', $task, $class, 'icon-remove', false);
	}

	/**
	 * Create a save button.
	 *
	 * @param   string  $task        The task name.
	 * @param   string  $class       A css class to add to the button.
	 * @param   string  $classAddOn  A css class add on.
	 *
	 * @return  \Redgit\Toolbar\Button\ButtonStandard  The button.
	 */
	public static function createSaveButton($task, $class = '', $classAddOn = 'btn-success')
	{
		$class = !empty($class) ? $class . ' ' . $classAddOn : $classAddOn;

		return new ButtonStandard('JTOOLBAR_APPLY', $task, $class, 'icon-save', false);
	}

	/**
	 * Create a save and close button.
	 *
	 * @param   string  $task   The task name.
	 * @param   string  $class  A css class to add to the button.
	 *
	 * @return  \Redgit\Toolbar\Button\ButtonStandard  The button.
	 */
	public static function createSaveAndCloseButton($task, $class = '')
	{
		return new ButtonStandard('JTOOLBAR_SAVE', $task, $class, 'icon-save', false);
	}

	/**
	 * Create a save and new button.
	 *
	 * @param   string  $task   The task name.
	 * @param   string  $class  A css class to add to the button.
	 *
	 * @return  \Redgit\Toolbar\Button\ButtonStandard  The button.
	 */
	public static function createSaveAndNewButton($task, $class = '')
	{
		return new ButtonStandard('JTOOLBAR_SAVE_AND_NEW', $task, $class, 'icon-save', false);
	}

	/**
	 * Create a save as copy button.
	 *
	 * @param   string  $task   The task name.
	 * @param   string  $class  A css class to add to the button.
	 *
	 * @return  \Redgit\Toolbar\Button\ButtonStandard  The button.
	 */
	public static function createSaveAsCopyButton($task, $class = '')
	{
		return new ButtonStandard('JTOOLBAR_SAVE_AS_COPY', $task, $class, 'icon-copy', false);
	}

	/**
	 * Create a link button.
	 *
	 * @param   string  $url        The button task.
	 * @param   string  $text       The button text.
	 * @param   string  $iconClass  The icon class.
	 * @param   string  $class      The button class.
	 *
	 * @return  \Redgit\Toolbar\Button\ButtonLink  The button.
	 */
	public static function createLinkButton($url, $text, $iconClass = '', $class = '')
	{
		return new ButtonLink($text, $url, $class, $iconClass);
	}

	/**
	 * Create an options (preferences) button.
	 *
	 * @param   string  $component  The component name.
	 * @param   string  $path       The path.
	 * @param   string  $class      A class attribute for the button.
	 *
	 * @return  \Redgit\Toolbar\Button\ButtonLink  The button.
	 */
	public static function createOptionsButton($component, $path = '', $class = '')
	{
		$component = urlencode($component);
		$path = urlencode($path);
		$uri = (string) JUri::getInstance();
		$return = urlencode(base64_encode($uri));
		$link = 'index.php?option=com_config&amp;view=component&amp;component=' .
			$component . '&amp;path=' . $path . '&amp;return=' . $return;

		return new ButtonLink('JToolbar_Options', $link, $class, 'icon-cogs');
	}

	/**
	 * Create a standard button (mapped to a controller task).
	 *
	 * @param   string   $task       The button task.
	 * @param   string   $text       The button text.
	 * @param   string   $class      The button class.
	 * @param   string   $iconClass  The icon class.
	 * @param   boolean  $list       Is the button applying on a list ?
	 *
	 * @return  \Redgit\Toolbar\Button\ButtonStandard  The button.
	 */
	public static function createStandardButton($task, $text, $class = '', $iconClass = '', $list = true)
	{
		return new ButtonStandard($text, $task, $class, $iconClass, $list);
	}

	/**
	 * Create a modal button.
	 *
	 * @param   string   $dataTarget  The data-target selector.
	 * @param   string   $text        The button text.
	 * @param   string   $class       The button class.
	 * @param   string   $iconClass   The icon class.
	 * @param   boolean  $list        Is the button applying on a list ?
	 * @param   array    $params      The list params
	 *
	 * @return  \Redgit\Toolbar\Button\ButtonModal  The button.
	 */
	public static function createModalButton($dataTarget, $text, $class = '', $iconClass = '', $list = false, $params = array())
	{
		return new ButtonModal($text, $dataTarget, $class, $iconClass, $list, $params);
	}
}
