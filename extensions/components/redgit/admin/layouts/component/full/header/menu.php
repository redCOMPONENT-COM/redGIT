<?php
/**
 * @package     Redgit.Backend
 * @subpackage  Layout
 *
 * @copyright   Copyright (C) 2015 - 2017 redcomponent.com. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE
 */

defined('_JEXEC') or die;

extract($displayData);

$user = JFactory::getUser();

$profileUrl = JRoute::_('index.php?option=com_admin&task=profile.edit&id=' . $user->get('id'));
$logoutUrl  = JRoute::_('index.php?option=com_login&task=logout&' . JSession::getFormToken() . '=1');

$uri = JUri::getInstance();
$return = base64_encode('index.php' . $uri->toString(array('query')));
$configurationLink = 'index.php?option=com_config&view=component&component=com_redgit&path=&return=' . $return;

?>
<ul class="nav navbar-nav">
	<!-- User Account: style can be found in dropdown.less -->
	<li class="dropdown user user-menu">
		<a href="#" class="dropdown-toggle" data-toggle="dropdown">
			<span class="hidden-xs"><?php echo $user->get('name'); ?></span>
		</a>
		<ul class="dropdown-menu">
			<!-- User image -->
			<li class="user-header">
				<p><?php echo $user->get('name'); ?><small>Member since Nov. 2012</small></p>
			</li>
			<!-- Menu Footer-->
			<li class="user-footer">
				<div class="pull-left">
				  <a href="<?php echo $profileUrl; ?>" class="btn btn-default btn-flat">Profile</a>
				</div>
				<div class="pull-right">
				  <a href="<?php echo $logoutUrl; ?>" class="btn btn-default btn-flat">Sign out</a>
				</div>
			</li>
		</ul>
	</li>
	<!-- Control Sidebar Toggle Button -->
	<li>
		<a href="<?php echo JRoute::_($configurationLink); ?>"><i class="fa fa-gears"></i></a>
	</li>
</ul>
