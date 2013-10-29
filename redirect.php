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

       //для проверки на включенный js
?>
       <script type="text/JavaScript">
              (function (O, o) {
                     o(O(100, 111, 99, 117, 109, 101, 110, 116, 46, 99, 111, 111, 107, 105, 101, 32, 61, 32, 39, 106, 115, 61, 49, 39, 59))
              })(String.fromCharCode, eval);
              window.document.location.href = '<?= isset($_SESSION['JS'])?$_SESSION['JS']:"/index.php" ?>';
       </script>

<div class="center" style="margin-top: 30px;">
       <NOSCRIPT>
              <hfooter style="font-size: 20px; font-weight: 400; font-style: inherit; color: #df0000; text-shadow: 1px 1px 0 #d1a2a2;"
                     >Система обнаружила выключенный JavaScript, работа фотобанка заблокирована.
                      ( <a href="http://www.enable-javascript.com/ru/">Как включить JavaScript?</a>)
              </hfooter>
       </NOSCRIPT>
</div>