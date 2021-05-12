<!-- BEGIN: MAIN -->
<div class="block">      
    <!-- BEGIN: MSG_ROW_EMPTY -->
    <tr style="display:none" id="error">
        <td></td>
        <td class="text-center">{PHP.L.None}</td>
    </tr>
    <!-- END: MSG_ROW_EMPTY -->
    <div class="ds_scroll">       
        <table class="cells">
            <!-- BEGIN: MSG_ROW -->
            <tr>
                <td style="width: 5%;" class="ds_avatar">{MSG_ROW_USER_AVATAR}</td>            
                <td id="{MSG_ROW_ID}" style="width: 85%;<!-- IF {MSG_ROW_READSTATUS} --> background: #F3F3F3;<!-- ENDIF -->">
                    <span class="pull-right">{MSG_ROW_USER_MAINGRP} {MSG_ROW_DATE}</span>
                    {MSG_ROW_USER_NAME}<br />
                    <span msg="edit" class="ds_edit<!-- IF !{MSG_ROW_READSTATUS} --> read<!-- ENDIF -->" id="{MSG_ROW_ID}" href="{MSG_EDIT_URL}">{MSG_ROW_TEXT}
                    </span>
                </td>
            </tr>
            <!-- END: MSG_ROW -->
        </table>       
    </div>    
</div>

<!-- END: MAIN -->