<?php
/**
 * Handles Comment Post to WordPress and prevents duplicate comment posting.
 *
 * @package WordPress
 */
if ('POST' != $_SERVER['REQUEST_METHOD']) {
	header('Allow: POST');
	header('HTTP/1.1 405 Method Not Allowed');
	header('Content-Type: text/plain');
	exit;
}

if (isset($_POST['comment'])) {
	$comment_post_ID = isset($_POST['comment_post_ID']) ? intval($_POST['comment_post_ID']) : 0;
	$comment_parent  = isset($_POST['comment_parent']) ? intval($_POST['comment_parent']) : 0;
	$news_id         = isset($_POST['news_id']) ? intval($_POST['news_id']) : 0;
	$comment_content = (isset($_POST['comment'])) ? trim($_POST['comment']) : NULL;
	$comment_upd     = 0;
}
else {
	$comment_post_ID = isset($_POST['comment_post_ID_r']) ? intval($_POST['comment_post_ID_r']) : 0;
	$comment_parent  = isset($_POST['comment_parent_r']) ? intval($_POST['comment_parent_r']) : 0;
	$news_id         = isset($_POST['news_id_r']) ? intval($_POST['news_id_r']) : 0;
	$comment_content = (isset($_POST['comment_r'])) ? trim($_POST['comment_r']) : NULL;
	$comment_upd     = 1;
}
$comment_author = (isset($_POST['author'])) ? trim(strip_tags($_POST['author'])) : NULL;
$comment_author_email = (isset($_POST['email'])) ? trim($_POST['email']) : NULL;
$comment_author_url = (isset($_POST['url'])) ? trim($_POST['url']) : NULL;



?>
<div class="block">
	<h2 id="comments">Предватительный просмотр</h2>
	<ol class="commentlist">
		<li id='comment-<?= $comment_post_ID ?>' class='comment even'>
			<div id='div-comment-<?= $comment_post_ID ?>' class='comment-body'>
				<div class='comment-author vcard'>
					<?php echo get_gravatar($comment_author_email, true); ?>
					<cite class='fn'>
						<noindex>
							<a class='url' href='<?= $comment_author_url ?>' rel='nofollow' target='_blank'><?=$comment_author?></a>
						</noindex>
					</cite> <span class='says'>:</span>
				</div>
				<div class='comment-meta commentmetadata'>
					<a href='http://<?= $_SERVER['HTTP_HOST'] ?><?= $_SERVER['REQUEST_URI'] ?>#comment-<?= $comment_post_ID ?>'><?=dateToRus(time(), '%DAYWEEK%, j %MONTH% Y в G:i')?></a>
				</div>
				<p>
					<strong id='previewed-comment-header'>Так будет выглядеть ваш комментарий:</strong>
				</p>

				<p><?=$comment_content?></p>

				<div class='reply'>
					<a href="/canon68452/index.php#redaktor">Отменить</a>
					<a onclick="ajaxPostRec('/inc/wp/ajaxPostNews.php', {idKomments: '<?= $comment_post_ID ?>', newsId:'<?= $news_id ?>',comment_parent:'<?= $comment_parent ?>',content:'<?= $comment_content ?>',email_komm:'<?= $comment_author_email ?>',us_name_komm:'<?= $comment_author ?>',url_komm:'<?= $comment_author_url ?>',comment_upd:'<?= $comment_upd ?>'})" href="/canon68452/index.php#redaktor">Записать</a>
				</div>
			</div>
		</li>
	</ol>
</div>