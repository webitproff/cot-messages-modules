<?php

/* ====================
  [BEGIN_COT_EXT]
  Hooks=usertags.main
  [END_COT_EXT]
  ==================== */

/**
 * MSG header notices
 * @version 1.0
 * @package MSG
 * @copyright (c) PluginsPro Team
 */
defined('COT_CODE') or die('Wrong URL.');

if ($cfg["messages"]["dashboard"] == 1) {
    $temp_array['PM'] = cot_rc_link(html_entity_decode(cot_url('dashboard', 'm=messages&act=new&to=' . $temp_array['ID'])), $L['msg_profilepm']);
} else {
    $temp_array['PM'] = cot_rc_link(html_entity_decode(cot_url('messages', 'm=dialog&act=new&to=' . $temp_array['ID'])), $L['msg_profilepm']);
}