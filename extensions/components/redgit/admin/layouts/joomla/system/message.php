<?php
/**
 * @package     Joomla.Site
 * @subpackage  Layout
 *
 * @copyright   Copyright (C) 2015 - 2017 redcomponent.com. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_JEXEC') or die;

extract($displayData);

// Nothing to show
if (!is_array($msgList) || empty($msgList))
{
	return;
}

$allowedTypes = array('error', 'message', 'notice', 'warning');

?>
<div id="system-message-container">
	<div id="system-message">
		<?php
			foreach ($msgList as $type => $msgs)
			{
				$type = in_array($type, $allowedTypes) ? $type : 'notice';

				$layoutData = array(
					'type'     => $type,
					'messages' => $msgs
				);

				echo JLayoutHelper::render('joomla.system.message.' . strtolower($type), $layoutData);
			}
		?>
	</div>
</div>
