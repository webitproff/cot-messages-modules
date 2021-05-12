MSG_ROW_USER_<?php

/**
 * Messages
 * @version 1.0
 * @package MSG
 * @copyright (c) PluginsPro Team
 */
defined('COT_CODE') or die('Wrong URL');

require_once cot_incfile('messages', 'module');

$act = cot_import('act','G','TXT');
$chat = cot_import('chat','G','INT');
$submit = cot_import('submit','G','BOL');

$t = new XTemplate(cot_tplfile(array('messages', 'admin.act')));
if ($act == 'chatdelete')
 {
  if ($submit)
  {
   $sql = $db->query("SELECT * FROM $db_messages_msg WHERE dialog = $chat")->fetchAll();
   $jj = 0;
   foreach ($sql as $row)
	  {
     $jj++;
     $msgdel = $db->delete($db_messages_msg, "id = ".$row['id']."");
	  }
    $dialogdel = $db->delete($db_messages_dialog, "id = ".$chat."");
    $t->assign(array(
  	 'MSG_JJ' => $jj,
	  ));
    $t->parse('MAIN.DELETE_SUCCESS'); 

  }else{ 
  
   $chatsql = $db->query("SELECT * FROM $db_messages_dialog WHERE id = $chat LIMIT 1")->fetch();    //определяем диалог

   $to = cot_generate_usertags($chatsql['toid'], 'MSG_TO_USER_');
   $from = cot_generate_usertags($chatsql['fromid'], 'MSG_FROM_USER_'); 
 
   $t->assign(array(
  	'MSG_DELETE' => cot_url('admin', 'm=messages&act=chatdelete&chat='.$chat.'&submit=1'),
	 ));
   $t->assign($to);
	 $t->assign($from);
   $t->parse('MAIN.CHAT_DELETE'); 
  }
}

$t->parse('MAIN'); 
$adminmain = $t->text("MAIN");

