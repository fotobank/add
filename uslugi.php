<?php
			define ( 'ROOT_PATH' , realpath ( __DIR__ ) . '/' , TRUE );
			require_once (ROOT_PATH.'inc/head.php');


				$renderData['dataDB_top' ] =  go\DB\query('select txt from content where id = ?i', array(17), 'el');
				$renderData['dataDB_bottom' ] =  go\DB\query('select txt from content where id = ?i', array(18), 'el');
				$loadTwig('.twig', $renderData);




				require_once (ROOT_PATH.'inc/footer.php');
