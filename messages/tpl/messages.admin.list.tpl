<!-- BEGIN: MAIN -->
{ADMIN_IMPORT}
<div class="block">
    <table class="table" style="margin: 0px auto;">
        <thead>
            <tr>
                <th style="width: 20%; text-align: center;">Диалог</th>
                <th style="width: 70%; text-align: center;">Последнее сообщение</th>
                <th style="width: 10%; text-align: center;">Удалить</th>
            </tr>
        </thead>
        <tbody>
            <!-- BEGIN: MSG_ROW -->
            <tr class="dialoghover">
                <td>
                    <span class="ds_avatar">{MSG_TO_USER_AVATAR}</span>
                    <span>{MSG_TO_USER_NAME}</span>
                </td>
                <td href="{MSG_DIAOG_URL}" onclick="window.open('{MSG_DIAOG_URL}', '', 'Toolbar=0,Location=0,Directories=0,Status=0,Menubar=0,Scrollbars=1,Resizable=0,Width=750,Height=500');
                      return false;">
                    <div class="ds_avatar marginright10" style="float: left;">{MSG_FROM_USER_AVATAR}</div>
                    <div class="paddingright10 dialogmsg<!-- IF {MSG_STATUS} --> unreadmsg<!-- ENDIF -->">{MSG_FROM_USER_NAME}
                        <small class="pull-right">{MSG_DATE}</small>
                        <br />
                        <small>{MSG_TEXT}</small></div>
                </td>
                <td style="text-align: center;">
                    <a href="{MSG_DELETE}" onclick="window.open('{MSG_DELETE}', '', 'Toolbar=0,Location=0,Directories=0,Status=0,Menubar=0,Scrollbars=0,Resizable=0,Width=550,Height=400');return false;" class="ds_avatar" target="_blank"><img class="icon" src="images/icons/{PHP.cfg.defaulticons}/pm-delete.png" alt="Удалить" /></a>
                </td>
            </tr>
            <!-- END: MSG_ROW -->
        </tbody>
    </table>
</div>

<!-- END: MAIN -->