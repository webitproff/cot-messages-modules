<?php

/**
 * Messages
 * @version 1.0
 * @package MSG
 * @copyright (c) PluginsPro Team
 */

defined('COT_CODE') or die('Wrong URL');

if ($usr['id'] > 0)
{

  cot_sendheaders();
  require_once cot_incfile('messages', 'module');
  $newmsg = $db->query("SELECT COUNT(*) FROM $db_messages_dialog WHERE (toid='".$usr['id']."' AND tostatus = 1) OR (fromid='".$usr['id']."' AND fromstatus = 1)")->fetchColumn();
	if ($newmsg > 0)
	{
		$usr['messages'] = $db->query("SELECT COUNT(*) FROM $db_messages_msg WHERE touser='".$usr['id']."' AND status = 1")->fetchColumn();
	}

	$out['pmreminder'] = cot_rc_link(cot_url('messages'),
		($usr['messages'] > 0) ? cot_declension($usr['messages'], $Ls['Privatemessages']) : $L['hea_noprivatemessages']
	);

	echo $out['pmreminder'];
}
