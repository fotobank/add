<? 
chdir("..");
include ('/../inc/head.php');
chdir("folder_for_prototype");
?>

<div id="main">
<div id="cont_fb">
<a class="small button full green" href="../f_svadbi.php">����� � ��������� ��������</a>

<!--������ ������-->

<!--
	1) ������ �� �����, ���������� JavaScript � CSS.
��� ����� ������ ���� ����������� �� ����� �������.
-->

<script type="text/javascript" src="../highslide/highslide-with-gallery.js"></script>
<link rel="stylesheet" type="text/css" href="../highslide/highslide.css" />

<!--
	2) ��� ������������� �������� ���������, �������� � �������
�� highslide.js ����.�������� hs.graphicsDir �����!
-->

<script type="text/javascript">
hs.graphicsDir = '/highslide/graphics/';
hs.showCredits = false; 
hs.align = 'center';
hs.transitions = ['expand', 'crossfade'];
hs.outlineType = 'rounded-white';
hs.fadeInOut = true;
hs.numberPosition = 'caption';
hs.dimmingOpacity = 0.75;

// Add the controlbar
if (hs.addSlideshow) hs.addSlideshow({
	//slideshowGroup: 'group1',
	interval: 5000,
	repeat: false,
	useControls: true,
	fixedControls: 'fit',
	overlayOptions: {
		opacity: .75,
		position: 'bottom center',
		hideOnMouseOut: true
	}
});
</script>


<!--
	3) ���������� �������� ������ DIV ��� ����������
-->
<div class="highslide-gallery">
<!--
	4) ������ ��� �� ������ ��������� � ����������� ����������� � ���� �������� ������ ����.
������� HREF ����� ���������� URL �������������� �����������.
-->
<a id="thumb1" href="/images/id729.jpg" class="highslide" onclick="return hs.expand(this)" >
	<img src="/images/id730.jpg" width="200" height="200" alt="Highslide JS"
		title="Click to enlarge" />
</a>

<!--������ + ���� �����
<a class="alb_usl" rel="lightbox[roadtrip2]" href="foto/svadbi/11.08.12/01.jpg">
 <img class="album_usl_img" border="0" src="foto/svadbi/11.08.12/01.jpg" width="165" height="220">
 </a>
 ������ + ���� ����� �����-->



<!--
	5 (�������������). ��� ��� ����� ��������� �������. ���������� �������� ������ ����� ������ ��������.
-->

<div class="highslide-caption">
	������� �� ����.
</div>


<!--
	6) ��������� ����������� ������ � ������� ����������.ThumbnailId �������� ������������
��� ��������� �������, ����� ����� �����������, ����� �������.
-->
<div class="hidden-container">
	<a href="/images2/733/id6573.jpg" class="highslide" onclick="return hs.expand(this, { thumbnailId: 'thumb1' })"></a>
	<div class="highslide-caption">
		Caption for the second image.
	</div>

	<a href="/images2/733/id6577.jpg" class="highslide" onclick="return hs.expand(this, { thumbnailId: 'thumb1' })"></a>
	<div class="highslide-caption">
		Caption for the third image.
	</div>
</div>





<!--������ �����-->
</div>
</div>
</div>
  </div>
<?php include ('/../inc/footer.php');
?>