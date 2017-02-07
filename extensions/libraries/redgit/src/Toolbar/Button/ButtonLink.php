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
 * Represents a link button.
 *
 * @since  1.0
 */
class ButtonLink extends ToolbarButton
{
	/**
	 * The button url.
	 *
	 * @var  string
	 */
	protected $url;

	/**
	 * Constructor.
	 *
	 * @param   string  $text       The button text.
	 * @param   string  $url        The button task.
	 * @param   string  $class      The button class.
	 * @param   string  $iconClass  The icon class.
	 */
	public function __construct($text = '', $url = '', $class = '', $iconClass = '')
	{
		parent::__construct($text, $iconClass, $class);

		$this->url = $url;
	}

	/**
	 * Get the button url.
	 *
	 * @return  string  The url.
	 */
	public function getUrl()
	{
		return $this->url;
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
			'redgit.toolbar.button.link',
			array(
				'button' => $this,
				'isOption' => $isOption
			)
		);
	}
}
