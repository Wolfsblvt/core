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

class formatter
{
	/** @var \wolfsblvt\core\core\core */
	protected $core;
	
	/** @var \phpbb\config\config */
	protected $config;

	/** @var \phpbb\user */
	protected $user;

	/** @var string phpBB root path  */
	protected $root_path;

	/** @var string PHP file extension */
	protected $php_ext;

	/**
	 * Constructor
	 *
	 * @param \wolfsblvt\core\core\core $core
	 * @param \phpbb\config\config $config
	 * @param \phpbb\user $user
	 * @param string $root_path
	 * @param string $php_ext
	 * @return \wolfsblvt\core\core\core
	 * @access public
	 */
	public function __construct(\wolfsblvt\core\core\core $core, \phpbb\config\config $config, \phpbb\user $user, $root_path, $php_ext)
	{
		$this->core = $core;
		$this->config = $config;
		$this->user = $user;
		$this->root_path = $root_path;
		$this->php_ext = $php_ext;
		
		$this->ext_root_path = 'ext/wolfsblvt/core';
		
		// Add language vars
		$this->user->add_lang_ext('wolfsblvt/core', 'formatter');
	}
	
	/**
	 * Formats a timespan in the users language.
	 * 
	 * @param int $timespan The timespan as timestamp, in seconds.
	 * @return string The formatted timespan.
	 */
	public function format_timespan($timespan)
	{
		// Workaround to get a comparable timespan, use DateTime->diff()
		$date1 = new \DateTime("2000-1-1");
		$date2 = new \DateTime("2000-1-1");
		$date2->add(new \DateInterval("PT{$timespan}S"));
		$diff = $date2->diff($date1);
		
		// Add week count, we want that here
		$weeks = floor($diff->d / 7);
		$diff->d = $diff->d % 7;
		
		$formatted = "";
		if($diff->y > 0)
			$formatted .= $this->user->lang((($diff->y > 1) ? 'CORE_YEARS'   : 'CORE_YEAR'),   $diff->y) . ' ';
		if($diff->m > 0)
			$formatted .= $this->user->lang((($diff->m > 1) ? 'CORE_MONTHS'  : 'CORE_MONTH'),  $diff->m) . ' ';
		if($weeks > 0)
			$formatted .= $this->user->lang((($weeks   > 1) ? 'CORE_WEEKS'   : 'CORE_WEEK'),   $weeks) . ' ';
		if($diff->h > 0)
			$formatted .= $this->user->lang((($diff->h > 1) ? 'CORE_HOURS'   : 'CORE_HOUR'),   $diff->h) . ' ';
		if($diff->i> 0)
			$formatted .= $this->user->lang((($diff->i > 1) ? 'CORE_MINUTES' : 'CORE_MINUTE'), $diff->i) . ' ';
		if($diff->s > 0)
			$formatted .= $this->user->lang((($diff->s > 1) ? 'CORE_SECONDS' : 'CORE_SECOND'), $diff->s) . ' ';
		
		return trim($formatted);
	}
}
