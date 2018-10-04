<?php

// Include MapBuilder class.
require_once 'class.MapBuilder.php';

// Create MapBuilder object.
$map = new MapBuilder();

// Set map's center position by latitude and longitude coordinates. 
$map->setCenter(48.860181, 2.3249648);

// Set the default map type.
$map->setMapTypeId(MapBuilder::MAP_TYPE_ID_ROADMAP);

// Set width and height of the map.
$map->setSize(860, 550);

// Set default zoom level.
$map->setZoom(14);

// Connect the database.
mysql_connect('localhost', 'root', '') or die('Unable to connect the database!');
mysql_select_db('map_data') or die('Unable to select the database!');

// Select data and add markers using that data.
$result = mysql_query("SELECT name, lat, lng FROM highlights") or die(mysql_error());
while ($row = mysql_fetch_assoc($result)) {
    $map->addMarker($row['lat'], $row['lng'], array(
        'title' => $row['title'] 
    ));
}

// Display the map.
$map->show();

?>