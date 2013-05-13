$(document).ready(function () {
    $(function () {
        $('.top_pos').each(function (i) {
            $(this).delay((i) * 500).fadeTo(300, 1);

        });

    });
});


function preview(idPhoto) {

    $('#photo_preview').fadeTo('fast', 0.01, function () {
        $('#photo_preview').load('photo_preview.php?id=' + idPhoto, function () {
            $('#photo_preview_bg').height($(document).height()).toggleClass('hidden').fadeTo('fast', 0.7, function () {
                $('#photo_preview').alignCenter().toggleClass('hidden').fadeTo('fast', 1).click(function(){
                        $('#photo_preview').css('box-shadow','');
                });
            });
        });
    });
    return false;
}





function previewTop(idPhoto) {

    $('#photo_preview').fadeTo('fast', 0.01, function () {
        $('#photo_preview').load('photo_top_preview.php?id=' + idPhoto, function () {
            $('#photo_preview_bg').height($(document).height()).toggleClass('hidden').fadeTo('fast', 0.7, function () {
           //   $("img[src='dir.php?num=5618']").closest("#photo_preview").css('box-shadow', '0 0 0 2px #000,0 0 2px 6px #fa0, 0 0 0 11px #fd0, 0 0 0 13px #000');
              $("#photo_preview").css('box-shadow', '0 0 0 2px #000,0 0 2px 6px #fa0, 0 0 0 11px #fd0, 0 0 0 13px #000');
                $('#photo_preview').alignCenter().toggleClass('hidden').fadeTo('fast', 1).click(function(){
                      $('#photo_preview').css('box-shadow','');
                  });
                });
            });
        });
    return false;
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


function hidePreview() {
    $('#photo_preview').toggleClass('hidden').fadeOut('normal', function () {
        $('#photo_preview_bg').toggleClass('hidden').removeAttr('style').hide().click(function(){
           $('#photo_preview').css('box-shadow','');
    });
  });
    return false;
}

humane.forceNew = (true);
humane.clickToClose = (true);
humane.timeout = (2500);

function basketAdd(idPhoto) {
    $.post('add_basket.php', {'id': idPhoto}, function (data) {
        var ans = JSON.parse(data);
        if (ans.status == 'ERR') {
            humane.error(ans.msg);
        }
        else {
       //     humane.success(["Файл добавлен в корзину"]);
            dhtmlx.message({
                text: "Фотография добавленна в корзину",
                expire:15000,
                type:"addfoto" // 'customCss' - css класс
            });
        }
    });
}


function goVote(voteprice, idPhoto) {
    if (voteprice != 0)
    {
    dhtmlx.confirm({
        type: "confirm",
        text: "Цена одного голоса " + voteprice + " гр.<br> Проголосовать?",
        callback: function (index) {
            if (index == true) {
                $.post('go_Vote.php', {'id': idPhoto}, function (data) {
                    var ans = JSON.parse(data);
                    if (ans.status == 'ERR') {
                        humane.timeout = (8000);
                        humane.error(ans.msg);
                    }
                    else {
                       dhtmlx.message({ text: "Ваш голос добавлен", expire: 10000, type: "addgolos" });
                        preview(idPhoto);
                    }
                })
            }
        }
    });
    }
    else
    {
        $.post('go_Vote.php', {'id': idPhoto}, function (data) {
            var ans = JSON.parse(data);
            if (ans.status == 'ERR') {
                humane.timeout = (8000);
                humane.error(ans.msg);
            }
            else {
                humane.success("Ваш голос успешно добавлен");
                preview(idPhoto);
            }
        })
    }
}


