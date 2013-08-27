<?php
/**
 * Handles Comment Post to WordPress and prevents duplicate comment posting.
 *
 * @package WordPress
 */

if ( 'POST' != $_SERVER['REQUEST_METHOD'] ) {
	header('Allow: POST');
	header('HTTP/1.1 405 Method Not Allowed');
	header('Content-Type: text/plain');
	exit;
}


$comment_post_ID      = isset($_POST['comment_post_ID']) ? intval($_POST['comment_post_ID']) : 0;
$comment_parent       = isset($_POST['comment_parent'])  ? intval($_POST['comment_parent']) : 0;
$comment_Id           = ( isset($_POST['comment_Id']))   ? trim($_POST['comment_Id']) : 0;
$comment_author       = ( isset($_POST['author']))       ? trim(strip_tags($_POST['author'])) : null;
$comment_author_email = ( isset($_POST['email']))        ? trim($_POST['email']) : null;
$comment_author_url   = ( isset($_POST['url']))          ? trim($_POST['url']) : null;
$comment_content      = ( isset($_POST['comment']))      ? trim($_POST['comment']) : null;


	 ?>
  <div class="block">
    <h2 id="comments">Предватительный просмотр</h2>
		 <ol class="commentlist">
			  <li id='comment-<?=$comment_post_ID?>' class='comment even'>
				 <div id= 'div-comment-<?=$comment_post_ID?>' class='comment-body'>
						<div class='comment-author vcard'>
						  <?php echo get_gravatar($comment_author_email, true); ?>
						<cite class='fn'>
						  <noindex>
							 <a class='url' href='<?=$comment_author_url?>' rel='nofollow' target='_blank'><?=$comment_author?></a>
						  </noindex>
						</cite>
						<span class='says'>:</span>
						</div>
						<div class='comment-meta commentmetadata'>
			<a href='http://<?=$_SERVER['HTTP_HOST']?><?=$_SERVER['REQUEST_URI']?>#comment-<?=$comment_post_ID?>'><?=dateToRus( time(), '%DAYWEEK%, j %MONTH% Y в G:i')?></a>
						</div>
						 <p>
							<strong id='previewed-comment-header'>Так будет выглядеть ваш комментарий:</strong>
						 </p>
						<p><?=$comment_content?></p>
						<div class='reply'>
						  <a href="/canon68452/index.php#redaktor">Отмена</a>
						  <a onclick="ajaxPostNews('/canon68452/ajax/ajaxPostNews.php', '', 'idKomments=<?=$comment_post_ID?>&idNews=<?=$post['news_id']?>');"
						  href="/canon68452/index.php#redaktor">Ответить</a>
						</div>
					</div>
			  </li>
		  </ol>
  </div>