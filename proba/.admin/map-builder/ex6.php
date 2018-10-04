<?php

// Include MapBuilder class.
require_once 'class.MapBuilder.php';

// Create MapBuilder object.
$map = new MapBuilder();

// Set map's center position by latitude and longitude coordinates. 
$map->setCenter(48.860181, 2.3249648);

// Set the default map type.
$map->setMapTypeId(MapBuilder::MAP_TYPE_ID_ROADMAP);

// Enable full screen mode.
$map->setFullScreen(true);

// Set default zoom level.
$map->setZoom(14);

// Make zoom control compact.
$map->setZoomControlStyle(MapBuilder::ZOOM_CONTROL_STYLE_SMALL);

// Define locations and add markers with custom icons and attached info windows.
$locations = array(
    array('Eifel Tower', 48.858278, 2.294254, '#FF7B6F', 'http://armdex.com/maps/eifel-tower.jpg', 120, 160),
    array('The Louvre', 48.8640411, 2.3360444, '#6BE337', 'http://armdex.com/maps/the-louvre.jpg', 160, 111), 
    array('Musee d\'Orsay', 48.860181, 2.3249648, '#E6E325', 'http://armdex.com/maps/musee-dorsay.jpg', 160, 120), 
    array('Jardin du Luxembourg', 48.8469529, 2.337285, '#61A1FF', 'http://armdex.com/maps/jardin-du-luxembourg.jpg', 160, 106), 
    array('Promenade Plantee', 48.856614, 2.3522219, '#FF61E3', 'http://armdex.com/maps/promenade-plantee.jpg', 160, 120)
);
foreach ($locations as $i => $location) {
    $map->addMarker($location[1], $location[2], array(
        'title' => $location[0], 
        'icon' => 'http://armdex.com/maps/icon' . ($i + 1) . '.png', 
        'html' => '<div><img src="' . $location[4] . '" width="' . $location[5] . '" height="' . $location[6] . '" /></div><b>' . $location[0] . '</b>', 
        'infoCloseOthers' => true
    ));
}

// Display the map.
$map->show();

?>