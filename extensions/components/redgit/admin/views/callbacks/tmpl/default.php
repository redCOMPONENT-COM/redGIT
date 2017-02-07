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

/**
 * Layout variables
 * -----------------
 * @var    \Redgit\View\AbstractView  $view       View rendering this layout
 * @var    string                     $viewTitle  Title of this view
 * @var    \Redgit\Toolbar\Toolbar    $toolbar    Toolbar to render in this view
 * @var    array                      $items      Items to render
 */

$component = JFactory::getApplication()->input->get('option');

$action = JRoute::_('index.php?option=' . $component . '&view=callbacks');

$listOrder = $this->escape($state->get('list.ordering'));
$listDirn  = $this->escape($state->get('list.direction'));
?>
<form action="<?php echo $action; ?>" class="adminForm" id="adminForm" method="post" name="adminForm">
	<div class="box">
		<?php if (empty($items)) : ?>
			<blockquote class="text-center text-warning">
				<p><?php echo JText::_('LIB_REDGIT_MSG_NO_ITEMS_FOUND'); ?></p>
			</blockquote>
		<?php else : ?>
			<table class="table table-striped" id="table-callbacks">
				<thead>
					<tr>
						<th class="text-center">
							<?php echo JHtml::_('grid.checkall'); ?>
						</th>
						<th>
							<?php echo JHtml::_('grid.sort', 'COM_REDGIT_CALLBACKS_COLUMN_CREATION_DATE', 'c.created', $listDirn, $listOrder); ?>
						</th>
						<th>
							<?php echo JHtml::_('grid.sort', 'COM_REDGIT_CALLBACKS_COLUMN_PLUGIN', 'c.plugin', $listDirn, $listOrder); ?>
						</th>
						<th>
							<?php echo JHtml::_('grid.sort', 'COM_REDGIT_CALLBACKS_COLUMN_TYPE', 'c.type', $listDirn, $listOrder); ?>
						</th>
						<th class="text-center">
							<?php echo JHtml::_('grid.sort', 'JSTATUS', 'c.state', $listDirn, $listOrder); ?>
						</th>
					</tr>
				</thead>
				<tbody>
				<?php $n = count($items); ?>
				<?php foreach ($items as $i => $item) : ?>
					<tr>
						<td class="text-center">
							<?php echo JHtml::_('grid.id', $i, $item->id); ?>
						</td>
						<td>
							<a href="<?php echo JRoute::_('index.php?option=com_redgit&view=callback&id=' . $item->id); ?>">
								<?php echo $this->escape($item->created_date); ?>
							</a>
							<small>(ip: <?php echo $this->escape($item->remote_ip); ?>)</small>
							<?php if (!$item->state) : ?>
								<br />
								<small><?php echo $this->escape($item->error_message); ?></small>
							<?php endif; ?>
						</td>
						<td>
							<?php echo $this->escape($item->plugin); ?>
						</td>
						<td>
							<?php echo $this->escape($item->type); ?>
						</td>
						<td class="text-center">
							<?php if ($item->state) : ?>
								<label class="label label-success">OK</label>
							<?php else: ?>
								<label class="label label-danger">KO</label>
							<?php endif; ?>
						</td>
					</tr>
				<?php endforeach; ?>
				</tbody>
			</table>
			<div class="box-footer clearfix">
				<?php echo $pagination->getListFooter(); ?>
			</div>
		<?php endif; ?>
	</div>

	<input type="hidden" name="task" value="" />
	<input type="hidden" name="boxchecked" value="0" />
	<input type="hidden" name="filter_order" value="<?php echo $listOrder; ?>" />
	<input type="hidden" name="filter_order_Dir" value="<?php echo $listDirn; ?>" />
	<?php echo JHtml::_('form.token'); ?>
</form>

