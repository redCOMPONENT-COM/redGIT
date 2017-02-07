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

$toolbar = $view->getToolbar();
?>

<section id="component">
	<?php if ($toolbar instanceof RToolbar) : ?>
		<?php echo $toolbar->render() ?>
	<?php endif; ?>
	<div class="message-sys"></div>
	<?php echo $content ?>
</section>
