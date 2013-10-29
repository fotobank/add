<?php
       /*
       :::::::::::::::::::::::::::::::::::::::::::::::::
       ::                                             ::
       ::             H O W  T O  U S E ?             ::
       ::                                             ::
       ::                                             ::
       ::                                             ::
       ::   require('Loader.class.php');              ::
       ::                                             ::
       ::   $protect = new Loader(                    ::
       ::    	$_SERVER['HTTP_REFERER'],              ::
       ::    	$_SERVER['QUERY_STRING'],              ::
       ::    	String password,                       ::
       ::    	String watermark text,                 ::
       ::    	Watermark switch true->on false->off,  ::
       ::    	String font,                           ::
       ::    	Int fontsize,                          ::
       ::    	Hex fontcolor,                         ::
       ::    	Hex shadowcolor,                       ::
       ::      String Error action:                   ::
       ::      *	'jump=>protected.php'                ::
       ::      	Redirect into specified site         ::
       ::                   or                        ::
       ::	    *	'show=>protected/protected.gif'      ::
       ::      	Display a specified image            ::
       ::     );                                      ::
       ::                                             ::
       :::::::::::::::::::::::::::::::::::::::::::::::::
       */
       require_once(__DIR__.'/inc/config.php');
       $_SESSION['JS'] = $_SERVER['REQUEST_URI'];
       if(!JS)  main_redir('/redirect.php');
       setcookie('js', '', time() - 1, '/');
       $ini = go::has('md5_loader') ? NULL : array(
              "pws"          => "Protected_Site_Sec", // секретная строка
        //    "text_string"  => "ТЕСТ", // текст водяного знака
              "vz"           => "img/vz.png", // картинка водяного знака
              "vzm"          => "img/vzm.png", // multi картинка водяного знака
              "font"         => "fonts/arialbd.ttf", // применяемый шрифт
              "text_padding" => 10, // смещение от края
              "hotspot"      => 2, // расположение текста (1-9)
              "font_size"    => 16, // размер шрифта водяного знака
              "iv_len"       => 16, // сложность шифра
              "rgbtext"      => "FFFFFF", // цвет текста
              "rgbtsdw"      => "000000", // цвет тени
              "process"      => "jump=>security/protected.gif", // "jump=>security/protected.php"
              // или картинка "jump=>security/protected.gif" - выводится при незаконной закачке
       );
       go::call('md5_loader', $ini);
       $imgData = array(
              "referer" => $_SERVER['HTTP_REFERER'],
              "query"   => $_SERVER['QUERY_STRING']
       );
       go::call('md5_loader')->img($imgData);