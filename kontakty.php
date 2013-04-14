<?php
    include './inc/head.php';
?>

<!--[if IE]><script>
    $(document).ready(function() {
            $("#form_wrap").addClass('');
            $("#form_wrap").prepend( '<div id="before"></div>').append( '<div id="after"</div>');
            $("#form_wrap").hover(function(){
             $(this).stop(true, false).animate({
                  height : '900px',
                  top : '-150px'
             }, 2000);
            $('form').stop(true, false).animate({
        height : '680px'
        }, 2000, function(){
                         $('#form_wrap input[type=submit]').css({'z-index' : '1', 'opacity' : '1'})} ) }, function() {
        $('#form_wrap input[type=submit]').stop(true, true).css({ 'opacity' : '0'})
            $(this).stop(true, false).animate({
            height : '546px',
            top : '0px'

        }, 2000);
        $('form').stop(true, false).animate({
                height : '200px'}, 2000)
        })
})
</script><![endif]-->

<style>
        /* CSS Document */
    body, div,form, fieldset, textarea {
        margin: 0; padding: 0; border: 0; outline: none;
    }
    #wrap {width:530px; margin:0 0 0 40px; height:820px;}
    p {text-shadow:0 1px 0 #fff; font-size:18px; color: #000;}
    #form_wrap { overflow:hidden; height:446px; position:relative; top:0px;
        -webkit-transition: all 1s ease-in-out .3s;
        -moz-transition: all 1s ease-in-out .3s;
        -o-transition: all 1s ease-in-out .3s;
        transition: all 1s ease-in-out .3s;}

    #form_wrap:before {content:"";
        position:absolute;
        bottom:128px;left:0;
        background:url('img/before.png');
        width:530px;height: 316px;}

    #form_wrap:after {content:"";position:absolute;
        bottom:0;left:0;
        background:url('img/after.png');
        width:530px;height: 260px; }

    #form_wrap.hide:after, #form_wrap.hide:before {display:none; }
    #form_wrap:hover {height:876px;top:-150px;}


    #form_ob {background:#f7f2ec url('img/letter_bg.png');
        color: #000;
        position:relative;top:150px;overflow:hidden;
        height:200px;width:470px;margin:0px auto;padding:20px;
        border: 1px solid #ccc;
        border-radius: 3px;
        -moz-border-radius: 3px; -webkit-border-radius: 3px;
        box-shadow: 0px 0px 3px #9d9d9d, inset 0px 0px 27px #fff;
        -moz-box-shadow: 0px 0px 3px #9d9d9d, inset 0px 0px 14px #fff;
        -webkit-box-shadow: 0px 0px 3px #9d9d9d, inset 0px 0px 27px #fff;
        -webkit-transition: all 1s ease-in-out .3s;
        -moz-transition: all 1s ease-in-out .3s;
        -o-transition: all 1s ease-in-out .3s;
        transition: all 1s ease-in-out .3s;}


    #form_wrap:hover form {height:530px;}


    textarea:focus, input[type=text]:focus {background:rgba(255,255,255,.35);}

    #form_wrap input[type=submit] {
        position:relative;
        font-size:24px; color: #000;text-shadow:0 1px 0 #fff;
        width:100%; text-align:center;opacity:0;
        background:none;
        cursor: pointer;
        -moz-border-radius: 3px; -webkit-border-radius: 3px; border-radius: 3px;
        -webkit-transition: opacity .6s ease-in-out 0s;
        -moz-transition: opacity .6s ease-in-out 0s;
        -o-transition: opacity .6s ease-in-out 0s;
        transition: opacity .6s ease-in-out 0s;
    }

    #form_wrap:hover input[type=submit] {z-index:1;opacity:1;
        -webkit-transition: opacity .5s ease-in-out 1.3s;
        -moz-transition: opacity .5s ease-in-out 1.3s;
        -o-transition: opacity .5s ease-in-out 1.3s;
        transition: opacity .5s ease-in-out 1.3s;}

    #form_wrap:hover input:hover[type=submit] {color:#000;}

    textarea { height: 150px; padding-top:14px;}

