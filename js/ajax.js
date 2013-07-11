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

function ajaxPostQ(url, idName,  data) {

    $(idName).empty();
 //   $(idName).empty().append();
    // индикатор загрузки
    $(document).ready(function() {

        // Установка ajax indicator
        $(idName).append('<div id="ajaxBusy"><p><img src="/img/loading2.gif"></p></div>');

        $('#ajaxBusy').css({
            display:"none",
            position:"relative",
            left:"30px",
            width:"auto"
        });
    });

    // Ajax activity indicator bound to ajax start/stop document events
    $(document).ajaxStart(function(){
        $('#ajaxBusy').show();
    }).ajaxStop(function(){
            $('#ajaxBusy').hide();
        });

    $.ajax({
        type: "POST",
        header: ('Content-Type: application/json; charset=utf-8;'),
        url: url,
        data: data,

        error:function(XHR) {
            $(this).outDebug(" Ошибка: "+XHR.status+ "  " + XHR.statusText,url,"ajaxPostQ");
        },
        statusCode: {
            404: function() {
                $(this).outDebug("Страница не найдена",url,"ajaxPostQ");
            }
        },

        success: function (html) {
// alert (html);
            $(this).outDebug(html,url,"ajaxPostQ");
            $(idName).empty().append(html);
        }
    });
}



// перезагрузка капчи
function reload (cfg, SID) {

       $(" #cryptogram ").attr("src", "/inc/captcha/cryptographp.php?cfg=" + cfg + "&" + SID + "&" + Math.round(Math.random(0)*1000)+1);
}

function returnCaptcha () {

    reload('kontakti.cfg.php','.<?=SID?>.')
}



//корзина
function goKorzDel(idName, srt) {
    $('#ramka'+idName).empty().html("<div style='margin:25px 0 0 35px;'><img style='width: 140px; float: left; margin-left: 5px;' src= '/img/not_foto.png'></div>");
    $('#iTogo').empty().load('/inc/ajaxZakazDel.php', {goZakazDel: idName , str: srt }, function(data){
            $(this).outDebug(data,"/inc/ajaxZakazDel.php","goKorzDel");
          if(!data)
          {
   $('#clearStr').empty().html("<div class='drop-shadow lifted' style='margin: 50px 0 0 480px;'><div style='font-size: 24px;'>Ваша корзина пуста!</div></div>");
          }
    }
    );
}


//подписка
function goPodpiska(album) {

    $('#podpiska').empty().load('/inc/ajaxPodpiska.php', {album: album }, function(data){
        $(this).outDebug(data,"/inc/ajaxPodpiska.php","goPodpiska");
        if(data)
            {
                $('#podpiska').empty().html(data);
            }
        });
 }


function ajaxAdd(data) {

    $.ajax({
        type: "POST",
        header: ('Content-Type: application/json; charset=utf-8;'),
        url: '/inc/ajaxZakazDel.php',
        data: data,

        error:function(XHR) {
            $(this).outDebug(" Ошибка: "+XHR.status+ "  " + XHR.statusText,"/inc/ajaxZakazDel.php","ajaxAdd");
        },
        statusCode: {
            404: function() {
                $(this).outDebug("Страница не найдена","/inc/ajaxZakazDel.php","ajaxAdd");
            }
        },

        success: function (html) {
            $(this).outDebug(html,"/inc/ajaxZakazDel.php","ajaxAdd");
            var ans = JSON.parse(html);
            if (ans.add == 1) {
                dhtmlx.message({
                    text: "Фотография № "+ans.nm+"<br> добавленна в корзину",
                    expire:9000,
                    type:"addfoto" // 'customCss' - css класс
                });
            } else {
                dhtmlx.message({
                    text: "Фотография № "+ans.nm+"<br> удалена из корзины",
                    expire:12000
                });
            }
            if(ans.fDel == 1) {
                if(!ans.prKoll)
                {
     $('#clearStr').empty().html("<div class='drop-shadow lifted' style='margin: 50px 0 0 480px;'><div style='font-size: 24px;'>Ваша корзина пуста!</div></div>");
                }
                $('#ramka'+ans.id).empty().html("<div style='margin:25px 0 0 35px;'><img style='width: 140px; float: left; margin-left: 5px;' src= '/img/not_foto.png'></div>")
            } else {
                $('#fKoll'+ans.id).empty().append(ans.fKoll+' шт');
                $('#fSumm'+ans.id).empty().append(ans.fSumm+' грн');
            }
            $('#iTogo').empty().append('ИТОГО: '+ans.sum+'  гривень  ('+ans.prKoll+' фото '+ans.format+' см)');
        }
    });
}


