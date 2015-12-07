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
<h2><?php echo $module->title; ?></h2>
<form action="<?php echo $action ?>" method="post" name="adminForm" id="adminForm">
	<button class="btn btn-default" type="submit">Restore database</button>
	<?php echo JHtml::_('form.token'); ?>
</form>
