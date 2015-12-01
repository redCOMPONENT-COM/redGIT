<?php
/**
 * @package     Redgit.Library
 * @subpackage  Application
 *
 * @copyright   Copyright (C) 2015 redcomponent.com. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE
 */

namespace Redgit\Git;

use GitWrapper\GitWorkingCopy as GitWorkingCopyBase;
use GitWrapper\GitException;

/**
 * Customised GitWrapper
 *
 * @since  1.0.0
 */
class GitWorkingCopy extends GitWorkingCopyBase
{
	/**
	 * Executes a `git commit` command.
	 *
	 * Record changes to the repository. If only one argument is passed, it is
	 * assumed to be the commit message. Therefore `$git->commit('Message');`
	 * yields a `git commit -am "Message"` command.
	 *
	 * @code
	 * $git->commit('My commit message');
	 * $git->commit('Makefile', array('m' => 'My commit message'));
	 * @endcode
	 *
	 *
	 * @return \GitWrapper\GitWorkingCopy
	 *
	 * @throws \GitWrapper\GitException
	 */
	public function commit()
	{
		if (!$this->triggerEvent('onRedgitBeforeCommit', array('com_redgit.git.workingcopy', $this)))
		{
			return $this;
		}

		call_user_func_array(array('parent', __FUNCTION__), func_get_args());

		if (!$this->triggerEvent('onRedgitAfterCommit', array('com_redgit.git.workingcopy', $this)))
		{
			return $this;
		}
	}

	/**
	 * Method to get a setting and clear the output automatically to avoid inheriting that output
	 *
	 * @param   string  $settingName  Name of the setting. Example: 'user.name'
	 *
	 * @return  string
	 */
	public function getConfigSetting($settingName)
	{
		try
		{
			$this->config($settingName);
			$value = $this->getOutput();
		}
		catch (GitException $e)
		{
			return null;
		}

		$this->clearOutput();

		return $value;
	}

	/**
	 * Executes a `git pull` command.
	 *
	 * Fetch from and merge with another repository or a local branch.
	 *
	 * @code
	 * $git->pull('upstream', 'master');
	 * @endcode
	 *
	 *
	 * @return \GitWrapper\GitWorkingCopy
	 *
	 * @throws \GitWrapper\GitException
	 */
	public function pull()
	{
		if (!$this->triggerEvent('onRedgitBeforePull', array('com_redgit.git.workingcopy', $this)))
		{
			return $this;
		}

		call_user_func_array(array('parent', __FUNCTION__), func_get_args());

		if (!$this->triggerEvent('onRedgitAfterPull', array('com_redgit.git.workingcopy', $this)))
		{
			return $this;
		}
	}

	/**
	 * Executes a `git push` command.
	 *
	 * Update remote refs along with associated objects.
	 *
	 * @code
	 * $git->push('upstream', 'master');
	 * @endcode
	 *
	 * @return \GitWrapper\GitWorkingCopy
	 *
	 * @throws \GitWrapper\GitException
	 */
	public function push()
	{
		if (!$this->triggerEvent('onRedgitBeforePush', array('com_redgit.git.workingcopy', $this)))
		{
			return $this;
		}

		call_user_func_array(array('parent', __FUNCTION__), func_get_args());

		if (!$this->triggerEvent('onRedgitAfterPush', array('com_redgit.git.workingcopy', $this)))
		{
			return $this;
		}
	}

	/**
	 * Trigger an event
	 *
	 * @param   string  $event      Event name
	 * @param   array   $arguments  Arguments for the event being triggered
	 *
	 * @return  boolean
	 */
	protected function triggerEvent($event, $arguments)
	{
		$dispatcher = \JEventDispatcher::getInstance();

		\JPluginHelper::importPlugin('redgit');

		$results = $dispatcher->trigger($event, $arguments);

		if (count($results) && in_array(false, $results, true))
		{
			return false;
		}

		return true;
	}
}
