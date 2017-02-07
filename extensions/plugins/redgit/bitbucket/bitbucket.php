<?php
/**
 * @package     Redgit.Plugin
 * @subpackage  Redgit.Bitbucket
 *
 * @copyright   Copyright (C) 2015 - 2017 redcomponent.com. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE
 */

defined('_JEXEC') or die;

require_once JPATH_LIBRARIES . '/redgit/library.php';

use Redgit\Bitbucket\Ip;
use Redgit\Application;
use Redgit\Plugin\RedgitPlugin;

/**
 * Bitbucket plugin for redGIT.
 *
 * @since  1.0
 */
class PlgRedgitBitbucket extends RedgitPlugin
{
	/**
	 * Receive a callback
	 *
	 * @param   string  $context  Context that describes where this callback has been received
	 * @param   mixed   $data     Data from the request
	 *
	 * @return  boolean
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

		if (!$this->isValidData($data))
		{
			return false;
		}

		if (!$this->isAllowedIp())
		{
			$message = JText::_('JLIB_APPLICATION_ERROR_ACCESS_FORBIDDEN');

			$log->addError($message);

			$this->_subject->setError($message);

			return false;
		}

		$git = Application::getGit();

		try
		{
			if ($git->hasChanges())
			{
				$git->add('.');

				$message = Application::getStationConfiguration()->get('default_commit_message', '[server] Latest version online');

				$git->commit($message);
			}

			$git->fetch('origin', $config->get('git_branch', 'master'));
			$git->rebase('origin/' . $config->get('git_branch', 'master'));
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

		$enabled = $params->get('bitbucket_enabled');

		if (!$enabled)
		{
			$this->_subject->setError(JText::_('PLG_REDGIT_BITBUCKET_ERROR_DISABLED'));

			return false;
		}

		$repoUrl = $params->get('bitbucket_url');

		if (!$repoUrl)
		{
			$this->_subject->setError(JText::_('PLG_REDGIT_BITBUCKET_ERROR_MISSING_REPO_URL'));

			return false;
		}

		return true;
	}

	/**
	 * Only bitbucket servers are allowed to perform callbacks
	 *
	 * @return  boolean
	 */
	protected function isAllowedIp()
	{
		return true;

		$app = JFactory::getApplication();

		$ip = new Ip($app->input->server->get('REMOTE_ADDR'));

		if (!$ip->isValid())
		{
			return false;
		}

		return true;
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
		$params = $this->getParams();
		$log    = Application::getLog();

		if (empty($data) || empty($data->repository->name))
		{
			$message = JText::_('LIB_REDGIT_ERROR_CALLBACK_WRONG_DATA_RECEIVED');

			$this->_subject->setError($message);

			$log->addError($message);

			return false;
		}

		return true;
	}
}
