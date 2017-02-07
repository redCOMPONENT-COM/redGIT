<?php
/**
 * @package     Redgit.Module
 * @subpackage  Admin.mod_redgit_remotes
 *
 * @copyright   Copyright (C) 2015 - 2017 redcomponent.com. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE
 */

defined('_JEXEC') or die;

$action = JRoute::_('index.php?option=com_redgit');
?>
<form action="<?php echo $action ?>" method="post" name="adminForm" id="adminForm">
	<button class="btn btn-default" type="submit" onclick="document.getElementById('remote_task').value='git.pull';"><?php echo JText::_('MOD_REDGIT_REMOTE_LINK_PULL'); ?></button>
	<button class="btn btn-default" type="submit" onclick="document.getElementById('remote_task').value='git.pull';"><?php echo JText::_('MOD_REDGIT_REMOTE_LINK_PUSH'); ?></button>
	<input type="hidden" id="remote_task" name="task" value="" />
	<?php echo JHtml::_('form.token'); ?>
</form>
