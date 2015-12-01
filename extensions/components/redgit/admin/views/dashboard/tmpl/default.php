<?php
/**
 * @package     RedITEM.Backend
 * @subpackage  Template
 *
 * @copyright   Copyright (C) 2008 - 2015 redCOMPONENT.com. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE
 */

defined('_JEXEC') or die;

use Redgit\Application;

$component = JFactory::getApplication()->input->get('option');

$action = JRoute::_('index.php?option=' . $component . '&task=git.commit');
?>

<p>Latest git activity:</p>
<pre><?php echo $this->gitLog; ?> </pre>
<form action="<?php echo $action ?>" method="post" name="adminForm" id="adminForm">
	<fieldset>
		<label for="message">Commit message:</label>
		<input id="message" type="text" class="span6" name="message" value="<?php echo Application::getConfig()->get('default_commit_message', '[server] Latest version online'); ?>" />
	</fieldset>
	<button class="btn btn-primary" type="submit">Dump database &amp; commit changes</button>
	<?php echo JHtml::_('form.token'); ?>
</form>
