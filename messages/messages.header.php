<?php

/* ====================
  [BEGIN_COT_EXT]
  Hooks=header.main
  Tags=header.tpl:{HEADER_USER_PMS},{HEADER_USER_PMREMINDER},{HEADER_USER_PM_URL},{HEADER_USER_PM_COUNT}
  [END_COT_EXT]
  ==================== */

/**
 * Messages
 * @version 1.0
 * @package MSG
 * @copyright (c) PluginsPro Team
 */
defined('COT_CODE') or die('Wrong URL.');
if ($usr['id'] > 0) {
    require_once cot_incfile('messages', 'module');

    $usr['messages'] = 0;

    $newmsg = $db->query("SELECT COUNT(*) FROM $db_messages_dialog WHERE (toid='" . $usr['id'] . "' AND tostatus = 1) OR (fromid='" . $usr['id'] . "' AND fromstatus = 1)")->fetchColumn();
    if ($newmsg > 0) {
        $usr['messages'] = $db->query("SELECT COUNT(*) FROM $db_messages_msg WHERE touser='" . $usr['id'] . "' AND status = 1")->fetchColumn();
    }


    if ($cfg["messages"]["dashboard"] == 1) {
        $out['pmreminder'] = cot_rc_link(cot_url('dashboard', 'm=messages'), ($usr['messages'] > 0) ? cot_declension($usr['messages'], $Ls['Privatemessages']) : $L['hea_noprivatemessages']);

        $out['pms'] = cot_rc_link(cot_url('dashboard', 'm=messages'), $L['Private_Messages']);
    } else {
        $out['pmreminder'] = cot_rc_link(cot_url('messages'), ($usr['messages'] > 0) ? cot_declension($usr['messages'], $Ls['Privatemessages']) : $L['hea_noprivatemessages']);

        $out['pms'] = cot_rc_link(cot_url('messages'), $L['Private_Messages']);
    }


    $t->assign(array(
        'HEADER_USER_PM_URL' => cot_url('messages'),
        'HEADER_USER_PMS' => $out['pms'],
        'HEADER_USER_PM_COUNT' => $usr['messages'],
        'HEADER_USER_PMREMINDER' => $out['pmreminder']
    ));
}
