<?php
/**
 * 
 * Wolsblvt's Library - Core Functions
 * 
 * @copyright (c) 2014 Wolfsblut ( www.pinkes-forum.de )
 * @license http://opensource.org/licenses/gpl-2.0.php GNU General Public License v2
 * @author Clemens Husung (Wolfsblvt)
 */

namespace wolfsblvt\core\migrations;

class v1_0_0_configs extends \phpbb\db\migration\migration
{
	public function update_data()
	{
		return array();
	}

	public function revert_data()
	{
		return array(
			 array('config.remove', array('wolfsblvt.core.temporary_disabled_extensions')),
		);
	}
}
