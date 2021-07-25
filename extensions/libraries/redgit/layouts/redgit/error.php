<?php
/**
 * @package     Redgit.Library
 * @subpackage  Layout
 *
 * @copyright   Copyright (C) 2015 - 2021 redWEB.dk. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE
 */

defined('_JEXEC') or die;

extract($displayData);

/**
 * Layout variables
 * --------------------
 * @var   string  $message  Message to display
 */

?>
<div class="alert alert-danger">
	<?php echo JText::sprintf('LIB_REDGIT_MSG_ERROR_FOUND', $message); ?>
</div>
