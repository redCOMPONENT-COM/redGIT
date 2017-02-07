<?php
/**
 * @package     Redgit.Library
 * @subpackage  View
 *
 * @copyright   Copyright (C) 2015 - 2017 redcomponent.com. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE
 */

namespace Redgit\View;

defined('_JEXEC') or die;

use Redgit\Helper\AclHelper;
use Redgit\Application;

/**
 * Base view class.
 *
 * @since  1.0
 */
abstract class AbstractView extends \JViewLegacy
{
	/**
	 * @var  object
	 */
	protected $actions;

	/**
	 * Component URL option
	 *
	 * @var  string
	 */
	protected $componentName;

	/**
	 * Debug layouts
	 *
	 * @var  boolean
	 */
	protected $debug = false;

	/**
	 * Default layout
	 *
	 * @var  string
	 */
	protected $layout = 'redgit.view.base';

	/**
	 * System messages for the user
	 *
	 * @var    array
	 * @since  1.0
	 */
	protected $messages = array();

	/**
	 * URL to redirect
	 *
	 * @var    string
	 * @since  1.0
	 */
	protected $redirect;

	/**
	 * Default view title
	 *
	 * @var  string
	 */
	protected $title;

	/**
	 * Title to use on standard joomla toolbar
	 *
	 * @var  string
	 */
	protected $titleIcon;

	/**
	 * @var  array
	 */
	protected $toolbarButtons = array();

	/**
	 * Rendered content of the toolbar
	 *
	 * @var  string
	 */
	protected $renderedToolbar;

	/**
	 * The view options.
	 *
	 * @var  array
	 */
	protected $options = array();

	/**
	 * Constructor
	 *
	 * @param   array  $config  A named configuration array for object construction. Options:
	 *                          name: the name (optional) of the view (defaults to the view class name suffix).<br/>
	 *                          charset: the character set to use for display<br/>
	 *                          escape: the name (optional) of the function to use for escaping strings<br/>
	 *                          base_path: the parent path (optional) of the views directory (defaults to the component folder)<br/>
	 *                          template_plath: the path (optional) of the layout directory (defaults to base_path + /views/ + view name<br/>
	 *                          helper_path: the path (optional) of the helper files (defaults to base_path + /helpers/)<br/>
	 *                          layout: the layout (optional) to use to display the view<br/>
	 *
	 */
	public function __construct($config = array())
	{
		parent::__construct($config);

		// Autodetect component option
		if (empty($this->componentName))
		{
			$this->setComponentName(\JApplicationHelper::getComponentName());
		}
	}

	/**
	 * Adds a system message
	 *
	 * @param   string  $message  Message to show
	 * @param   string  $type     Type of message
	 *
	 * @return  self
	 */
	protected function addMessage($message, $type = 'message')
	{
		if (!isset($this->messages[$type]))
		{
			$this->messages[$type] = array();
		}

		$this->messages[$type][] = $message;

		return $this;
	}

	/**
	 * Common validations that may be shared by all the layouts
	 *
	 * @return  boolean
	 */
	protected function allowLayoutCommon()
	{
		return true;
	}

	/**
	 * Default layout validation
	 *
	 * @return  boolean
	 */
	protected function allowLayoutDefault()
	{
		if (!$this->allowLayoutCommon())
		{
			return false;
		}

		return true;
	}

	/**
	 * Allow to check access to the item view in child classes
	 *
	 * @param   string  $layout  Layout being rendered
	 *
	 * @return  boolean
	 */
	protected function allowLayout($layout = null)
	{
		$layout = $layout ? $layout : \JFactory::getApplication()->input->getCmd('layout', 'default');

		$validationFunction = 'allowLayout' . ucfirst(strtolower($layout));

		if (method_exists($this, $validationFunction))
		{
			return $this->$validationFunction();
		}

		return $this->allowLayoutDefault();
	}

	/**
	 * Debug a layout
	 *
	 * @param   string  $layoutId  Layout identifier
	 * @param   array   $data      Optional data to render
	 *
	 * @return  string
	 */
	public function debug($layoutId, $data = array())
	{
		$renderer = $this->getRenderer($layoutId);

		return $renderer->debug(array_merge($this->getLayoutData(), $data));
	}

