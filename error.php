<?php
	define ( 'BASEPATH' , realpath ( __DIR__ ) . '/' , TRUE );
	require_once (BASEPATH.'inc/head.php');
	require_once (BASEPATH.'error_.php');



	$loadTwig('.twig', $renderData);

	require_once (BASEPATH.'inc/footer.php');