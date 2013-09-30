<?php
			define ( 'BASEPATH' , realpath ( __DIR__ ) . '/' , TRUE );
			include (dirname(__FILE__).'/inc/head.php');
?>

<div id="main">
	<div class="cont-list" style="margin: 20px 0 0 39%"><div class="drop-shadow curved curved-vt-2">
			<h2><b><span style="color: #001591">Активация логина:</span></b></h2>
		</div></div>
	<div style="clear: both; margin-bottom: 20px"></div>

	<?
	if (isset($_GET['login']) && isset($_GET['key']))
		{
			$login = $_GET['login'];
			$key   = $_GET['key'];
// Делаем проверку login на нехорошие символы
			if (!preg_match("/^\w{3,}$/", $login))
				{
					echo('Неправильная ссылка!');
				}
			else
				{
					$time = time();
					$user =
						go\DB\query("SELECT `id`, `email`, `status`, `timestamp` FROM `users` WHERE `login`=(?string)  LIMIT 1",
							array($login),
							'numeric');
// Есть ли пользователь с таким логином?
					if (!$user)
						{
							echo("<div id='form_act'>Такого пользователя нет!</div>");
						}
// Может он уже активен?
					elseif ($user[2] == 1)
						{
							echo("<div id='form_act'><b>Данный логин уже активирован!</b></div>");
						}
// Успел ли юзер активировать логин? (если нет - удаляем из базы)
					elseif ($user[3] - $time > 5 * 24 * 60 * 60)
						{
							go\DB\query("DELETE FROM users WHERE login= ? LIMIT 1", array($login));
							echo("<div id='form_act'>Срок активации истёк! Регистрируйтесь, пожалуйста, заново.</div>");
						}
// Поверяем "keystring"
					elseif ($key != md5(substr($user[1], 0, 2).$user[0].substr($login, 0, 2)))
						{
							echo("<div id='form_act'>Неправильная контрольная сумма!</div>");
						}
					else
						{
// Если все проверки пройдены - активируем логин!
							go\DB\query("UPDATE users SET status = 1 WHERE login='$login'");
							echo "<div id='form_act'> Активация прошла успешно.</div>";
						}
				}
			go\DB\Storage::getInstance()->get()->close();
		}
	?>
</div></div>
	<div class="end_content"></div>

<?php include (dirname(__FILE__).'/inc/footer.php');
?>