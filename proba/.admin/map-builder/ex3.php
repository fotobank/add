<?php

// Include MapBuilder class.
require_once 'class.MapBuilder.php';

// Create MapBuilder object.
$map = new MapBuilder();

// Retrieve coordinates of address.
try {
    $pos = $map->getLatLng('Eiffel Tower, Paris', MapBuilder::URL_FETCH_METHOD_SOCKETS);
} catch (MapBuilderException $ex) {
    die($ex->getMessage());
}

// Set map's center position by latitude and longitude coordinates. 
$map->setCenter($pos['lat'], $pos['lng']);

// Add a marker with specified color and symbol. 
$map->addMarker($pos['lat'], $pos['lng'], array(
    'title' => 'Eiffel Tower', 
    'defColor' => '#FA6D6D', 
    'defSymbol' => 'E'
));

// Set the default map type.
$map->setMapTypeId(MapBuilder::MAP_TYPE_ID_TERRAIN);

// Set width and height of the map.
$map->setSize(650, 450);

// Set default zoom level.
$map->setZoom(17);

// Define map type control parameters.
$map->setMapTypeControl(true);
$map->setMapTypeControlIds(array(
    MapBuilder::MAP_TYPE_ID_HYBRID, 
    MapBuilder::MAP_TYPE_ID_ROADMAP, 
    MapBuilder::MAP_TYPE_ID_SATELLITE, 
    MapBuilder::MAP_TYPE_ID_TERRAIN 
));
$map->setMapTypeControlPosition(MapBuilder::CONTROL_POSITION_LEFT_TOP);
$map->setMapTypeControlStyle(MapBuilder::MAP_TYPE_CONTROL_STYLE_DROPDOWN_MENU);

// Define overview control parameters.
$map->setOverviewMapControl(true);
$map->setOverviewMapControlOpened(true);

// Define pan control parameters.
$map->setPanControl(true);
$map->setPanControlPosition(MapBuilder::CONTROL_POSITION_LEFT_BOTTOM);

// Define rotate control parameters.
$map->setRotateControl(true);
$map->setRotateControlPosition(MapBuilder::CONTROL_POSITION_LEFT_BOTTOM);

// Define scale control parameters.
$map->setScaleControl(true);
$map->setScaleControlPosition(MapBuilder::CONTROL_POSITION_LEFT_BOTTOM);

// Define street view control parameters.
$map->setStreetViewControl(true);
$map->setStreetViewControlPosition(MapBuilder::CONTROL_POSITION_RIGHT_TOP);

// Define zoom control parameters.
$map->setZoomControl(true);
$map->setZoomControlPosition(MapBuilder::CONTROL_POSITION_RIGHT_TOP);
$map->setZoomControlStyle(MapBuilder::ZOOM_CONTROL_STYLE_SMALL);

// Display the map.
$map->show();

?>