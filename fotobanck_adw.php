<?php
       define ('ROOT_PATH', realpath(__DIR__).'/', true);
       define('PHOTOS_ON_PAGE', 70);  //Количество фоток на странице
       require_once __DIR__.'/alex/fotobank/Framework/Boot/config.php';
       // обработка ошибок
       require_once __DIR__.'/inc/errorDump.php';
       // вызов ошибки
       // ERROR_CONSTANT;
       if (isset($_COOKIE['js']) && $_COOKIE['js'] == 1) {
              define ('JS', true);
              unset ($_COOKIE['js']);   // удаляем куки JS из сервера
       } else define ('JS', false);
       $session->set("JS", JS);
       $session->set("JS_REQUEST_URI" , $_SERVER['REQUEST_URI']);
       if(!JS)  main_redir('/redirect.php');
       $session->set("JS_REDIRECT" , 0);
       setcookie('js', '', time() - 1, '/');   // удаляем куки JS из браузера

       require_once  (ROOT_PATH.'inc/head.php');
       /*$renderData['dataDB'] = go\DB\query('select txt from content where id = ?i', array(1), 'el');
       $loadTwig('.twig', $renderData);*/
      // require_once  (ROOT_PATH.'inc/ip-ban.php');
       set_time_limit(0);

       // include  (dirname(__FILE__).'/inc/lib/dtimediff/diftimer_class.php'); // подсчет времени между двумя событиями
       // $isiPad = (bool) strpos($_SERVER['HTTP_USER_AGENT'],'iPad');


       $bank = new fotoBanck();

       $rv = json_decode($bank->check_block(), true);
       // проверка на парольную блокировку альбома
       if($rv) {
              $renderData['ret'] = $rv['ret'];
              $renderData['okonc'] = $rv['okonc'];
       }
       $renderData['ip'] = $bank->get('ip');
       $renderData['dataDB'] = go\DB\query('select txt from content where id = ?i', array(1), 'el');
       $renderData['album_name'] = $bank->get_arr('album_name', 'current_album')?:NULL;
       $renderData['current_album'] = $bank->get('current_album');
       $renderData['current_cat'] = $bank->get('current_cat');


       /** начало страницы */
       if ($bank->get('current_album')) {

       // <!-- Ввод и блокировка пароля -->
          $renderData['parol'] = $bank->parol();
       /** Отключить проверку пароля */
//        $bank->set('may_view', false);
       /** Аккордеон */
              $renderData['may_view'] = $bank->get('may_view');
       if ($bank->get('may_view')) {
       /** выдавать контент только c включенным JS в браузере */
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
                     /** вывод топ 5  */
                     $renderData['top5'] = $bank->top5Modern();
                     if (!$bank->get_arr('record_count', 'current_album')) {
                            $rs = go\DB\query('select SQL_CALC_FOUND_ROWS p.* from photos p where id_album = ?i', array($bank->get('current_album')), 'assoc');
                            $session->set('record_count/'.$bank->get('current_album'), go\DB\query('select FOUND_ROWS() as cnt', NULL, 'el')); // количество записей
                     }
                     $page = "pg"; // название GET страницы
                     $pager = new Pager2($session->get('record_count/'.(int)$bank->get('current_album')), PHOTOS_ON_PAGE, new pagerHtmlRenderer());
                     $pager->delta = 3;
                     $pager->firstPagesCnt = 3;
                     $pager->lastPagesCnt = 3;
                     $pager->setPageVarName($page);
                     $pager->enableCacheRemover = false;
                     $renderData['renderTop'] = $pager->renderTop();
                     // $pager->printDebug();
                           // Вывод фото в альбом
                     $renderData['fotoPageModern'] = $bank->fotoPageModern();
                     $renderData['renderBottom'] = $pager->render();
                     $renderData['album_img'] = substr(($bank->get('album_img')), 2, -4);
                     // $pager->printDebug();
              } else {
                     /** TODO:  подписка на альбом (когда альбом появится в категории)*/
              }
       } else {
              /** TODO: в браузере отключен ява скрипт */
       }

} else {
         /** TODO: альбом запаролен */
       }

       /** Вывод альбомов в разделах */
}

       if ($bank->get('current_cat')) {
              /** $rs['albums'][0]['txt'] - Вывод текстовой информации на страницы разделов */
              $renderData['albums'] = go\DB\query('select * from albums where id_category = ?i
                                                   order by order_field asc', array($bank->get('current_cat')), 'assoc');
              $renderData['categories'] = go\DB\query('select nm as razdel, txt, id from categories where id = ?i', array($bank->get('current_cat')), 'assoc');
              /**  Печать альбомов*/
       } else {
              /**  кнопки разделов (категорий) */
              $renderData['buttons'] = go\DB\query('select * from categories order by id_num asc', NULL, 'assoc:id');
       }


       $renderData['include_Js_banck'] = array('js/visLightBox/js/visuallightbox.js', 'js/photo-prev.js', 'js/visLightBox/js/vlbdata.js');
//       $renderData['include_Js_banck'] = array('js/photo-prev.js', 'js/visLightBox/js/vlbdata.js');
       $loadTwig('.twig', $renderData);
//       $loadTwig('_footer.twig', $renderData);
//       include (ROOT_PATH.'inc/footer.php');
