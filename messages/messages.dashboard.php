<?php

/**
 * [BEGIN_COT_EXT]
 * Hooks=dashboard.include
 * [END_COT_EXT]
 */
defined('COT_CODE') or die('Wrong URL.');
if ($cfg["messages"]["dashboard"] == 1) {
    list($usr['auth_read'], $usr['auth_write'], $usr['isadmin']) = cot_auth('dashboard', 'any');
    cot_block($usr['auth_write']);

    require_once cot_incfile('messages', 'module');
    require_once cot_incfile('users', 'module');

    require_once cot_langfile('messages', 'module');

    $dashboardmenu['messages']['title'] = $L['Private_Messages'];
    $dashboardmenu['messages']['url'] = cot_url('dashboard', "m=messages");

    if ($m == 'messages') {

        require_once cot_incfile('messages', 'module', "dashboard");

        $t1->parse('MAIN');
        $t->assign('DASH_CONTENT', $t1->text('MAIN'));
    }
}
?>