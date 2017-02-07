<?php
/**
 * @package     Redgit.Module
 * @subpackage  Admin.mod_redgit_git
 *
 * @copyright   Copyright (C) 2015 - 2017 redcomponent.com. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE
 */

defined('_JEXEC') or die;
?>
<div class="nav-tabs-custom">
	<ul class="nav nav-tabs">
		<li class="active"><a data-toggle="tab" href="#status" aria-expanded="true"><?php echo JText::_('MOD_REDGIT_GIT_TAB_STATUS'); ?></a></li>
		<li><a data-toggle="tab" href="#log" aria-expanded="true"><?php echo JText::_('MOD_REDGIT_GIT_TAB_LOG'); ?></a></li>
			</ul>
	<div class="tab-content">
		<div id="status" class="tab-pane active">
			<pre><?php echo $git->getStatus(); ?></pre>
		</div>
		<div id="log" class="tab-pane">
			<?php
				try
				{
					$git->log("-15", "--pretty=format:'%h - %s (%cr) | %an'", "--abbrev-commit", "--date=relative");
					$log = $git->getOutput();
				}
				catch (Exception $e)
				{
					$log = $e->getMessage();
				}

				$git->clearOutput();
			?>
			<pre><?php echo $log; ?></pre>
		</div>
	</div>
</div>

