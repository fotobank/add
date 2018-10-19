<?php
			define ( 'ROOT_PATH' , realpath ( __DIR__ ) . '/' , TRUE );
		 include_once (ROOT_PATH.'inc/head.php');


		 $renderData['dataDB' ] =  go\DB\query('select txt from content where id = ?i', array(3), 'el');
		 $loadTwig('.twig', $renderData);


		 include_once (ROOT_PATH.'inc/footer.php');
