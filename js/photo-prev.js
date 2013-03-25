$(document).ready(function () {
    $(function () {
        $(' .top_pos').each(function (i) {
            $(this).delay((i++) * 500).fadeTo(300, 1);
        });

    });
});


function preview(id_photo) {

    $('#photo_preview').fadeTo('fast', 0.01, function () {
        $('#photo_preview').load('photo_preview.php?id=' + id_photo, function () {
            $('#photo_preview_bg').height($(document).height()).toggleClass('hidden').fadeTo('fast', 0.7, function () {
                $('#photo_preview').alignCenter().toggleClass('hidden').fadeTo('fast', 1);
            });
        });
    })
}


//additional properties for jQuery object
$(document).ready(function () {
    //align element in the middle of the screen
    $.fn.alignCenter = function () {
        //get margin left
        var marginLeft = -$(this).width() / 2 + 'px';
        //get margin top
        var marginTop = -$(this).height() / 2 + 'px';
        //return updated element
        return $(this).css({'margin-left': marginLeft, 'margin-top': marginTop});
    };
});


function hide_preview() {
    $('#photo_preview').toggleClass('hidden').fadeOut('normal', function () {
        $('#photo_preview_bg').toggleClass('hidden').removeAttr('style').hide();
    });
}

function basket_add(id_photo) {
    $.post('add_basket.php', {'id': id_photo}, function (data) {
        var ans = JSON.parse(data);
        if (ans.status == 'ERR') {
            alert(ans.msg);
        }
        else {
            alert('Файл добавлен в корзину!');
        }
    });
}



function go_vote(event, id_photo) {
    var voteprice = document.vote_price.id1.value;
    if (confirm('Цена одного голоса '+ voteprice +' гр. Проголосовать?')) {
        $.post('go_vote.php', {'id': id_photo}, function (data) {
            var ans = JSON.parse(data);
            if (ans.status == 'ERR') {
                alert(ans.msg);
            }
            else {
                alert('Ваш голос успешно добавлен!');
                preview(id_photo);
                //location.replace("fotobanck.php?1=1");
            }
        });
    }
}

