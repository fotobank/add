/**
 * Created with JetBrains PhpStorm.
 * User: Jurii
 * Date: 12.04.13
 * Time: 12:59
 * To change this template use File | Settings | File Templates.
 */

/**
 * ����������� ������
 */


function send()
{
//�������� ���������
    var data = $('#login').val() + '][' + $('#email').val();
    $("#login").empty();
    $("#email").empty();
    // �������� �������
    $.ajax({
        type: "POST",
        url: "/inc/SendData.php",
        data: "data="+data,

        // ������� �� ��� ������ PHP
        success: function(html) {
            //�������������� ������� ������ ������� ��������
            $("#result").empty().append(html);

         //   dhtmlx.message({ type:'warning', text: data});
        }
    });

}


(function($) {
    $.fn.autoClear = function () {
        // ��������� �� ���������� ���������� ������� ��������
        $(this).each(function() {
            $(this).data("autoclear", $(this).attr("value"));
        });
        $(this)
            .bind('focus', function() {   // ��������� ������
                if ($(this).attr("value") == $(this).data("autoclear")) {
                    $(this).attr("value", "").addClass('autoclear-normalcolor');
                }
            })
            .bind('blur', function() {    // ��������� ������ ������
                if ($(this).attr("value") == "") {
                    $(this).attr("value", $(this).data("autoclear")).removeClass('autoclear-normalcolor');
                }
            });
        return $(this);
    }
})(jQuery);


$(function(){
    // ����������� ������ �� ���� ��������� � ������� "autoclear"
    $('.autoclear').autoClear();
});
