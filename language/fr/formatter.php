<?php
/**
*
* Wolsblvt's Library - Core Functions extension for the phpBB Forum Software package.
* French translation by Galixte (http://www.galixte.com)
*
* @copyright (c) 2015 Clemens Husung (Wolfsblvt) <www.pinkes-forum.de>
* @license GNU General Public License, version 2 (GPL-2.0)
*
*/

/**
* DO NOT CHANGE
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
// ’ « » “ ” …
//

$lang = array_merge($lang, array(
	'CORE_YEAR'			=> '%s année',
	'CORE_YEARS'		=> '%s années',
	'CORE_MONTH'		=> '%s mois',
	'CORE_MONTHS'		=> '%s mois',
	'CORE_WEEK'			=> '%s semaine',
	'CORE_WEEKS'		=> '%s semaines',
	'CORE_DAY'			=> '%s jour',
	'CORE_DAYS'			=> '%s jours',
	'CORE_HOUR'			=> '%s heure',
	'CORE_HOURS'		=> '%s heures',
	'CORE_MINUTE'		=> '%s minute',
	'CORE_MINUTES'		=> '%s minutes',
	'CORE_SECOND'		=> '%s seconde',
	'CORE_SECONDS'		=> '%s secondes',
));
