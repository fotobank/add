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

function send() {
    $.ajax({
        type: "POST",
        url: "/inc/SendData.php",
        // data: "data="+data,
        data: $('#reminder').serialize(),

        // ������� �� ��� ������ PHP
        success: function (html) {
            //�������������� ������� ������ ������� ��������
            $("#result").empty().append(html);
            getCaptca();

        }
    });
}




function getCaptca() {

 //  $(" .loadCaptca").load("/inc/captcha/captcha.html");

    $.ajax({
        type: "GET",
        url: "/inc/captcha/captcha.html ",


        cache: false,
        success: function(data){
            $(" .loadCaptca ").empty().append(data);


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
                if ($(this).attr("value") == "") {
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



