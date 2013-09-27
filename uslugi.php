<?php
			define ( 'BASEPATH' , realpath ( __DIR__ ) . '/' , TRUE );
			require_once (BASEPATH.'inc/head.php');


				$renderData['dataDB_top' ] =  go\DB\query('select txt from content where id = ?i', array(17), 'el');
				$renderData['dataDB_bottom' ] =  go\DB\query('select txt from content where id = ?i', array(18), 'el');
				$loadTwig('.twig', $renderData);




				require_once (BASEPATH.'inc/footer.php');