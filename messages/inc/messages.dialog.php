<?php

/**
 * Messages
 * @version 1.0
 * @package MSG
 * @copyright (c) PluginsPro Team
 */
defined('COT_CODE') or die('Wrong URL');

require_once cot_incfile('forms');
require_once cot_incfile('pluginspro', 'plug');

list($usr['auth_read'], $usr['auth_write'], $usr['isadmin']) = cot_auth('messages', 'a');
cot_block($usr['auth_read']);


$chatid = cot_import('chat', 'G', 'INT');
$act = cot_import('act', 'G', 'TXT');
$to = cot_import('to', 'G', 'INT');

require_once $cfg['system_dir'] . '/header.php';
$t = new XTemplate(cot_tplfile(array('messages', 'dialog')));

$dialogsfilter = "(toid = '" . $usr['id'] . "') OR (fromid = '" . $usr['id'] . "')";
$dialogs = $db->query("SELECT * FROM $db_messages_dialog WHERE $dialogsfilter ORDER BY lastmsg DESC")->fetchAll();


if ($act == "new") {
    if (!empty($to)) {
        if ($to != $usr['id']) {
            $touser = $db->query("SELECT * FROM $db_users WHERE user_id = $to LIMIT 1");
            if ($touser->rowCount() != 0) {
                $touser = $touser->fetch();
                $chatid = cot_chat_id((int) $usr['id'], $to);
            } else {
                cot_die();
            }
        } else {
            #cot_redirect(cot_url('dashboard', 'm=messages'));
            cot_redirect(html_entity_decode(cot_url('messages', 'chat=' . $chatid)));
        }
    }

    if (!cot_error_found()) {
        if (!empty($chatid)) {
            cot_redirect(html_entity_decode(cot_url('messages', 'chat=' . $chatid)));
        } else {
            $chatid = cot_create_chat((int) $usr['id'], $to);
            cot_redirect(html_entity_decode(cot_url('messages', 'chat=' . $chatid)));
        }
    }
    exit;
}

/* === Hook === */
foreach (cot_getextplugins('messages.first') as $pl) {
    include $pl;
}
/* ===== */


if (!empty($chatid)) {
    $dialogsql = $db->query("SELECT * FROM $db_messages_dialog WHERE id = $chatid LIMIT 1")->fetch();    //определяем диалог

    If (empty($dialogsql) || (($dialogsql['fromid'] != $usr['id']) && ($dialogsql['toid'] != $usr['id']))) {     //проверяем есть ли такой чат для этого пользователя
        cot_redirect(cot_url('messages'));
    }

    $opponent = ($dialogsql['fromid'] == $usr['id']) ? $dialogsql['toid'] : $dialogsql['fromid'];  //определяем c кем переписка 
    $newpm = ($dialogsql['fromid'] == $usr['id']) ? $dialogsql['fromstatus'] : $dialogsql['tostatus'];  //определяем есть ли в диалоге новые сообщения для меня
    $state = ($dialogsql['fromid'] == $usr['id']) ? array('fromstatus' => '0') : array('tostatus' => '0');

    $oppname = $db->query("SELECT user_name FROM $db_users WHERE user_id = $opponent LIMIT 1")->fetch();    //для вывода в название
}
$title[] = array(cot_url('messages'), $L['Private_Messages']);

$title_params = array(
    'DIALOG' => $L['msg_dialogwith'],
    'OPP' => $oppname['user_name'],
);
$out['subtitle'] = cot_title('{DIALOG} {OPP}', $title_params);
$out['head'] .= $R['code_noindex'];

/* === Hook === */
foreach (cot_getextplugins('messages.main') as $pl) {
    include $pl;
}
/* ===== */



