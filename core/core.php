<?php
/**
 * 
 * Wolsblvt's Library - Core Functions
 * 
 * @copyright (c) 2014 Wolfsblut ( www.pinkes-forum.de )
 * @license http://opensource.org/licenses/gpl-2.0.php GNU General Public License v2
 * @author Clemens Husung (Wolfsblvt)
 */

namespace wolfsblvt\core\core;

class core
{
	/** @var \phpbb\extension\manager */
	protected $manager;
	
	/** @var \phpbb\config\config */
	protected $config;

	/** @var \phpbb\db\driver\driver_interface */
	protected $db;

	/** @var \phpbb\request\request */
	protected $request;

	/** @var \phpbb\template\template */
	protected $template;

	/** @var \phpbb\user */
	protected $user;

	/** @var string phpBB root path  */
	protected $root_path;

	/** @var string PHP file extension */
	protected $php_ext;

	/**
	 * Constructor
	 *
	 * @param \phpbb\extension\manager $manager
	 * @param \phpbb\config\config $config
	 * @param \phpbb\db\driver\driver_interface $db
	 * @param \phpbb\request\request $request
	 * @param \phpbb\template\template $template
	 * @param \phpbb\user $user
	 * @param string $root_path
	 * @param string $php_ext
	 * @return \wolfsblvt\core\core\core
	 * @access public
	 */
	public function __construct(\phpbb\extension\manager $manager, \phpbb\config\config $config, \phpbb\db\driver\driver_interface $db, \phpbb\request\request $request, \phpbb\template\template $template, \phpbb\user $user, $root_path, $php_ext)
	{
		$this->manager = $manager;
		$this->config = $config;
		$this->db = $db;
		$this->request = $request;
		$this->template = $template;
		$this->user = $user;
		$this->root_path = $root_path;
		$this->php_ext = $php_ext;
		
		$this->ext_root_path = 'ext/wolfsblvt/core';
		
		// Add language vars
		$this->user->add_lang_ext('wolfsblvt/core', 'core');
	}
	
	/**
	 * Returns the given value, or if it is not valid, the given default value
	 * 
	 * @param mixed $value The value you want to check if it is a value.
	 * @param mixed $default The default value.
	 * @return mixed The value or the default value.
	 */
	public function val_or_default($value, $default = false)
	{
		if(isset($value) || is_null($value))
			return $default;
		return $value;
	}
	
	/**
	 * Checks if the string starts with given string.
	 * 
	 * @param string $haystack The string to check if it starts with.
	 * @param string $needle The string you are looking for.
	 * @return bool TRUE, if the string starts with, otherwise false.
	 */
	public function starts_with($haystack, $needle)
	{
		$length = strlen($needle);
		return (substr($haystack, 0, $length) == $needle);
	}
	
	/**
	 * Checks if the string ends with given string.
	 * 
	 * @param string $haystack The string to check if it ends with.
	 * @param string $needle The string you are looking for.
	 * @return bool TRUE, if the string ends with, otherwise false.
	 */
	public function ends_with($haystack, $needle)
	{
		$length = strlen($needle);
		return ($length == 0 || substr($haystack, -$length) === $needle);
	}
}
