<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Jurii
 * Date: 22.08.13
 * Time: 18:35
 * To change this template use File | Settings | File Templates.
 */

	include (dirname(__FILE__).'/../../inc/config.php');
	include (dirname(__FILE__).'/../../inc/func.php');


  // передать данные  в форму
	if (isset($_POST['idNews']))
	  {
		 $idNews 	 = GetFormValue($_POST['idNews']);
		 $idKomments = GetFormValue($_POST['idKomments']);
		 $komment 	 = go\DB\query('select * from `komments` where `id` = ?i',array($idKomments), 'row');
		 $user	 	 = go\DB\query('select * from `users` where `id` = ?i',array($komment['user_id']), 'row');
		 $author_r	 = iconv('windows-1251', 'utf-8',  $user['us_name']);

		 $email 	 =  ($komment['email_komm'])?$komment['email_komm']:$user['email'];
		 $us_name =  ($komment['us_name_komm'])?$komment['us_name_komm']:$user['us_name'];
		 $url		 =  ($komment['url_komm'])?$komment['url_komm']:$user['url'];

		 echo json_encode(array("author_r"  => iconv('windows-1251', 'utf-8', $us_name),
										"email_r"   => $email,
										"url_r" 	   => $url,
										"comment_r" => iconv('windows-1251', 'utf-8', $komment['text'])));
	  }

  // записать комент
  if (isset($_POST['comment_upd']) && $_POST['comment_upd'] == 0)
	 {
		$newsId					 = $_POST['newsId'];
		$idKomments 			 = $_POST['idKomments'];
		$content					 = iconv ( 'utf-8', 'windows-1251', $_POST['content']);
		$comment_parent		 = $_POST['comment_parent'];
		$comment_author_email = $_POST['email_komm'];
		$comment_author		 = iconv ( 'utf-8', 'windows-1251',  $_POST['us_name_komm']);
		$comment_author_url	 = $_POST['url_komm'];

		$pattern = 'INSERT INTO komments (news_id, parents_id , text, data, email_komm, us_name_komm, url_komm) VALUES (?i, ?i, ?string, ?i, ?string, ?string, ?string)';
		$dt = array($newsId, $comment_parent, $content, time(), $comment_author_email, $comment_author, $comment_author_url);
		go\DB\query($pattern, $dt);
	 }

  // изменить контент
  if (isset($_POST['comment_upd']) && $_POST['comment_upd'] == 1)
	 {

		  $comment_author_email = ( isset($_POST['email_komm']))       ? trim($_POST['email_komm']) : null;
		  $comment_author       = ( isset($_POST['us_name_komm']))     ? trim(strip_tags(iconv( 'utf-8', 'windows-1251',  $_POST['us_name_komm']))) : null;
		  $comment_author_url   = ( isset($_POST['url_komm']))         ? trim($_POST['url_komm']) : null;
		  $news_id              = ( isset($_POST['newsId']))     		? trim($_POST['newsId']) : 0;
		  $comment_parent       = (isset($_POST['comment_parent']))		? intval($_POST['comment_parent']) : 0;
		  $idKomments           = (isset($_POST['idKomments']))	      ? intval($_POST['idKomments']) : 0;
		  $comment_content      = ( isset($_POST['content']))       	? trim(iconv( 'utf-8', 'windows-1251', $_POST['content'])) : null;

		  $set = array( 'news_id' 		 => $news_id,
							 'parents_id' 	 => $comment_parent,
							 'text'			 => $comment_content,
							 'email_komm'	 => $comment_author_email,
							 'us_name_komm' => $comment_author,
							 'url_komm' 	 => $comment_author_url );

		  go\DB\query('UPDATE `komments` SET ?set WHERE `id` = ?i', array($set, $idKomments));
	  }


  // Удаление комментов
  if (isset($_POST['idDelKomments'])) {

	 $id = trim($_POST['idDelKomments']);
	 go\DB\query('delete from `komments` where `id` = ?i', array($id));
	 echo 'Комментарий удален';

}