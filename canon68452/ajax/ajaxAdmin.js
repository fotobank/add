/**
 * Created with JetBrains PhpStorm.
 * User: Jurii
 * Date: 14.04.13
 * Time: 14:59
 * To change this template use File | Settings | File Templates.
 */

//var value = $(" #result ").html();
     //   alert (value);


/**
 * ������ multiselect
 */

function multSel() {
    $('.multiselect').multiselect({
        buttonClass: 'btn',
        buttonWidth: 'auto',
        includeSelectAllOption: true,
        buttonContainer: '<div class="btn-group" />',
        maxHeight: false,
        buttonText: function (options) {
            if (options.length == 0) {
                return 'None selected <b class="caret"></b>';
            }
            else if (options.length > 3) {
                return options.length + ' selected  <b class="caret"></b>';
            }
            else {
                var selected = '';
                options.each(function () {
                    selected += $(this).text() + ', ';
                });
                return selected.substr(0, selected.length - 2) + ' <b class="caret"></b>';
            }
        }
    });
}

function multSelFtp() {
    $('#upFTP').multiselect({
        buttonClass: 'btn',
        buttonWidth: 'auto',
        includeSelectAllOption: true,
        buttonContainer: '<div class="btn-group" />',
        maxHeight: false,
        buttonText: function (options) {
            if (options.length == 0) {
                return 'None selected <b class="caret"></b>';
            }
            else if (options.length > 3) {
                return options.length + ' selected  <b class="caret"></b>';
            }
            else {
                var selected = '';
                options.each(function () {
                    selected += $(this).text() + ', ';
                });
                return selected.substr(0, selected.length - 2) + ' <b class="caret"></b>';
            }
        }
    });
}

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
                    multSelFtp();
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