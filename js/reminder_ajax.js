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