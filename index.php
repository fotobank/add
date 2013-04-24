<?php
include (dirname(__FILE__).'/inc/head.php');

?>
<div id="main">

<!--<div id="myModal" class="modal hide fade in"  tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
<div class="modal-header">
<button class="close" data-dismiss="modal">x</button>
<h3>Заголовок</h3>
</div>
<div class="modal-body">
</div>
<div class="modal-footer">
<a class="btn" data-dismiss="modal" href="#">Закрыть</a>
</div>
</div>-->

<div id="cont_fb">
<? echo mysql_result(mysql_query('select txt from content where id = 1'), 0); ?>
</div>
<?
/*echo "<script type='text/javascript'>
         $(document).ready(function(){
         $('#myModal').modal('show');
         });
         </script>"; */
?>

<!-- <button id="parol" style="margin-left:30%"  class="btn btn-primary" href="#myModal" data-toggle="modal">модальное окно</button> -->

</div>
<div class="end_content"></div>
</div>

<?php include (dirname(__FILE__).'/inc/footer.php');
?>