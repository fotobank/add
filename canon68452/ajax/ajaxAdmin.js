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
                data: {ftpDir: $('#prependedInput').val()},

              error:function(xhr, status, errorThrown) {
                 	                alert(errorThrown+'\n'+status+'\n'+xhr.statusText);
              },
                // ������� �� ��� ������ PHP
                success: function (data) {

                var selector;
                var option;
                var dataArray = data.split(":");
                var topSelector = "<div class='input-prepend'><br>";
                 //   topSelector += "<span id='refresh' title='�������� �����' class='add-on' onclick='sendFtp();'>����� uploada FTP:</span>";
                    topSelector += "<select id='prependedInput' class='span2'  NAME='ftp_folder' >";


                    jQuery.each(dataArray, function() {

                        if (this != ">/") // ��������� ������� �������
                        {
                 option += "<option value = '" + this  + "/' >" + this  + "/</option>";
                        }
                        return option;
                    });

                    var bottomSelector = "</select></div>";
                    selector = topSelector + option + bottomSelector;

                    $(" .result ").empty().append(selector);

                }
            });

          //  alert (value);
       //     $("#result").empty().append(value);
           // $("#result").empty();
}


function checkFtp  (data){

    $.ajax({
        type: "POST",
        header: ('Content-Type: application/json; charset=utf-8;'),
        url: "./zaprosDirFtp.php",
        data: data,
        error:function(XHR) {
            alert(" ������: "+XHR.status+ "  " + XHR.statusText);
        },
        statusCode: {
            404: function() {
                alert("�������� �� �������");
            }
        },
        // ������� �� ��� ������ PHP
        success: function (html) {
            //�������������� ������� ������ ������� ��������
            $(idName).empty().append(html);
        }
    });

    return idName;
}


function ajaxPostQ(url, idName,  data) {
    $.ajax({
        type: "POST",
        header: ('Content-Type: application/json; charset=utf-8;'),
        url: url,
        data: data,
        error:function(XHR) {
            alert(" ������: "+XHR.status+ "  " + XHR.statusText);
        },
        statusCode: {
           404: function() {
           alert("�������� �� �������");
         }
         },
        // ������� �� ��� ������ PHP
        success: function (html) {
            //�������������� ������� ������ ������� ��������
            $(idName).empty().append(html);
         }
    });
}
