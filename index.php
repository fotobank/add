<?php
		include_once (__DIR__.'/inc/head.php');

		$dataDB = $db->query('select txt from content where id = ?i', array(1), 'el');
		$include_Js_footer = array('js/jquery.easing.1.3.js', 'js/dynamic.to.top.dev.js');
		$renderData = array(
				'title'             => $title,
				'description'       => $description,
				'keywords'          => $keywords,
				'logged'            => $session->has('logged'),
				'us_name'           => $session->get('us_name'),
				'user_balans'       => $user_balans,
				'accVer'            => $session->get('accVer'),
				'userVer'           => $session->get('userVer'),
				'value'             => $value,
				'include_Js'        => $include_Js,
				'prioritize_Js'     => $prioritize_Js,
				'include_CSS'       => $include_CSS,
				'include_Js_footer' => $include_Js_footer,
				'SERVER_NAME'       => $_SERVER['SERVER_NAME'],
				'dataDB'            => $dataDB
		);
		try {
				echo $twig->render(mb_substr($_SERVER['PHP_SELF'], 0, -3).'twig', $renderData);
		}
		catch (Exception $e) {
				if (DUMP_R) {
						dump_r($e->getMessage());
				}
		}



		include_once (dirname(__FILE__).'/inc/footer.php');
?>