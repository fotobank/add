<?php include (dirname(__FILE__).'/inc/head.php');
?>

<div id="main">
	<h2 style="margin: 30px 0 30px 0"><hremind>���������:</hremind></h2>
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
						$db->query("SELECT `id`, `email`, `status`, `timestamp` FROM `users` WHERE `login`=(?string)  LIMIT 1",
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
							$db->query("DELETE FROM users WHERE login= ? LIMIT 1", array($login));
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
							$db->query("UPDATE users SET status = 1 WHERE login='$login'");
							echo "<div id='form_act'> ��������� ������ �������.</div>";
						}
				}
			$db->close();
		}
	?>

	<div class="end_content"></div>

<?php include (dirname(__FILE__).'/inc/footer.php');
?>