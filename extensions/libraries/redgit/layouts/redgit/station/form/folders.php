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
	<div class="col-md-6">
		<div class="form-group">
			<?php
				echo $form->getLabel('git_repository');
				echo $form->getInput('git_repository');
			?>
		</div>
	</div>
	<div class="col-md-6">
		<div class="form-group">
			<?php
				echo $form->getLabel('ssh_private_key');
				echo $form->getInput('ssh_private_key');
			?>
		</div>
	</div>
</div>
<div class="form-group">
	<?php
		echo $form->getLabel('ssh_wrapper_folder');
		echo $form->getInput('ssh_wrapper_folder');
	?>
</div>
<div class="form-group">
	<?php
	echo $form->getLabel('git_path');
	echo $form->getInput('git_path');
	?>
</div>

