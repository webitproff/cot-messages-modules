<?php

/**
 * Messages
 * @version 1.0
 * @package MSG
 * @copyright (c) PluginsPro Team
 */
defined('COT_CODE') or die('Wrong URL');


$chatid = cot_import('chat', 'G', 'INT');
$a = cot_import('a', 'G', 'TXT');

/* === Hook === */
foreach (cot_getextplugins('messages.ajax.first') as $pl) {
    include $pl;
}
/* === Hook === */

cot_sendheaders();
if (!empty($chatid)) {
    $dialogsql = $db->query("SELECT * FROM $db_messages_dialog WHERE id = $chatid LIMIT 1")->fetch();    //определяем диалог

    if (!empty($dialogsql) || !(($dialogsql['fromid'] != $usr['id']) && ($dialogsql['toid'] != $usr['id']))) {     //проверяем есть ли такой диалог для этого пользователя
        $to = ($dialogsql['fromid'] == $usr['id']) ? $dialogsql['toid'] : $dialogsql['fromid'];  //определяем с кем диалог  
        $newpm = ($dialogsql['fromid'] == $usr['id']) ? $dialogsql['fromstatus'] : $dialogsql['tostatus'];  //определяем есть ли в диалоге новые сообщения для меня
        $tonewpm = ($dialogsql['fromid'] == $usr['id']) ? array('tostatus' => '1') : array('fromstatus' => '1');  //для установки статуса нового сообщения для собеседника
        $readpm = ($dialogsql['fromid'] == $usr['id']) ? array('fromstatus' => '0') : array('tostatus' => '0'); //для того что бы указать что сообщения прочитаны

        $opptags = $_SESSION['dialogs'][$to];     //получаем тэги собеседника
        $usrtags = $_SESSION['dialogs']['my'];    //получаем наши тэги 

        $t = new XTemplate(cot_tplfile(array('messages', 'newmsg')));

        if ($a == 'update') {  //если мы обновляем
            if ($newpm == 0) {   //если нет сообщении
                echo '0';
                exit;
            } else {  //если есть
                $newmsg = $db->query("SELECT * FROM $db_messages_msg WHERE dialog = '" . $chatid . "' AND status = 1 AND touser = '" . $usr['id'] . "' ORDER BY id ASC")->fetchAll();

                $pmsql = $db->update($db_messages_dialog, $readpm, "id = " . (int) $chatid . "");   //убираем статус непрочитанных сообщений

                /* === Hook - Part1 : Set === */
                $extp = cot_getextplugins('messages.newmsg.loop');
                /* ===== */

                $t->assign($opptags);

                foreach ($newmsg as $row) {
                    $t->assign(array(
                        'MSG_ROW_ID' => $row['id'],
                        'MSG_ROW_DATE' => cot_date('H:i', $row['date']),
                        'MSG_ROW_DATE_STAMP' => $row['date'],
                        'MSG_ROW_TEXT' => htmlentities($row['text'], ENT_QUOTES, "UTF-8"),
                    ));

                    /* === Hook - Part2 : Include === */
                    foreach ($extp as $pl) {
                        include $pl;
                    }
                    /* ===== */
                    $pmsql = $db->update($db_messages_msg, array('status' => '0'), "dialog = " . (int) $chatid . "");   //ставим статус то что сообщение прочитано
                    $t->parse('MAIN.INBOX');
                }
            }
        } elseif (!cot_error_found() && $a == 'send') {      //если это отправка сообщения

            /* === Hook === */
            foreach (cot_getextplugins('messages.ajax.send.first') as $pl) {
                include $pl;
            }
            /* ===== */

            $newpmtext = cot_import('newpmtext', 'P', 'HTM');

            if (mb_strlen($newpmtext) < 2) {
                $t->assign(array('ERROR_MSG' => $L['msg_shortmsg'],));
                $t->parse('MAIN.ERROR');
            } else {
                $pm['dialog'] = (int) $chatid;
                $pm['date'] = (int) $sys['now'];
                $pm['text'] = $newpmtext;
                $pm['touser'] = $to;
                $pmsql = $db->insert($db_messages_msg, $pm);

                $tonewpm = $tonewpm + array('lastmsg' => (int) $sys['now']);
                $pmsql = $db->update($db_messages_dialog, $tonewpm, "id = " . (int) $chatid . "");   //устанавливаем статус нового сообщения для собеседника

                /* === Hook === */
                foreach (cot_getextplugins('messages.ajax.send.done') as $pl) {
                    include $pl;
                }
                /* === Hook === */

                if (!$cfg['messages']['turnajax']) {             //если выключен ajax то возвращаемся обратно
                    cot_redirect(cot_url('messages', 'chat=' . $chatid, '', true));
                }

                $t->assign($usrtags);
                $t->assign(array(
                    'MSG_ROW_DATE' => cot_date('H:i', $pm['date']),
                    'MSG_ROW_DATE_STAMP' => $pm['date'],
                    'MSG_ROW_TEXT' => htmlentities($pm['text'], ENT_QUOTES, "UTF-8"),
                ));

                $t->parse('MAIN.OUTBOX');
            }
        } else {
            $t->assign(array('ERROR_MSG' => $L['msg950_body'],));
            $t->parse('MAIN.ERROR');
        }              //парсим ошибку если она есть
    } else {
        $t->assign(array('ERROR_MSG' => $L['msg401_title'],));
        $t->parse('MAIN.ERROR');
    }
}


if ($a == 'who_wrote') {
    $newmsg = $db->query("SELECT * FROM $db_messages_msg WHERE status = 1 AND touser = '" . $usr['id'] . "' ORDER BY id ASC")->fetchAll();

    $msg = array();
    foreach ($newmsg as $v) {
        #$db->query("UPDATE $db_messages_msg SET status=0 WHERE id='{$v["id"]}'");
        $msg[]['dialog'] = $v["id"];
        $msg[]['id'] = $v["dialog"];
    }

    print json_encode($msg);
    exit;
}


//парсим
$t->parse('MAIN');
$t->out('MAIN');
echo $t->text("MAIN");
exit;
