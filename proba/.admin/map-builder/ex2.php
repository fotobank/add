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
$map->setMapTypeId(MapBuilder::MAP_TYPE_ID_ROADMAP);

// Set width and height of the map.
$map->setSize(650, 450);

// Set default zoom level.
$map->setZoom(17);

// Set minimum and maximum zoom levels.
$map->setMinZoom(10);
$map->setMaxZoom(19);

// Disable mouse scroll wheel.
$map->setScrollwheel(false);

// Make the map draggable.
$map->setDraggable(true);

// Enable zooming by double click.
$map->setDisableDoubleClickZoom(false);

// Disable all on-map controls.
$map->setDisableDefaultUI(true);

// Display the map.
$map->show();

?>