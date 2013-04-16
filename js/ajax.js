/**
 * Created with JetBrains PhpStorm.
 * User: Jurii
 * Date: 12.04.13
 * Time: 12:59
 * To change this template use File | Settings | File Templates.
 */


/*
 Todo    - ajax - Ќапоминание парол€
 @author - Jurii
 @date   - 13.04.13
 @time   - 8:54
 */

function send() {
    $.ajax({
        type: "POST",
        url: "/inc/SendData.php",
        // data: "data="+data,
        data: $('#reminder').serialize(),

        // ¬ыводим то что вернул PHP
        success: function (html) {
            //предварительно очищаем нужный элемент страницы
            $("#result").empty().append(html);
            getCaptca();

        }
    });
}


function getCaptca() {
    $(' .loadimg ').load('/inc/captcha/captcha.html');
}


/*
 Todo    - јвтоочистка текстового пол€ при получении фокуса
 @author - Jurii
 @date   - 13.04.13
 @time   - 8:56
 */
(function ($) {
    $.fn.autoClear = function () {
        // сохран€ем во внутреннюю переменную текущее значение
        $(this).each(function () {
            $(this).data("autoclear", $(this).attr("value"));
        });
        $(this).bind('focus', function () {   // обработка фокуса
            if ($(this).attr("value") == $(this).data("autoclear")) {
                $(this).attr("value", "").addClass('autoclear-normalcolor');
            }
        })
            .bind('blur', function () {    // обработка потери фокуса
                if ($(this).attr("value") == "") {
                    $(this).attr("value", $(this).data("autoclear")).removeClass('autoclear-normalcolor');
                }
            });
        return $(this);
    }
})(jQuery);

$(function () {
    // прив€зываем плагин ко всем элементам с id "#email, #login"
    $(' .autoclear ').autoClear();
});

;