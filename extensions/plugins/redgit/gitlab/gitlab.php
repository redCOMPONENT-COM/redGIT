<?php
/**
 * @package     Redgit.Plugin
 * @subpackage  Redgit.Gitlab
 *
 * @copyright   Copyright (C) 2015 - 2017 redcomponent.com. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE
 */

defined('_JEXEC') or die;

require_once JPATH_LIBRARIES . '/redgit/library.php';

use Redgit\Application;
use Redgit\Plugin\RedgitPlugin;

/**
 * Gitlab plugin for redGIT.
 *
 * @since  1.0.0
 */
class PlgRedgitGitlab extends RedgitPlugin
{
	/**
	 * Receive a callback
	 *
	 * @param   string  $context  Context that describes where this callback has been received
	 * @param   mixed   $data     Data from the request
	 *
	 * @return  boolean
	 *
	 * @todo    Add X-Gitlab-Token HTTP header
	 */
	public function onRedgitReceivePushCallback($context, $data)
	{
		if (!$this->checkPluginSettings())
		{
			return false;
		}

		$data = json_decode($data);

		$config = Application::getStationConfiguration();
		$log    = Application::getLog();

		if (!$this->isValidData($data) || !$this->isAllowedRequest())
		{
			$message = JText::_('JLIB_APPLICATION_ERROR_ACCESS_FORBIDDEN');

			$log->addError($message);

			$this->_subject->setError($message);

			return false;
		}

		$git = Application::getGit();

		try
		{
			$hasChanges = $git->hasChanges();

			if ($hasChanges)
			{
				$git->add('.');

				$message = Application::getStationConfiguration()->get('default_commit_message', '[server] Latest version online');

				$git->commit($message);
			}

			$git->fetch('origin', $config->get('git_branch', 'master'));
			$git->rebase('origin/' . $config->get('git_branch', 'master'));

			if ($hasChanges)
			{
				$git->push('origin', Application::getStationConfiguration()->get('git_branch', 'master'));
			}
		}
		catch (Exception $e)
		{
			$message = JText::sprintf('LIB_REDGIT_ERROR_UPDATING_SITE', $e->getMessage());

			$log->addError($message);

			$this->_subject->setError($message);

			return false;
		}

		return true;
	}

	/**
	 * Check if plugin has all the required settings to work
	 *
	 * @return  boolean
	 */
	protected function checkPluginSettings()
	{
		$params = $this->getParams();

		$repoUrl = $params->get('gitlab_url');

		if (!$repoUrl)
		{
			$this->_subject->setError(JText::_('PLG_REDGIT_GITLAB_ERROR_MISSING_REPO_URL'));

			return false;
		}

		return true;
	}

	/**
	 * Only Gitlab servers are allowed to perform callbacks
	 *
	 * @return  boolean
	 */
	protected function isAllowedRequest()
	{
		$token = $this->getParams()->get('gitlab_token');

		if (empty($token))
		{
			return false;
		}

		$receivedToken = JFactory::getApplication()->input->server->get('HTTP_X_GITLAB_TOKEN', '', 'RAW');
		$valid = trim($receivedToken) === trim($token);

		if (!$valid)
		{
			Application::getLog()->addError('Invalid Gitlab Token received: `' . $receivedToken . '`');
		}

		return $valid;
	}

	/**
	 * Load the callback data. Forces validation.
	 *
	 * @param   mixed  $data  Data received
	 *
	 * @return  self
	 */
	protected function isValidData($data)
	{
		$log    = Application::getLog();

		$repoUrl = $this->getParams()->get('gitlab_url');

		if (!$repoUrl)
		{
			return false;
		}

		$receivedUrls = array();

		if (!empty($data->repository->git_http_url))
		{
			$receivedUrls[] = $data->repository->git_http_url;
		}

		if (!empty($data->repository->git_ssh_url))
		{
			$receivedUrls[] = $data->repository->git_ssh_url;
		}

		if (empty($data) || !in_array($repoUrl, $receivedUrls))
		{
			$message = JText::_('LIB_REDGIT_ERROR_CALLBACK_WRONG_DATA_RECEIVED');

			$this->_subject->setError($message);

			$log->addError($message);

			return false;
		}

		return true;
	}
}
