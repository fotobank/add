<?php
       error_reporting(E_ALL | E_STRICT);
       ini_set('display_errors', 1);
       require_once(__DIR__.'/inc/config.php');
       // ��������� ������
       require_once (__DIR__.'/inc/errorDump.php');
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

       define ('BASEPATH', realpath(__DIR__).'/', true);
       define('PHOTOS_ON_PAGE', 70);  //���������� ����� �� ��������
       require_once  (BASEPATH.'inc/head.php');
       /*$renderData['dataDB'] = go\DB\query('select txt from content where id = ?i', array(1), 'el');
       $loadTwig('.twig', $renderData);*/
      // require_once  (BASEPATH.'inc/ip-ban.php');
       set_time_limit(0);

       // include  (dirname(__FILE__).'/inc/lib/dtimediff/diftimer_class.php'); // ������� ������� ����� ����� ���������
       // $isiPad = (bool) strpos($_SERVER['HTTP_USER_AGENT'],'iPad');


       $banck = new fotoBanck();

       $rv = json_decode($banck->check_block(), true);
       // �������� �� ��������� ���������� �������
       if($rv) {
              $renderData['ret'] = $rv['ret'];
              $renderData['okonc'] = $rv['okonc'];
       }
       $renderData['ip'] = $banck->get('ip');
       $renderData['dataDB'] = go\DB\query('select txt from content where id = ?i', array(1), 'el');
       $renderData['album_name'] = $banck->get_arr('album_name', 'current_album')?:NULL;
       $renderData['current_album'] = $banck->get('current_album');
       $renderData['current_cat'] = $banck->get('current_cat');





       /** ������ �������� */
       if ($banck->get('current_album')) {

       // <!-- ���� � ���������� ������ -->
              $renderData['parol'] = $banck->parol();
       /** ��������� �������� ������ */
//        $banck->set('may_view', false);
       /** ��������� */
              $renderData['may_view'] = $banck->get('may_view');
       if ($banck->get('may_view')) {

              $renderData['akkordeon'] = $banck->akkordeon();
              echo $renderData['akkordeon'];

              $renderData['razdel'] = $banck->get('razdel');
              $renderData['album_name']['current_album'] = $banck->get_arr('album_name', 'current_album');
              $renderData['descr'] = $banck->get('descr');
              $renderData['JS'] = JS;
              $renderData['REQUEST_URI'] = $_SERVER['REQUEST_URI'];
              $renderData['event'] = $banck->get('event');
              $renderData['current_album'] = $banck->get('current_album');
              // �������� ������� ������ c ���������� JS � ��������
       if (JS) {

              if ($banck->get('event') == 'on') {
                     //		<!-- ����� ��� 5  -->
                     $banck->top5Modern();

                     if (!$banck->get_arr('record_count', 'current_album')) {
                            $rs = go\DB\query('select SQL_CALC_FOUND_ROWS p.* from photos p where id_album = ?i', array($banck->get('current_album')), 'assoc');
                            $session->set('record_count/'.$banck->get('current_album'), go\DB\query('select FOUND_ROWS() as cnt', NULL, 'el')); // ���������� �������
                     }
                     $page = "pg"; // �������� GET ��������
                     $pager = new Pager2($session->get("record_count/".intval($banck->get('current_album'))), PHOTOS_ON_PAGE, new pagerHtmlRenderer());
                     $pager->delta = 3;
                     $pager->firstPagesCnt = 3;
                     $pager->lastPagesCnt = 3;
                     $pager->setPageVarName($page);
                     $pager->enableCacheRemover = false;
                     $pager->renderTop();
                     // $pager->printDebug();
                     ?>

                     <!-- ����� ���� � ������ -->

                     <?
                     $renderData['fotoPageModern'] = $banck->fotoPageModern();
                     $pager->render();
//                   $pager->printDebug();
              } else {
                     /**  �������� �� ������ (����� ������ �������� � ���������)*/
              }
       } else {

       }

} else {

       }

       /** ����� �������� � �������� */
}

       if ($banck->get('current_cat')) {
              /** $rs['albums'][0]['txt'] - ����� ��������� ���������� �� �������� �������� */
              $renderData['albums'] = go\DB\query('select * from albums where id_category = ?i
                                                   order by order_field asc', array($banck->get('current_cat')), 'assoc');
              $renderData['categories'] = go\DB\query('select nm as razdel, txt, id from categories where id = ?i', array($banck->get('current_cat')), 'assoc');
              /**  ������ ��������*/
       } else {
              /**  ������ �������� (���������) */
              $renderData['buttons'] = go\DB\query('select * from categories order by id_num asc', NULL, 'assoc:id');
       }


       $renderData['include_Js_banck'] = array('js/visLightBox/js/visuallightbox.js', 'js/photo-prev.js', 'js/visLightBox/js/vlbdata.js');
       $loadTwig('.twig', $renderData);
    //   $loadTwig('_footer.twig', $renderData);
    //   include (BASEPATH.'inc/footer.php');
?>