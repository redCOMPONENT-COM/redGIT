<?php
/**
 * @package     Redgit.Library
 * @subpackage  Application
 *
 * @copyright   Copyright (C) 2015 - 2017 redcomponent.com. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE
 */

namespace Redgit\Git;

use GitWrapper\GitWrapper as GitWrapperBase;

/**
 * Customised GitWrapper
 *
 * @since  1.0.0
 */
class GitWrapper extends GitWrapperBase
{
	/**
	 * Returns an object that interacts with a working copy.
	 *
	 * @param   string  $directory  Path to the directory containing the working copy.
	 *
	 * @return GitWorkingCopy
	 */
	public function workingCopy($directory)
	{
		return new GitWorkingCopy($this, $directory);
	}
}
