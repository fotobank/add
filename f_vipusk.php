<?php
			define ( 'BASEPATH' , realpath ( __DIR__ ) . '/' , TRUE );
			require_once (BASEPATH.'inc/head.php');


			$renderData['autoPrev']            = new autoPrev();
			$renderData['txt']                 = $db->query('select txt from content where id = ?i', array(9), 'el');
			$renderData['include_Js_f_svadbi'] = array('js/prettyPhoto/js/jquery.prettyPhoto.js', 'js/montage/js/jquery.montage.js');
			$loadTwig('.twig', $renderData);


			require_once (BASEPATH.'inc/footer.php');