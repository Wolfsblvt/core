<?php
/**
 * 
 * Wolsblvt's Library - Core Functions [Deutsch]
 * 
 * @copyright (c) 2014 Wolfsblut ( www.pinkes-forum.de )
 * @license http://opensource.org/licenses/gpl-2.0.php GNU General Public License v2
 * @author Clemens Husung (Wolfsblvt)
 */

if (!defined('IN_PHPBB'))
{
	exit;
}

if (empty($lang) || !is_array($lang))
{
	$lang = array();
}

// DEVELOPERS PLEASE NOTE
//
// All language files should use UTF-8 as their encoding and the files must not contain a BOM.
//
// Placeholders can now contain order information, e.g. instead of
// 'Page %s of %s' you can (and should) write 'Page %1$s of %2$s', this allows
// translators to re-order the output of data while ensuring it remains correct
//
// You do not need this where single placeholders are used, e.g. 'Message %d' is fine
// equally where a string contains only two placeholders which are used to wrap text
// in a url you again do not need to specify an order e.g., 'Click %sHERE%s' is fine
//
// Some characters you may want to copy&paste:
// ’ » “ ” …
//

$lang = array_merge($lang, array(
	'CORE_YEAR'			=> '%s Jahr',
	'CORE_YEARS'		=> '%s Jahre',
	'CORE_MONTH'		=> '%s Monat',
	'CORE_MONTHS'		=> '%s Monate',
	'CORE_WEEK'			=> '%s Woche',
	'CORE_WEEKS'		=> '%s Wochen',
	'CORE_DAY'			=> '%s Tag',
	'CORE_DAYS'			=> '%s Tage',
	'CORE_HOUR'			=> '%s Stunde',
	'CORE_HOURS'		=> '%s Stunden',
	'CORE_MINUTE'		=> '%s Minute',
	'CORE_MINUTES'		=> '%s Minuten',
	'CORE_SECOND'		=> '%s Sekunde',
	'CORE_SECONDS'		=> '%s Sekunden',
));
