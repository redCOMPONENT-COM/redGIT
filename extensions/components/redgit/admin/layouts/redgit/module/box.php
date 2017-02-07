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

/**
 * Layout variables
 * ------------------
 * @var   stdClass  $module  Module object from JModuleHelper
 */

$params = new JRegistry($module->params);
$headerTag = $params->get('header_tag', 'h4');
?>
<div class="module box <?php echo $params->get('moduleclass_sfx'); ?>">
	<?php if ($module->showtitle) : ?>
		<div class="box-header  <?php echo $params->get('header_class', 'with-border'); ?>">
			<<?php echo $headerTag; ?>><?php echo $module->title; ?></<?php echo $headerTag; ?>>
		</div>
	<?php endif; ?>
	<div class="box-body">
		<?php echo JModuleHelper::renderModule($module); ?>
	</div>
</div>
