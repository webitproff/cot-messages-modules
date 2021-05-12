<?php

/**
 * Messages
 * @version 1.0
 * @package MSG
 * @copyright (c) PluginsPro Team
 */
defined('COT_CODE') or die('Wrong URL');

include_once cot_incfile("users", "module");

$search = cot_import("search", "G", "TXT");

$myReferal = $usr["profile"]["user_referal"];
$data = $db->query(" SELECT  * FROM {$db_users} WHERE  `user_name` LIKE '%{$search}%' ")->fetchAll();
$res = array();
foreach ($data as $k => $v) {

    $res[$k]['value'] = $v['user_name'];
    $res[$k]['title'] = $v['user_name'];
    $res[$k]['url'] = cot_url('users', 'm=details&user=' . $v['user_name']);
    $res[$k]['avatar'] = $v['user_avatar'] ? $v['user_avatar'] : "/datas/defaultav/blank.png";
    $res[$k]['userpoints'] = $v['user_userpoints'];
    $res[$k]['pro'] = $v['user_pro'] ? "PRO" : "";
    $res[$k]['text'] = $v['user_text'] ? substr(strip_tags($v['user_text']), 0, 65) : $L["msg_user_not_text"];
    if ($cfg["messages"]["dashboard"] == 1) {
        $res[$k]['url'] = html_entity_decode(cot_url('dashboard', 'm=messages&act=new&to=' . $v['user_id']));
    } else {
        $res[$k]['url'] = html_entity_decode(cot_url('messages', 'm=dialog&act=new&to=' . $v['user_id']));
    }
}
if (empty($data)) {
    $res[0]['value'] = $cfg["maintitle"];
    $res[0]['title'] = $cfg["maintitle"];
    $res[0]['url'] = "#";
    $res[0]['avatar'] = "/datas/defaultav/blank.png";
    $res[0]['userpoints'] = 9999;
    $res[0]['pro'] = "PRO";
    $res[0]['text'] = "К сожалению  по вашему запросу  мы не кого не нашли =(";
    if ($cfg["messages"]["dashboard"] == 1) {
        $res[0]['url'] = "#";
    } else {
        $res[0]['url'] = "#";
    }
}
print json_encode($res);

exit;
