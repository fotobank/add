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
     //   if($(" #slideThree4 + :checked").val()==$(this).val())
//    if($(" #slideThree4").prop("checked"))
//        {
          $.ajax({
                type: "POST",
                header: ('Content-Type: application/json; charset=utf-8;'),
                url: "./zaprosDirFtp.php",
                // data: "data="+data,
                data: {ftpDir: $('#prependedInput').val()},

              error:function(xhr, status, errorThrown) {
                 	                alert(errorThrown+'\n'+status+'\n'+xhr.statusText);
              },
                // ������� �� ��� ������ PHP
                success: function (data) {

                   // $('#result')
                   //     .ajaxStart(function() { $(this).hide(); })
                    //    .empty().append(data)
                   //     .ajaxStop(function() { $(this).show(); });

                //    $("#result").empty().append(data).fadeIn('slow');
                var selector;
                var option;
                var dataArray = data.split(":");
                var topSelector = "<div class='input-prepend'><br>";
                    topSelector += "<span id='refresh' title='�������� �����' class='add-on' onclick='sendFtp();'>����� uploada FTP:</span>";
                    topSelector += "<select id='prependedInput' class='span2'  NAME='ftp_folder' >";

                    jQuery.each(dataArray, function() {

                        if (this != ">/")
                        {
               option += "<option value = '" + this  + "/' <?='" + this  + "/' == $ln['ftp_folder'] ? 'selected= \"selected\"'" + " : '' ? >/>" + this  + "/</option>";
                        }
                    });

                    var bottomSelector = "</select></div>";
                    selector = topSelector + option + bottomSelector;

                    $(" .result ").empty().append(selector);




                  //  $(" .result ").empty().html("<option value = '" + data + "' <?='" + data + "' == $ln['ftp_folder'] ? 'selected= 'selected'' : '' ?> >" + data + "</option>");

               //    $(select).insertAfter('#result');
                //    alert (select);
                }
            });
       /* }
        else
        {*/
          //  alert (value);
       //     $("#result").empty().append(value);
           // $("#result").empty();
//        }
}


/*
$(function() {

$(' #result li a').click(function(){
    var a = $(this).text();
    $(this).closest(' #result').hide('slow');
    $(" #foto_folder").val(a).show('slow');
    return false
    });
});
*/


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
