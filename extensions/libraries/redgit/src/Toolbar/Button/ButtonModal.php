<?php
/**
 * @package     Redgit.Library
 * @subpackage  Toolbar
 *
 * @copyright   Copyright (C) 2015 - 2017 redcomponent.com. All rights reserved.
 * @license     GNU General Public License version 2 or later, see LICENSE.
 */

defined('_JEXEC') or die;

use Redgit\Toolbar\ToolbarButton;

/**
 * Represents a modal button.
 *
 * @since  1.0.0
 */
class ButtonModal extends ToolbarButton
{
	/**
	 * The data-target attribute.
	 *
	 * @var  string
	 */
	protected $dataTarget;

	/**
	 * Is this applying on a list ?
	 *
	 * @var  boolean
	 */
	protected $list;

	/**
	 * The button params
	 *
	 * @var array
	 */
	public $params;

	/**
	 * Constructor.
	 *
	 * @param   string   $text        The button text.
	 * @param   string   $dataTarget  The data-target attribute.
	 * @param   string   $class       The button class.
	 * @param   string   $iconClass   The icon class.
	 * @param   boolean  $list        Is the button applying on a list ?
	 * @param   array    $params      The button params
	 */
	public function __construct($text = '', $dataTarget = '', $class = '', $iconClass = '', $list = false, $params = array())
	{
		parent::__construct($text, $iconClass, $class);

		$this->params = $params;
		$this->dataTarget = $dataTarget;
		$this->list = $list;
	}

	/**
	 * Get button params
	 *
	 * @return array
	 */
	public function getParams()
	{
		return $this->params;
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
	 * Get the data target attribute.
	 *
	 * @return  string  The data-target attribute.
	 */
	public function getDataTarget()
	{
		return $this->dataTarget;
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
			'redgit.toolbar.button.modal',
			array(
				'button' => $this,
				'isOption' => $isOption
			)
		);
	}
}
