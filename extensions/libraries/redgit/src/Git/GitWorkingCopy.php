<?php
/**
 * @package     Redgit.Library
 * @subpackage  Application
 *
 * @copyright   Copyright (C) 2015 - 2017 redcomponent.com. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE
 */

namespace Redgit\Git;

use Redgit\Application;
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
		$arguments = func_get_args();

		if (!$this->triggerEvent('onRedgitBeforeCommit', null, array($arguments)))
		{
			return $this;
		}

		call_user_func_array(array('parent', __FUNCTION__), $arguments);

		if (!$this->triggerEvent('onRedgitAfterCommit', null, array($arguments)))
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
		$arguments = func_get_args();

		if (!$this->triggerEvent('onRedgitBeforePull', null, array($arguments)))
		{
			return $this;
		}

		call_user_func_array(array('parent', __FUNCTION__), $arguments);

		if (!$this->triggerEvent('onRedgitAfterPull', null, array($arguments)))
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
		$arguments = func_get_args();

		if (!$this->triggerEvent('onRedgitBeforePush', null, array($arguments)))
		{
			return $this;
		}

		call_user_func_array(array('parent', __FUNCTION__), $arguments);

		if (!$this->triggerEvent('onRedgitAfterPush', null, array($arguments)))
		{
			return $this;
		}
	}

	/**
	 * Executes a `git reset` command.
	 *
	 * Reset current HEAD to the specified state.
	 *
	 * @code
	 * $git->reset(array('hard' => true));
	 * @endcode
	 *
	 * @return \GitWrapper\GitWorkingCopy
	 *
	 * @throws \GitWrapper\GitException
	 */
	public function reset()
	{
		$arguments = func_get_args();

		if (!$this->triggerEvent('onRedgitBeforeReset', null, array($arguments)))
		{
			return $this;
		}

		call_user_func_array(array('parent', __FUNCTION__), $arguments);

		if (!$this->triggerEvent('onRedgitAfterReset', null, array($arguments)))
		{
			return $this;
		}
	}

	/**
	 * Trigger an event
	 *
	 * @param   string  $event    Event name
	 * @param   string  $context  Context to send
	 * @param   array   $params   Arguments for the event being triggered
	 *
	 * @return  boolean
	 */
	public function triggerEvent($event, $context = null, $params = array())
	{
		if (null === $context)
		{
			$context = 'com_redgit.git.workingcopy';
		}

		$dispatcher = Application::getDispatcher();

		\JPluginHelper::importPlugin('redgit');

		// Add context + Git as event arguments
		array_unshift($params, $this);
		array_unshift($params, $context);

		$results = $dispatcher->trigger($event, $params);

		if (count($results) && in_array(false, $results, true))
		{
			return false;
		}

		return true;
	}
}
