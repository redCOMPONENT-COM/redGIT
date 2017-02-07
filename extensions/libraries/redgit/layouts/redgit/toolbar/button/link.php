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
	throw new InvalidArgumentException(JText::sprintf('LIB_REDGIT_ERROR_TOOLBAR_MISSING_BUTTON', 'button.link'));
}

/** @var RToolbarButtonLink $button */
$button = $data['button'];
$isOption = $data['isOption'];

$class = $button->getClass();
$iconClass = $button->getIconClass();
$url = $button->getUrl();
$text = $button->getText();

// Get the button class.
$btnClass = $isOption ? '' : 'btn';
$btnClass .= ' ' . (empty($class) ? 'btn-default' : $class);

?>

<?php if ($isOption) :?>
	<li>
		<a class="<?php echo $btnClass ?>" href="<?php echo $url ?>">
			<?php if (!empty($iconClass)) : ?>
				<i class="<?php echo $iconClass ?>"></i>
			<?php endif; ?>
			<?php echo $text ?>
		</a>
	</li>
<?php else:?>
	<button class="<?php echo $btnClass ?>" onclick="location.href='<?php echo $url ?>';">
		<?php if (!empty($iconClass)) : ?>
			<i class="<?php echo $iconClass ?>"></i>
		<?php endif; ?>
		<?php echo $text ?>
	</button>
<?php endif;?>
