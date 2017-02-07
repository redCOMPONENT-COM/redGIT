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
?>
<div class="alert alert-info"><?php echo JText::_('LIB_REDGIT_STATION_MSG_RECOMMENDED_PERMISSIONS'); ?></div>
<div class="row">
	<div class="col-md-6">
		<div class="form-group">
			<?php
				echo $form->getLabel('git_pull_enabled');
				echo $form->getInput('git_pull_enabled');
			?>
		</div>
	</div>
	<div class="col-md-6">
		<div class="form-group">
			<?php
				echo $form->getLabel('git_push_enabled');
				echo $form->getInput('git_push_enabled');
			?>
		</div>
	</div>
</div>
<div class="row">
	<div class="col-md-6">
		<div class="form-group">
			<?php
				echo $form->getLabel('db_dump_enabled');
				echo $form->getInput('db_dump_enabled');
			?>
		</div>
	</div>
	<div class="col-md-6">
		<div class="form-group">
			<?php
				echo $form->getLabel('db_restore_enabled');
				echo $form->getInput('db_restore_enabled');
			?>
		</div>
	</div>
</div>
