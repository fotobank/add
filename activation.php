<?php
			define ( 'BASEPATH' , realpath ( __DIR__ ) . '/' , TRUE );
			include (dirname(__FILE__).'/inc/head.php');
?>

<div id="main">
	<div class="cont-list" style="margin: 20px 0 0 39%"><div class="drop-shadow curved curved-vt-2">
			<h2><b><span style="color: #001591">��������� ������:</span></b></h2>
		</div></div>
	<div style="clear: both; margin-bottom: 20px"></div>

	<?
	if (isset($_GET['login']) && isset($_GET['key']))
		{
			$login = $_GET['login'];
			$key   = $_GET['key'];
// ������ �������� login �� ��������� �������
			if (!preg_match("/^\w{3,}$/", $login))
				{
					echo('������������ ������!');
				}
			else
				{
					$time = time();
					$user =
						go\DB\query("SELECT `id`, `email`, `status`, `timestamp` FROM `users` WHERE `login`=(?string)  LIMIT 1",
							array($login),
							'numeric');
// ���� �� ������������ � ����� �������?
					if (!$user)
						{
							echo("<div id='form_act'>������ ������������ ���!</div>");
						}
// ����� �� ��� �������?
					elseif ($user[2] == 1)
						{
							echo("<div id='form_act'><b>������ ����� ��� �����������!</b></div>");
						}
// ����� �� ���� ������������ �����? (���� ��� - ������� �� ����)
					elseif ($user[3] - $time > 5 * 24 * 60 * 60)
						{
							go\DB\query("DELETE FROM users WHERE login= ? LIMIT 1", array($login));
							echo("<div id='form_act'>���� ��������� ����! ���������������, ����������, ������.</div>");
						}
// �������� "keystring"
					elseif ($key != md5(substr($user[1], 0, 2).$user[0].substr($login, 0, 2)))
						{
							echo("<div id='form_act'>������������ ����������� �����!</div>");
						}
					else
						{
// ���� ��� �������� �������� - ���������� �����!
							go\DB\query("UPDATE users SET status = 1 WHERE login='$login'");
							echo "<div id='form_act'> ��������� ������ �������.</div>";
						}
				}
			go\DB\Storage::getInstance()->get()->close();
		}
	?>
</div></div>
	<div class="end_content"></div>

<?php include (dirname(__FILE__).'/inc/footer.php');
?>