<?php
			 /**
				* Created by JetBrains PhpStorm.
				* User: Jurii
				* Date: 12.09.13
				* Time: 14:31
				* To change this template use File | Settings | File Templates.
				*/
			 // дополнительная функция для twig - сжатие css и js
			 function merge_twig($a, $b, $c, $e, $f) {

							try {
										 $vars = array(
														'encode' => true,
														'timer'  => true,
														'gzip'   => true
										 );
										 $min  = new minifier_jsCss($vars);

										 return $min->merge($a, $b, $c, $e, $f);

							}
							catch (Exception $e) {
										 if (check_Session::getInstance()->has('DUMP_R')) {
														dump_r($e->getMessage());
										 }

										 return false;
							}
			 }

			 loadTwig::$twig->addFunction('merge_files', new Twig_Function_Function('merge_twig'));
			 function __kapca_kontakty() {

							try {
										 /** @noinspection PhpVoidFunctionResultUsedInspection */
										 return dsp_crypt('kontakti.cfg.php', 1);
							}
							catch (Exception $e) {
										 if (check_Session::getInstance()->has('DUMP_R')) {
														dump_r($e->getMessage());
										 }

										 return false;
							}
			 }

			 loadTwig::$twig->addFunction('kapca_kontakty', new Twig_Function_Function('__kapca_kontakty'));
			 function __dump_r($dump) {

							return dump_r($dump);
			 }

		 loadTwig::$twig->addFunction('dump_t', new Twig_Function_Function('__dump_r'));
/* function __substr($a, $b, $c) {

			try {
						 return substr($a, $b, $c);
			}
			catch (Exception $e) {
						 if (check_Session::getInstance()->has('DUMP_R')) {
										dump_r($e->getMessage());
						 }

						 return false;
			}
}

loadTwig::$twig->addFilter(new Twig_SimpleFilter('substr', '__substr'));*/