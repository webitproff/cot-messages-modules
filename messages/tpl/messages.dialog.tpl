<!-- BEGIN: MAIN -->
<div class="uk-container uk-container-center">
    <ul class="uk-breadcrumb">
        <li><a href="/">{PHP.L.Home}</a></li>
            {BREADCRUMBS}
    </ul>
</div>
<div class="uk-container uk-container-center uk-margin-large-top">
    <div class="uk-grid uk-grid-divider chat-height" data-uk-grid-match>
        
        <div class="uk-width-1-1 uk-width-medium-1-3 uk-padding-remove<!-- IF !{DIALOG_COUNT} --> uk-hidden<!-- ENDIF -->">
            <ul class="uk-list uk-list-line msg-list">
                <!-- BEGIN: MSG_LIST -->
                <li class="<!-- IF {MSG_ACTIVE} -->uk-active<!-- ENDIF -->">
                    <!-- IF {MSG_DATE_STAMP} --><div class="uk-panel-badge uk-badge uk-margin-small-top uk-margin-small-right">{MSG_TIME_AGO}</div><!-- ENDIF -->
                    <a href="{MSG_DIAOG_URL}" class="uk-grid">
                        <div class="uk-width-1-3">
                            <img class="msg-avatar uk-border-circle" src="<!-- IF {MSG_OPPONENT_AVATAR_SRC} -->{MSG_OPPONENT_AVATAR_SRC}<!-- ELSE -->/datas/defaultav/blank.png<!-- ENDIF -->" alt="">
                        </div>
                        <div class="uk-width-2-3">  
                            <div class="uk-margin-top">{MSG_OPPONENT_NICKNAME}</div>
                            <div class="uk-text-muted uk-margin-small-top uk-text-small">{MSG_TEXT}</div>
                            <div class="uk-badge uk-border-circle uk-float-right <!-- IF !{MSG_NEW} -->uk-hidden<!-- ENDIF -->" data-id="{MSG_ID}">&nbsp;</div>  
                        </div> 
                    </a>
                </li>
                <!-- END: MSG_LIST -->
            </ul>
        </div>
        <div class="uk-width-1-1 <!-- IF !{DIALOG_COUNT} -->uk-width-medium-1-1<!-- ELSE -->uk-width-medium-2-3<!-- ENDIF --> uk-padding-remove">
            <!-- IF  {DIALOG_ID} -->
            <div id="scroll" class="msg-scroll">       
                <div id="formsg">
                    <!-- BEGIN: MSG_ROW -->
                    <div id="{MSG_ROW_ID}" class="uk-grid">
                        <div class="uk-width-2-10 uk-text-center  uk-padding-remove">
                            <img class="msg-avatar uk-border-circle" src="<!-- IF {MSG_ROW_USER_AVATAR_SRC} -->{MSG_ROW_USER_AVATAR_SRC}<!-- ELSE -->/datas/defaultav/blank.png<!-- ENDIF -->" alt="">
                        </div>
                        <div class="uk-width-8-10 uk-padding-remove">  
                            <div class="uk-margin-top"><span class="uk-text-small uk-text-muted uk-margin-right">{MSG_ROW_DATE}</span> {MSG_ROW_USER_NAME}</div>
                            <div class="uk-text-muted uk-margin-small-top msg-text">{MSG_ROW_TEXT}</div>
                        </div> 
                    </div>
                    <!-- END: MSG_ROW -->
                </div>       
            </div>
            <form action="{MSG_FORM_SEND}" method="post" id="dialogform" data-dialog-id="{DIALOG_ID}" class="uk-form">
                {MSG_FORM_TEXT}
                <button id="dialogbutton" type="submit" class="uk-button uk-button-primary">{PHP.L.Reply}</button>
            </form>    
            <!-- ELSE -->
            <div class="uk-vertical-align uk-text-center uk-height-1-1">
                <div class="uk-vertical-align-middle" id="create-dialog-form" style="display: none;">
                    <form class="uk-search" id="search" data-uk-autocomplete="{method: 'GET', source:'/{PHP|cot_url("messages", "m=search")}'}">
                        <div class="uk-button-group">
                            <div class="uk-form-icon">
                                <i class="uk-icon-users"></i>
                                <input type="text" class="uk-form" id="usersearch" name="usersearch" placeholder="Поиск пользователя">
                            </div>
                        </div>
                        <script type="text/autocomplete">
                            <ul class="uk-nav uk-nav-autocomplete uk-autocomplete-results" id="tmp-search-results">
                                {{~items}}
                                <li data-value="{{ $item.value }}">
                                    <a href="{{ $item.url }}" class="uk-grid">
                                        <div class="uk-width-1-3">
                                            <img class="msg-avatar uk-border-circle" src="{{{ $item.avatar }}}" alt="">
                                        </div>
                                        <div class="uk-width-2-3  uk-text-left">  
                                            <div class="uk-margin-top">{{ $item.title }}</div>
                                            <div class="uk-text-muted uk-margin-small-top">{{ $item.text }}</div>
                                        </div> 
                                    </a>
                                </li>
                                {{/items}}
                            </ul>
                        </script>
                    </form>
                    <ul id="search-results" style="display: none;"></ul>
                </div>
                <div class="uk-vertical-align-middle" id="create-dialog-message">
                    <i class="uk-icon-commenting-o msg-no-dialog-icon"></i>
                    <div class="uk-margin-large-top">
                        {PHP.L.msg_please_select_dialog} <a href="#" data-search="users">{PHP.L.msg_create_dialog}</a>
                            </div>
                        </div>
                    </div>
                    <!-- ENDIF -->
                </div>
            </div>
        </div>              
<!-- END: MAIN -->