	/**
	 * Method to override in each controller
	 *
	 * @param   string  $tpl  The name of the template file to parse; automatically searches through the template paths.
	 *
	 * @return  mixed  A string if successful, otherwise a Error object.
	 */
	public function display($tpl = null)
	{
		$app = \JFactory::getApplication();

		if (!$this->allowLayout($tpl))
		{
			$content = null;
		}
		else
		{
			$content = $this->render($tpl);
		}

		// If view added system messages enqueue them
		$this->enqueueAppMessages();

		// If view required a redirect do redirect user
		$redirectUrl = $this->getRedirectUrl();

		if ($redirectUrl)
		{
			$app->redirect($redirectUrl);
		}

		if ($content instanceof \Exception)
		{
			return $content;
		}

		echo Application::getRenderer($this->layout)
			->render(
				array(
					'content' => $content,
					'view'    => $this,
					'toolbar' => $this->getToolbar()
				)
			);

		return true;
	}

	/**
	 * Gets a list of the actions that can be performed.
	 *
	 * @param   string  $section    The section.
	 * @param   mixed   $component  The component name (auto = automatic)
	 * @param   mixed   $assetName  The asset name (auto = automatic)
	 *
	 * @return  JObject  The actions
	 *
	 * @throws  RuntimeException
	 */
	protected function getActions($section = 'component', $component = 'auto', $assetName = 'auto')
	{
		if (empty($this->actions))
		{
			$this->actions = AclHelper::getActions($section, $component, $assetName);
		}

		return $this->actions;
	}

	/**
	 * Get the active component name
	 *
	 * @return  string
	 */
	public function getComponentName()
	{
		// Autodetect component option
		if (empty($this->componentName))
		{
			$this->componentName = \JApplicationHelper::getComponentName();
		}

		return $this->componentName;
	}

	/**
	 * Gets the name of the latest extending class.
	 * For a class named ContentViewArticles will return Articles
	 *
	 * @return  string
	 */
	public function getInstanceName()
	{
		$class = get_class($this);

		$name = strstr($class, 'View');
		$name = str_replace('View', '', $name);

		return strtolower($name);
	}

	/**
	 * Get the data that is going to be passed to the layout
	 *
	 * @return  array
	 */
	public function getLayoutData()
	{
		return	array(
			'view'      => $this,
			'viewTitle' => $this->getTitle(),
			'toolbar'   => $this->getToolbar()
		);
	}

	/**
	 * Get the syste messages generated by this view
	 *
	 * @param   string  $type  Optional type selector
	 *
	 * @return  array
	 */
	public function getMessages($type = null)
	{
		return $type && isset($this->messages[$type]) ? $this->messages[$type] : $this->messages;
	}

	/**
	 * Method to get the model object
	 *
	 * @param   string  $name  The name of the model (optional)
	 *
	 * @return  mixed  JModelLegacy object
	 *
	 * @throws  RuntimeException
	 */
	public function getModel($name = null)
	{
		if (empty($name))
		{
			$name = ucfirst($this->getInstanceName());
		}

		if ($name === null)
		{
			$name = $this->_defaultModel;
		}

		if (!isset($this->_models[strtolower($name)]))
		{
			throw new \RuntimeException('Cannot find the model: ' . $name);
		}

		return $this->_models[strtolower($name)];
	}

	/**
	 * Has the view set a redirection?
	 *
	 * @param   boolean  $route  Process URL with JRoute?
	 *
	 * @return  string
	 */
	protected function getRedirectUrl($route = true)
	{
		return $route ? \JRoute::_($this->redirect, false) : $this->redirect;
	}

	/**
	 * Redirection URL when view is not allowed
	 *
	 * @return  string
	 */
	protected function getRedirectViewNotAllowed()
	{
		$redirect = (null !== $this->redirect) ? $this->redirect : \JRoute::_('index.php');

		return \JRoute::_('index.php');
	}

