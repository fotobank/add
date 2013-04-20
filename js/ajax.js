/**
 * Created with JetBrains PhpStorm.
 * User: Jurii
 * Date: 12.04.13
 * Time: 12:59
 * To change this template use File | Settings | File Templates.
 */


/*
 Todo    - ajax - ����������� ������
 @author - Jurii
 @date   - 13.04.13
 @time   - 8:54
 */

function ajaxP() {
    $.ajax({
        type: "POST",
        header: ('Content-Type: application/json; charset=utf-8;'),
        url: "/inc/SendData.php",
        // data: "data="+data,
        data: $(' #reminder').serialize(),

        error:function(xhr, status, errorThrown) {
            alert(errorThrown+'\n'+status+'\n'+xhr.statusText);
        },

        // ������� �� ��� ������ PHP
        success: function (html) {
            //�������������� ������� ������ ������� ��������
            $(" #result").empty().append(html);
            getCaptca();

        }
    });
}




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
 * ����������� ���� ��������
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
 * @ todo - �������� ajax �������
 * @param url - ��������� ������
 * @param idName - id �������� ��� ������ ������
 * @param data - ���������� ������ ��� ���� ������ (��� <form> -" $('#div').serialize());" ��� "data[a,b,c]")
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
            idElement(idName).innerHTML = '<br><div style="text-align: center;">������ ...</div>';
        }
    };
    xmlhttp.setRequestHeader("Content-Type", "application/x-www-form-urlencoded; charset=utf-8");
    xmlhttp.send(data);
}


/**
 * @ todo - �������� ajax �������
 * @param url - ��������� ������
 * @param idName - id �������� ��� ������ ������
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
        idElement(idName).innerHTML = '<br><div style="text-align: center;">������ ...</div>';
    }
    };
    xmlhttp.setRequestHeader("Content-Type", "application/x-www-form-urlencoded; charset=utf-8");
    xmlhttp.send();
}




/*
 Todo    - ����������� ���������� ���� ��� ��������� ������
 @author - Jurii
 @date   - 13.04.13
 @time   - 8:56
 */
(function ($) {
    $.fn.autoClear = function () {
        // ��������� �� ���������� ���������� ������� ��������
        $(this).each(function () {
            $(this).data("autoclear", $(this).attr("value"));
        });
        $(this).bind('focus', function () {   // ��������� ������
            if ($(this).attr("value") == $(this).data("autoclear")) {
                $(this).attr("value", "").addClass('autoclear-normalcolor');
            }
        })
            .bind('blur', function () {    // ��������� ������ ������
                if ($(this).attr("value") == " ") {
                    $(this).attr("value", $(this).data("autoclear")).removeClass('autoclear-normalcolor');
                }
            });
        return $(this);
    }
})(jQuery);

$(function () {
    // ����������� ������ �� ���� ��������� � id "#email, #login"
    $(' .autoclear ').autoClear();
});
