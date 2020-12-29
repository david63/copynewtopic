<?php
/**
*
* @package Cookie Policy Extension
* @copyright (c) 2014 david63
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
	$lang = [];
}

/// DEVELOPERS PLEASE NOTE
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
	'COPY_NEW_TOPIC_EXPLAIN'			=> 'Set the options for automatically copying a new topic from one forum to another.',
	'COPY_TOPIC_ENABLE'					=> 'Enable automatic topic copying',
	'COPY_TOPIC_ENABLE_EXPLAIN'			=> 'This will allow for the automatic copying of new topics posted in the “from” forum to the “to” forum.',
	'COPY_TOPIC_FROM_FORUM'				=> 'Copy from',
	'COPY_TOPIC_FROM_FORUM_EXPLAIN'		=> 'The forum from which you want the new topic to be copied from.',
	'COPY_TOPIC_OVERRIDE_COUNT'			=> 'Override total counts',
	'COPY_TOPIC_OVERRIDE_COUNT_EXPLAIN'	=> 'Setting this to <strong>yes</strong> will increase the total counts (topics and posts) when the new topic is copied to the “to” forum.',
	'COPY_NEW_TOPIC_OPTIONS'			=> 'Options',
	'COPY_TOPIC_TO_FORUM'				=> 'Copy to',
	'COPY_TOPIC_TO_FORUM_EXPLAIN'		=> 'The forum to which you want the new topic to be copied to.',

	'ENABLE_INVALID'					=> 'There must be a valid entry in both the “from” and “to” forums when enabling this extension.',
	'FORUMS_INVALID'					=> 'The “from” and “to” forums cannot be the same.',
));
