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

function send1() {
    $.ajax({
        type: "POST",
        header: ('Content-Type: application/json; charset=utf-8;'),
        url: "/inc/SendData.php",
        // data: "data="+data,
        data: $(' #reminder').serialize(),

        error:function(xhr, status, errorThrown) {
            alert(errorThrown+'\n'+status+'\n'+xhr.statusText);
        },

        // Выводим то что вернул PHP
        success: function (html) {
            //предварительно очищаем нужный элемент страницы
            $(" #result").empty().append(html);
            getCaptca();

        }
    });
}




function getCaptca2() {

 //  $(" .loadCaptca").load("/inc/captcha/captcha.html");

    $.ajax({
        type: "GET",
        header: ('Content-Type: application/json; charset=utf-8;'),
        url: "/inc/captcha/captcha.html",
       cache: false,
        error:function(xhr, status, errorThrown) {
            alert(errorThrown+'\n'+status+'\n'+xhr.statusText);
        },
        success: function(data){
            $(" #loadCaptca ").empty().append(data);


            return false;


        }


    });





 //   $.ajax({
//        type: 'post',
    //    url: "/inc/captcha/captcha.php",
   //     cache: false,
//        data: 'action=report_link',
//        dataType : 'html',
//        context: $(this),
   //     success: function (data) {
        //    $(" .loadCaptca ").html(data);


     //   }
 //   });





//   $(" .loadCaptca ").attr("src", src);

  //  $.get("/inc/captcha/captcha.php");

//   $.get("/inc/captcha/captcha.php", function(data){

    //   alert(data);

 //       $(" .loadCaptca ").attr("src", data);

 //   });


   // $(" .loadCaptca ").attr("src", "/inc/captcha/captcha.php");

  //  $('img').each( function(){ this.src = this.getAttribute('data-full'); } );
 //   $('img').each( function(){ $(this).attr('src', $(this).data('full')); } );




    /* var src = ($(" .loadCaptca").attr("src") === "/inc/captcha/captcha.php")
         ? "/inc/captcha/captcha.php"
         : "/inc/captcha/captcha.php";
     $(" .loadCaptca").attr("src", src);*/
}

/*
 Todo    - Автоочистка текстового поля при получении фокуса
 @author - Jurii
 @date   - 13.04.13
 @time   - 8:56
 */
(function ($) {
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
    }
})(jQuery);

$(function () {
    // привязываем плагин ко всем элементам с id "#email, #login"
    $(' .autoclear ').autoClear();
});









/*
var req = sCreate();

function nameId(id)
{
    return document.getElementById(id);
}

function sCreate()
{
    if(navigator.appName == "Microsoft Internet Explorer")
    {
        req = new ActiveXObject("Microsoft.XMLHTTP");
    }
    else
    {
        req = new XMLHttpRequest();
    }
    return req;
}

function refresh(id)
{
    var a = req.readyState;
    id = "loadCaptca";
// alert(a);
    if( a == 4 )
    {
        var b = req.responseText;
        nameId(id).innerHTML = b;
    }
    else
    {
        nameId(id).innerHTML = '<br><div style="text-align: center;">Запрос.........</div>';
    }
}


function gRequest(query)
{
    req.open('post', '/inc/SendData.php' , true );
    req.onreadystatechange = refresh(' result ');
    req.setRequestHeader("Content-Type", "application/x-www-form-urlencoded; charset=utf-8");
    req.send(query);
}



// элементы формы восстановления пароля, которые будем отправлять
function getReminder()
{
    var query;
    query = $('#reminder').serialize();
    gRequest(query);
}


function getCaptca()
{
    var query;
    var captcha = "1";
    query = 'captcha=' + captcha;
    req.open('post', '/inc/captcha/captcha.html' , true );
    req.onreadystatechange = refresh();
    req.setRequestHeader("Content-Type", "application/x-www-form-urlencoded; charset=utf-8");
    req.send(query);
}
*/



var req = objectCreate();


function idElement(idName)
{
    return document.getElementById(idName);
}



function objectCreate()
{
    if(navigator.appName == "Microsoft Internet Explorer")
    {
        req = new ActiveXObject("Microsoft.XMLHTTP");
    }
    else
    {
        req = new XMLHttpRequest();
    }
    return req;
}


function getRefresh()
{
    var dataState = req.readyState;
    var id = 'loadCaptca';
    if( dataState == 4 )
    {
      //  var dataResponse = req.responseText;
        idElement(id).innerHTML = req.responseText;
    }
    else
    {
        idElement(id).innerHTML = '<br><div style="text-align: center;">Запрос ...</div>';

    }
}


// элементы формы восстановления пароля, которые будем отправлять
function getReminder()
{
    var query;
    query = $('#reminder').serialize();
    req.open('post', '/inc/captcha/captcha.html' , true );
    req.onreadystatechange = getRefresh;
    req.setRequestHeader("Content-Type", "application/x-www-form-urlencoded; charset=utf-8");
    req.send(query);
}


function ajaxGet(metod, url, idName)
{
    req.open(metod, url + '?sl&rn=' + Math.random() , true );
    req.onreadystatechange = function () {

    var dataState = req.readyState;

    if( dataState == 4 )
    {

        idElement(idName).innerHTML = req.responseText;
    }
    else
    {
        idElement(idName).innerHTML = '<br><div style="text-align: center;">Запрос ...</div>';

    }
    };
    req.setRequestHeader("Content-Type", "application/x-www-form-urlencoded; charset=utf-8");
    req.send();
}
