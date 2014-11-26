<?php
/**
 * 
 * Wolsblvt's Library - Core Functions
 * 
 * @copyright (c) 2014 Wolfsblut ( www.pinkes-forum.de )
 * @license http://opensource.org/licenses/gpl-2.0.php GNU General Public License v2
 * @author Clemens Husung (Wolfsblvt)
 */

namespace wolfsblvt\core;

use Symfony\Component\DependencyInjection\ContainerInterface;

class ext extends \phpbb\extension\base
{
	/** @var \phpbb\extension\manager */
	protected $manager;
	
	/** @var \phpbb\extension\metadata_manager */
	protected $metadata_manager;
	
	/** @var \wolfsblvt\core\core\requirements_helper */
	protected $requirements_helper;
	
	
	public function __construct(ContainerInterface $container, \phpbb\finder $extension_finder, \phpbb\db\migrator $migrator, $extension_name, $extension_path)
	{
		parent::__construct($container, $extension_finder, $migrator, $extension_name, $extension_path);
		
		$this->manager = $this->container->get('ext.manager');
		$this->metadata_manager = $this->manager->create_extension_metadata_manager($this->extension_name, $this->container->get('template'));
		
		// We are maybe not enabled, so we need to create the object ourself
		if ($this->container->has('wolfsblvt.core.requirements_helper'))
		{
			$this->requirements_helper = $this->container->get('wolfsblvt.core.requirements_helper');
		}
		else
		{
			$core = new \wolfsblvt\core\core\core($this->manager, $this->container->get('config'), $this->container->get('dbal.conn'), $this->container->get('request'), $this->container->get('template'), $this->container->get('user'), $this->container->getParameter('core.root_path'), $this->container->getParameter('core.php_ext'));
			$this->requirements_helper = new \wolfsblvt\core\core\requirements_helper($core, $this->manager, $this->container->get('config'), $this->container->get('dbal.conn'), $this->container->get('template'), $this->container->get('user'));
			$this->container->set('wolfsblvt.core.requirements_helper', $this->requirements_helper);
			$this->container->set('wolfsblvt.core.core', $core);
		}
	}
	
	function enable_step($old_state)
	{
		$this->requirements_helper->enable_disabled_requiring_extensions($this->extension_name);
		$ret = parent::enable_step($old_state);
		return $ret;
	}
	
	function disable_step($old_state)
	{
		$this->requirements_helper->disable_requiring_extensions($this->extension_name);
		$ret = parent::disable_step($old_state);
		return $ret;
	}
	
	function purge_step($old_state)
	{
		$ret = parent::purge_step($old_state);
		return $ret;
	}
	
	function is_enableable()
	{
		// Check if extension wolfsblvt\core is installed. It is required, every time.
		// Okay, I think we are in wolfsblvt\core. So we don't need that here :P
		
		$meta_data = $this->metadata_manager->get_metadata();
		$require = $meta_data['require'];
		$has_requirements = $this->requirements_helper->check_requirements($require);
		
		return $has_requirements;
	}
}
