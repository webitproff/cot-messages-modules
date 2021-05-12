<?php
/**
 * Installation handler
 * @version 1.0
 * @package MSG
 * @copyright (c) PluginsPro Team (http://cmsworks.ru/users/alexvlad)
 */

defined('COT_CODE') or die('Wrong URL');
require_once cot_incfile('extensions');
cot_extension_pause('pm');

require_once cot_incfile('users', 'module');
global $db, $db_users;

if (!$db->fieldExists($db_users, "user_lastmsg"))
{
	$db->query("ALTER TABLE $db_users ADD COLUMN `user_lastmsg` int(11) NOT NULL DEFAULT '0'");
}
