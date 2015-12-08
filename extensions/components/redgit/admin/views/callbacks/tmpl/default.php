<?php
/**
 * @package     Redgit.Backend
 * @subpackage  Layout
 *
 * @copyright   Copyright (C) 2015 redCOMPONENT.com. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE
 */

defined('_JEXEC') or die;

use Redgit\Application;

extract($displayData);

$component = JFactory::getApplication()->input->get('option');

$action = JRoute::_('index.php?option=' . $component . '&task=station.edit');
?>
<div role="alert" class="alert alert-warning">
	<h4 class="alert-heading">Work in progress</h4>
	<div>
		<p>This management is still not finished</p>
	</div>
</div>
