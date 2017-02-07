<?php
/**
 * @package     Redgit.Library
 * @subpackage  Layout
 *
 * @copyright   Copyright (C) 2015 - 2017 redcomponent.com. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE
 */

defined('_JEXEC') or die;

extract($displayData);

/**
 * Layout variables
 * -----------------
 * @var   stdClass  $item  Callback information
 */

$data = new JRegistry($item->data);
$createdDate = $this->escape($item->created_date);

$timeZone = JFactory::getUser()->getParam('timezone', 'UTC');
$date = JDate::getInstance($createdDate, $timeZone);

?>
<div class="nav-tabs-custom">
	<ul class="nav nav-tabs">
		<li class="active"><a data-toggle="tab" href="#details" aria-expanded="true"><?php echo JText::_('LIB_REDGIT_TAB_DETAILS'); ?></a></li>
		<li><a data-toggle="tab" href="#data" aria-expanded="true"><?php echo JText::_('LIB_REDGIT_CALLBACK_TAB_DATA'); ?></a></li>
	</ul>
	<div class="tab-content">
		<div id="details" class="tab-pane active">
			<dl class="dl-horizontal">
				<dt><?php echo JText::_('LIB_REDGIT_CALLBACK_FIELD_DATE'); ?>:</dt>
				<dd><?php echo $date->toSql(); ?></dd>
				<dt><?php echo JText::_('LIB_REDGIT_CALLBACK_FIELD_REMOTE_IP'); ?>:</dt>
				<dd><?php echo $this->escape($item->remote_ip); ?></dd>
				<dt><?php echo JText::_('LIB_REDGIT_CALLBACK_FIELD_PLUGIN'); ?>:</dt>
				<dd><?php echo $this->escape($item->plugin); ?></dd>
				<dt><?php echo JText::_('LIB_REDGIT_CALLBACK_FIELD_TYPE'); ?>:</dt>
				<dd><?php echo $this->escape($item->type); ?></dd>
				<dt><?php echo JText::_('LIB_REDGIT_CALLBACK_FIELD_STATE'); ?>:</dt>
				<dd>
					<?php if ($item->state) : ?>
						<label class="label label-success">OK</label>
					<?php else: ?>
						<label class="label label-danger">KO</label>
					<?php endif; ?>
				</dd>
				<dt><?php echo JText::_('LIB_REDGIT_CALLBACK_FIELD_ERROR_MESSAGE'); ?>:</dt>
				<dd><?php echo $this->escape($item->error_message); ?></dd>
			</dl>
		</div>
		<div id="data" class="tab-pane">
			<pre><?php print_r($data->toArray()); ?></pre>
		</div>
	</div>
</div>

