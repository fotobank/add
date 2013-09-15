<?php
	// define ( 'BASEPATH' , realpath ( __DIR__ ) . '/' , TRUE );
	require_once (__DIR__.'/inc/head.php');
	require_once (__DIR__.'/error_.php');



	$loadTwig('.twig', $renderData);

	require_once (__DIR__.'/inc/footer.php');