<?php
/**
*
* @package Copy New Topic Extension
* @copyright (c) 2016 david63
* @license GNU General Public License, version 2 (GPL-2.0)
*
*/

namespace david63\copynewtopic\migrations;

use phpbb\db\migration\migration;

class version_2_1_0 extends migration
{
	public function update_data()
	{
		return array(
			array('config.add', array('copy_topic_count_override', '0')),
			array('config.add', array('copy_topic_enable', '0')),
			array('config.add', array('copy_topic_from_forum', '0')),
			array('config.add', array('copy_topic_to_forum', '0')),

			// Add the ACP module
			array('module.add', array('acp', 'ACP_CAT_DOT_MODS', 'COPY_NEW_TOPIC')),

			array('module.add', array(
				'acp', 'COPY_NEW_TOPIC', array(
					'module_basename'	=> '\david63\copynewtopic\acp\copynewtopic_module',
					'modes'				=> array('main'),
				),
			)),
		);
	}
}
