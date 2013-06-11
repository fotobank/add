/**
 * Created with JetBrains PhpStorm.
 * User: Jurii
 * Date: 14.04.13
 * Time: 14:59
 * To change this template use File | Settings | File Templates.
 */


//var value = $(" #result ").html();
     //   alert (value);



function sendFtp() {

          $.ajax({
                type: "POST",
                header: ('Content-Type: application/json; charset=utf-8;'),
                url: "./zaprosDirFtp.php",
                data: {ftpDir: $('#prependedInput').val()},

              error:function(xhr, status, errorThrown) {
                 	                alert(errorThrown+'\n'+status+'\n'+xhr.statusText);
              },
                success: function (data) {

                var selector;
                var option;
                var dataArray = data.split(":");
                var ftpFold = $(' #ftpFold ').val();

                    jQuery.each(dataArray, function() {
                        if (this != ">/") // последний элемент массива
                        {
                 option += "<option value = '" + this  + "/' >" + this  + "/</option>";
                        }
                        return option;
                    });
                    selector = "<option value = '" + ftpFold  + "' >" + ftpFold  + "</option>" + option;
                    $(" #upFTP ").empty().append(selector);
                }
            });
}


function ajaxPostQ(url, idName,  data) {
    $.ajax({
        type: "POST",
        header: ('Content-Type: application/json; charset=utf-8;'),
        url: url,
        data: data,
        error:function(XHR) {
            alert(" Ошибка: "+XHR.status+ "  " + XHR.statusText);
        },
        statusCode: {
           404: function() {
           alert("Страница не найдена");
         }
         },
        // Выводим то что вернул PHP
        success: function (html) {
//           alert(html);
            $(idName).empty().append(html);
         }
    });
}
