<?
    include __DIR__.'./config.php';
    include __DIR__.'./func.php';
    header('Content-type: text/html; charset=windows-1251');


?>

    <!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//RU" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=windows-1251"/>
        <meta name="google-site-verification" content="uLdE_lzhCOntN_AaTM1_sQNmIXFk1-Dsi5AWS0bKIgs"/>
        <link href='http://fonts.googleapis.com/css?family=Lobster|Comfortaa:700|Jura:600&subset=cyrillic,cyrillic-ext' rel='stylesheet' type='text/css'>
        <?
        include __DIR__.'./title.php';
        ?>

        <!--[if lt IE 9]>
        <script>
            document.createElement('header');
            document.createElement('nav');
            document.createElement('section');
            document.createElement('article');
            document.createElement('aside');
            document.createElement('footer');
            document.createElement('figure');
            document.createElement('figcaption');
            document.createElement('span');
        </script>
        <![endif]-->




        <link rel="shortcut icon" type="image/vnd.microsoft.icon" href="favicon.ico"/>
        <link rel="shortcut icon" href="/img/ico_nmain.gif"/>
        <link href="/css/main.css" rel="stylesheet" type="text/css"/>
        <link href="/css/dynamic-to-top.css" rel="stylesheet" type="text/css"/> <!-- кнопка вверх -->
        <link href="/css/bootstrap.css" rel="stylesheet"/>
        <link rel="stylesheet" href="/css/lightbox.css" type="text/css" media="screen"/>


        <script src="/js/jquery.js"></script>

        <script src="/js/bootstrap.min.js"></script>
        <script src="/js/main.js"></script>


        <link href="/css/animate.css" rel="stylesheet" type="text/css"/>
        <link href="/css/bootstrap-modal.css" rel="stylesheet" type="text/css"/>
        <script src="/js/bootstrap-modalmanager.js"></script>
        <script src="/js/bootstrap-modal.js"></script>


        <script type="text/javascript">$.ie6no({runonload:true});</script>

        <? if (strstr($_SERVER['PHP_SELF'], 'folder_for_prototype')): ?>
            <script type="text/javascript" src="/js/prototype.js"></script>
            <script type="text/javascript" src="/js/scriptaculous.js?load=effects"></script>
            <script type="text/javascript" src="/js/lightbox.js"></script>
        <? endif; ?>


        <script language=JavaScript type="text/javascript">
            function clickIE4() {
                if (event.button == 2) {
                    return false;
                }
            }
            function clickNS4(e) {
                if (document.layers || document.getElementById && !document.all) {
                    if (e.which == 2 || e.which == 3) {
                        return false;
                    }
                }
            }
            if (document.layers) {
                document.captureEvents(Event.MOUSEDOWN);
                document.onmousedown = clickNS4;
            }
            else if (document.all && !document.getElementById) {
                document.onmousedown = clickIE4;
            }
            document.oncontextmenu = new Function("return false");
        </script>


        <script language=JavaScript type="text/javascript">

            function smile(str) {
                obj = document.Sad_Raven_Guestbook.mess;
                obj.focus();
                obj.value = obj.value + str;
            }
            function openBrWindow(theURL, winName, features) {
                window.open(theURL, winName, features);
            }
            function inserttags(st_t, en_t) {
                obj = document.Sad_Raven_Guestbook.mess;
                obj2 = document.Sad_Raven_Guestbook;
                if ((document.selection)) {
                    obj.focus();
                    obj2.document.selection.createRange().text = st_t + obj2.document.selection.createRange().text + en_t;
                }
                else {
                    obj.focus();
                    obj.value += st_t + en_t;
                }
            }
        </script>


        <script type="text/javascript">
            $(document).ready(function () {
                $(".vhod").tooltip();
            });
        </script>

        <script type="text/javascript">
            $(document).ready(function () {
                $("input, textarea").tooltip();
            });
        </script>

        <script type="text/javascript">
            $(document).ready(function () {
                $("a[rel=popover]")
                  .popover({
                      offset: 10
                  })
                  .click(function (e) {
                      e.preventDefault()
                  })
            });
        </script>

        <script type="text/javascript">
            $(document).ready(function () {
                $(".registracia").tooltip({offset: 10});
            });
            $('body').modalmanager('loading');
        </script>


