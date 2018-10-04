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
$map->setSize(800, 500);

// Set default zoom level.
$map->setZoom(14);

// Enable sensor. 
// It's not required, as the sensor will turned on automatically by the following 2 methods.
$map->setSensor(true);

// Add marker at location returned by GPS sensor.
$map->addGeoMarker(array(
    'html' => '<b>Hey, it\'s my location!</b>', 
    'defColor' => '#FF6161', 
    'defSymbol' => '%E2%80%A2',
    'infoCloseOthers' => true     
));

// Make location returned by GPS sensor the map center.
$map->overrideCenterByGeo(true);

// Display the map.
$map->show();

?>