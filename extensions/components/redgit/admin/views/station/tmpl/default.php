<?php
/**
 * @package     Redgit.Backend
 * @subpackage  Layout
 *
 * @copyright   Copyright (C) 2015 - 2017 redcomponent.com. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE
 */

defined('_JEXEC') or die;

use Redgit\Application;

extract($displayData);

$component = JFactory::getApplication()->input->get('option');

$action = JRoute::_('index.php?option=' . $component . '&task=station.edit');
?>
<div class="box box-grey">
	<div class="box-body">
		<?php echo RedgitLayoutHelper::render('redgit.station.settings', $displayData); ?>
	</div>
</div>
<form action="<?php echo $action ?>" method="post" name="adminForm" id="adminForm">
	<?php echo JHtml::_('form.token'); ?>
	<input type="hidden" name="task" value="" />
	<input type="hidden" name="boxchecked" value="0" />
</form>
