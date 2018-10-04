<?php
session_start();
$id = $_GET['id'];
$file = $_SESSION['class_protect_picture'][$id];
if (file_exists($file)) readfile($file);
?>
