<?php

/**
 * Messages
 * @version 1.0
 * @package MSG
 * @copyright (c) PluginsPro Team
 */
defined('COT_CODE') or die('Wrong URL');

require_once cot_incfile('messages', 'module');
require_once cot_incfile('extensions');

$title_params = array(
	'MSG' => $L['msg_dialogs'],
);
$out['subtitle'] = cot_title('{MSG}', $title_params);
$out['head'] .= $R['code_noindex'];

require_once $cfg['system_dir'] . '/header.php';

$dialogs = $db->query("SELECT * FROM $db_messages_dialog ORDER BY lastmsg DESC")->fetchAll();
$t = new XTemplate(cot_tplfile(array('messages', 'admin.list')));
foreach ($dialogs as $row)
{  
  $msgfilter = "(dialog = '".$row['id']."')";
  $msg = $db->query("SELECT * FROM $db_messages_msg WHERE $msgfilter ORDER BY id DESC LIMIT 1")->fetch();   //получаем последнее сообщение из диалога

	$t->assign(array(
  	'MSG_DELETE' => cot_url('admin', 'm=messages&act=chatdelete&chat='.$row['id']),
		'MSG_DATE' => cot_date('datetime_medium', $msg['date']),
		'MSG_DATE_STAMP' => $msg['date'],
    'MSG_TIME_AGO' => cot_build_timeago($msg['date']),
		'MSG_DIAOG_URL' => cot_url('admin', 'm=messages&act=show&chat='.$msg['dialog']),   //ссылка на диалог
    'MSG_STATUS' => $msg['status'],  //прочитано или нет
		'MSG_TEXT' => cot_string_truncate($msg['text'], 65, true, false, "..."),   //сокрашенный текст где 65 это колл-во символов после чего сокращяем
	));
	$t->assign(cot_generate_usertags($row['toid'], 'MSG_TO_USER_'));
  $t->assign(cot_generate_usertags($row['fromid'], 'MSG_FROM_USER_'));

	$t->parse('MAIN.MSG_ROW');
}

if (!$cfg['messages']['hideimport'])
{
$import = cot_import('import', 'G', 'BOL');
$t_im = new XTemplate(cot_tplfile(array('messages', 'admin.import')));

  if ($import)
  {
    $run = cot_extension_resume('pm');
    if (!$run)
    {
      $pause = cot_extension_pause('pm');
      $run = ($pause) ? cot_extension_resume('pm') : false;
    }
    
    if ($run)
    {
    require_once cot_incfile('pm', 'module');
    $sql = $db->query("SELECT COUNT(*) FROM $db_pm")->fetchColumn();
    if ($sql != 0)
    {
     cot_import_old_pm();
 		 $t_im->assign(array(
		  	'IMPORT_PM' => $sql,
		 ));

		 $t_im->parse('MAIN.SUCCESS');
    }
    else
    {
		  $t_im->parse('MAIN.ERROR');    
    }
     cot_extension_pause('pm');
    }
    else
    {
     $t_im->parse('MAIN.ERROR2');
    }
  }
  else
  {
		$t_im->assign(array(
			'IMPORT_PM' => cot_url('admin', 'm=messages&import=1'),
		));

		$t_im->parse('MAIN.IMPORT');
  }
  $t_im->parse('MAIN');
  $t->assign(array('ADMIN_IMPORT' => $t_im->text("MAIN")));
}

$t->parse('MAIN');
$adminmain = $t->text("MAIN");
