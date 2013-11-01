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
       require_once(__DIR__.'/inc/func.php');

       $ini = go::has('md5_loader') ? NULL : array(
              "pws"          => "Protected_Site_Sec", // ñåêğåòíàÿ ñòğîêà
        //    "text_string"  => "ÒÅÑÒ", // òåêñò âîäÿíîãî çíàêà
              "vz"           => "img/vz.png", // êàğòèíêà âîäÿíîãî çíàêà
              "vzm"          => "img/vzm.png", // multi êàğòèíêà âîäÿíîãî çíàêà
              "font"         => "fonts/arialbd.ttf", // ïğèìåíÿåìûé øğèôò
              "text_padding" => 10, // ñìåùåíèå îò êğàÿ
              "hotspot"      => 2, // ğàñïîëîæåíèå òåêñòà â óãëàõ êâàäğàòà (1-9)
              "font_size"    => 16, // ğàçìåğ øğèôòà âîäÿíîãî çíàêà
              "iv_len"       => 24, // ñëîæíîñòü øèôğà
              "rgbtext"      => "FFFFFF", // öâåò òåêñòà
              "rgbtsdw"      => "000000", // öâåò òåíè
              "process"      => "show=>security/protected.gif", // "jump=>security/protected.php"
              // èëè êàğòèíêà "jump=>security/protected.gif" - âûâîäèòñÿ ïğè íåçàêîííîé çàêà÷êå
       );
       go::call('md5_loader', $ini);
       $imgData = array(
              "referer" => $_SERVER['HTTP_REFERER'],
              "query"   => $_SERVER['QUERY_STRING']
       );

       if($session->get('JS') == true) {
        go::call('md5_loader')->img($imgData);
       } else {
        go::call('md5_loader')->bad();
       }