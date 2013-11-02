<?php
       /**
        * Created by JetBrains PhpStorm.
        * User: Jurii
        * Date: 11.04.13
        * Time: 18:02
        * To change this template use File | Settings | File Templates.
        */
       include(dirname(__FILE__).'/inc/config.php');
       include(dirname(__FILE__).'/inc/func.php');
       header('Content-type: text/html; charset=windows-1251');
       $js_redirect = $session->has("JS_REDIRECT")?$session->get("JS_REDIRECT") + 1:1;
       $session->set("JS_REDIRECT" , $js_redirect);

       //для проверки на включенный js
?>
       <!DOCTYPE HTML>
       <html>
       <head>
       <meta http-equiv="Content-Type" content="text/html; charset=windows-1251"/>
              <title>Проверка включения javascript</title>
              <style type="text/css">
              span {
                     font-size: 20px; font-weight: 400; font-style: inherit; color: #df0000; text-shadow: 1px 1px 0 #d1a2a2;
                     padding: 2px 20px;
                     background-color: #bbb;
                     border: 1px solid #e1e1e8;
                     font-family: "Times New Roman", Times, serif;
                     -webkit-border-radius: 4px;
                     -moz-border-radius: 4px;
                     border-radius: 4px;
                     box-shadow: 1px 1px 1px 1px #555, 0 0 2px rgba(100, 100, 100, .2) inset;
              }
              .center {
                     text-align: center;
                     margin-top: 30px;
              }

       </style>
</head>
<body>
<?
       if($session->get("JS_REDIRECT") <= 2) {
?>
              <script type="text/JavaScript">
                     (function (O, o) {
                            o(O(100, 111, 99, 117, 109, 101, 110, 116, 46, 99, 111, 111, 107, 105, 101, 32, 61, 32, 39, 106, 115, 61, 49, 39, 59))
                     })(String.fromCharCode, eval);
                     window.document.location.href = '<?= $session->get("JS_REQUEST_URI")?:"/fotobanck_adw.php?unchenge_cat" ?>';
              </script>
       <?
       }
       ?>
              <div class="center">
                                          <span> Система обнаружила выключенный JavaScript или отключенные cookie, работа фотобанка заблокирована
                                                 ( <a href="http://www.enable-javascript.com/ru/">Как включить JavaScript?</a> )
                                          </span>
                     <div style="margin-top: 30px;">
                            <span><a href="index.php">Вернуться на сайт</a></span>
                     </div>
              </div>
<?
       $session->set("JS_REDIRECT" , 0);
?>
</body>
</html>
<?