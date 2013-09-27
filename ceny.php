<?php
			define ( 'BASEPATH' , realpath ( __DIR__ ) . '/' , TRUE );
		 include_once (BASEPATH.'inc/head.php');


		 $renderData['dataDB' ] =  go\DB\query('select txt from content where id = ?i', array(3), 'el');
		 $loadTwig('.twig', $renderData);


		 include_once (BASEPATH.'inc/footer.php');