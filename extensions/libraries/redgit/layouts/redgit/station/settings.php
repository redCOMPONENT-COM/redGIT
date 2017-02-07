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
 * @var   \Redgit\Station\Configuration  $config  Current station configuration
 */

?>
<div class="nav-tabs-custom">
	<ul class="nav nav-tabs">
		<li class="active"><a data-toggle="tab" href="#git" aria-expanded="true"><?php echo JText::_('LIB_REDGIT_STATION_TAB_GIT'); ?></a></li>
		<li><a data-toggle="tab" href="#folders" aria-expanded="true"><?php echo JText::_('LIB_REDGIT_STATION_TAB_FOLDERS'); ?></a></li>
		<li><a data-toggle="tab" href="#permissions" aria-expanded="true"><?php echo JText::_('LIB_REDGIT_STATION_TAB_PERMISSIONS'); ?></a></li>
	</ul>
	<div class="tab-content">
		<div id="git" class="tab-pane active">
			<dl class="dl-horizontal">
				<dt><?php echo JText::_('LIB_REDGIT_STATION_FIELD_GIT_BRANCH'); ?>:</dt>
				<dd><?php echo $config->get('git_branch'); ?></dd>
				<dt><?php echo JText::_('LIB_REDGIT_STATION_FIELD_GIT_DEFAULT_COMMIT_MESSAGE'); ?>:</dt>
				<dd><?php echo $config->get('default_commit_message', '[server] Latest version'); ?></dd>
				<dt><?php echo JText::_('LIB_REDGIT_STATION_FIELD_SSH_PORT'); ?>:</dt>
				<dd><?php echo $config->get('ssh_port', 22); ?></dd>
				<dt><?php echo JText::_('LIB_REDGIT_STATION_FIELD_GIT_USER'); ?>:</dt>
				<dd><?php echo $config->get('git_user'); ?></dd>
				<dt><?php echo JText::_('LIB_REDGIT_STATION_FIELD_GIT_EMAIL'); ?>:</dt>
				<dd><?php echo $config->get('git_email'); ?></dd>
			</dl>
		</div>
		<div id="folders" class="tab-pane">
			<dl class="dl-horizontal">
				<dt><?php echo JText::_('LIB_REDGIT_STATION_FIELD_GIT_REPOSITORY'); ?>:</dt>
				<dd><?php echo $config->get('git_repository'); ?></dd>
				<dt><?php echo JText::_('LIB_REDGIT_STATION_FIELD_SSH_PRIVATE_KEY'); ?>:</dt>
				<dd><?php echo $config->get('ssh_private_key'); ?></dd>
				<dt><?php echo JText::_('LIB_REDGIT_STATION_FIELD_SSH_WRAPPER_FOLDER'); ?>:</dt>
				<dd><?php echo $config->get('ssh_wrapper_folder'); ?></dd>
				<dt><?php echo JText::_('LIB_REDGIT_STATION_FIELD_GIT_PATH'); ?>:</dt>
				<dd><?php echo $config->get('git_path'); ?></dd>
			</dl>
		</div>
		<div id="permissions" class="tab-pane">
			<dl class="dl-horizontal">
				<dt><?php echo JText::_('LIB_REDGIT_STATION_FIELD_DB_DUMP_ENABLED'); ?>:</dt>
				<dd><?php echo $config->get('db_dump_enabled') ? JText::_('JYES') : JText::_('JNO'); ?></dd>
				<dt><?php echo JText::_('LIB_REDGIT_STATION_FIELD_DB_RESTORE_ENABLED'); ?>:</dt>
				<dd><?php echo $config->get('db_restore_enabled') ? JText::_('JYES') : JText::_('JNO'); ?></dd>
				<dt><?php echo JText::_('LIB_REDGIT_STATION_FIELD_GIT_PULL_ENABLED'); ?>:</dt>
				<dd><?php echo $config->get('git_pull_enabled') ? JText::_('JYES') : JText::_('JNO'); ?></dd>
				<dt><?php echo JText::_('LIB_REDGIT_STATION_FIELD_GIT_PUSH_ENABLED'); ?>:</dt>
				<dd><?php echo $config->get('git_push_enabled') ? JText::_('JYES') : JText::_('JNO'); ?></dd>
			</dl>
		</div>
	</div>
</div>