	/**
	 * Get the view title.
	 *
	 * @return  string  The view title.
	 */
	public function getTitle()
	{
		$option = \JApplicationHelper::getComponentName();

		// Autogenerated title
		$autoTitle = strtoupper($option) . '_TITLE_VIEW_' . strtoupper($this->getInstanceName());

		return !empty($this->title) ? \JText::_($this->title) : \JText::_($autoTitle);
	}

	/**
	 * Dummy sample method. Base view has no toolbar
	 *
	 * @return  string
	 */
	public function getToolbar()
	{
		if (null !== $this->renderedToolbar)
		{
			return $this->renderedToolbar;
		}

		$this->renderedToolbar = '';

		return $this->renderedToolbar;
	}

	/**
	 * Get the layout paths for this view
	 *
	 * @return  array
	 */
	protected function getLayoutPaths()
	{
		$component = \JApplicationHelper::getComponentName();
		$template  = \JFactory::getApplication()->getTemplate();

		return array(
			JPATH_THEMES . '/' . $template . '/html/' . $component . '/' . $this->getInstanceName(),
			JPATH_COMPONENT . '/view/' . $this->getInstanceName() . '/tmpl',
			JPATH_COMPONENT . '/views/' . $this->getInstanceName() . '/tmpl',
		);
	}

	/**
	 * Get the renderer and setup view paths
	 *
	 * @param   string  $layoutId  Layout to load.
	 *
	 * @return  self
	 */
	public function getRenderer($layoutId)
	{
		$app = \JFactory::getApplication();

		$autoLayout = $app->input->get('layout', 'default', 'string');
		$layoutId = $layoutId ?: $autoLayout;

		$renderer = Application::getRenderer($layoutId);

		$renderer->setIncludePaths($this->getLayoutPaths());

		return $renderer;
	}

	/**
	 * Enqueue the app messages
	 *
	 * @return  void
	 */
	protected function enqueueAppMessages()
	{
		$systemMessages = $this->getMessages();

		if (!$systemMessages)
		{
			return;
		}

		$app = \JFactory::getApplication();

		foreach ($systemMessages as $messageType => $messages)
		{
			foreach ($messages as $message)
			{
				$app->enqueueMessage($message, $messageType);
			}
		}
	}

	/**
	 * Render a layout
	 *
	 * @param   string  $layoutId  Layout identifier
	 * @param   array   $data      Optional data to render
	 *
	 * @return  string
	 */
	public function render($layoutId, $data = array())
	{
		$renderer = $this->getRenderer($layoutId);

		return $renderer->render(array_merge($this->getLayoutData(), $data));
	}

	/**
	 * Initialise the value of the component
	 *
	 * @param   string  $componentName  Component option
	 *
	 * @return  self
	 */
	public function setComponentName($componentName)
	{
		$this->componentName = !empty($config['componentOption']) ? $config['componentOption'] : \JApplicationHelper::getComponentName();

		return $this;
	}

	/**
	 * Set the view option.
	 *
	 * @param   string  $key  The option name
	 * @param   mixed   $val  The option value
	 *
	 * @return  self
	 */
	public function setOption($key, $val)
	{
		$this->options[$key] = $val;

		return $this;
	}

	/**
	 * Set a redirection
	 *
	 * @param   string  $url  URL to redirect the user
	 *
	 * @return  self
	 */
	protected function setRedirect($url)
	{
		$this->redirect = $url;

		return $this;
	}

	/**
	 * Set the view option.
	 *
	 * @param   string  $key      The option name
	 * @param   mixed   $default  The default value if not found
	 *
	 * @return  mixed
	 */
	public function getOption($key, $default = null)
	{
		if (isset($this->options[$key]))
		{
			return $this->options[$key];
		}

		return $default;
	}

	/**
	 * Check if the view has the given option.
	 *
	 * @param   string  $key  The option key
	 *
	 * @return  boolean  True if the view has the option, false otherwise
	 */
	public function hasOption($key)
	{
		return isset($this->options[$key]);
	}
}