</head>
<body>
<div id="maket">
    <div id="photo_preview_bg" class="hidden" onClick="JavaScript: hide_preview();"></div>
    <div id="photo_preview" class="hidden"></div>


    <!--Голова начало-->
    <div id="head">
    <table class="tb_head">
        <tr>
            <td>
                <?
                if (isset($_SESSION['us_name']) && $_SESSION['us_name'] == 'test')
                    {
                        $time = microtime();
                        $time = explode(' ', $time);
                        $time = $time[1] + $time[0];
                        $start = $time;
                        ?>
                        <div class="ttext_orange" style="position:absolute">
                            <?
                            echo "Память в начале: ".memory_get_usage()." байт \n";
                            ?>
                        </div>
                    <?
                    }
                ?>


                <div class="td_head_logo">

                    <div id="flash-container">
                        <object classid="clsid:D27CDB6E-AE6D-11cf-96B8-444553540000" width="910" height="208" id="flash-object">
                            <param name="movie" value="img/container.swf">
                            <param name="quality" value="high">
                            <param name="scale" value="default">
                            <param name="wmode" value="transparent">
                            <param name="flashvars" value="color1=0xFFFFFF&amp;alpha1=.50&amp;framerate1=24&amp;loop=true&amp;wmode=transparent&amp;clip=img/flash.swf&amp;radius=4&amp;clipx=-50&amp;clipy=0&amp;initalclipw=900&amp;initalcliph=200&amp;clipw=1000&amp;cliph=200&amp;width=900&amp;height=200&amp;textblock_width=0&amp;textblock_align=no&amp;hasTopCorners=true&amp;hasBottomCorners=true">
                            <param name="swfliveconnect" value="true">

                            <!--[if !IE]>-->
                          <object type="application/x-shockwave-flash" data="img/container.swf" width="910" height="208">
                                <param name="quality" value="high">
                                <param name="scale" value="default">
                                <param name="wmode" value="transparent">
                                <param name="flashvars" value="color1=0xFFFFFF&amp;alpha1=.50&amp;framerate1=24&amp;loop=true&amp;wmode=transparent&amp;clip=img/flash.swf&amp;radius=4&amp;clipx=-50&amp;clipy=0&amp;initalclipw=900&amp;initalcliph=200&amp;clipw=1000&amp;cliph=200&amp;width=900&amp;height=200&amp;textblock_width=0&amp;textblock_align=no&amp;hasTopCorners=true&amp;hasBottomCorners=true">
                                <param name="swfliveconnect" value="true">

                                <!--<![endif]-->

                            <div class="flash-alt">
                                    <a href="http://www.adobe.com/go/getflashplayer"><img src="http://www.adobe.com/images/shared/download_buttons/get_flash_player.gif" alt="Get Adobe Flash player"></a>
                                </div>

                                <!--[if !IE]>-->
                            </object>
                            <!--<![endif]-->
                      </object>
                    </div>

                    <a class="logo" href="/index.php"></a>

                    <div id="zagol">
                        <h1><span></span>Профессиональная<br> фото и видеосъёмка <br> в Одессе </h1>
                    </div>

             </div>

            </td>
            <td class="td_form_ent">

                <div id="form_ent">

                    <? if (isset($_SESSION['logged'])): ?>
                        <center>
  <span style="color:#bb5">Здравствуйте,<br> <b><?=$_SESSION['us_name']?></b><br/>
      <?
      $user_balans = floatval(mysql_result(mysql_query('select balans from users where id = '.intval($_SESSION['userid'])), 0));
      ?>
      Ваш баланс: <b><?=$user_balans?></b> гр.<br/></span></center>

                        <div style="margin-top: 8px;">
                            <a class="korzina" href="/basket.php">корзина</a>
                            <a class="vihod" href="/enter.php?logout=1">выход</a>
                        </div>
                        <div style="margin-top: 8px;">
                            <a class="scet" href="#scet_form">пополнение счета</a>
                        </div>

                    <? else: ?>
                        <u>Форма входа:</u><br>
                        <form action="/enter.php" method="post">
                            <table>
                                <tr>
                                    <td> Логин:</td>
                                    <td><input class="inp_fent" name="login"></td>
                                </tr>
                                <tr>
                                    <td> Пароль:</td>
                                    <td><input class="inp_fent" type="password" name="password"></td>
                                </tr>
                                <tr></tr>
                                <tr>
                                    <td>
                                        <input data-placement="left" rel="tooltip" class="vhod" name="submit" type="submit" value="вход" title="Добро пожаловать!" data-original-title="Tooltip on left">
                                    </td>

                                    <td>
                                        <a href="/registr.php" class="registracia" data-placement="right" data-original-title="Вы еще не зарегистрировались? Присоединяйтесь">регистрация</a>
                                    </td>
                                </tr>
                            </table>
                            <a href="/reminder.php" style="color: #fff; text-decoration: none;">Забыли пароль?</a>
                        </form>
                    <? endif; ?>

                </div>
            </td>

        <tr>
            <td></td>
            <td>
    </table>
    <a href="#x" class="overlay" id="scet_form"></a>

    <div id="popup">
        Пополнение счета <a class="close2" href="#close"></a>
    </div>


    <!-- СООБЩЕНИЕ ОБ ОШИБКЕ-->
    <?
    if (isset($_SESSION['err_msg']))
        {
            ?>
            <div id="error" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                <div class="err_msg">
                    <div class="modal-header">
                        <button class="close" data-dismiss="modal">x</button>
                        <h3 style="color:red">Ошибка!</h3>
                    </div>
                    <div class="modal-body">
                        <div style="float:left">
                            <span class="ttext_red"><?=$_SESSION['err_msg']?></span>
                        </div>
                        <a style="float:right" class="btn" data-dismiss="modal" href="#">Закрыть</a>
                    </div>
                </div>
            </div>
            <?
            echo "<script type='text/javascript'>
         $(document).ready(function(){
         $('#error').modal('show');
         });
		 function gloze() {
		 $('#error').modal('hide');
		 };
	     setTimeout('gloze()', 4000);
         </script>";
            unset($_SESSION['err_msg']);
        }
    ?>

    <!-- СООБЩЕНИЕ О УПЕШНОМ ЗАВЕРШЕНИИ-->
    <?
    if (isset($_SESSION['ok_msg']))
        {
            ?>

            <div id="ok" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                <div class="ok_msg">
                    <div class="modal-header">
                        <button class="close" data-dismiss="modal">x</button>
                        <h3>Добро пожаловать!</h3>
                    </div>
                    <div class="modal-body">
                        <div style="float:left">
                            <span><?=$_SESSION['ok_msg']?></span>
                        </div>
                        <a style="float:right" class="btn" data-dismiss="modal" href="#">Закрыть</a>
                    </div>
                </div>
            </div>
            <?
            echo "<script type='text/javascript'>
         $(document).ready(function(){
         $('#ok').modal('show');
         });
		 function gloze() {
		 $('#ok').modal('hide');
		 };
	     setTimeout('gloze()', 4000);
         </script>";
            unset($_SESSION['ok_msg']);
        }
    ?>


    <div id="fixed_menu">
    <div id="main_menu"  data-spy="affix" data-offset-top="210">

        <?PHP
        $value = $_SERVER['PHP_SELF'];
        if ($_SERVER['PHP_SELF'] == '/fotobanck.php')
            {
                $value = '/fotobanck.php?unchenge_cat';
            }

        if ($value == '/index.php')
            {
                $act_ln = 'gl_act';
                $key = 'Главная';
                echo "
	<a href='$value' class='$act_ln'>$key</a>
	<a class='bt_fb' href='/fotobanck.php?unchenge_cat'>Фото-банк</a>
	<a class='bt_usl' href='/uslugi.php'>Услуги</a>
	<a class='bt_ceny' href='/ceny.php'>Цены</a>
	<a class='bt_konty' href='/kontakty.php'>Контакты</a>
	<a class='bt_gb' href='/gb/'>Гостевая</a>";
            }
        elseif ($value == '/fotobanck.php?unchenge_cat')
            {
                $act_ln = 'fb_act';
                $key = 'Фото-банк';
                echo "
	<a class='bt_gl' href='/index.php'>Главная</a>
	<a href='$value' class='$act_ln'>$key</a>
	<a class='bt_usl' href='/uslugi.php'>Услуги</a>
	<a class='bt_ceny' href='/ceny.php'>Цены</a>
	<a class='bt_konty' href='/kontakty.php'>Контакты</a>
	<a class='bt_gb' href='/gb/'>Гостевая</a>";
            }
        elseif ($value == '/uslugi.php')
            {
                $act_ln = 'usl_act';
                $key = 'Услуги';
                echo "
	<a class='bt_gl' href='/index.php'>Главная</a>
	<a class='bt_fb' href='/fotobanck.php?unchenge_cat'>Фото-банк</a>
	<a href='$value' class='$act_ln'>$key</a>
	<a class='bt_ceny' href='/ceny.php'>Цены</a>
	<a class='bt_konty' href='/kontakty.php'>Контакты</a>
	<a class='bt_gb' href='/gb/'>Гостевая</a>";
            }
        elseif ($value == '/ceny.php')
            {
                $act_ln = 'cn_act';
                $key = 'Цены';
                echo "
	<a class='bt_gl' href='/index.php'>Главная</a>
	<a class='bt_fb' href='/fotobanck.php?unchenge_cat'>Фото-банк</a>
	<a class='bt_usl' href='/uslugi.php'>Услуги</a>
	<a href='$value' class='$act_ln'>$key</a>
	<a class='bt_konty' href='/kontakty.php'>Контакты</a>
	<a class='bt_gb' href='/gb/'>Гостевая</a>";
            }
        elseif ($value == '/kontakty.php')
            {
                $act_ln = 'konty_act';
                $key = 'Контакты';
                echo "
	<a class='bt_gl' href='/index.php'>Главная</a>
	<a class='bt_fb' href='/fotobanck.php?unchenge_cat'>Фото-банк</a>
	<a class='bt_usl' href='/uslugi.php'>Услуги</a>
	<a class='bt_ceny' href='/ceny.php'>Цены</a>
	<a href='$value' class='$act_ln'>$key</a>
	<a class='bt_gb' href='/gb/'>Гостевая</a>";
            }
        elseif ($value == '/gb/index.php')
            {
                $act_ln = 'gb_act';
                $key = 'Гостевая';
                echo "
	<a class='bt_gl' href='/index.php'>Главная</a>
	<a class='bt_fb' href='/fotobanck.php?unchenge_cat'>Фото-банк</a>
	<a class='bt_usl' href='/uslugi.php'>Услуги</a>
	<a class='bt_ceny' href='/ceny.php'>Цены</a>
	<a class='bt_konty' href='/kontakty.php'>Контакты</a>
	<a href='$value' class='$act_ln'>$key</a>";
            }
        elseif ($value == '/registr.php' or'/activation.php')
            {
                $act_ln = 'gb_act';
                $key = 'Гостевая';
                echo "
	<a class='bt_gl' href='/index.php'>Главная</a>
	<a class='bt_fb' href='/fotobanck.php?unchenge_cat'>Фото-банк</a>
	<a class='bt_usl' href='/uslugi.php'>Услуги</a>
	<a class='bt_ceny' href='/ceny.php'>Цены</a>
	<a class='bt_konty' href='/kontakty.php'>Контакты</a>
	<a class='bt_gb' href='/gb/'>Гостевая</a>";
            }
        ?>

        <object width="90" height="90" style="position: absolute; margin-left: 135px; margin-top: 26px; width: 70px; height: 80px;" type="application/x-shockwave-flash" data="img/calendarb.swf">
            <param name="movie" value="img/calendar2b.swf"/>
            <param name="wmode" value="transparent"/>
        </object>


    </div>
    </div>
    </div>

    <!--Голова конец-->

<?
    if ($value == '/gb/index.php'): ?>
        <div id="main">
    <table width=<?= $TABWIDTH ?> border=2 cellspacing=0 cellpadding=2>
        <tr>
            <td>
                <table width=100% border=2 cellspacing=1 cellpadding=3 bgcolor=<?=$BORDER?>>
                    <tr>
                        <td align=center class=pdarkhead bgcolor=<?=$DARK?>><b><?=$gname?></b></td>
                    </tr>
                </table>
            </td>
        </tr>
        <tr>
            <td>
    <? endif; ?>