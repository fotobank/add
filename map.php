<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Jurii
 * Date: 24.04.13
 * Time: 14:56
 * To change this template use File | Settings | File Templates.
 */

$visitorIP = $_SERVER['REMOTE_ADDR'];
// $visitorIP = '31.31.116.22';
$location = json_decode(file_get_contents('http://iploc.mwudka.com/iploc/'.$visitorIP.'/json'));
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
	"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta http-equiv="Content-Type" content="text/html" />
	<meta http-equiv="X-UA-Compatible" content="IE=7"/>
	<meta http-equiv="content-type" content="text/html;charset=utf-8" />
	<title>√де €? :-)</title>
	<script src="http://api-maps.yandex.ru/1.1/index.xml?key=AA3Jd1EBAAAAMXcKGAMA-0yN_Na-LXsKvwsyPMQgwhgzaoQAAAAAAAAAAAAVJw_gC8K61J1Z7obG7AoCROYYPg=="
		type="text/javascript"></script>
	<script type="text/javascript">
		window.onload = function() {
			var map;
			map = new YMaps.Map(document.getElementById("ipmap"));
			map.setCenter(new YMaps.GeoPoint(<?php echo $location->longitude; ?>, <?php echo $location->latitude; ?>), 13,
				YMaps.MapType.HYBRID);
			map.addControl(new YMaps.TypeControl());
			map.addControl(new YMaps.Zoom());
			map.addControl(new YMaps.ScaleLine());
			map.enableRuler();
			var text = "<?php echo $location->city; ?>";
			map.openBalloon(new YMaps.GeoPoint(<?php echo $location->longitude; ?>, <?php echo $location->latitude; ?>), text);
		};
	</script>
</head>

<body>
<div id="ipmap" style="height:400px; width:600px;"></div>
</body>
</html>