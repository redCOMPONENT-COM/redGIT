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
	<section id="component">
		<div class="row message-sys"></div>
		<div class="row">
			<?php echo $content ?>
		</div>
	</section>
</div>
