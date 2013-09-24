<?php
		define ( 'BASEPATH' , realpath ( __DIR__ ) . '/' , TRUE );
		include_once (BASEPATH.'inc/head.php');


		$renderData['dataDB' ] =  $db->query('select txt from content where id = ?i', array(1), 'el');
		$loadTwig('.twig', $renderData);


		include_once (BASEPATH.'inc/footer.php');
?>