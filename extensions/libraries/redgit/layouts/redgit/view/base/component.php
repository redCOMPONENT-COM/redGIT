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

/**
 * Avaliable variables
 * --------------------
 * 	$content : (string) HTML content to embed
 * 	$view    : (JViewLegacy) View to render
 */
?>
<div class="row">
	<div class="content">
		<section id="component">
			<div class="row">
				<h1><?php echo $view->getTitle() ?></h1>
			</div>
			<div class="row message-sys"></div>
			<hr/>
			<div class="row">
				<?php echo $content; ?>
			</div>
		</section>
	</div>
</div>
