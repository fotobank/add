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
       //          	                alert(errorThrown+'\n'+status+'\n'+xhr.statusText);
              },
                success: function (data) {
                var selector;
                var option;
                var dataArray = data.split(":");
                var ftpFold = $(' #ftpFold ').val();

                    jQuery.each(dataArray, function() {
                        if (this != ">/") // ��������� ������� �������
                        {
                 option += "<option value = '" + this  + "/' >" + this  + "/</option>";
                        }
                        return option;
                    });
                    selector = "<option value = '" + ftpFold  + "' >" + ftpFold  + "</option>" + option;
                    $(" #upFTP ").empty().append(selector);
               //     $(this).outDebug(dataArray,'/canon68452/ajax/ajaxAdmin.js','uploadFTP');
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
     //       alert(" ������: "+XHR.status+ "  " + XHR.statusText);
        },
        statusCode: {
           404: function() {
     //      alert("�������� �� �������");
         }
         },
        // ������� �� ��� ������ PHP
        success: function (html) {
//           alert(html);
  //          $(this).outDebug(html,'/canon68452/ajax/ajaxAdmin.js','ajaxPostQ');
            $(idName).empty().append(html);
         }
    });
}


function ajaxPostNews (url, idName,  data) {
    $.ajax({
        type: "POST",
        header: ('Content-Type: application/json; charset=utf-8;'),
        url: url,
        data: data,
        error:function(XHR) {
          //         alert(" ������: "+XHR.status+ "  " + XHR.statusText);
        },
        statusCode: {
            404: function() {
          //            alert("�������� �� �������");
            }
        },
        // ������� �� ��� ������ PHP
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