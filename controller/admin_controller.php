<?php
/**
*
* @package Copy New Topic Extension
* @copyright (c) 2016 david63
* @license GNU General Public License, version 2 (GPL-2.0)
*
*/

namespace david63\copynewtopic\controller;

use phpbb\config\config;
use phpbb\request\request;
use phpbb\template\template;
use phpbb\user;
use phpbb\language\language;
use phpbb\log\log;
use david63\copynewtopic\core\functions;

/**
* Admin controller
*/
class admin_controller implements admin_interface
{
	/** @var \phpbb\config\config */
	protected $config;

	/** @var \phpbb\request\request */
	protected $request;

	/** @var \phpbb\template\template */
	protected $template;

	/** @var \phpbb\user */
	protected $user;

	/** @var \phpbb\language\language */
	protected $language;

	/** @var \phpbb\log\log */
	protected $log;

	/** @var \david63\copynewtopic\core\functions */
	protected $functions;

	/** @var string Custom form action */
	protected $u_action;

	protected $copy_enabled;
	protected $from_forum;
	protected $to_forum;

	/**
	* Constructor for admin controller
	*
	* @param \phpbb\config\config					$config			Config object
	* @param \phpbb\request\request					$request		Request object
	* @param \phpbb\template\template				$template		Template object
	* @param \phpbb\user							$user			User object
	* @param \phpbb\language\language				$language		Language object
	* @param \phpbb\log\log							$log			Log object
	* @param \david63\copynewtopic\core\functions	$functions		Functions for the extension
	*
	* @return \phpbb\copynewtopic\controller\admin_controller
	* @access public
	*/
	public function __construct(config $config, request $request, template $template, user $user, language $language, log $log, functions $functions)
	{
		$this->config		= $config;
		$this->request		= $request;
		$this->template		= $template;
		$this->user			= $user;
		$this->language		= $language;
		$this->log			= $log;
		$this->functions	= $functions;
	}

	/**
	* Display the options a user can configure for this extension
	*
	* @return null
	* @access public
	*/
	public function display_options()
	{
		// Add the language file
		$this->language->add_lang('acp_copynewtopic', $this->functions->get_ext_namespace());

		// Create a form key for preventing CSRF attacks
		$form_key = 'copynewtopic_manage';
		add_form_key($form_key);

		$back = false;

		// Is the form being submitted?
		if ($this->request->is_set_post('submit'))
		{
			// Is the submitted form is valid?
			if (!check_form_key($form_key))
			{
				trigger_error($this->language->lang('FORM_INVALID') . adm_back_link($this->u_action), E_USER_WARNING);
			}

			// Let's do some error checking
			$this->copy_enabled	= $this->request->variable('copy_topic_enable', 0);
			$this->from_forum	= $this->request->variable('copy_topic_from_forum', 0);
			$this->to_forum		= $this->request->variable('copy_topic_to_forum', 0);

			// Check that both fora are > 0
			if ($this->copy_enabled && ($this->from_forum == 0 || $this->to_forum == 0))
			{
				trigger_error($this->language->lang('ENABLE_INVALID') . adm_back_link($this->u_action), E_USER_WARNING);
			}

			// Check that copy to and copy from fora are not the same
			if ($this->from_forum == $this->to_forum)
			{
				trigger_error($this->language->lang('FORUMS_INVALID') . adm_back_link($this->u_action), E_USER_WARNING);
			}

			// If no errors, process the form data
			// Set the options the user configured
			$this->set_options();

			// Add option settings change action to the admin log
			$this->log->add('admin', $this->user->data['user_id'], $this->user->ip, 'COPY_NEW_TOPIC_LOG');

			// Option settings have been updated and logged
			// Confirm this to the user and provide link back to previous page
			trigger_error($this->language->lang('CONFIG_UPDATED') . adm_back_link($this->u_action));
		}

		$copy_from_forum = isset($this->config['copy_topic_from_forum']) ? $this->config['copy_topic_from_forum'] : 0;
		$copy_to_forum	 = isset($this->config['copy_topic_to_forum']) ? $this->config['copy_topic_to_forum'] : 0;

		// Template vars for header panel
		$this->template->assign_vars(array(
			'HEAD_TITLE'		=> $this->language->lang('COPY_NEW_TOPIC'),
			'HEAD_DESCRIPTION'	=> $this->language->lang('COPY_NEW_TOPIC_EXPLAIN'),

			'NAMESPACE'			=> $this->functions->get_ext_namespace('twig'),

			'S_BACK'			=> $back,
			'S_VERSION_CHECK'	=> $this->functions->version_check(),

			'VERSION_NUMBER'	=> $this->functions->get_this_version(),
		));

		// Set output vars for display in the template
		$this->template->assign_vars(array(
			'COPY_NEW_TOPIC_ENABLE'		=> isset($this->config['copy_topic_enable']) ? $this->config['copy_topic_enable'] : 0,
			'COPY_NEW_TOPIC_OVERRIDE'	=> isset($this->config['copy_topic_count_override']) ? $this->config['copy_topic_count_override'] : 0,
			'COPY_TOPIC_FROM_FORUM'		=> make_forum_select($copy_from_forum, false, true, true),
			'COPY_TOPIC_TO_FORUM'		=> make_forum_select($copy_to_forum, false, true, true),

			'U_ACTION' 					=> $this->u_action,
		));
	}

	/**
	* Set the options a user can configure
	*
	* @return null
	* @access protected
	*/
	protected function set_options()
	{
		$this->config->set('copy_topic_count_override', $this->request->variable('copy_topic_count_override', '0'));
		$this->config->set('copy_topic_enable', $this->copy_enabled);
		$this->config->set('copy_topic_from_forum', $this->from_forum);
		$this->config->set('copy_topic_to_forum', $this->to_forum);
	}
}
