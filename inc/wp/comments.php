<?php
	/**
	 * Created by JetBrains PhpStorm.
	 * User: Jurii
	 * Date: 20.08.13
	 * Time: 1:39
	 * To change this template use File | Settings | File Templates.
	 */
function printKoment($newsId)
{
	//  $pattern = 'SELECT u.*, k.* FROM komments k, users u WHERE k.news_id = ?i AND k.user_id = u.id ORDER BY k.parents_id, k.data ASC';
	//  $pattern = 'SELECT k.* FROM komments k LEFT JOIN users u ON k.news_id = ?i and k.user_id = u.id ORDER BY k.parents_id, k.data ASC';
	//  $pattern = 'SELECT k.*, u.url, u.us_name, u.email FROM komments k LEFT JOIN users u ON k.news_id = ?i and k.user_id = u.id  ORDER BY k.parents_id, k.data ASC';
	$pattern  = 'SELECT k.*, u.url, u.us_name, u.email FROM komments k LEFT JOIN users u ON k.user_id = u.id WHERE k.news_id = ?i ORDER BY k.parents_id, k.data ASC';
	$komments = go\DB\query($pattern, array($newsId), 'assoc');

	/*
	  include( __DIR__ . '/../inc/Gravatar.php');
	  $gravatar = new \emberlabs\GravatarLib\Gravatar();
	  // example: setting default image and maximum size
	  $gravatar->setDefaultImage('mm') ->setAvatarSize(150);
	//  $gravatar->setDefaultImage('http://aleks.od.ua/path/to/image.png');
	  // example: setting maximum allowed avatar rating
	  $gravatar->setMaxRating('G');
	  $avatar = $gravatar->buildGravatarURL('aleksjurii@gmail.com');*/
	?>
	<script type="text/javascript" src="/inc/wp/comment-reply.js"></script>

	<ol class="commentlist">
		<?
		/**
		 *
		 * печать подкоментариев
		 * @param $komments
		 * @param $id
		 *
		 * @return string
		 */
		function commentChildren(&$komments, $id) {

			$rez = '';
			$n   = true;
			foreach ($komments as $key2 => $post) {
				if (isset($post['parents_id']) && $post['parents_id'] == $id) {
					if (isset($komments[$key2]['parents_id'])) {
						unset($komments[$key2]['parents_id']);
					}
					if ($n) {
						$rez .= "<ul class='children'>";
					}
					$rez .= commentParents($post, $komments);
					if ($n) {
						$rez .= "</ul>";
						$n = false;
					}
				}
			}
			return $rez;
		}


		/**
		 * печать коментария
		 * @param $post
		 * @param $komments
		 *
		 * @return string
		 */
		function commentParents($post, &$komments) {

			$email   = ($post['email_komm']) ? $post['email_komm'] : $post['email'];
			$us_name = ($post['us_name_komm']) ? $post['us_name_komm'] : $post['us_name'];
			$url     = ($post['url_komm']) ? $post['url_komm'] : $post['url'];
			$url     = preg_replace("#https?://#i", '', $url);
			$urlUser = ($url) ? "<noindex><a class='url' href='http://{$url}' rel='nofollow' target='_blank'>{$us_name}</a></noindex>" : $us_name;
			$gravatar = get_gravatar($email, true);
			$rez      = "<li id='comment-{$post['id']}' class='comment even'>";
			$rez .= "<div id= 'div-comment-{$post['id']}' class='comment-body'>
				<div class='comment-author vcard'>
				  {$gravatar}
				<cite class='fn'>
				  {$urlUser}
				</cite>
				<span class='says'>:</span>
				</div>
				<div class='comment-meta commentmetadata'>
					<a href='http://{$_SERVER['HTTP_HOST']}{$_SERVER['REQUEST_URI']}#comment-{$post['id']}'>".dateToRus($post['data'], '%DAYWEEK%, j %MONTH% Y, G:i')."</a>
				</div>
				<p>{$post['text']}</p>
				<div class='reply'>
				  <a onclick=\"edCanvas = document.getElementById('comment'); return addComment.moveForm('div-comment-{$post['id']}', '{$post['id']}', 'respond', '{$post['id']}', '{$post['news_id']}');\"
				  href=\"index.php?replytocom=".$post['id']."#respond\">Ответить</a>

				  ".if_adm("<a onclick=\"edCanvas = document.getElementById('comment_r'); $('#redaktor').toggle();
				      $('#respond').toggle(); $('#cancel-comment-reply-link').toggle();
						ajaxPostNews('/inc/wp/ajaxPostNews.php', '', 'idKomments={$post['id']}&idNews={$post['news_id']}');
						return addComment.moveForm('div-comment-{$post['id']}', '{$post['parents_id']}', 'redaktor', '{$post['id']}', '{$post['news_id']}'); \"
				      href=\"index.php?replytocom={$post['id']}#redaktor\">Редактировать</a>
				      <a onclick=\"ajaxPostDel('/inc/wp/ajaxPostNews.php', 'idDelKomments={$post['id']}'); \"
				      href=\"index.php?replytocom={$post['id']}#redaktor\">Удалить</a>
				    ")."

				</div>
				</div>";
			$rez .= commentChildren($komments, $post['id']);
			$rez .= "</li>";
			return $rez;
		}

		/**
		 * @param $komments
		 * печать ветки коментариев из одной строки
		 *
		 * @return string
		 */
		function comments($komments) {

			$rez = '';
			foreach ($komments as $key => $post) {
				if (isset($komments[$key]['parents_id'])) {
					unset($komments[$key]['parents_id']);
					$rez .= commentParents($post, $komments);
				}
			}
			return $rez;
		}

		echo comments($komments);

		$respond = (if_adm('')) ? "Присоединяйтесь к обсуждению!" : "Ответить";
		$idKomment = go\DB\query('SELECT `id` FROM `komments` ORDER BY `id` DESC LIMIT 1')->el();

		?>
	</ol>


	<div id="respond">
		<div class="block">
			<h2><?=$respond?></h2>

			<div class="cancel-comment-reply">
				<small><a rel="nofollow" id="cancel-comment-reply-link" style="display:none;" href="#respond">Нажмите, чтобы
						отменить ответ.</a></small>
			</div>
			<form action="/canon68452/index.php?page=8" method="post" id="commentform">
				<p>
					<input type="text" name="author" id="author" value="<?= if_adm('Jurii') ?>" size="22" tabindex="1" class="textarea"/>
					<label for="author">
						<small>Имя (обязательно)</small>
					</label></p>
				<p>
					<input type="text" name="email" id="email" value="<?= if_adm('aleksjurii@gmail.com') ?>" size="22" tabindex="2" class="textarea"/>
					<label for="email">
						<small>E-mail (не публикуется) (обязательно)</small>
					</label></p>
				<p>
					<input type="text" name="url" id="url" value="<?= if_adm('http://www.aleks.od.ua') ?>" size="22" tabindex="3" class="textarea"/>
					<label for="url">
						<small>Ваш сайт</small>
					</label></p>
				<div id="comment_quicktags">
					<script src="/inc/wp/wp-comment-quicktags-plus.php" type="text/javascript"></script>
					<script type="text/javascript">edToolbar();</script>
				</div>
				<p><textarea name="comment" id="comment" cols="100%" rows="10" tabindex="4"></textarea></p>
				<?=if_login_not_admin("<p class='terms'>Отправляя кoммeнтapий, Вы автоматически принимаете <a href='#t4'
		                       onclick=\"view('t4'); return false\">правила кoммeнтиpoвaния</a> на нашем сайте.</p>
		<div id='t4' class='terms'>
		  <h3>Правила кoммeнтиpoвaния на сайте ".$_SERVER['HTTP_HOST'].":</h3>
		  <ol>
			 <li>Во избежание захламления спамом, <strong>первый кoммeнтapий</strong> всегда проходит премодерацию.</li>
			 <li>В поле \"<strong>Ваш сайт</strong>\" лучше указывать ссылку на главную страницу вашего сайта/блога. Ссылки на прочую веб-лабуду (в том числе блоги/сплоги, <strong>созданные не для людей</strong>) будут удалены.</li>
			 <li>Не используйте в качестве имени комментатора <strong>слоганы/названия сайтов, рекламные фразы, ключевые</strong> и т.п. слова. В случае несоблюдения этого условия, имя изменяю на свое усмотрение. Просьба указывать нормальное имя или ник.</li>
			 <li>Комментарии не по теме удаляются без предупреждения.</li>
		  </ol>
		</div>");
				?>
				<p><input id='preview' type='submit' name='preview' tabindex='5' class='Cbutton' value='Предпросмотр'/>
					<input id='submit' type='submit' name='insert' tabindex='6' style='font-weight: bold' class='Cbutton' value='Отправить &raquo;'/>
					<input type='hidden' name='comment_post_ID' value="<?= $idKomment ?>" id='comment_post_ID'/>
					<input type='hidden' name='comment_parent' id='comment_parent' value="0"/>
					<input type='hidden' name='news_id' id='news_id' value="<?= $newsId ?>"/>
				</p>
				<?=if_login_not_admin("<p style='display: none;'><input type='hidden' id='akismet_comment_nonce' name='akismet_comment_nonce' value='4447100622' /></p>
		<p style='clear: both;' class='subscribe-to-comments'>
		  <input type='checkbox' name='subscribe' id='subscribe' value='subscribe' style='width: auto;' />
		  <label for='subscribe'>Оповещать о новых комментариях по почте</label>
		</p>");
				?>
				<script type="text/javascript">
					<!--
					edCanvas = document.getElementById('comment');
					//-->
				</script>
			</form>
			<?=if_login_not_admin("<form action='' method='post'>
		<input type='hidden' name='solo-comment-subscribe' value='solo-comment-subscribe' />
		<input type='hidden' name='postid' value='1481' />
		<input type='hidden' name='ref' value='{$_SERVER['HTTP_HOST']}{$_SERVER['REQUEST_URI']}%2Fcomment-page-1%3Freplytocom%3D2392' />
		<p class='solo-subscribe-to-comments'>
		  Подписаться не комментируя:	<br />
		  <label for='solo-subscribe-email'>E-mail:	<input type='text' name='email' id='solo-subscribe-email' size='22' value='' /></label>
		  <input type='submit' name='submit' value='Подписаться &raquo;' />
		</p>
	 </form>");
			?>
		</div>
	</div>

	<div id="redaktor" style="display:none;">
		<div class="block">
			<h2>Редактировать</h2>

			<div class="cancel-comment-reply">
				<small>
					<a rel="nofollow" id="cancel-redaktor-reply-link" href="#redaktor">Нажмите, чтобы отменить ответ.</a>
				</small>
			</div>

			<form action="/canon68452/index.php?page=8" method="post" id="commentform">
				<p><input type="text" name="author" id="author_r" value="" size="22" tabindex="1" class="textarea"/>
					<label for="author">
						<small>Имя (обязательно)</small>
					</label></p>
				<p><input type="text" name="email" id="email_r" value="" size="22" tabindex="2" class="textarea"/>
					<label for="email">
						<small>E-mail (не публикуется) (обязательно)</small>
					</label></p>
				<p><input type="text" name="url" id="url_r" value="" size="22" tabindex="3" class="textarea"/>
					<label for="url">
						<small>Ваш сайт</small>
					</label></p>
				<div id="comment_quicktags">
					<script src="/inc/wp/wp-comment-quicktags-plus.php" type="text/javascript"></script>
					<script type="text/javascript">edToolbar();</script>
				</div>
				<p>
					<label for="comment_r"></label><textarea name="comment_r" id="comment_r" cols="100%" rows="10" tabindex="4"></textarea>
				</p>

				<p>
					<input id="preview_r" type="submit" name="preview" tabindex="5" class="Cbutton" value="Предпросмотр"/>
					<input id="submit" type="submit" name="update" tabindex="6" style="font-weight: bold" class="Cbutton" value="Отправить &raquo;"/>
					<input type='hidden' name='comment_post_ID_r' value="" id='comment_post_ID_r'/>
					<input type='hidden' name='comment_parent_r' id='comment_parent_r' value=""/>
					<input type='hidden' name='news_id_r' id='news_id_r' value=""/>
				</p>
			</form>

		</div>
	</div>

<?
}