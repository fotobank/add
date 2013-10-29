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
              "pws"          => "Protected_Site_Sec", // ��������� ������
        //    "text_string"  => "����", // ����� �������� �����
              "vz"           => "img/vz.png", // �������� �������� �����
              "vzm"          => "img/vzm.png", // multi �������� �������� �����
              "font"         => "fonts/arialbd.ttf", // ����������� �����
              "text_padding" => 10, // �������� �� ����
              "hotspot"      => 2, // ������������ ������ (1-9)
              "font_size"    => 16, // ������ ������ �������� �����
              "iv_len"       => 16, // ��������� �����
              "rgbtext"      => "FFFFFF", // ���� ������
              "rgbtsdw"      => "000000", // ���� ����
              "process"      => "jump=>security/protected.gif", // "jump=>security/protected.php"
              // ��� �������� "jump=>security/protected.gif" - ��������� ��� ���������� �������
       );
       go::call('md5_loader', $ini);
       $imgData = array(
              "referer" => $_SERVER['HTTP_REFERER'],
              "query"   => $_SERVER['QUERY_STRING']
       );
       go::call('md5_loader')->img($imgData);