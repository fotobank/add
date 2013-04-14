/**
 * Created with JetBrains PhpStorm.
 * User: Jurii
 * Date: 14.04.13
 * Time: 14:59
 * To change this template use File | Settings | File Templates.
 */


function sendFtp() {
    var data = 'dir';
    $.ajax({
        type: "POST",
        url: "../zaprosDirFtp.php",
         data: "data="+data,

        // ¬ыводим то что вернул PHP
        success: function (html) {
            //предварительно очищаем нужный элемент страницы
            $("#result").empty().append(html);
            getCaptca();

        }
    });
}