$dialog_history = $db->query("SELECT * FROM $db_messages_msg WHERE dialog = '" . $chatid . "' ORDER BY id ASC")->fetchAll();
if (licensed("messages", $cfg["messages"]["license"]) && $_SERVER["SCRIPT_NAME"] != "/admin.php") {
    cot_die_message(403);
}
if (!empty($dialog_history)) {
    if (isset($_SESSION['dialogs'][$opponent])) {       //оптимизация, записываем тэги в сессию, что бы не генерировать их при каждом запросе
        $opptags = $_SESSION['dialogs'][$opponent];
    } else {
        $opptags = cot_generate_usertags($opponent, 'MSG_ROW_USER_');
        $_SESSION['dialogs'][$opponent] = $opptags;
    }
    if (isset($_SESSION['dialogs']['my'])) {
        $usrtags = $_SESSION['dialogs']['my'];
    } else {
        $usrtags = cot_generate_usertags($usr['id'], 'MSG_ROW_USER_');
        $_SESSION['dialogs']['my'] = $usrtags;
    }                                               //конец оптимизаии (скорость созд.стр примерно на 0.03 - 0.04 сек меньше уже при 10-ти сообщениях)

    /* === Hook - Part1 : Set === */
    $extp = cot_getextplugins('messages.history.loop');
    /* ===== */

    foreach ($dialog_history as $row) {
        $t->assign(array(
            'MSG_ROW_ID' => $row['id'],
            'MSG_ROW_DATE' => cot_date('H:i', $row['date']),
            'MSG_ROW_DATE_STAMP' => $row['date'],
            'MSG_ROW_TEXT' => htmlentities($row['text'], ENT_QUOTES, "UTF-8"),
            'MSG_ROW_READSTATUS' => $row['status'],
        ));

        if ($row['touser'] == $usr['id']) {
            $t->assign($opptags);
        } else {
            $t->assign($usrtags);
        }
        /* === Hook - Part2 : Include === */
        foreach ($extp as $pl) {
            include $pl;
        }
        /* ===== */

        $t->parse('MAIN.MSG_ROW');
    }

    if ($newpm == 1) {
        $pmsql = $db->update($db_messages_msg, array('status' => '0'), "dialog = " . (int) $chatid . " AND touser = " . (int) $usr['id'] . " AND status = 1");
        $pmsql = $db->update($db_messages_dialog, $state, "id = " . (int) $chatid . "");
    }
}

$t->assign(array(
    'DIALOG_ID' => $chatid,
    'MSG_FORM_SEND' => cot_url('messages', 'm=ajax&a=send&chat=' . $chatid),
    'MSG_FORM_TEXT' => cot_textarea('newpmtext', $newpmtext, 4, 56),
    'DIALOG_COUNT' => count($dialogs),
));

$title[] = array(cot_url('users', 'm=details&id=' . $opptags['MSG_ROW_USER_ID'] . '&u=' . $opptags['MSG_ROW_USER_NICKNAME']), $opptags['MSG_ROW_USER_NICKNAME']);
$t->assign(array(
    'BREADCRUMBS' => cot_breadcrumbs_uk($title, $cfg['homebreadcrumb']),
));

/* === Hook === */
foreach (cot_getextplugins('messages.tags') as $pl) {
    include $pl;
}
/* ===== */



// -------------------- START LIST

/* === Hook - Part1 : Set === */
$extp = cot_getextplugins('messages.list.loop');
/* ===== */
$jj = 0;
foreach ($dialogs as $row) {
    $jj++;

    $msgfilter = "(dialog = '" . $row['id'] . "')";
    $msg = $db->query("SELECT * FROM $db_messages_msg WHERE $msgfilter ORDER BY id DESC LIMIT 1")->fetch();

    $_opponent = ($row['toid'] == $usr['id']) ? $row['fromid'] : $row['toid'];
    $from_user = ($msg['touser'] == $usr['id']) ? $opponent : $usr['id'];

    $t->assign(cot_generate_usertags($_opponent, 'MSG_OPPONENT_'));
    $t->assign(cot_generate_usertags($from_user, 'MSG_FROM_USER_'));

    if ($row['id'] == $chatid) {
        $active = 1;
    } else {
        $active = 0;
    }
    if ($msg["touser"] == $usr["id"] && $msg["status"] == 1) {
        $new = 1;
    } else {
        $new = 0;
    }
    
    $t->assign(array(
        'MSG_ID' => $row['id'],
        'MSG_ACTIVE' => $active,
        'MSG_NEW' => $new,
        'MSG_DATE' => cot_date('datetime_medium', $msg['date']),
        'MSG_DATE_STAMP' => $msg['date'],
        'MSG_TIME_AGO' => cot_build_timeago($msg['date']),
        'MSG_DIAOG_URL' => cot_url('messages', 'chat=' . $row['id']),
        'MSG_STATUS' => $msg['status'],
        'MSG_TEXT' => cot_string_truncate(htmlentities($msg['text'], ENT_QUOTES, "UTF-8"), 65, true, false, "..."),
    ));
    /* === Hook - Part2 : Include === */
    foreach ($extp as $pl) {
        include $pl;
    }
    /* ===== */

    $t->parse('MAIN.MSG_LIST');
}

// -------------------- END LIST

$t->parse('MAIN');
$t->out('MAIN');

require_once $cfg['system_dir'] . '/footer.php';
