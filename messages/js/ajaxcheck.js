
$(document).ready(function(){
    function $_GET(key) {
	    var s = window.location.search;
	    s = s.match(new RegExp(key + '=([^&=]+)'));
	    return s ? s[1] : false;
    }

    function updatecountmsg() {
    $.ajax({
        type: 'GET',
        url: 'index.php?e=messages&m=count',
        success: function (data) {
            if (data) {
              if (data && data != $('#updatecountmsg').html())
              {              
                $('#updatecountmsg').html(data);
                if($_GET('m') != 'dialog' && window.location.pathname.split("/")[1] != 'admin')
                {
                 ion.sound.play("info_alert");
                }
              }
              update_count_timer();
            }
        }
    }) 
    }
    
    var timer;
    function update_count_timer() {
        if (timer)
            clearTimeout(timer);
        timer = setTimeout(function () {
            updatecountmsg();
        }, 5000);
    }
    update_count_timer();
    updatecountmsg();
}); 