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

$toolbar = $view->getToolbar();
?>
<div class="row">
	<div class="col-md-6">
		<h1><?php echo $view->getTitle() ?></h1>
	</div>
	<div class="col-md-6">
		<?php if ($toolbar instanceof \Redgit\Toolbar\Toolbar) : ?>
			<div class="header-toolbar pull-right">
				<?php echo $toolbar->render() ?>
			</div>
		<?php endif; ?>
	</div>
</div>
<div class="row-fluid message-sys"></div>
