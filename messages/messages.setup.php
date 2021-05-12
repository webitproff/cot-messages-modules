<?php
/* ====================
[BEGIN_COT_EXT]
Name=Messages
Description=User communication with ajax update and send
Version=2.6
Date=2016-10-15
Author=Kolev Andrew (Attar)
Copyright= (c) PluginsPro Team 2016
Requires_plugins=pluginspro
Auth_guests=
Lock_guests=W12345A
Auth_members=RW
Lock_members=
[END_COT_EXT]

[BEGIN_COT_EXT_CONFIG]
turnajax=01:radio::1:
sound=02:radio::1:Включить звуковые оповещания
ajaxcheck=03:radio::1:Включить AJAX проверку новых сообщений
hideimport=04:radio::0:Скрыть функцию импорта сообщений в админке
dashboard=05:radio::0:Включить переписку через личный кабинет
hideset=06:hidden:::
timesend=07:string::120:Частота рассылки ( в минутах )
license=08:string:::Лицензия
[END_COT_EXT_CONFIG]
==================== */

/**
 * MSG setup file
 * @version 2.6
 * @package Messages
 * @copyright (c) Kolev Andrew (PluginsPro Team)
 */
