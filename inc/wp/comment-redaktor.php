<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Jurii
 * Date: 27.08.13
 * Time: 1:55
 * To change this template use File | Settings | File Templates.
 */

  if ( 'POST' != $_SERVER['REQUEST_METHOD'] ) {
	 header('Allow: POST');
	 header('HTTP/1.1 405 Method Not Allowed');
	 header('Content-Type: text/plain');
	 exit;
  }

  $comment_author_email = ( isset($_POST['email']))       	 ? trim($_POST['email']) : null;
  $comment_author       = ( isset($_POST['author']))      	 ? trim(strip_tags($_POST['author'])) : null;
  $comment_author_url   = ( isset($_POST['url']))         	 ? trim($_POST['url']) : null;

  if (isset($_POST['update'])) {

	 $news_id              = ( isset($_POST['news_id_r']))     	 ? trim($_POST['news_id_r']) : 0;
	 $comment_parent       = (isset($_POST['comment_parent_r']))  ? intval($_POST['comment_parent_r']) : 0;
	 $comment_post_ID      = (isset($_POST['comment_post_ID_r'])) ? intval($_POST['comment_post_ID_r']) : 0;
	 $comment_content      = ( isset($_POST['comment_r']))        ? trim($_POST['comment_r']) : null;

	 $set = array( 'news_id' 	 => $news_id,
		            'parents_id' => $comment_parent,
						'text'		 => $comment_content,
						'email_komm'	 => $comment_author_email,
						'us_name_komm'	 => $comment_author,
						'url_komm' 		 => $comment_author_url );

	 go\DB\query('UPDATE `komments` SET ?set WHERE `id` = ?i', array($set, $comment_post_ID));
  }


  if (isset($_POST['insert'])) {

	 $news_id              = ( isset($_POST['news_id']))     	 ? trim($_POST['news_id']) : 0;
	 $comment_parent       = (isset($_POST['comment_parent']))  ? intval($_POST['comment_parent']) : 0;
	 $comment_content      = ( isset($_POST['comment']))        ? trim($_POST['comment']) : null;

	 if(isset($_SESSION['logged']) && $_SESSION['logged'])
		{
		$pattern = 'INSERT INTO komments (news_id, parents_id , text, data, user_id) VALUES (?i, ?i, ?string, ?i, ?i)';
		$dt    = array($news_id, $comment_parent, $comment_content, time(), $_SESSION['userid']);
		} else {
		$pattern = 'INSERT INTO komments (news_id, parents_id , text, data, email_komm, us_name_komm, url_komm) VALUES (?i, ?i, ?string, ?i, ?string, ?string, ?string)';
		$dt    = array($news_id, $comment_parent, $comment_content, time(), $comment_author_email, $comment_author, $comment_author_url);
	   }
	   go\DB\query($pattern, $dt);
  }