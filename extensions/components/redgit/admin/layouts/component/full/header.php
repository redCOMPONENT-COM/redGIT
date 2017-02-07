<?php
/**
 * @package     Redgit.Backend
 * @subpackage  Layout
 *
 * @copyright   Copyright (C) 2015 - 2017 redcomponent.com. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE
 */

defined('_JEXEC') or die;
?>
<!-- Logo -->
<a href="<?php echo JRoute::_('index.php?option=com_redgit'); ?>" class="logo">
  <!-- mini logo for sidebar mini 50x50 pixels -->
  <span class="logo-mini">Git</span>
  <!-- logo for regular state and mobile devices -->
  <span class="logo-lg">redGIT</span>
</a>
<!-- Header Navbar: style can be found in header.less -->
<nav class="navbar navbar-static-top" role="navigation">
	<!-- Sidebar toggle button-->
	<a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
		<span class="sr-only">Toggle navigation</span>
	</a>
	<div class="navbar-custom-menu">
		<?php echo RedgitLayoutHelper::render('component.full.header.menu', $displayData); ?>
	</div>
</nav>
