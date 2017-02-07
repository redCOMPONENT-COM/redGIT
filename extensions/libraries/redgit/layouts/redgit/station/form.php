<?php
/**
 * @package     Redgit.Library
 * @subpackage  Layout
 *
 * @copyright   Copyright (C) 2015 - 2017 redcomponent.com. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE
 */

defined('_JEXEC') or die;

use Redgit\Application;

extract($displayData);

/**
 * Layout variables
 * -----------------
 * @var   JForm                          $form    Station form
 * @var   \Redgit\Station\Configuration  $config  Current station configuration
 */

JHtml::_('behavior.keepalive');

$action = JRoute::_('index.php?option=com_redgit&view=station');
?>
<form action="<?php echo $action ?>" method="post" name="adminForm" id="adminForm">
	<div class="nav-tabs-custom">
		<ul class="nav nav-tabs">
			<li class="active"><a data-toggle="tab" href="#git" aria-expanded="true"><?php echo JText::_('LIB_REDGIT_STATION_TAB_GIT'); ?></a></li>
			<li><a data-toggle="tab" href="#folders" aria-expanded="true"><?php echo JText::_('LIB_REDGIT_STATION_TAB_FOLDERS'); ?></a></li>
			<li><a data-toggle="tab" href="#permissions" aria-expanded="true"><?php echo JText::_('LIB_REDGIT_STATION_TAB_PERMISSIONS'); ?></a></li>
		</ul>
		<div class="tab-content">
			<div id="git" class="tab-pane active">
				<?php echo RedgitLayoutHelper::render('redgit.station.form.git', $displayData); ?>
			</div>
			<div id="folders" class="tab-pane">
				<?php echo RedgitLayoutHelper::render('redgit.station.form.folders', $displayData); ?>
			</div>
			<div id="permissions" class="tab-pane">
				<?php echo RedgitLayoutHelper::render('redgit.station.form.permissions', $displayData); ?>
			</div>
		</div>
	</div>
	<input type="hidden" name="task" value="" />
	<?php echo JHtml::_('form.token'); ?>
</form>
