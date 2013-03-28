$(document).ready(function () {
    $(function () {
        $('.top_pos').each(function (i) {
            $(this).delay((i) * 500).fadeTo(300, 1);
            i++;
        });

    });
});


function preview(idPhoto) {

    $('#photo_preview').fadeTo('fast', 0.01, function () {
        $('#photo_preview').load('photo_preview.php?id=' + idPhoto, function () {
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


function hidePreview() {
    $('#photo_preview').toggleClass('hidden').fadeOut('normal', function () {
        $('#photo_preview_bg').toggleClass('hidden').removeAttr('style').hide();
    });
}

humane.clickToClose = (true);
humane.timeout = (2500);

function basketAdd(idPhoto) {
    $.post('add_basket.php', {'id': idPhoto}, function (data) {
        var ans = JSON.parse(data);
        if (ans.status == 'ERR') {

            humane.error(ans.msg);
        }
        else {
            humane.success(["���� �������� � �������"]);
            dhtmlx.message({
                text: "���������� ���������� � �������",
                expire:15000,
                type:"addfoto" // 'customCss' - css �����
            });
        }
    });
}


function goVote(event, idPhoto) {
    var voteprice = document.vote_price.id1.value;
    dhtmlx.confirm({
        type: "confirm",
        text: "���� ������ ������ " + voteprice + " ��.<br> �������������?",
        callback: function (index) {
            if (index == true) {
                $.post('go_Vote.php', {'id': idPhoto}, function (data) {
                    var ans = JSON.parse(data);
                    if (ans.status == 'ERR') {
                        humane.timeout = (8000);
                        humane.error(ans.msg);
                    }
                    else {
                        dhtmlx.message({ text: "��� ����� ��������", expire: 10000, type: "addgolos" });
                        humane.info("��� ����� ������� ��������");
                        preview(idPhoto);
                    }
                })
            }
        }
    });
}

