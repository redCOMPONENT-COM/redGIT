<?php
/**
 * @package     Redgit.Backend
 * @subpackage  Layout
 *
 * @copyright   Copyright (C) 2015 - 2017 redcomponent.com. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE
 */

defined('_JEXEC') or die;

use Redgit\Helper\AclHelper;

$app = JFactory::getApplication();
$user = JFactory::getUser();

$canDo = AclHelper::getActions();

$option = 'com_redgit';
$activeView = $app->input->get('view');
?>
<!-- sidebar menu: : style can be found in sidebar.less -->
<ul class="sidebar-menu">
	<li>
		<a href="<?php echo JRoute::_('index.php'); ?>"><i class="fa fa-joomla"></i> <span>Back to Joomla</span></a>
	</li>
	<li class="header">MAIN NAVIGATION</li>
	<li <?php echo $activeView == 'dashboard' ? 'class="active"' : null; ?>>
		<a href="<?php echo JRoute::_('index.php?option=' . $option . '&view=dashboard'); ?>">
			<i class="fa fa-dashboard"></i> <span><?php echo JText::_('COM_REDGIT_TITLE_VIEW_DASHBOARD'); ?></span>
		</a>
	</li>
	<?php if ($canDo->get('core.manage')) :?>
		<li <?php echo $activeView == 'station' ? 'class="active"' : null; ?>>
			<a href="<?php echo JRoute::_('index.php?option=' . $option . '&view=station'); ?>">
				<i class="fa fa-plug"></i> <span><?php echo JText::_('COM_REDGIT_TITLE_VIEW_STATION'); ?></span>
			</a>
		</li>
		<li <?php echo $activeView == 'callbacks' ? 'class="active"' : null; ?>>
			<a href="<?php echo JRoute::_('index.php?option=' . $option . '&view=callbacks'); ?>">
				<i class="fa fa-exchange"></i> <span><?php echo JText::_('COM_REDGIT_TITLE_VIEW_CALLBACKS'); ?></span>
			</a>
		</li>
	<?php endif; ?>
</ul>
