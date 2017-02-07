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
<div class="row">
	<div class="col-md-5">
		<div class="form-group">
			<?php
				echo $form->getLabel('git_branch');
				echo $form->getInput('git_branch');
			?>
		</div>
	</div>
	<div class="col-md-5">
		<div class="form-group">
			<?php
				echo $form->getLabel('default_commit_message');
				echo $form->getInput('default_commit_message');
			?>
		</div>
	</div>
	<div class="col-md-2">
		<div class="form-group">
			<?php
				echo $form->getLabel('ssh_port');
				echo $form->getInput('ssh_port');
			?>
		</div>
	</div>
</div>
<div class="row">
	<div class="col-md-6">
		<div class="form-group">
			<?php
				echo $form->getLabel('git_user');
				echo $form->getInput('git_user');
			?>
		</div>
	</div>
	<div class="col-md-6">
		<div class="form-group">
			<?php
				echo $form->getLabel('git_email');
				echo $form->getInput('git_email');
			?>
		</div>
	</div>
</div>
