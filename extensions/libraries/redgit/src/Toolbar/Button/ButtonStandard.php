<?php
/**
 * @package     Redgit.Library
 * @subpackage  Toolbar
 *
 * @copyright   Copyright (C) 2015 - 2017 redcomponent.com. All rights reserved.
 * @license     GNU General Public License version 2 or later, see LICENSE.
 */

namespace Redgit\Toolbar\Button;

defined('_JEXEC') or die;

use Redgit\Toolbar\ToolbarButton;

/**
 * Represents a standard button.
 *
 * @since  1.0
 */
class ButtonStandard extends ToolbarButton
{
	/**
	 * The button task.
	 *
	 * @var  string
	 */
	protected $task;

	/**
	 * Is this applying on a list ?
	 *
	 * @var  boolean
	 */
	protected $list;

	/**
	 * Constructor.
	 *
	 * @param   string   $text       The button text.
	 * @param   string   $task       The button task.
	 * @param   string   $class      The button class.
	 * @param   string   $iconClass  The icon class.
	 * @param   boolean  $list       Is the button applying on a list ?
	 */
	public function __construct($text = '', $task = '', $class = '', $iconClass = '', $list = true)
	{
		parent::__construct($text, $iconClass, $class);

		$this->task = $task;
		$this->list = $list;
	}

	/**
	 * Get the button task.
	 *
	 * @return  string  The task.
	 */
	public function getTask()
	{
		return $this->task;
	}

	/**
	 * Check if the button applies on a list.
	 *
	 * @return  boolean  True if applying on a list, false otherwise.
	 */
	public function isList()
	{
		return $this->list;
	}

	/**
	 * Render the button.
	 *
	 * @param   boolean  $isOption  Is menu option?
	 *
	 * @return  string  The rendered button.
	 */
	public function render($isOption = false)
	{
		return \RedgitLayoutHelper::render(
			'redgit.toolbar.button.standard',
			array(
				'button' => $this,
				'isOption' => $isOption
			)
		);
	}
}
