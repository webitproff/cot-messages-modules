<?php
/* ====================
[BEGIN_COT_EXT]
Hooks=module
[END_COT_EXT]
==================== */

/**
 * Messages main
 * @version 1.0
 * @package MSG
 * @copyright (c) PluginsPro Team
 */

defined('COT_CODE') or die('Wrong URL.');

define('COT_DS', true);
$env['location'] = 'dialogs';

require_once cot_incfile('extrafields');
require_once cot_incfile('users', 'module');

require_once cot_incfile('messages', 'module');
require_once cot_langfile('messages', 'module');

 if (!in_array($m, array('send', 'dialog', 'ajax', 'count', 'search')))
 {
	$m = 'dialog';
 }

require_once cot_incfile('messages', 'module', $m);