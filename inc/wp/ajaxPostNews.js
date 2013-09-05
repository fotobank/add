/**
 * Created with JetBrains PhpStorm.
 * User: Jurii
 * Date: 27.08.13
 * Time: 18:32
 * To change this template use File | Settings | File Templates.
 */


function ajaxPostNews (url, idName,  data) {
    $.ajax({
        type: "POST",
        header: ('Content-Type: application/json; charset=utf-8;'),
        url: url,
        data: data,
        error:function(XHR) {
            //         alert(" Ошибка: "+XHR.status+ "  " + XHR.statusText);
        },
        statusCode: {
            404: function() {
                //            alert("Страница не найдена");
            }
        },
        // Выводим то что вернул PHP
        success: function (html) {
            //     alert(html);
            var ans = jQuery.parseJSON(html);
            //    var ans = JSON.parse(html);

            $(this).outDebug(html,'/canon68452/ajax/ajaxPostNews.php','ajaxPostNews');
            $(this).outDebug(ans.author_r);

            $('#author_r').val( ans.author_r);
            $('#email_r').val(ans.email_r);
            $('#url_r').val(ans.url_r);
            $('#comment_r').empty().append(ans.comment_r);

            $(this).outDebug(ans.url_r);
        }
    });
}




function ajaxPostRec (url, data) {
    $.ajax({
        type: "POST",
        header: ('Content-Type: application/json; charset=utf-8;'),
        url: url,
        data: data,
        error:function(XHR) {
             //         alert(" Ошибка: "+XHR.status+ "  " + XHR.statusText);
        },
        statusCode: {
            404: function() {
              //               alert("Страница не найдена");
            }
        },
        // Выводим то что вернул PHP
        success: function (html) {
        //      alert(html);

        }
    });
}



// удаление постов
function ajaxPostDel (url, data) {
    $.ajax({
        type: "POST",
        header: ('Content-Type: application/json; charset=utf-8;'),
        url: url,
        data: data,
        error:function(XHR) {
            //         alert(" Ошибка: "+XHR.status+ "  " + XHR.statusText);
        },
        statusCode: {
            404: function() {
                //            alert("Страница не найдена");
            }
        },
        // Выводим то что вернул PHP
        success: function (html) {
            //     alert(html);
         //   $(this).outDebug(html,'/canon68452/ajax/ajaxDel.php','ajaxPostDel');
            dhtmlx.message.expire = 6000;
            dhtmlx.message({ type: 'warning', text: html});
        }
    });
}
