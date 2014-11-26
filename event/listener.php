<?php
/**
 * 
 * Wolsblvt's Library - Core Functions
 * 
 * @copyright (c) 2014 Wolfsblut ( www.pinkes-forum.de )
 * @license http://opensource.org/licenses/gpl-2.0.php GNU General Public License v2
 * @author Clemens Husung (Wolfsblvt)
 */

namespace wolfsblvt\core\event;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;

/**
 * Event listener
 */
class listener implements EventSubscriberInterface
{
	/** @var \phpbb\path_helper */
	protected $path_helper;

	/** @var \phpbb\template\template */
	protected $template;

	/** @var \phpbb\user */
	protected $user;

	/** @var string phpEx */
	protected $php_ext;

	/**
	 * Constructor of event listener
	 *
	 * @param \phpbb\path_helper		$path_helper	phpBB path helper
	 * @param \phpbb\template\template	$template		Template object
	 * @param \phpbb\user			    $user			User object
	 * @param string				    $php_ext		phpEx
	 */
	public function __construct(\phpbb\path_helper $path_helper, \phpbb\template\template $template, \phpbb\user $user, $php_ext)
	{
		$this->path_helper = $path_helper;
		$this->template = $template;
		$this->user = $user;
		$this->php_ext = $php_ext;

		$this->ext_root_path = 'ext/wolfsblvt/core';
	}

	/**
	 * Assign functions defined in this class to event listeners in the core
	 *
	 * @return array
	 */
	static public function getSubscribedEvents()
	{
		return array(
			'core.page_header'			=> 'assign_template_vars',
		);
	}

	/**
	 * Assign template vars
	 *
	 * @param object $event The event object
	 * @return null
	 */
	public function assign_template_vars($event)
	{
		$this->template->assign_vars(array(
            'T_EXT_CORE_PATH'               => $this->path_helper->get_web_root_path() . $this->ext_root_path,
			'T_EXT_CORE_THEME_PATH'		    => $this->path_helper->get_web_root_path() . $this->ext_root_path . '/styles/' . $this->user->style['style_path'] . '/theme',
		));
	}
}
