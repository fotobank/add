<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Jurii
 * Date: 22.08.13
 * Time: 18:35
 * To change this template use File | Settings | File Templates.
 */
 //  header('Content-type: text/html; charset=utf-8');

	include (dirname(__FILE__).'/../../inc/config.php');
	include (dirname(__FILE__).'/../../inc/func.php');
   include (dirname(__FILE__).'/../../inc/lib_ouf.php');

	if (isset($_POST['idNews']))
	  {
		 $idNews = GetFormValue($_POST['idNews']);
		 $idKomments = GetFormValue($_POST['idKomments']);
		 $komment = $db->query('select * from `komments` where `id` = ?i',array($idKomments), 'row');
		 $user = $db->query('select * from `users` where `id` = ?i',array($komment['user_id']), 'row');
		 $author_r = iconv('windows-1251', 'utf-8',  $user['us_name']);

		 echo json_encode(array("author_r" => iconv('windows-1251', 'utf-8', $user['us_name']),
										"email_r" => $user['email'],
										"url_r" => $user['cite'],
										"comment_r" => iconv('windows-1251', 'utf-8', $komment['text'])));
	  }