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
       if($rv) {
              $renderData['ret'] = $rv['ret'];
              $renderData['okonc'] = $rv['okonc'];
       }
       $renderData['ip'] = $banck->get('ip');
       $renderData['dataDB'] = go\DB\query('select txt from content where id = ?i', array(1), 'el');
       $renderData['album_name'] = $banck->get_arr('album_name', 'current_album')?:NULL;
       $loadTwig('.twig', $renderData);
       ?>
 <div id="main">
       <?








       /** ������ �������� */
       if ($banck->get('current_album')) {

       // <!-- ���� � ���������� ������ -->
       $banck->parol();

       /** ��������� �������� ������ */
       // $banck->set('may_view', false);
       /** ��������� */
       if ($banck->get('may_view')) {

              $renderData['akkordeon'] = $banck->akkordeon();
              echo $renderData['akkordeon'];

       ?>
</div>
       <script language=JavaScript type="text/javascript">
              $(function () {
                     $('.modern').click(function () {
                            onJS('/js_test.php');
                            return false;
                     });
              });
              $(function () {
                     $('.profile_bitton , .profile_bitton2').click(function () {
                            $('.profile').slideToggle();
                            return false;
                     });
              });
       </script>

       <!-- ������ ����� -->
       <div class="page">
              <a class="next" href="/fotobanck_adw.php?back_to_albums">� �����</a> <a class="next" href="/fotobanck_adw.php?unchenge_cat">� ����� ��������� </a>
              <a class="next" href="/fotobanck_adw.php?back_to_albums">� ������ "<?=$banck->get('razdel')?>"</a>
              <a class="next">� ������"<?=$banck->get_arr('album_name', 'current_album')?>"</a>
       </div>

       <!-- �������� �������  -->
       <div class="cont-list"
            style="margin: 40px 10px 30px 0;">
              <div class="drop-shadow lifted">
                     <h2><span style="color: #00146e;">���������� ������� "<?=$banck->get_arr('album_name', 'current_album')?>"</span>
                     </h2>
              </div>
       </div>
       <div style="clear: both;"></div>

       <!--/**	������� ���������� - ��������� �������*/ -->
       <div id="alb_opis"
            class="span3">
              <div class="alb_logo">
                     <div id="fb_alb_fotoP">
                            <img src="album_id.php?num=<?= substr(($banck->get('album_img')), 2, -4) ?>"
                                 width="130px"
                                 height="124px"
                                 alt="-"/>
                     </div>
              </div>
              <?=$banck->get('descr')?>
       </div>

       <?

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
                     <div id="modern">
                     <hr class='style-one' style='margin-top: 10px; margin-bottom: -20px;'/> <div style= 'clear: both;'>
                            <?
                                 $renderData['fotoPageModern'] = $banck->fotoPageModern();
                            echo $renderData['fotoPageModern'];
                            ?>
                     </div>
                     </div>
                     <script type="text/javascript">
                            $(function () {
                                   $("img.lazy").lazyload({
                                          threshold: 200,
                                          effect: "fadeIn"
                                   });
                            });
                     </script>

                     <!-- ���� --><!-- 4 -->
                     <hr class="style-one"
                         style="clear: both; margin-bottom: -20px; margin-top: 0"/>

                     <?
                     $pager->render();
                     // $pager->printDebug();
              } else {
                     /**  �������� �� ������ (����� ������ �������� � ���������)*/
                     $renderData['current_album'] = $banck->get('current_album');
                     $loadTwig('_podpiska.twig', $renderData);

              }
       } else {
              ?>
              <br><br>
                     <hfooter style="font-size: 20px; font-weight: 400; font-style: inherit; color: #df0000; text-shadow: 1px 1px 0 #d1a2a2;"
                            >� ����� �������� �� �������� JavaScript!
                     </hfooter>
              <script type='text/javascript'>
                     $(function(){
                       window.document.location.href = '<?= $_SERVER['REQUEST_URI'] ?>';
                     }
              </script>
              <NOSCRIPT>
                     <br><br>
                     <hfooter style="font-size: 20px; font-weight: 400; font-style: inherit; color: #df0000; text-shadow: 1px 1px 0 #d1a2a2;"
                            >�� - �� ����������� JavaScript ����� ���������� ����������!
                             ( <a href="http://www.enable-javascript.com/ru/">��� �������� JavaScript?</a>)
                     </hfooter>
              </NOSCRIPT>
       <?
       }

} else {
       ?>
       <div class="center" style="margin-top: 30px;">
       <hfooter style="font-size: 20px; font-weight: 400; font-style: inherit; color: #df0000; text-shadow: 1px 1px 0 #d1a2a2;">
              ������ ������������ �������
       </hfooter>
       </div>
       <div class="center" style="margin-top: 30px;">
       <NOSCRIPT>
              <hfooter style="font-size: 20px; font-weight: 400; font-style: inherit; color: #df0000; text-shadow: 1px 1px 0 #d1a2a2;">
                     ��� ����������� JavaScript ���������� ����� ������������! ( <a href="http://www.enable-javascript.com/ru/">��� �������� JavaScript?</a> )
              </hfooter>
       </NOSCRIPT>
       </div>
       <?
       }

       /** ����� �������� � �������� */
} else {

       if ($banck->get('current_cat')) {
              /** $rs['albums'][0]['txt'] - ����� ��������� ���������� �� �������� �������� */
              $renderData['albums'] = go\DB\query('select * from albums where id_category = ?i
                                                   order by order_field asc', array($banck->get('current_cat')), 'assoc');
              $renderData['categories'] = go\DB\query('select nm as razdel, txt, id from categories where id = ?i', array($banck->get('current_cat')), 'assoc');
              /**  ������ ��������*/
              $loadTwig('_razdel.twig', $renderData);
       } else {
              /**  ������ �������� (���������) */
              $renderData['buttons'] = go\DB\query('select * from categories order by id_num asc', NULL, 'assoc:id');
              $loadTwig('_kategorii.twig', $renderData);
       }

}
       $renderData['include_Js_banck'] = array('js/visLightBox/js/visuallightbox.js', 'js/photo-prev.js', 'js/visLightBox/js/vlbdata.js');
       $loadTwig('_footer.twig', $renderData);
       include (BASEPATH.'inc/footer.php');
?>