<?php
/**
 * @package     Redgit.Library
 * @subpackage  Layout
 *
 * @copyright   Copyright (C) 2015 - 2017 redcomponent.com. All rights reserved.
 * @license     GNU General Public License version 2 or later, see LICENSE.
 */

defined('_JEXEC') or die;

$data = $displayData;


if (!isset($data['button']))
{
	throw new InvalidArgumentException(JText::sprintf('LIB_REDGIT_ERROR_TOOLBAR_MISSING_BUTTON', 'button.standard'));
}

/** @var RToolbarButtonStandard $button */
$button = $data['button'];
$isOption = $data['isOption'];

$text = $button->getText();
$iconClass = $button->getIconClass();
$task = $button->getTask();
$isList = $button->isList();
$class = $button->getClass();

// Get the button command.
JHtml::_('behavior.framework');
$message = JText::_('JLIB_HTML_PLEASE_MAKE_A_SELECTION_FROM_THE_LIST');
$message = addslashes($message);

if ($isList)
{
	$cmd = "if (document.adminForm.boxchecked.value==0){alert('$message');}else{ Joomla.submitbutton('$task')}";
}
else
{
	$cmd = "Joomla.submitbutton('$task')";
}

// Get the button class.
$btnClass = $isOption ? '' : 'btn';
$btnClass .= ' ' . (empty($class) ? 'btn-default' : $class);
?>

<?php if ($isOption) :?>
	<li>
		<a href="#" class="<?php echo $btnClass ?>" onclick="<?php echo $cmd ?>">
			<?php echo $text ?>
		</a>
	</li>
<?php else:?>
	<button onclick="<?php echo $cmd ?>" class="<?php echo $btnClass ?>">
		<?php echo $text ?>
	</button>
<?php endif;?>
