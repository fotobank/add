<?php
       define ('ROOT_PATH', realpath(__DIR__).'/', true);
       define('PHOTOS_ON_PAGE', 70);  //���������� ����� �� ��������
       require_once __DIR__.'/alex/fotobank/Framework/Boot/config.php';
       // ��������� ������
       require_once __DIR__.'/inc/errorDump.php';
       // ����� ������
       // ERROR_CONSTANT;
       if (isset($_COOKIE['js']) && $_COOKIE['js'] == 1) {
              define ('JS', true);
              unset ($_COOKIE['js']);   // ������� ���� JS �� �������
       } else define ('JS', false);
       $session->set("JS", JS);
       $session->set("JS_REQUEST_URI" , $_SERVER['REQUEST_URI']);
       if(!JS)  main_redir('/redirect.php');
       $session->set("JS_REDIRECT" , 0);
       setcookie('js', '', time() - 1, '/');   // ������� ���� JS �� ��������

       require_once  (ROOT_PATH.'inc/head.php');
       /*$renderData['dataDB'] = go\DB\query('select txt from content where id = ?i', array(1), 'el');
       $loadTwig('.twig', $renderData);*/
      // require_once  (ROOT_PATH.'inc/ip-ban.php');
       set_time_limit(0);

       // include  (dirname(__FILE__).'/inc/lib/dtimediff/diftimer_class.php'); // ������� ������� ����� ����� ���������
       // $isiPad = (bool) strpos($_SERVER['HTTP_USER_AGENT'],'iPad');


       $bank = new fotoBanck();

       $rv = json_decode($bank->check_block(), true);
       // �������� �� ��������� ���������� �������
       if($rv) {
              $renderData['ret'] = $rv['ret'];
              $renderData['okonc'] = $rv['okonc'];
       }
       $renderData['ip'] = $bank->get('ip');
       $renderData['dataDB'] = go\DB\query('select txt from content where id = ?i', array(1), 'el');
       $renderData['album_name'] = $bank->get_arr('album_name', 'current_album')?:NULL;
       $renderData['current_album'] = $bank->get('current_album');
       $renderData['current_cat'] = $bank->get('current_cat');


       /** ������ �������� */
       if ($bank->get('current_album')) {

       // <!-- ���� � ���������� ������ -->
          $renderData['parol'] = $bank->parol();
       /** ��������� �������� ������ */
//        $bank->set('may_view', false);
       /** ��������� */
              $renderData['may_view'] = $bank->get('may_view');
       if ($bank->get('may_view')) {
       /** �������� ������� ������ c ���������� JS � �������� */
       if (JS) {

              $renderData['akkordeon'] = $bank->akkordeon();
              $renderData['razdel'] = $bank->get('razdel');
       //       $renderData['album_name']['current_album'] = $bank->get_arr('album_name', 'current_album');
              $renderData['descr'] = $bank->get('descr');
              $renderData['JS'] = JS;
              $renderData['REQUEST_URI'] = $_SERVER['REQUEST_URI'];
              $renderData['disable_photo_display'] = $bank->get('disable_photo_display');
              $renderData['current_album'] = $bank->get('current_album');

              if ($bank->get('disable_photo_display') == 'on') {
                     /** ����� ��� 5  */
                     $renderData['top5'] = $bank->top5Modern();
                     if (!$bank->get_arr('record_count', 'current_album')) {
                            $rs = go\DB\query('select SQL_CALC_FOUND_ROWS p.* from photos p where id_album = ?i', array($bank->get('current_album')), 'assoc');
                            $session->set('record_count/'.$bank->get('current_album'), go\DB\query('select FOUND_ROWS() as cnt', NULL, 'el')); // ���������� �������
                     }
                     $page = "pg"; // �������� GET ��������
                     $pager = new Pager2($session->get('record_count/'.(int)$bank->get('current_album')), PHOTOS_ON_PAGE, new pagerHtmlRenderer());
                     $pager->delta = 3;
                     $pager->firstPagesCnt = 3;
                     $pager->lastPagesCnt = 3;
                     $pager->setPageVarName($page);
                     $pager->enableCacheRemover = false;
                     $renderData['renderTop'] = $pager->renderTop();
                     // $pager->printDebug();
                           // ����� ���� � ������
                     $renderData['fotoPageModern'] = $bank->fotoPageModern();
                     $renderData['renderBottom'] = $pager->render();
                     $renderData['album_img'] = substr(($bank->get('album_img')), 2, -4);
                     // $pager->printDebug();
              } else {
                     /** TODO:  �������� �� ������ (����� ������ �������� � ���������)*/
              }
       } else {
              /** TODO: � �������� �������� ��� ������ */
       }

} else {
         /** TODO: ������ ��������� */
       }

       /** ����� �������� � �������� */
}

       if ($bank->get('current_cat')) {
              /** $rs['albums'][0]['txt'] - ����� ��������� ���������� �� �������� �������� */
              $renderData['albums'] = go\DB\query('select * from albums where id_category = ?i
                                                   order by order_field asc', array($bank->get('current_cat')), 'assoc');
              $renderData['categories'] = go\DB\query('select nm as razdel, txt, id from categories where id = ?i', array($bank->get('current_cat')), 'assoc');
              /**  ������ ��������*/
       } else {
              /**  ������ �������� (���������) */
              $renderData['buttons'] = go\DB\query('select * from categories order by id_num asc', NULL, 'assoc:id');
       }


       $renderData['include_Js_banck'] = array('js/visLightBox/js/visuallightbox.js', 'js/photo-prev.js', 'js/visLightBox/js/vlbdata.js');
//       $renderData['include_Js_banck'] = array('js/photo-prev.js', 'js/visLightBox/js/vlbdata.js');
       $loadTwig('.twig', $renderData);
//       $loadTwig('_footer.twig', $renderData);
//       include (ROOT_PATH.'inc/footer.php');
