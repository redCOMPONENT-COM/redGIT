<?php
/**
 * @package     Redgit.Backend
 * @subpackage  Layout
 *
 * @copyright   Copyright (C) 2008 - 2015 redCOMPONENT.com. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE
 */

defined('_JEXEC') or die;

use Redgit\Application;

extract($displayData);

/**
 * Layout variables
 * ------------------
 * @var   array  $mainModules     Modules to display in the main area
 * @var   array  $sidebarModules  Modules to display in the sidebar
 */
?>
<div class="row">
	<div class="col-md-8">
		<?php foreach ($mainModules as $module) : ?>
			<?php echo RedgitLayoutHelper::render('redgit.module.box', compact('module')); ?>
		<?php endforeach; ?>
	</div>
	<div class="col-md-4 dashboard-sidebar">
		<?php foreach ($sidebarModules as $module) : ?>
			<?php echo RedgitLayoutHelper::render('redgit.module.box', compact('module')); ?>
		<?php endforeach; ?>
	</div>
</div>


