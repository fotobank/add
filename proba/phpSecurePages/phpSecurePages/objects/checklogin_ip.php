<?php


// check if user is coming from an allowed IP address
$ip_array_count = count($allowed_addr);
$remote_ip = explode(".", $_SERVER['REMOTE_ADDR']);

for ($t = 0; $t < count($allowed_addr); $t++) {
        $permitted[$t] = 1;
        for($i = 0; $i < sizeof($allowed_addr[$t]); $i++) {
                if($remote_ip[$i] != $allowed_addr[$t][$i]){
                        $permitted[$t] = 0;
                        }
                }
        }

$permitted_sum=array_sum($permitted);
if($permitted_sum<1)    {
        // IP address not allowed
        $phpSP_message = $strNoAccess;
        include($cfgProgDir . "interface.php");
        exit;
        }
?>
