<?php

/**
 * [BEGIN_COT_EXT]
 * Hooks=rc
 * [END_COT_EXT]
 */
defined('COT_CODE') or die('Wrong URL.');

if (file_exists(cot_incfile("uikit", "plug")))
    include_once cot_incfile("uikit", "plug");

if (function_exists("uk_com")) {
    uk_com("autocomplete");
}

if ($cfg['messages']['sound']) {
    cot_rc_link_footer($cfg['modules_dir'] . '/messages/js/ion.sound.min.js');
}

cot_rc_link_file($cfg['modules_dir'] . '/messages/tpl/messages.css');
cot_rc_link_footer($cfg['modules_dir'] . '/messages/js/messages.js');


if ($cfg['messages']['ajaxcheck']) {
    cot_rc_link_footer($cfg['modules_dir'] . '/messages/js/ajaxcheck.js');
}

if ($cfg['messages']['turnajax']) {
    cot_rc_link_footer($cfg['modules_dir'] . '/messages/js/messages.ajax.js');
}
   