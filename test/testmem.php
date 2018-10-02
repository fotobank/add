<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Jurii
 * Date: 07.10.13
 * Time: 21:11
 * To change this template use File | Settings | File Templates.
 */

header('Content-type: text/html; charset=windows-1251');

for($i=0; $i<500; $i++) {
       $a = loadmem($i);
       echo "Используемая память: ".$i."M (".memory_get_usage().")<br />";
       unset($a);
}

function loadmem($showmuchmed) {
       $a = str_repeat("0", $showmuchmed * 1024 * 1024 );
       return $a;
}