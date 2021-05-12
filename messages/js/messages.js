
$(document).ready(function () {
    //по клику на ячейку в диалогах переходим по ссылке на сам диалог
    $(".dialog_body").on('click', function () {
        window.location = $(this).attr("href");
        return false;
    });

    var ShiftDown = false;
    // при нажатии на enter отправляем сообщение
    $('[name="newpmtext"]').keydown(function (e) {
        if (e.keyCode == 13) {
            if (e.shiftKey)
            {
                $('#dialogform [type="submit"]').val($('#dialogform [type="submit"]').val() + '\n');
            } else {
                e.preventDefault();
                $('#dialogform [type="submit"]').click();
            }
        }
    });
    $('[data-search').click(function () {
        //alert($(this).data('search'));
        $('#create-dialog-message').hide(500);
        $('#create-dialog-form').show(500);
        return false;
    });

    $('#search').on('show.uk.autocomplete', function (data) {
        $('#search-results').addClass('uk-active');
        $('#search-results').show(500);
        $("#search-results").html($("#tmp-search-results").html());
        $("#tmp-search-results").parent().hide();
        console.log(data);
    });
});