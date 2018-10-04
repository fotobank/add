<?php

$password = 'McF-GU*".k9B[';

require 'class.password-entropy-estimator.php';
$ent = new password_entropy_estimator;
echo $ent->entropy($password); // 85 bits

?>