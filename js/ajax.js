/**
 * Created with JetBrains PhpStorm.
 * User: Jurii
 * Date: 12.04.13
 * Time: 12:59
 * To change this template use File | Settings | File Templates.
 */


/*
 Todo    - ajax - Напоминание пароля
 @author - Jurii
 @date   - 13.04.13
 @time   - 8:54
 */

function send()
{

    reminderAjax('');
}

function clearAjax()
{
    $("#login").attr({value: "Введите Ваш логин:"});
    $("#email").attr({value: "или E-mail:"});

}

function reminderAjax()
{

    //Получаем параметры
    var data = $('#login').val() + '][' + $('#email').val();

    // Отсылаем паметры
    $.ajax({
        type: "POST",
        url: "/inc/SendData.php",
        data: "data="+data,

        // Выводим то что вернул PHP
        success: function(html) {
            //предварительно очищаем нужный элемент страницы
            $("#result").empty().append(html);

            //   dhtmlx.message({ type:'warning', text: data});
        }
    });

}
/*
 Todo    - Автоочистка текстового поля при получении фокуса
 @author - Jurii
 @date   - 13.04.13
 @time   - 8:56
 */

(function($) {
    $.fn.autoClear = function () {
        // сохраняем во внутреннюю переменную текущее значение
        $(this).each(function() {
            $(this).data("autoclear", $(this).attr("value"));
        });
        $(this).bind('focus', function() {   // обработка фокуса
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
    // привязываем плагин ко всем элементам с id "#email, #login"
     $(' #email, #login ').autoClear();
});


