/**
 * Created with JetBrains PhpStorm.
 * User: Jurii
 * Date: 12.04.13
 * Time: 12:59
 * To change this template use File | Settings | File Templates.
 */

/**
 * Напоминание пароля
 */


function send()
{
//Получаем параметры
    var data = $('#login').val() + '][' + $('#email').val();
    $("#login").empty();
    $("#email").empty();
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