<!-- BEGIN: MAIN -->
<!-- BEGIN: INBOX -->
<div id="{MSG_ROW_ID}" class="uk-grid">
    <div class="uk-width-2-10 uk-text-center  uk-padding-remove">
        <img class="msg-avatar uk-border-circle" src="<!-- IF {MSG_ROW_USER_AVATAR_SRC} -->{MSG_ROW_USER_AVATAR_SRC}<!-- ELSE -->/datas/defaultav/blank.png<!-- ENDIF -->" alt="">
    </div>
    <div class="uk-width-8-10 uk-padding-remove">  
        <div class="uk-margin-top"><span class="uk-text-small uk-text-muted uk-margin-right">{MSG_ROW_DATE}</span> {MSG_ROW_USER_NAME}</div>
        <div class="uk-text-muted uk-margin-small-top">{MSG_ROW_TEXT}</div>
    </div> 
    <!-- IF {MSG_ROW_READSTATUS} --><div class="uk-text-small">прочитано</div><!-- ENDIF -->
</div>
<!-- END: INBOX -->

<!-- BEGIN: OUTBOX -->
<div id="{MSG_ROW_ID}" class="uk-grid">
    <div class="uk-width-2-10 uk-text-center  uk-padding-remove">
        <img class="msg-avatar uk-border-circle" src="<!-- IF {MSG_ROW_USER_AVATAR_SRC} -->{MSG_ROW_USER_AVATAR_SRC}<!-- ELSE -->/datas/defaultav/blank.png<!-- ENDIF -->" alt="">
    </div>
    <div class="uk-width-8-10 uk-padding-remove">  
        <div class="uk-margin-top"><span class="uk-text-small uk-text-muted uk-margin-right">{MSG_ROW_DATE}</span> {MSG_ROW_USER_NAME}</div>
        <div class="uk-text-muted uk-margin-small-top msg-text">{MSG_ROW_TEXT}</div>
    </div> 
    <!-- IF {MSG_ROW_READSTATUS} --><div class="uk-text-small">прочитано</div><!-- ENDIF -->
</div>
<!-- END: OUTBOX -->

<!-- BEGIN: ERROR -->
<div class="uk-alert uk-alert-danger" style="display:none" id="error">{ERROR_MSG}</div>
<!-- END: ERROR -->

<!-- END: MAIN -->