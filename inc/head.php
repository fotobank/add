<?php

       use Site\View\Twig\LoadTwig;

       /** -----------------------------------------------------------------------------------*/
       header('Content-type: text/html; charset=windows-1251');
       header('X-Frame-Options: SAMEORIGIN');
       //�� ����������
       header('Expires: Mon, 26 Jul 1997 05:00:00 GMT'); // Date in the past
       header('Last-Modified: ' . gmdate('D, d M Y H:i:s') . ' GMT'); // always modified
       header('Cache-Control: no-cache, no-store, must-revalidate'); // HTTP/1.1
       header('Pragma: no-cache'); // HTTP/1.0'
       header('Expires: 0'); // Proxies.
       /** -----------------------------------------------------------------------------------*/
       require_once __DIR__.'/../alex/fotobank/Framework/Boot/config.php';
       $loadTwig = new LoadTwig();
       /** -----------------------------------------------------------------------------------*/
       // seo
       require_once __DIR__.'/title.php';
       /** -----------------------------------------------------------------------------------*/
       // ��������� ������
       require_once __DIR__.'/errorDump.php';
       /** -----------------------------------------------------------------------------------*/
       $session = check_Session::getInstance();
       /** -----------------------------------------------------------------------------------*/
       // ������ ������ ������ � DUMP_R ( true - ���������� )
       $session->set('DUMP_R', true);
       // ������ ������ ������ � Debug_HackerConsole_Main ( true - ���������� false - ��� )
       $session->set('Debug_HC', true);
       /** -----------------------------------------------------------------------------------*/
       // �����
       $cryptinstall = '/classes/dsp/cryptographp.fct.php';
       require_once __DIR__.'/../classes/dsp/cryptographp.fct.php';
       /** -----------------------------------------------------------------------------------*/
       $include_CSS = array(
              // ������ �����
              'css/dynamic-to-top.css',
              'css/bootstrap.css',
              'css/lightbox.css',
              'css/animate.css',
              'css/bootstrap-modal.css',
              // ���������
              'js/jsmessage/codebase/themes/message_default.css',
              // ���������
              'js/humane/themes/jackedup.css',
//              		  'js/humane/themes/libnotify.css',
//              		  'js/humane/themes/bigbox.css',
//              		  'css/main.css',
              'js/visLightBox/data/vlboxCustom.css',
              'js/visLightBox/data/visuallightbox.css',
              'js/prettyPhoto/css/prettyPhoto.css',
              'js/badger/badger.css'
       );
       $include_Js    = array(
              'js/jquery-1.10.2.min.js',
              'js/jquery.lazyload.js',
              'js/bootstrap.min.js',
              'js/bootstrap-modalmanager.js',
              'js/bootstrap-modal.js',
              //	  <!--���������-->
              'js/jsmessage/codebase/message.js',
              'js/humane/humane.js',
              'js/main.js',
              'js/ajax.js',
              'js/no-copy.js',
              'js/badger/badger.js'
       );
       $prioritize_Js = array(
              'js/jquery-1.10.2.min.js',
              'js/jquery.lazyload.js',
              'js/bootstrap.min.js',
              'js/bootstrap-modalmanager.js',
              'js/bootstrap-modal.js'
       );
       /** ----------------------------------------------------------------------------------*/
       $user_balans         = $session->has('userid') ? go\DB\query('select `balans` from `users` where `id` = ?f', array($session->get('userid')), 'el'):NULL;
       $_SESSION['userVer'] = $session->has('userVer') ? $session->get('userVer') : genpass(10, 2);
       $_SESSION['accVer']  = $session->has('accVer') ? $session->get('accVer') : genpass(10, 2);
       // $razdel ��� �������� �������� ����
       $razdel = $_SERVER['PHP_SELF'];
       if ($_SERVER['PHP_SELF'] === '/fotobanck_adw.php') {
              $razdel = '/fotobanck_adw.php?unchenge_cat';
       }
       $printErr = $session->get('err_msg').$session->get('ok_msg').$session->get('ok_msg2');
       if (!empty($error)) {
              $printErr .= is_array($error) ? implode(' ', $error) : $error;
       }
       $renderData = array(
              // SEO � top
              'title'             => $title,
              'description'       => $description,
              'keywords'          => $keywords,
              // �������������
              'logged'            => $session->has('logged'),
              'us_name'           => $session->get('us_name'),
              'user_balans'       => $user_balans,
              'accVer'            => $session->get('accVer'),
              'userVer'           => $session->get('userVer'),
              // $value - ��� ������ ����
              'razdel'            => $razdel,
              // ������ js � css � top
              'include_Js'        => $include_Js,
              'prioritize_Js'     => $prioritize_Js,
              'include_CSS'       => $include_CSS,
              // ������ js � footer ��� ������ ������
              'include_Js_footer' => array('js/jquery.easing.1.3.js', 'js/dynamic.to.top.dev.js'),
              // �������� � ������ ��� pivic � ������ ������ ��� aleks.od.ua
              'SERVER_NAME'       => $_SERVER['SERVER_NAME'],
              // ��������� ���������
              'printMsg'          => new printMsg(),
              'odebug'            => $odebug,
              'odebugCSSLOG'      => $odebugCSSLOG,
              'odebugCSS'         => $odebugCSS
       );
// <!-- ������ ����� -->
