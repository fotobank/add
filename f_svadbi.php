<?php
  include (__DIR__.'/inc/head.php');
  include (__DIR__.'/inc/autoPrev.php');

  $include_Js = array('js/prettyPhoto/js/jquery.prettyPhoto.js','js/montage/js/jquery.montage.js' );
?>
  <script src="<?php $min->merge( '/cache/uslugi.min.js', 'js', $include_Js); ?>"></script>
<?
  //  $min->logs();
?>
  <div id="main">
	 <div id="cont_fb">
		<div class="cont-list" style="margin: 0 10px 20px 43%;">
		  <div class="drop-shadow lifted">
			 <h2><span style="color: #00146e;">�������</span></h2>
		  </div>
		</div>

		<a class="small button full blue" href="uslugi.php"><span>����� � ����������</span></a>

		<?
		echo $db->query('select txt from content where id = ?i', array(5), 'el');



		$thumb = new autoPrev();
		$thumb->printAlbum('/reklama/photo/svadbi/', 250, true); // ����� �������� � ����� (url ����� , ������ ������ � ����� �������� �� ������ ��� ������)
		$thumb->printStart(); // ����� ��������� ������� ������� ��� ��������� �������� ��������
//		$thumb->startPrettyPhoto();
		?>

	 </div>
	 <div style="clear: both;"></div>

	 <!-- ����� ����������-->

	 <div id='thumb' style="min-height: 600px; margin-top: 50px;"></div>


  </div>
  <div class="end_content"></div>
  </div>


<?php
  include (__DIR__.'/inc/footer.php');
?>