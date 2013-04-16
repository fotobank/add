/**
 * Created with JetBrains PhpStorm.
 * User: Jurii
 * Date: 14.04.13
 * Time: 14:59
 * To change this template use File | Settings | File Templates.
 */



var value = $(" #result ").html();
     //   alert (value);


function sendFtp() {

     //   if($(" #slideThree4 + :checked").val()==$(this).val())
    if($(" #slideThree4").prop("checked"))
        {


            $.ajax({
                type: "POST",
                url: "./zaprosDirFtp.php",
                // data: "data="+data,
                data: {ftpDir: $('#slideThree4').val()},

                // ¬ыводим то что вернул PHP
                success: function (data) {

                   // $('#result')
                   //     .ajaxStart(function() { $(this).hide(); })
                    //    .empty().append(data)
                   //     .ajaxStop(function() { $(this).show(); });

                    //предварительно очищаем нужный элемент страницы
                    $("#result").empty().append(data).fadeIn('slow');
                }
            });

        }
        else
        {
          //  alert (value);
            $("#result").empty().append(value);
           // $("#result").empty();
        }

}