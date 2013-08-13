
// вызов out
/*window.outDebug = function (msg, title, group){
 window.hackerConsole = window.hackerConsole || window.Debug_HackerConsole_Js && new window.Debug_HackerConsole_Js();
 if (window.hackerConsole) setTimeout(function() { with (window.hackerConsole) {
 out(msg, title, group);
 }}, 200);
 };*/

(function($) {

    $.fn.outDebug = function (msg, title, group){
        return this.each(function() {
            window.hackerConsole = window.hackerConsole || window.Debug_HackerConsole_Js && new window.Debug_HackerConsole_Js();
            if (window.hackerConsole) setTimeout(function() { with (window.hackerConsole) {
                out(msg, title, group);
            }}, 200);
        });
    };



    $(function () {
        $(".vhod , input, textarea, label, .lazy, .img3").tooltip();
        });

    $("a[rel=popover]")
    .popover({
        offset: 10
        })
    .click(function (e) {
        e.preventDefault()
        });


    function hPocta(){

        var data =  $('#nPocta').val().split('|');
        if (data[0] != 'выбрать')
        {
            var val = "<p style='font-size:12px;'>Обращаем Ваше внимание, что при выборе наложенного платежа заказчик оплачивает пересылку фотографий в одну сторону и денег в другую. С ценами на почтовые услуги Вы можете ознакомиться кликнув по ссылке.</p><a href= '" + data[1] +"' class='ttext_blue' style='font-size:10px; float: right;' target='_blank'>Расчет стоимости пересылки в почтовой службе  '"+ data[0] +"' </a>";
            $(' #httpPocta ').empty().html(val);
        }

    }


    /*
     Todo    - Автоочистка текстового поля при получении фокуса
     @author - Jurii
     @date   - 13.04.13
     @time   - 8:56
     */

        $.fn.autoClear = function () {
            // сохраняем во внутреннюю переменную текущее значение
            $(this).each(function () {
                $(this).data("autoclear", $(this).attr("value"));
            });
            $(this).bind('focus', function () {   // обработка фокуса
                if ($(this).attr("value") == $(this).data("autoclear")) {
                    $(this).attr("value", "").addClass('autoclear-normalcolor');
                }
            })
                .bind('blur', function () {    // обработка потери фокуса
                    if ($(this).attr("value") == " ") {
                        $(this).attr("value", $(this).data("autoclear")).removeClass('autoclear-normalcolor');
                    }
                });
            return $(this);
        };


    $(function () {
        // привязываем плагин ко всем элементам с id "#email, #login"
        $('.autoclear, .inp_f_reg').autoClear();
    });



//    <!--	запуск modal reminder -->
    $(function () {
        $('[data-toggle="modal"]').click(function (e) {
            e.preventDefault();
            var url = $(this).attr('href');
            if (url.indexOf("#") == 0) {
                $(url).modal('open');
            } else {
        $.get(url, function (data) {
            $('<div id="vosst" class="modal hide fade in animated fadeInDown" style="position: absolute; top: 40%; left: 50%; z-index: 1; " data-keyboard="false" data-width="460" data-backdrop="static" tabindex="-1" aria-hidden="false">' + data + '</div>').modal();
        })
    .success(function () {
        // привязываем плагин ко всем элементам с "autoclear"
        $(' .autoclear ').autoClear().tooltip();
        });
    }
    });
    });


//    <!--	запуск modal order -->

    $(function () {
        $('[data-toggle="order"]').click(function (e) {
            e.preventDefault();
            var url = $(this).attr('href');
            if (url.indexOf("#") == 0) {
                $(url).modal('open');
            } else {
        $.get(url, function (data) {
            $('<div id="vosst" class="modal hide fade in animated fadeInDown" style="position: absolute; top: 40%; left: 50%; z-index: 1; " data-keyboard="false" data-width="950" data-backdrop="static" tabindex="-1" aria-hidden="false">' + data + '</div>').modal();
        })
    }
    });
    });

})(jQuery);


// <!--- шифровка E-mail -->

function scrambleVideo() {
    var pa, pb, pc, pd, pe, pf;
    pa = '<a href='+'"mai';
    pb = 'video';
    pc = '">';
    pa += 'lto:';
    pb += '@';
    pe = '</a>';
    pf = 'Заказ видеосъемки';
    pb += 'aleks.od.ua';
    pd = pf;
    document.write(pa + pb + pc + pd + pe)
}
function scrambleFoto() {
    var pa, pb, pc, pd, pe, pf;
    pa = '<a href='+'"mai';
    pb = 'foto';
    pc = '">';
    pa += 'lto:';
    pb += '@';
    pe = '</a>';
    pf = 'Заказ фотосесии';
    pb += 'aleks.od.ua';
    pd = pf;
    document.write(pa + pb + pc + pd + pe)
}

// гостевая
function smile(str) {
    obj = document.Sad_Raven_Guestbook.mess;
    obj.focus();
    obj.value = obj.value + str;
}
function openBrWindow(theURL, winName, features) {
    window.open(theURL, winName, features);
}
function inserttags(stT, enT) {
    obj = document.Sad_Raven_Guestbook.mess;
    obj2 = document.Sad_Raven_Guestbook;
    if ((document.selection)) {
        obj.focus();
        obj2.document.selection.createRange().text = stT + obj2.document.selection.createRange().text + enT;
    }
    else {
        obj.focus();
        obj.value += stT + enT;
    }
}
// end гостевая