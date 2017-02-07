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
<div class="com_redgit">
	<div class="wrapper">
		<header class="main-header">
			<?php echo RedgitLayoutHelper::render('component.full.header', array()); ?>
		</header>
		<aside class="main-sidebar">
			<?php echo RedgitLayoutHelper::render('component.full.sidebar', array()); ?>
		</aside>
		<div class="content-wrapper">
			<section class="content-header clearfix">
				<?php echo RedgitLayoutHelper::render('component.full.content.header', $displayData); ?>
			</section>
			<section class="content">
				<?php echo RedgitLayoutHelper::render('component.full.content.body', $displayData); ?>
			</section>
		</div>
		<footer class="main-footer">
			<?php echo RedgitLayoutHelper::render('component.full.content.footer', $displayData); ?>
		</footer>
	</div>
</div>
