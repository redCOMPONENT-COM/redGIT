<?php
/**
 * @package     Joomla.Site
 * @subpackage  Layout
 *
 * @copyright   Copyright (C) 2015 - 2017 redcomponent.com. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_JEXEC') or die;

extract($displayData);

// Nothing to show
if (empty($messages))
{
	return;
}

?>
<div class="alert alert-warning alert-dismissible" role="alert">
	<?php // This requires JS so we should add it trough JS. Progressive enhancement and stuff. ?>
	<button class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>

	<h4 class="alert-heading"><?php echo JText::_($type); ?></h4>
	<div>
		<?php foreach ($messages as $message) : ?>
			<p><?php echo $message; ?></p>
		<?php endforeach; ?>
	</div>
</div>
