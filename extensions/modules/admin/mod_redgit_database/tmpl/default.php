<?php
/**
 * @package     Redgit.Module
 * @subpackage  Admin.mod_redgit_log
 *
 * @copyright   Copyright (C) 2015 - 2017 redcomponent.com. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE
 */

defined('_JEXEC') or die;

$action = JRoute::_('index.php?option=com_redgit&task=database.restore');

JHtml::script('mod_redgit_database/module.min.js', false, true, false);
?>
<form action="<?php echo $action ?>" method="post" name="adminForm" id="mod-redgit-database">
	<p class="text-muted js-mod-redgit-database-msg"><?php echo JText::_('MOD_REDGIT_DATABASE_MSG_MODULE_LEGEND'); ?></p>
	<div class="alert alert-info js-mod-redgit-database-msg-confirm-dump" style="display: none;">
		<p style="margin-bottom: 15px;"><?php echo JText::_('MOD_REDGIT_DATABASE_MSG_CONFIRM_DUMP'); ?></p>
		<div>
			<button class="btn btn-success js-mod-redgit-database-btn-confirm-dump" type="button"><?php echo JText::_('JYES'); ?></button>
			<button class="btn btn-danger js-mod-redgit-database-btn-cancel-dump" type="button"><?php echo JText::_('JNO'); ?></button>
		</div>
	</div>
	<div class="alert alert-info js-mod-redgit-database-msg-wip-dump" style="display: none;">
		<i class="fa fa-spinner fa-pulse"></i> <?php echo JText::_('MOD_REDGIT_DATABASE_MSG_DUMPING_DATABASE'); ?>
	</div>
	<div class="alert alert-success js-mod-redgit-database-msg-success-dump" style="display: none;">
		<p style="margin-bottom: 15px;"><?php echo JText::_('MOD_REDGIT_DATABASE_MSG_DUMP_SUCCESS'); ?></p>
		<button class="btn btn-default js-mod-redgit-database-btn-return" type="button"><?php echo JText::_('MOD_REDGIT_DATABASE_LINK_RETURN'); ?></button>
	</div>
	<div class="alert alert-info js-mod-redgit-database-msg-confirm-restore" style="display: none;">
		<p style="margin-bottom: 15px;"><?php echo JText::_('MOD_REDGIT_DATABASE_MSG_CONFIRM_RESTORE'); ?></p>
		<div>
			<button class="btn btn-success js-mod-redgit-database-btn-confirm-restore" type="button"><?php echo JText::_('JYES'); ?></button>
			<button class="btn btn-danger js-mod-redgit-database-btn-cancel-restore" type="button"><?php echo JText::_('JNO'); ?></button>
		</div>
	</div>
	<div class="alert alert-info js-mod-redgit-database-msg-wip-restore" style="display: none;">
		<i class="fa fa-spinner fa-pulse"></i> <?php echo JText::_('MOD_REDGIT_DATABASE_MSG_RESTORING_DATABASE'); ?>
	</div>
	<div class="alert alert-success js-mod-redgit-database-msg-success-restore" style="display: none;">
		<p style="margin-bottom: 15px;"><?php echo JText::_('MOD_REDGIT_DATABASE_MSG_RESTORE_SUCCESS'); ?></p>
		<button class="btn btn-default js-mod-redgit-database-btn-reload" type="button"><?php echo JText::_('MOD_REDGIT_DATABASE_LINK_RELOAD'); ?></button>
	</div>
	<div class="alert alert-danger js-mod-redgit-database-msg-error" style="display: none;">
		<h4><?php echo JText::_('MOD_REDGIT_DATABASE_MSG_ERROR_WAS_FOUND'); ?></H4>
		<p class="js-mod-redgit-database-msg-error-message" style="margin-bottom: 15px;"></p>
		<button class="btn btn-default js-mod-redgit-database-btn-return" type="button"><?php echo JText::_('MOD_REDGIT_DATABASE_LINK_RETURN'); ?></button>
	</div>
	<div class="js-mod-redgit-database-actions">
		<?php if ($canDump) : ?>
			<button class="btn btn-default js-mod-redgit-database-btn-dump"  type="button">
				<?php echo JText::_('MOD_REDGIT_DATABASE_LINK_DUMP_DATABASE'); ?>
			</button>
			<button class="btn btn-success js-mod-redgit-database-btn-push" style="display: none;" type="button">
				<?php echo JText::_('MOD_REDGIT_DATABASE_LINK_PUSH'); ?>
			</button>
		<?php endif; ?>
		<?php if ($canRestore) : ?>
			<button class="btn btn-default js-mod-redgit-database-btn-restore" type="button">
				<?php echo JText::_('MOD_REDGIT_DATABASE_LINK_RESTORE_DATABASE'); ?>
			</button>
		<?php endif; ?>
	</div>
	<?php echo JHtml::_('form.token'); ?>
</form>
