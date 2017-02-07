<?php
/**
 * @package     Redgit.Backend
 * @subpackage  View
 *
 * @copyright   Copyright (C) 2015 - 2017 redcomponent.com. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE
 */

defined('_JEXEC') or die;

use Redgit\View\AbstractView;

/**
 * Station View.
 *
 * @since  1.0.0
 */
class RedgitViewCallbacks extends AbstractView
{
	/**
	 * Get the data that is going to be passed to the layout
	 *
	 * @return  array
	 */
	public function getLayoutData()
	{
		$data = parent::getLayoutData();

		$model = $this->getModel();

		$data['items'] = $model->getItems();
		$data['state'] = $model->getState();
		$data['pagination'] = $model->getPagination();

		return $data;
	}
}
