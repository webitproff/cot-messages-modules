<?php

/**
 * Messages
 * @version 1.0
 * @package MSG
 * @copyright (c) PluginsPro Team
 */

defined('COT_CODE') or die('Wrong URL');

require_once cot_incfile('messages', 'module');
require_once cot_incfile('forms');

list($usr['auth_read'], $usr['auth_write'], $usr['isadmin']) = cot_auth('messages', 'a');
cot_block($usr['auth_read']);

$chat = cot_import('chat','G','INT');

$sql = $db->query("SELECT * FROM $db_messages_dialog WHERE id = $chat LIMIT 1")->fetch();    //определяем диалог
$totags = cot_generate_usertags($sql['toid'], 'MSG_ROW_USER_');
$fromtags = cot_generate_usertags($sql['fromid'], 'MSG_ROW_USER_');

$title_params = array(
	'DIALOG' => $L['msg_dialogwith'],
);
$out['subtitle'] = cot_title('{DIALOG} {OPP1} и {OPP2}', $title_params);
$out['head'] .= $R['code_noindex'];

$t = new XTemplate(cot_tplfile(array('messages', 'admin.show')));

$dialog_history = $db->query("SELECT * FROM $db_messages_msg WHERE dialog = '".$chat."' ORDER BY id ASC")->fetchAll();
if (!empty($dialog_history))
{  
	foreach ($dialog_history as $row)
	{
		$t->assign(array(
			'MSG_ROW_ID' => $row['id'],
			'MSG_ROW_DATE' => cot_date('H:i', $row['date']),
			'MSG_ROW_DATE_STAMP' => $row['date'],
			'MSG_ROW_TEXT' => $row['text'],
      'MSG_ROW_READSTATUS' => $row['status'],
		));
    
    if ($row['touser'] == $fromtags['MSG_ROW_USER_ID'])
    {
    $t->assign($totags);
    }else{
		$t->assign($fromtags);
    }
		$t->parse('MAIN.MSG_ROW');
	}
}

$t->parse('MAIN');
$adminmain = $t->text("MAIN");
