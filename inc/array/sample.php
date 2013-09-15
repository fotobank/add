<?php

require_once('ArrayHelper.php');

echo "<pre>";

$a = new ArrayHelper();
//$a->setProperties(array("data"=> array(1,2,3)));
print_r($a);

$a->set("data/1","test");
$a->add("data/5/test","test5");

print_r($a);

//echo $a->has("data/0"); // return 1 или null
//  print_r($a->fetchAll()); # not cleared return of deep nested array

// print_r($a->getAll());

// print_r($a);


//  $a->setProperties(array("proba"=> array(array(1,2,3),array(1,2,3),array(1,2,3))));
//  print_r($a);




  echo "</pre>";