function ajaxFormat(data) {

    $.ajax({
        type: "POST",
        header: ('Content-Type: application/json; charset=utf-8;'),
        url: '/inc/ajaxZakazDel.php',
        data: data,

        error:function(XHR) {
            $(this).outDebug(" Ошибка: "+XHR.status+ "  " + XHR.statusText,"/inc/ajaxZakazDel.php","ajaxFormat");
        },
        statusCode: {
            404: function() {
                $(this).outDebug("Страница не найдена","/inc/ajaxZakazDel.php","ajaxFormat");
            }
        },

        success: function (html) {
            $(this).outDebug(html,"/inc/ajaxZakazDel.php","ajaxFormat");
            var ans = JSON.parse(html);
                dhtmlx.message({
                    text: "Выбран формат: <br> "+ans.format+" см",
                    expire:9000,
                    type:"addfoto"
                });
            $.each( ans.prArr, function(i, n){
                     $('#fCena'+i).empty().append(n+' грн');
            });
            $.each( ans.summArr, function(i, n){
                $('#fSumm'+i).empty().append(n+' грн');
            });
            $('#iTogo').empty().append('ИТОГО: '+ans.sum+'  гривень  ('+ans.prKoll+' фото '+ans.format+' см)');
        }
    });
}

// jQuery PHP обертка
jQuery.extend({
    php: function (url, params) {
        $.ajax({
            url: url,
            type: "POST",
            data: params,
            dataType : "json"
        })
    }
});

function getCaptca() {

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
            $(this).outDebug(data,"/inc/captcha/captcha.html","getCaptca");
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


/**
 * Определение типа браузера
 * @returns {*}
 */

function getXmlHttp(){
    var xmlhttp;
    try {
        xmlhttp = new ActiveXObject("Msxml2.XMLHTTP");
    } catch (e) {
        try {
            xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
        } catch (E) {
            xmlhttp = false;
        }
    }
    if (!xmlhttp && typeof XMLHttpRequest!='undefined') {
        xmlhttp = new XMLHttpRequest();
    }
    return xmlhttp;
}


function idElement(idName)
{
    return document.getElementById(idName);
}


/**
 * @ todo - отправка ajax запроса
 * @param url - серверный скрипт
 * @param idName - id элемента для вывода ответа
 * @param data - посылаемые данные при пост методе (для <form> -" $('#div').serialize());" или "data[a,b,c]")
 */

function ajaxPost(url, idName, data)
{
    var xmlhttp = getXmlHttp();
    xmlhttp.open('post', url, true );
    xmlhttp.onreadystatechange = function () {

        var dataState = xmlhttp.readyState;

        if( dataState == 4 )
        {
            idElement(idName).innerHTML = xmlhttp.responseText;
        }
        else
        {
            idElement(idName).innerHTML = '<br><div style="text-align: center;">Запрос ...</div>';
        }
    };
    xmlhttp.setRequestHeader("Content-Type", "application/x-www-form-urlencoded; charset=utf-8");
    xmlhttp.send(data);
}


/**
 * @ todo - отправка ajax запроса
 * @param url - серверный скрипт
 * @param idName - id элемента для вывода ответа
 */
function ajaxGet(url, idName)
{

    var xmlhttp = getXmlHttp();
    xmlhttp.open("get", url + '?sl&rn=' + Math.random(), true );
    xmlhttp.onreadystatechange = function () {

    var dataState = xmlhttp.readyState;

    if( dataState == 4 )
    {
        idElement(idName).innerHTML = xmlhttp.responseText;
    }
    else
    {
        idElement(idName).innerHTML = '<br><div style="text-align: center;">Запрос ...</div>';
    }
    };
    xmlhttp.setRequestHeader("Content-Type", "application/x-www-form-urlencoded; charset=utf-8");
    xmlhttp.send();
}



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
    $('.autoclear, .inp_f_reg').autoClear();
});

