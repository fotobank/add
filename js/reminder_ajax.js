/**
 * Created with JetBrains PhpStorm.
 * User: Jurii
 * Date: 12.04.13
 * Time: 12:59
 * To change this template use File | Settings | File Templates.
 */

/**
 * Ќапоминание парол€
 */


function send()
{
//ѕолучаем параметры
    var data = $('#login').val() + '][' + $('#email').val();
    $("#login").empty();
    $("#email").empty();
    // ќтсылаем паметры
    $.ajax({
        type: "POST",
        url: "/inc/SendData.php",
        data: "data="+data,

        // ¬ыводим то что вернул PHP
        success: function(html) {
            //предварительно очищаем нужный элемент страницы
            $("#result").empty().append(html);

         //   dhtmlx.message({ type:'warning', text: data});
        }
    });

}


(function($) {
    $.fn.autoClear = function () {
        // сохран€ем во внутреннюю переменную текущее значение
        $(this).each(function() {
            $(this).data("autoclear", $(this).attr("value"));
        });
        $(this)
            .bind('focus', function() {   // обработка фокуса
                if ($(this).attr("value") == $(this).data("autoclear")) {
                    $(this).attr("value", "").addClass('autoclear-normalcolor');
                }
            })
            .bind('blur', function() {    // обработка потери фокуса
                if ($(this).attr("value") == "") {
                    $(this).attr("value", $(this).data("autoclear")).removeClass('autoclear-normalcolor');
                }
            });
        return $(this);
    }
})(jQuery);


$(function(){
    // прив€зываем плагин ко всем элементам с классом "autoclear"
    $('.autoclear').autoClear();
});
