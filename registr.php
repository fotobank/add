<?php include ('inc/head.php');
?>
	<div id="main">


		<div style="text-align: center;">
			<div>
				<h2><b>
						<hremind>����������� �� �����:</hremind>
					</b></h2>
			</div>
		</div>
		<br>

		<div id="for_reg_cont">
			����������� ���������� ��� ��������, ������� ��� ����������� ���������� ���������� �� ���������. ��� ����
			������������������ �������������, ������� ����������� ������� � ������������ �� ����������, �������������
			��������� ������ � �����, � ��� �������������, ��� ���������� ������� ���� � ����� ��������� �������� � �������
			- ���������� ������ �� ���������������� ������������. <br> ����������, ����������� ��������� ��� ���� � �������
			������ "���������". ���������� ������� ������������ email, �� ���� ����� ��������� ������ ��� ����������
			��������� ���� ����������. ��������! � ����� ������������, ������ �� ����������� ���� ����� � ������! ������ �
			����� ����� �������� ������ �� ��������� ����, ���� ��� �������������. ���������� ������������ ������ ������
			������ ���� ��������, ���������� � ���� �����, � ����� ������� � ��������� �����.
		</div>
		<br>

		<div id="form_reg">

			<?
			     $frm_reg='inline';
			if ($_SERVER['REQUEST_METHOD'] == 'POST')
				{
					$rLogin = trim($_POST['rLogin']);
					$rPass = trim($_POST['rPass']);
					$rPass2 = trim($_POST['rPass2']);
					$rEmail = trim($_POST['rEmail']);
					$rName_us = trim($_POST['rName_us']);
					if ($rLogin == '')
						{
							echo("<div align='center' class='err_f_reg'>���� '�����' �� ���������!</div>");
							// ����� ����� �������� �� ����, ���� � �������������
						}
					elseif (!preg_match("/^\w{3,}$/", $rLogin))
						{
							die("<div align='center' class='err_f_reg'>� ���� '�����' ������� ������������ �������.<dr>����������� ������ ��������� �������!</div>");
						}
					if ($rEmail == '')
						{
							die("<div align='center' class='err_f_reg'>���� 'E-mail' �� ���������</div>");
							// ��������� e-mail �� ������������
						}
					elseif (!preg_match("/^[a-zA-Z0-9_\.\-]+@([a-zA-Z0-9\-]+\.)+[a-zA-Z]{2,6}$/", $rEmail))
						{
							die("<div align='center' class='err_f_reg'>��������� 'E-mail' ����� ������������ ������</div>");
						}
					if ($rPass == '' || $rPass2 == '')
						{
							die("<div align='center' class='err_f_reg'>���� '������' �� ���������</div>");
						}
					elseif ($rPass !== $rPass2)
						{
							die("<div align='center' class='err_f_reg'>������ �� ���������</div>");
							// ������ ����� �������� �� ����, ���� � �������������
						}
					elseif (!preg_match("/^\w{3,}$/", $rPass))
						{
							die("<div align='center' class='err_f_reg'>� ���� '������' ������� ������������ �������.����������� ������ ��������� ������� � �����!</div>");
						}
					// � ���� ������ � ��� ����� ��������� md5-��� ������
					$mdPassword = md5($rPass);
//   $mdPassword = $rPass;
					// � ����� ��������� ����� (����� - �����)
					$cnt = intval(mysql_result(mysql_query(
						'select count(*) cnt from users where login = \''.mysql_escape_string($rLogin).'\''), 0));
					if ($cnt > 0)
						{
							die('����������� � ����� ������� ��� ����������!');
						}
					$cnt = intval(mysql_result(mysql_query(
						'select count(*) cnt from users where email = \''.mysql_escape_string($rEmail).'\''), 0));
					if ($cnt > 0)
						{
							die('����������� � ����� e-mail ��� ����������!');
						}
					$time = time();
					// ������������� ���������� � ��(�� �������� ���������� ���� �������� ������-�����-������)
					mysql_query("INSERT INTO users (login, pass, email, us_name, timestamp)
                   VALUES ('$rLogin','$mdPassword','$rEmail','$rName_us',$time)");
					if (mysql_error() != "")
						{
							die("<div align='center' class='err_f_reg'>������������ � ����� ������� ��� ����������, �������� ������.</div>");
						}
					// �������� Id, ��� ������� ���� ��������� � ����
					$id = mysql_result(mysql_query("SELECT LAST_INSERT_ID()"), 0);
// ���������� "keystring" ��� ���������
					$key = md5(substr($rEmail, 0, 2).$id.substr($rLogin, 0, 2));
					$date = date("d.m.Y", $time);
// ��������� ������
					$title = '����������� ����������� �� ����� Creative line studio';
					$headers = "Content-type: text/plain; charset=windows-1251\r\n";
					$headers .= "From: ������������� Creative line studio <webmaster@aleks.od.ua> \r\n";
//$headers .= "From: webmaster@aleks.od.ua <webmaster@aleks.od.ua> \r\n";
					$subject = '=?koi8-r?B?'.base64_encode(convert_cyr_string($title, "w", "k")).'?=';
					$letter = <<< LTR
   ������������, $rName_us.
   �� ������� ������������������ �� Creative line studio.
   ����� ��������� �������� ��� ������ �������� ����������, ������� ��� ����������� �� ������������� ����������.
   ��� �� ��� ���� ������������������ ������������� ������������� ��������� ������ � ������.
   ���� ��������������� ������:
      �����: $rLogin
      ������: $rPass

   ��� ��������� �������� ��� ������� ������ �� ������:
   http://aleks.od.ua/activation.php?login=$rLogin&key=$key

   ������ ������ ����� �������� � ������� 5 ����.

   $date
LTR;
// ���������� ������
					if (!mail($rEmail, $subject, $letter, $headers))
						{
							// ���� ������ �� �����������, ������� ����� �� ����
							mysql_query("DELETE FROM users WHERE login='".$rLogin."' LIMIT 1");
							echo "<div align='center' class='err_f_reg'>��������� ������ ��� �������� ������. ���������� ������������������ ��� ���.</div>";
						}
					else
						{
							$frm_reg = 'none';
							echo "<div align='center' class='err_f_reg'>�� ������� ������������������ � �������.
   <br>�� ��������� ����
   e-mail ���� ���������� ������ �� ������� ��� ��������� ��������.
   </div>";
						}
				}

			?>

			<form action="" method="post" enctype="multipart/form-data" style="display:<?= $frm_reg ?>">
				<table>
					<tr>
						<td> �����:</td>
						<td><input class="inp_f_reg" name="rLogin"></td>
					</tr>
					<tr>
						<td> ������:</td>
						<td><input class="inp_f_reg" type="password" name="rPass"></td>
					</tr>
					<tr>
						<td>������ ��� ���:</td>
						<td><input class="inp_f_reg" type="password" name="rPass2"></td>
					</tr>
					<tr>
						<td>���� ���:</td>
						<td><input name="rName_us" class="inp_f_reg" type="text"></td>
					</tr>
					<tr>
						<td>E-mail:</td>
						<td><input name="rEmail" class="inp_f_reg" type="text"></td>
					</tr>
				</table>
				<br>

				<div align="center"><input class="metall_knopka" name="ok" type="submit" value="���������"></div>
			</form>
		</div>
	</div>
	<div class="end_content"></div>
	</div>
<?php include ('inc/footer.php');
?>