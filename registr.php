<?php
include (dirname(__FILE__).'/inc/head.php');
?>
	<div id="main">
		<div style="text-align: center">
			<div>
				<h2 style="margin-top: 30px;"><b>
						<hremind>����������� �� �����:</hremind>
					</b></h2>
			</div>
		</div>
		<br>


			<p id="for_reg_cont">
			����������� ���������� ��� ��������, ������� ��� ����������� ���������� ���������� �� ���������. ��� ����
			������������������ �������������, ������� ����������� ������� � ������������ �� ����������, �������������
			��������� ������ � �����, � ��� �������������, ��� ���������� ������� ���� � ����� ��������� �������� � �������
			- ���������� ������ �� ���������������� ������������. </p>
			<p id="for_reg_cont">����������, ����������� ��������� ��� ���� � �������
			������ "���������". ���������� ������� ������������ email, �� ���� ����� ��������� ������ ��� ����������
			��������� ���� ����������. ��������! � ����� ������������, ������ �� ����������� ���� ����� � ������! ������ �
			����� ����� �������� ������ �� ��������� ����, ���� ��� �������������. ���������� ������������ ������ ������
			������ ������ ��������, ���������� � ���� �����, � ����� ������� � ��������� �����.
			</p>

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
					$rIp =  Get_IP(); // Ip ������������
					if ($rLogin == '')
						{
							echo("<div align='center' class='err_f_reg'>���� '�����' �� ���������!</div>");
							// ����� ����� �������� �� ����, ���� � �������������
						}
					elseif (!preg_match("/[?a-zA-Z�-��-�0-9_-]{3,16}$/", $rLogin))
						{
							die("<div align='center' class='err_f_reg'>����� ����� �������� �� ����, ����, ������� � �������������. ����� �� 3 �� 16 ��������.</div>");
						}
					if ($rEmail == '')
						{
							die("<div align='center' class='err_f_reg'>���� 'E-mail' �� ���������</div>");
							// ��������� e-mail �� ������������
						}
				//	elseif (!preg_match("/^[a-zA-Z0-9_\.\-]+@([a-zA-Z0-9\-]+\.)+[a-zA-Z]{2,6}$/", $rEmail))
						elseif (!preg_match("/[0-9a-z_]+@[0-9a-z_^\.-]+\.[a-z]{2,3}/i", $rEmail))
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
					$cnt = intval($db->query('select count(*) cnt from users where login = ?string',array($rLogin),'el'));
					if ($cnt > 0)
						{
							die('������������ � ����� ������� ��� ����������!');
						}
					$cnt = intval($db->query(
						'select count(*) cnt from users where email = ?string',array($rEmail), 'el'));
					if ($cnt > 0)
						{
							die('������������ � ����� e-mail ��� ����������!');
						}
					$time = time();
					// ������������� ���������� � ��(�� �������� ���������� ���� �������� ������-�����-������)
					$id = $db->query('INSERT INTO users (login, pass, email, us_name, timestamp, ip)
                             VALUES (?,?,?,?,?,?)', array($rLogin,$mdPassword,$rEmail,$rName_us,$time,$rIp), 'id');
					if (mysql_error() != "")
						{
							die("<div align='center' class='err_f_reg'> '".mysql_error()."' </div>");
						}
					// �������� Id, ��� ������� ���� ��������� � ����
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
							$db->query('DELETE FROM users WHERE login= ?string LIMIT 1', array($rLogin));
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
						<td style="padding-right: 10px">������ ��� ���:</td>
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