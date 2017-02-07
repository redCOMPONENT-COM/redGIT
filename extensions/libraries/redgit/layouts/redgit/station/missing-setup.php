<?php
/**
 * @package     Redgit.Library
 * @subpackage  Layout
 *
 * @copyright   Copyright (C) 2015 - 2017 redcomponent.com. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE
 */

defined('_JEXEC') or die;

$setupLink = JRoute::_('index.php?option=com_redgit&task=station.edit');
?>
<div class="alert alert-warning">
	<?php echo JText::sprintf('LIB_REDGIT_ERROR_STATION_IS_NOT_SETUP', $setupLink); ?>
</div>
