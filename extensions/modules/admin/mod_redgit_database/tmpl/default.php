<?php
/**
 * @package     Redgit.Module
 * @subpackage  Admin.mod_redgit_log
 *
 * @copyright   Copyright (C) 2015 redCOMPONENT.com. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE
 */

defined('_JEXEC') or die;

$action = JRoute::_('index.php?option=com_redgit&task=database.restore');
?>
<form action="<?php echo $action ?>" method="post" name="adminForm" id="adminForm">
	<button class="btn btn-warning" type="submit" onclick="if (!confirm('<?php echo JText::_('MOD_REDGIT_DATABASE_MESSAGE_CONFIRM_RESTORE'); ?>')) return false;">
		<?php echo JText::_('MOD_REDGIT_DATABASE_LINK_RESTORE_DATABASE'); ?>
	</button>
	<?php echo JHtml::_('form.token'); ?>
</form>
