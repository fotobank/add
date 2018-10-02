<? 
chdir("..");
include ('/../inc/head.php');
chdir("folder_for_prototype");
?>

<div id="main">
<div id="cont_fb">
<a class="small button full green" href="../f_svadbi.php">Назад к свадебным альбомам</a>

<!--Альбом начало-->

<!--
	1) Ссылки на файлы, содержащие JavaScript и CSS.
Эти файлы должны быть расположены на Вашем сервере.
-->

<script type="text/javascript" src="../highslide/highslide-with-gallery.js"></script>
<link rel="stylesheet" type="text/css" href="../highslide/highslide.css" />

<!--
	2) При необходимости изменить параметры, заданные в верхнем
из highslide.js файл.Параметр hs.graphicsDir важен!
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
	3) Установите миниатюр внутри DIV для оформления
-->
<div class="highslide-gallery">
<!--
	4) Именно так вы можете размечать с миниатюрами изображений с тега привязки вокруг него.
Атрибут HREF якоря определяет URL полноразмерных изображений.
-->
<a id="thumb1" href="/images/id729.jpg" class="highslide" onclick="return hs.expand(this)" >
	<img src="/images/id730.jpg" width="200" height="200" alt="Highslide JS"
		title="Click to enlarge" />
</a>

<!--Превью + Сама фотка
<a class="alb_usl" rel="lightbox[roadtrip2]" href="foto/svadbi/11.08.12/01.jpg">
 <img class="album_usl_img" border="0" src="foto/svadbi/11.08.12/01.jpg" width="165" height="220">
 </a>
 Превью + Сама фотка конец-->



<!--
	5 (Дополнительно). Вот как можно разметить подписи. Правильное название класса имеет важное значение.
-->

<div class="highslide-caption">
	Надпись на фото.
</div>


<!--
	6) Поставьте последующие эскизы в скрытом контейнере.ThumbnailId параметр обеспечивает
эти миниатюры масштаб, чтобы право миниатюрами, когда закрыты.
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





<!--Альбом конец-->
</div>
</div>
</div>
  </div>
<?php include ('/../inc/footer.php');
?>