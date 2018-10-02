<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Jurii
 * Date: 24.04.13
 * Time: 14:56
 * To change this template use File | Settings | File Templates.
 */

header('Content-type: text/html; charset=windows-1251');


require_once("ipgeobase.php");
$visitorIP = isset($_GET['ip'])?$_GET['ip']:0;
//$visitorIP = '31.31.116.22';
$gb = new IPGeoBase();
$location = $gb->getRecord($visitorIP);
//var_dump($location);

?>

<div class="modal-header" style="background: rgba(229,229,229,0.53)">
  <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
  <h3>Карта</h3>
</div>
  <div class="modal-body" style="height: 450px;">
<div id="map1" style="width: 600px; height: 400px"></div>
  </div>
<div class="modal-footer">
  <a href="#" class="btn" data-dismiss="modal">Закрыть</a>
</div>


<script src="http://api-maps.yandex.ru/2.0-stable/?load=package.standard&lang=ru-RU" type="text/javascript"></script>
<script type="text/javascript">

  ymaps.ready(init);
  var myMap;
  function init(){
	 myMap = new ymaps.Map ("map", {
		center: [<?php echo $location['lat']; ?>, <?php echo $location['lng']; ?>],
		zoom: 14
	 });
	 var city = "<?= $location['city']; ?>";
	 var district = "<?= $location['district']; ?>";
	 var cc = "<?= $location['cc']; ?>";
	 var myPlacemark = new ymaps.Placemark(
	  [<?php echo $location['lat']; ?>, <?php echo $location['lng']; ?>],
	  { iconContent: 'Страна: '+cc+'<br>Город: '+ city +'<br>Регион: '+district },
	  { preset: 'twirl#whiteStretchyIcon' } // Иконка будет белой и растянется под iconContent
	 );

	 myMap.geoObjects.add(myPlacemark);
	 myMap.controls
		// Кнопка изменения масштаба.
	  .add('zoomControl', { left: 5, top: 5 })
		// Список типов карты
	  .add('typeSelector')
		// Стандартный набор кнопок
	  .add('mapTools', { left: 35, top: 5 });
  }
</script>

