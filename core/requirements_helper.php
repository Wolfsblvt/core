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

class requirements_helper
{
	/** @var \wolfsblvt\core\core\core */
	protected $core;
	
	/** @var \phpbb\extension\manager */
	protected $manager;
	
	/** @var \phpbb\config\config */
	protected $config;

	/** @var \phpbb\db\driver\driver_interface */
	protected $db;

	/** @var \phpbb\template\template */
	protected $template;

	/** @var \phpbb\user */
	protected $user;
	
	protected $temporary_disabled_extensions;

	/**
	 * Constructor
	 *
	 * @param \wolfsblvt\core\core\core $core
	 * @param \phpbb\extension\manager $manager
	 * @param \phpbb\config\config $config
	 * @param \phpbb\db\driver\driver_interface $db
	 * @param \phpbb\template\template $template
	 * @param \phpbb\user $user
	 * @return \wolfsblvt\core\core\requirements_helper
	 * @access public
	 */
	public function __construct(\wolfsblvt\core\core\core $core, \phpbb\extension\manager $manager, \phpbb\config\config $config, \phpbb\db\driver\driver_interface $db, \phpbb\template\template $template, \phpbb\user $user)
	{
		$this->core = $core;
		$this->manager = $manager;
		$this->config = $config;
		$this->db = $db;
		$this->template = $template;
		$this->user = $user;
		
		$this->ext_root_path = 'ext/wolfsblvt/core';
		
		$this->temporary_disabled_extensions =  isset($this->config['wolfsblvt.core.temporary_disabled_extensions']) ?
			json_decode($this->config['wolfsblvt.core.temporary_disabled_extensions'], true) : array();
	}
	
	/**
	 * Splits a string where an operator is combined with a version number. Operator comes first, followed by the version number without a space.
	 * For example the version strings from composer.json, example: ">=1.0.0"
	 * Returns assoziative array with 'version' and 'operator' or FALSE.
	 * 
	 * NOTE: valid operators are the ones used in phpbb_version_compare(). These are:
	 *		array("<", "lt", "<=", "le", ">", "gt", ">=", "ge", "==", "=", "eq", "!=", "<>", "ne")
	 * 
	 * @param string $version_string The string containing the operator and version number.
	 * @return mixed Assoziative array with 'version' and 'operator' as key. If string is not valid, then FALSE.
	 */
	public function split_version_and_operator($version_string)
	{
		if (!isset($version_string) || !is_string($version_string))
			return false;
		
		$operators = array(">=", ">", "ge", "gt", "==", "=", "eq", "!=", "<>", "ne", "<=", "<", "le", "lt");
		
		foreach ($operators as $op)
		{
			if ($this->core->starts_with($version_string, $op))
			{
				$ret = array(
					'version'	=> substr($version_string, strlen($op)),
					'operator'	=> $op,
					);
				return $ret;
			}
		}
		return false;
	}
	
	/**
	 * Checks if all requirements in the "require" section of the composer.json file are fulfilled.
	 * 
	 * @param array $require_fields The array of requirements specified, containing KeyValuePairs with extension name and version string.
	 * @return bool TRUE, if the requirements are fulfilled, FALSE if they aren't.
	 */
	public function check_requirements($require_fields)
	{
		if (!isset($require_fields) || empty($require_fields))
			return true;
		if (!is_array($require_fields))
			return false;
		
		foreach ($require_fields as $ext_name => $require)
		{
			$require = $this->split_version_and_operator($require);
			
			// If version string is formatted wrong we consider the requirement is not fullfilled. Sorry.
			if ($require === false)
				return false;
			
			// If the field is PHP, we need to check the php version. Just to make sure (:
			if (strtolower($ext_name) == "php")
				return (phpbb_version_compare(PHP_VERSION, $require['version'], $require['operator']));
			
			// If the extension is disabled, return false. If the extension is currently enabling, it counts as enabled.
			if (!$this->manager->is_enabled($ext_name) && !(isset($this->currently_enabling_extension) && $this->currently_enabling_extension == $ext_name))
				return false;
			
			// gets the actual version number of this extension
			$ext_meta = $this->manager->create_extension_metadata_manager($ext_name, $this->template);
			$version = $ext_meta->get_metadata()['version'];
			
			if (!phpbb_version_compare($version, $require['version'], $require['operator']))
				return false;
		}
		
		return true;
	}
	
	/**
	 * Disable all extensions wich are required by the given extension.
	 * 
	 * @param mixed $extension_name The name of the extension.
	 * @return void
	 */
	public function disable_requiring_extensions($extension_name)
	{
		$extensions = $this->manager->all_enabled();
		$this->temporary_disabled_extensions[$extension_name] = array();
		
		foreach ($extensions as $ext_name => $ext_path)
		{
			if ($this->manager->is_disabled($ext_name))
				continue;
			
			$meta_data = $this->manager->create_extension_metadata_manager($ext_name, $this->template)->get_metadata();
			
			if (isset($meta_data['require'][$extension_name]))
			{
				// Save that this extension is disabled
				$this->temporary_disabled_extensions[$extension_name][] = $ext_name;
				$this->manager->disable($ext_name);
			}
		}
		
		$this->config->set('wolfsblvt.core.temporary_disabled_extensions', json_encode($this->temporary_disabled_extensions));
		
		// Overwrite success message
		$this->user->add_lang_ext('wolfsblvt/core', 'extensions_override');
	}
	
	/**
	 * Enable all extensions wich were disabled by the given extension.
	 * 
	 * @param mixed $extension_name The name of the extension.
	 * @return void
	 */
	public function enable_disabled_requiring_extensions($extension_name)
	{
		$extensions = isset($this->temporary_disabled_extensions[$extension_name]) ? $this->temporary_disabled_extensions[$extension_name] : array();
		$this->currently_enabling_extension = $extension_name;
		
		foreach ($extensions as $ext_name)
		{
			if ($this->manager->is_available($ext_name) && $this->manager->is_disabled($ext_name))
				$this->manager->enable($ext_name);
		}
		
		unset($this->currently_enabling_extension);
		unset($this->temporary_disabled_extensions[$extension_name]);
		$this->config->set('wolfsblvt.core.temporary_disabled_extensions', json_encode($this->temporary_disabled_extensions));
		
		// Overwrite success message
		$this->user->add_lang_ext('wolfsblvt/core', 'extensions_override');
	}
	
	
}
