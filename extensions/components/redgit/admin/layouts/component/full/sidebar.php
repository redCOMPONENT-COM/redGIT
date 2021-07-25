<?php
/**
 * @package     Redgit.Backend
 * @subpackage  Layout
 *
 * @copyright   Copyright (C) 2015 - 2021 redWEB.dk. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE
 */

defined('_JEXEC') or die;
?>
<!-- sidebar: style can be found in sidebar.less -->
<section class="sidebar">
	<?php echo RedgitLayoutHelper::render('component.full.sidebar.menu', $displayData); ?>
</section>
