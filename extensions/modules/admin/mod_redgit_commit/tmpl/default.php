<?php
/**
 * @package     Redgit.Module
 * @subpackage  Admin.mod_redgit_commit
 *
 * @copyright   Copyright (C) 2015 redCOMPONENT.com. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE
 */

defined('_JEXEC') or die;
$action = JRoute::_('index.php?option=com_redgit&task=git.commit');
?>
<form action="<?php echo $action ?>" method="post" name="adminForm" id="adminForm">
	<div class="form-group">
		<label for="message">Commit message:</label>
		<input id="message" type="text" class="form-control" name="message" value="<?php echo $stationConfiguration->get('default_commit_message', '[server] Latest version online'); ?>" />
	</div>
	<button class="btn btn-default" type="submit"><?php echo JText::_('MOD_REDGIT_COMMIT_LINK_COMMIT'); ?></button>
	<?php echo JHtml::_('form.token'); ?>
</form>
