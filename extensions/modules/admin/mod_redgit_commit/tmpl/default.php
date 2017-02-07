<?php
/**
 * @package     Redgit.Module
 * @subpackage  Admin.mod_redgit_commit
 *
 * @copyright   Copyright (C) 2015 - 2017 redcomponent.com. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE
 */

defined('_JEXEC') or die;
$action = JRoute::_('index.php?option=com_redgit&task=git.commit');

JHtml::script('mod_redgit_commit/module.min.js', false, true, false);
?>
<form action="<?php echo $action ?>" method="post" name="adminForm" id="mod-redgit-commit">
	<p class="text-muted js-mod-redgit-commit-msg"><?php echo JText::_('MOD_REDGIT_COMMIT_MSG_MODULE_LEGEND'); ?></p>
	<!-- Reset alerts: start -->
	<div class="alert alert-info js-mod-redgit-commit-msg-confirm-reset" style="display: none;">
		<p style="margin-bottom: 15px;"><?php echo JText::_('MOD_REDGIT_COMMIT_MSG_CONFIRM_RESET'); ?></p>
		<div>
			<button class="btn btn-success js-mod-redgit-commit-btn-confirm-reset" type="button"><?php echo JText::_('JYES'); ?></button>
			<button class="btn btn-danger js-mod-redgit-commit-btn-cancel-reset" type="button"><?php echo JText::_('JNO'); ?></button>
		</div>
	</div>
	<div class="alert alert-info js-mod-redgit-commit-msg-wip-reset" style="display: none;">
		<i class="fa fa-spinner fa-pulse"></i> <?php echo JText::_('MOD_REDGIT_COMMIT_MSG_RESETING_REPOSITORY'); ?>
	</div>
	<div class="alert alert-success js-mod-redgit-commit-msg-success-reset" style="display: none;">
		<p style="margin-bottom: 15px;"><?php echo JText::_('MOD_REDGIT_COMMIT_MSG_RESET_SUCCESS'); ?></p>
		<button class="btn btn-default js-mod-redgit-commit-btn-reload" type="button"><?php echo JText::_('MOD_REDGIT_COMMIT_LINK_RETURN'); ?></button>
	</div>
	<!-- Reset alerts: end -->
	<!-- Commit alerts: start -->
	<div class="alert alert-info js-mod-redgit-commit-msg-confirm-commit" style="display: none;">
		<p style="margin-bottom: 15px;"><?php echo JText::_('MOD_REDGIT_COMMIT_MSG_CONFIRM_COMMIT'); ?></p>
		<div>
			<button class="btn btn-success js-mod-redgit-commit-btn-confirm-commit" type="button"><?php echo JText::_('JYES'); ?></button>
			<button class="btn btn-danger js-mod-redgit-commit-btn-cancel-commit" type="button"><?php echo JText::_('JNO'); ?></button>
		</div>
	</div>
	<div class="alert alert-info js-mod-redgit-commit-msg-wip-commit" style="display: none;">
		<i class="fa fa-spinner fa-pulse"></i> <?php echo JText::_('MOD_REDGIT_COMMIT_MSG_COMMITING_DATA'); ?>
	</div>
	<div class="alert alert-success js-mod-redgit-commit-msg-success-commit" style="display: none;">
		<p style="margin-bottom: 15px;"><?php echo JText::_('MOD_REDGIT_COMMIT_MSG_COMMIT_SUCCESS'); ?></p>
		<button class="btn btn-default js-mod-redgit-commit-btn-reload" type="button"><?php echo JText::_('MOD_REDGIT_COMMIT_LINK_RETURN'); ?></button>
	</div>
	<!-- Commit alerts: end -->
	<div class="alert alert-danger js-mod-redgit-commit-msg-error" style="display: none;">
		<h4><?php echo JText::_('MOD_REDGIT_COMMIT_MSG_ERROR_WAS_FOUND'); ?></H4>
		<p class="js-mod-redgit-commit-msg-error-message" style="margin-bottom: 15px;"></p>
		<button class="btn btn-default js-mod-redgit-commit-btn-return" type="button"><?php echo JText::_('MOD_REDGIT_COMMIT_LINK_RETURN'); ?></button>
	</div>

	<div class="js-mod-redgit-commit-actions">
		<div class="form-group">
			<label for="message">Commit message:</label>
			<input id="message" type="text" class="form-control" name="message" value="<?php echo $stationConfiguration->get('default_commit_message', '[server] Latest version online'); ?>" />
		</div>
		<button class="btn btn-default js-mod-redgit-commit-btn-reset" type="button"><?php echo JText::_('MOD_REDGIT_COMMIT_LINK_HARD_RESET'); ?></button>
		<button class="btn btn-default js-mod-redgit-commit-btn-commit" type="button"><?php echo JText::_('MOD_REDGIT_COMMIT_LINK_COMMIT'); ?></button>
	</div>
	<?php echo JHtml::_('form.token'); ?>
</form>