</style>

<div id="main">
<div id="cont_fb">
<?php

	$uname = "";
	$uphone = "";
	$skype = "";
	$utext = "";
	$umail = "";
	$umail = "";
	$e1 = $e2 = $e3 = $e4 = $e5 = "";

	if (isset($_POST["go"]))
	{
		$e1 = null;
		$uname = trim(htmlspecialchars($_POST["uname"]));
		if (strlen($uname) == "0" || (!preg_match("/[?a-zA-Zа-яА-Я0-9_-]{3,16}$/", $uname)))
		{
			$e1 .= "Недопустимые символы!<br>";
		}
		$e2 = null;
		$utext = trim(htmlspecialchars($_POST["utext"]));
		if (strlen($utext) == "0")
		{
			$e2 .= "Заполните поле 'Текст Сообщения'<br>";
		}
		$e3 = null;
		$umail = trim(htmlspecialchars($_POST["umail"]));
		if ((strlen($umail) == "0") || (!preg_match("/[0-9a-z_]+@[0-9a-z_^\.-]+\.[a-z]{2,3}/i",
			$umail)))
		{
			$e3 .= "Неверный E-Mail<br>";
		}
		$e4 = null;
		$uphone = trim(htmlspecialchars($_POST["uphone"]));
		if ((strlen($uphone) < 5) || (preg_match("/[%a-z_@.,^=:;а-я\"*()&$#№!?<>\~`|[{}\]]/i",
			$uphone)))
		{
			$e4 .= "Неверный телефон!<br>";
		}
		$skype = trim(htmlspecialchars($_POST["skype"]));
		$e5 = null;
		$umath = trim(htmlspecialchars($_POST["umath"]));
		if ($umath != "48")
		{
			$e5 .= "Введено неверное контрольное число<br>";
		}
		$eAll = $e1 . $e2 . $e3 . $e4 . $e5;
	}
	if (isset($_POST["go"]) && $eAll == null)
	{
		$dt = date("d F Y, H:i:s");
		// дата и время
		$mail = "aleksjurii@gmail.com";
		// e-mail куда уйдет письмо
		$title = "Сообщение с формы обратной связи aleks.od.ua";
		// заголовок(тема) письма
		$subject = '=?koi8-r?B?' . base64_encode(convert_cyr_string($title, "w", "k")) .
			'?=';
		$utext = str_replace("\r\n", "<br>", $utext);
		// обрабатываем
		$mess = "<u><b>Сообщение с формы обратной связи :</b></u><br>";
		$mess .= "<b>Имя: </b> $uname<br>";
		$mess .= "<b>E-Mail:  </b> <a href='mailto:$umail'>$umail</a><br>";
		$mess .= "<b>Skype:  </b>$skype<br>";
		$mess .= "<b>Телефон:  </b>$uphone<br>";
		$mess .= "<b>Дата и Время:  </b>$dt<br><br>";
		$mess .= "<u><b>Текст сообщения:  </b></u><br><br>";
		$mess .= "$utext<br>";
		$headers = "MIME-Version: 1.0\r\n";
		$headers .= "Content-type: text/html; charset=windows-1251\r\n";
		//кодировка
		$headers .= "From: jurii@aleks.od.ua \r\n";
		// откуда письмо (необязательнакя строка)
		mail($mail, $subject, $mess, $headers);
		// отправляем
		// выводим уведомление об успехе операции и перезагружаем страничку

?>
<div class="ok_msg">
  Спасибо. Ваше сообщение отправленно.
	<button class="close" data-dismiss="alert">x</button>
  </div>
			<?
print "<script language='Javascript' type='text/javascript'>
  <!--
  function reload()
  {location = \"kontakty.php\"};
  setTimeout('reload()', 4000);
  -->
  </script>";
	}
?>

<table style="float:left">
    <tr>
        <td>
            <div id="wrap">
                <div id='form_wrap'>
                    <table width="100%">
                        <tr>
                            <td width="750" >
                                <form id="form_ob" action="kontakty.php" method="post" name="send_form">
                                    <h3 style="color:#000;">Пишите нам:</h3>
                                    <table style="font-weight:bold">
                                        <tr>
                                            <td class="td_formL" style="width: 100px;">Ваше имя*:</td>
                                            <td class="td_formR"><input rel="tooltip" data-placement="top" data-original-title="Имя или ник на сайте.
                                              Длина от 3 до 16 символов."
		                                            class="inp_f_kont" type="text" name="uname" style="margin-bottom: 5px; margin-left: 0px; width: 200px;" maxlength="20" value="<?=$uname;?>"/></td>
                                            <td><span class="label label-important" style="margin-left: 10px;"><?=$e1;?></span></td>
                                        </tr>
                                        <tr>
                                            <td class="td_formL" style="width: 100px;">Телефон*:</td>
                                            <td class="td_formR"><input rel="tooltip" data-placement="right" data-original-title="Не меньше 6 цифр."
		                                            class="inp_f_kont" type="text" name="uphone" style="margin-bottom: 4px; margin-left: 0px; width: 200px;" maxlength="20" value="<?=$uphone;?>"/></td>
                                            <td><span class="label label-important" style=" margin-left: 10px;"><?=$e4;?></span></td>
                                        </tr>
                                        <tr>
                                            <td class="td_formL" style="width: 100px;">Skype:</td>
                                            <td class="td_formR"><input rel="tooltip" data-placement="right" data-original-title="Для быстрой связи."
		                                            class="inp_f_kont" type="text" name="skype" style="margin-bottom: 5px; margin-left: 0px; width: 200px;" maxlength="20" value="<?=$skype;?>"/></td>
                                        </tr>
                                        <tr>
                                            <td class="td_formL" style="width: 100px;">Ваш E-mail*:</td>
                                            <td class="td_formR"><input rel="tooltip" data-placement="bottom" data-original-title="Указывайте реально существующий почтовый ящик.
                                             На него Вам прийдет ответ." class="inp_f_kont" type="text" name="umail"
		                                            style="margin-bottom: 15px; margin-left: 0px; width: 200px;" maxlength="50" value="<?=$umail;?>"/></td>
                                            <td style="padding-bottom: 17px;"><span class="label label-important" style="margin-top: 7px; margin-left: 10px;"><?=$e3;?></span></td>
                                        </tr>
                                    </table>

                                    <table class="tb_m_form">
                                        <tr>
                                            <td class="td_formL2">Текст сообщения:</td>
                                            <td class="td_formR2"><textarea  style="margin-top: -5px; margin-bottom: 10px; width: 350px; " rel="tooltip"
		                                            data-placement="top" data-original-title="Краткость - сестра таланта! :)"
		                                            name="utext"><?=$utext;?></textarea></td>
                                            <span class="label label-important" style="margin-top: -13px; margin-left: 180px; position:absolute"><?=$e2;?></span>
                                        </tr>
                                        <tr>
                                            <td class="td_formL" style="width: 100px;"><div  style="position:relative; margin-top: -10px;">Введите результат 24*2=?:</div></td>
                                            <td class="td_formR2">

                                                <input rel="tooltip" data-placement="right" data-original-title="Защита от спама."
	                                                class="inp_f_kont" type="text" name="umath" value="" style="margin-left: -8px; width: 100px;" />
                                                <span class="label label-important" style="margin-top: 20px; margin-left: 20px;"><?=$e5;?></span>
                                                <input type="hidden" name="go" value="5"/><br>
                                                <input class="inp_f_kont" type="submit" name="submit" value="Готово. Отправить!"
	                                                data-original-title="" style="margin-top: 3px; margin-left: -8px; width: 300px;">
                                            </td>
                                        </tr>
                                    </table>
                                </form>
                            </td>
                        </tr>
                    </table>
                </div>
            </div>

        </td>
    </tr>
</table>
<div class="ttext_orange">
    <?
    echo mysql_result(mysql_query('select txt from content where id = 4'), 0);
    ?>
</div>
</div>
</div>
    <div class="end_content"></div>
    </div>
<?php
    include ('/inc/footer.php');
?>