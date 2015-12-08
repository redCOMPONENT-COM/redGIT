<?php
/**
 * @package     Redgit.Library
 * @subpackage  Layout
 *
 * @copyright   Copyright (C) 2015 redCOMPONENT.com. All rights reserved.
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
<dl class="dl-horizontal">
	<dt><?php echo JText::_('LIB_REDGIT_STATION_FIELD_GIT_REPOSITORY'); ?>:</dt>
	<dd><?php echo $config->get('git_repository'); ?></dd>
	<dt><?php echo JText::_('LIB_REDGIT_STATION_FIELD_GIT_USER'); ?>:</dt>
	<dd><?php echo $config->get('git_user'); ?></dd>
	<dt><?php echo JText::_('LIB_REDGIT_STATION_FIELD_GIT_EMAIL'); ?>:</dt>
	<dd><?php echo $config->get('git_email'); ?></dd>
	<dt><?php echo JText::_('LIB_REDGIT_STATION_FIELD_GIT_BRANCH'); ?>:</dt>
	<dd><?php echo $config->get('git_branch'); ?></dd>
	<dt><?php echo JText::_('LIB_REDGIT_STATION_FIELD_GIT_DEFAULT_COMMIT_MESSAGE'); ?>:</dt>
	<dd><?php echo $config->get('default_commit_message', '[server] Latest version'); ?></dd>
	<dt><?php echo JText::_('LIB_REDGIT_STATION_FIELD_SSH_PRIVATE_KEY'); ?>:</dt>
	<dd><?php echo $config->get('ssh_private_key'); ?></dd>
	<dt><?php echo JText::_('LIB_REDGIT_STATION_FIELD_DB_DUMP_ENABLED'); ?>:</dt>
	<dd><?php echo $config->get('db_dump_enabled') ? JText::_('JYES') : JText::_('JNO'); ?></dd>
	<dt><?php echo JText::_('LIB_REDGIT_STATION_FIELD_DB_RESTORE_ENABLED'); ?>:</dt>
	<dd><?php echo $config->get('db_restore_enabled') ? JText::_('JYES') : JText::_('JNO'); ?></dd>
</dl>
