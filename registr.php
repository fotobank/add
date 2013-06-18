<?php
 include (dirname(__FILE__).'/inc/head.php');
  if(isset($_SESSION['logged']))
  $_SESSION['err_msg'] = '�� ��� �����������������.';
  echo "<script>window.document.location.href='index.php'</script>";
?>
 <div id="main">
 <br>
 <?
 $rLogin = '��������� ��� �����';
 $rPass = '';
 $rPass2 = '';
 $rEmail = '������� E-mail';
 $rSkype = '�� �����������';
 $rPhone = '��� ������ ���������� �����������( ����� ������ ����� )';
 $rName_us = '������ ���';
 if ($_SERVER['REQUEST_METHOD'] == 'POST')
	{
	 $rLogin   = trim($_POST['rLogin']);
	 $rPass    = trim($_POST['rPass']);
	 $rPass2   = trim($_POST['rPass2']);
	 $rEmail   = trim($_POST['rEmail']);
	 $rName_us = trim($_POST['rName_us']);
	 $rPhone   = trim($_POST['rPhone']);
	 $rSkype   = trim($_POST['rSkype']);
	 $rPkey    = trim($_POST['rPkey']);
	 $rIp      = Get_IP();
	 if ($rLogin != '��������� ��� �����')
		{
		 if (preg_match("/[?a-zA-Z�-��-�0-9_-]{3,20}$/", $rLogin))
			{
			 if ($rEmail != '������� E-mail')
				{
				 if ($rName_us != '������ ���' || preg_match("/[?a-zA-Z�-��-�0-9_-]{2,20}$/", $rName_us))
					{
					 if (preg_match("/[0-9a-z_]+@[0-9a-z_^\.-]+\.[a-z]{2,3}/i", $rEmail))
						{
						 if ($rPass != '' || $rPass2 != '')
							{
							 if ($rPass === $rPass2)
								{
								 if (preg_match("/^\w{3,}$/", $rPass))
									{
									 $mdPassword = md5($rPass);
									 $cnt        = intval($db->query('select count(*) cnt from users where login = ?string',
										array($rLogin),
										'el'));
									 if ($cnt <= 0)
										{
										 $cnt = intval($db->query('select count(*) cnt from users where email = ?string',
											array($rEmail),
											'el'));
										 if ($cnt <= 0)
											{
											 if ($rPhone == '�� �����������')
												{
												 $rPhone = '';
												}
											 if ((strlen($rPhone) == '')
												|| (strlen($rPhone) >= 7)
												 && (!preg_match("/[%a-z_@.,^=:;�-�\"*()&$#�!?<>\~`|[{}\]]/i",
													$rPhone))
											 )
												{
												 if ($rSkype == '�� �����������')
													{
													 $rSkype = '';
													}
												 $time = time();
// �������� �����
												 if ($rPkey == chk_crypt($rPkey))
													{
// ������������� ���������� � ��(�� �������� ���������� ���� �������� ������-�����-������)
													 try
														{
// �������� Id, ��� ������� ���� ��������� � ����
														 $id = $db->query('INSERT INTO users (login, pass, email, us_name, timestamp, ip, phone, skype)
                             VALUES (?,?,?,?,?i,?,?,?)',
															array($rLogin, $mdPassword, $rEmail, $rName_us, $time, $rIp, $rPhone, $rSkype),
															'id');
														}
													 catch (go\DB\Exceptions\Exception  $e)
														{
														 trigger_error("������ ��� ������ � ����� ������ �� ����� ����������� ������������! ���� - registr.php.");
														 $err_msg = "������ ��� ������ � ����� ������!";
														 die("<div align='center' class='err_f_reg'>������ ��� ������ � ����� ������!</div>");
														}
// ���������� "keystring" ��� ���������
													 $key  = md5(substr($rEmail, 0, 2).$id.substr($rLogin,
														0,
														2));
													 $date = date("d.m.Y", $time);
// ��������� ������
													 $title   = '����������� ����������� �� ����� Creative line studio';
													 $headers = "Content-type: text/plain; charset=windows-1251\r\n";
													 $headers .= "From: ������������� Creative line studio <webmaster@aleks.od.ua> \r\n";
													 $subject = '=?koi8-r?B?'.base64_encode(convert_cyr_string($title,
														"w",
														"k")).'?=';
													 $letter
																		= <<< LTR
   ������������, $rName_us.
   �� ������� ������������������ �� Creative line studio.
   ����� ��������� �������� ��� ������ �������� ����������, ������� ��� ����������� �� ������������� ����������.
   ��� �� ��� ���� ������������������ ������������� ������������� ��������� ������ � ������.
   ���� ��������������� ������:
      �����: $rLogin
      ������: $rPass

   ��� ��������� �������� ��� ������� ������ �� ������:
   $_SERVER[DOCUMENT_ROOT]/activation.php?login=$rLogin&key=$key

   ������ ������ ����� �������� � ������� 5 ����.

   $date
LTR;
// ���������� ������
													 if (!mail($rEmail,
														$subject,
														$letter,
														$headers)
													 )
														{
														 // ���� ������ �� �����������, ������� ����� �� ����
														 $db->query('DELETE FROM users WHERE login= (?string) LIMIT 1',
															array($rLogin));
														 $err_msg
															= "��������� ������ ��� �������� ������.<br> ���������� ������������������ ��� ���.";
														}
													 else
														{
														 unset ($err_msg);
														 echo "<div align='center' class='err_f_reg'>�� ������� ������������������ � �������.
																											   <br>�� ��������� ����
																											   e-mail ���� ���������� ������ �� ������� ��� ��������� ��������.
																											   </div>";
														 print "<script language='Javascript' type='text/javascript'>
																												  <!--
																                                      humane.timeout = (6000);
                     humane.success('�������.<br>�� ������� ������������������ � �������.<br>�� ��������� ���� e-mail ���� ���������� ������ �� ������� ��� ��������� ��������.');
																												  function reLoad()
																												  {location = \"registr.php\"};
																												  setTimeout('reLoad()', 8000);
																												  -->
																												  </script>";
														}
													}
												 else
													{
													 $err_msg = "����������� ���� ������������ �����!";
													}

												}
											 else
												{
												 $err_msg = "������� ������ �����������! (������ ���� ������ 6 ����)";
												}
											}
										 else
											{
											 $err_msg
												= "������������ � ����� E-mail ��� ����������!<br>������� �� �������������� ������ ��� ����������������� �� ������ E-mail.";
											}
										}
									 else
										{
										 $err_msg = "������������ � ����� ������� ��� ����������!";
										}

									}
								 else
									{
									 $err_msg
										= "� ���� `������` ������� ������������ �������.<br> ����������� ������ ��������� ������� � �����!";
									}
								}
							 else
								{
								 $err_msg = "������ �� ���������!";
								}
							}
						 else
							{
							 $err_msg = "���� `������` �� ���������!";
							}
						}
					 else
						{
						 $err_msg = "��������� `E-mail` ����� ������������ ������!";
						}

					}
				 else
					{
					 $err_msg = "��������� ���� `���� ���`!";
					}
				}
			 else
				{
				 $err_msg = "���� `E-mail` �� ���������!";
				}

			}
		 else
			{
			 $err_msg = "����� ����� �������� �� ����, ����, ������� � �������������.<br> ����� �� 3 �� 20 ��������.";
			}
		}
	 else
		{
		 $err_msg = "���� `�����` �� ���������!";
		}
	 if (isset($err_msg))
		{
		 echo "<script language='Javascript' type='text/javascript'>
				      humane.timeout = (6000);
				      humane.error('������!<br>$err_msg');
			         </script>";
		}
	}
 ?>
 <div id="form_reg">

	<div class="cont-list" style="margin: 0 0 10px 80px">
	 <div class="drop-shadow curved curved-vt-2">
		<h2><b><span style="color: #001591">����������� �� �����:</span></b></h2>
	 </div>
	</div>
	<br><br>

	<form action="" method="post" enctype="multipart/form-data">
	 <table>
		<tr>
		 <td> �����:*</td>
		 <td>
			<input name="rLogin" class="inp_f_reg" title="����� ����� �������� �� ����, ����, ������� � �������������. ����� �� 3 �� 16 ��������." value="<?= $rLogin ?>" maxlength="20" data-placement="right">
		 </td>
		</tr>
		<tr>
		 <td> ������:*</td>
		 <td>
			<input name="rPass" class="inp_f_reg" type="password" title="�� 8 �� 20 ��������" maxlength="20" value="<?= $rPass ?>" data-placement="right">
		 </td>
		</tr>
		<tr>
		 <td>������ ��� ���:*</td>
		 <td>
			<input name="rPass2" class="inp_f_reg" type="password" title="��������� ������" maxlength="20" value="<?= $rPass2 ?>" data-placement="right">
		 </td>
		</tr>
		<tr>
		 <td>���� ���:*</td>
		 <td>
			<input name="rName_us" class="inp_f_reg" type="text" title="��� � ��� ����������?" value="<?= $rName_us ?>" maxlength="20" data-placement="right">
		 </td>
		</tr>
		<tr>
		 <td>E-mail:*</td>
		 <td>
			<input name="rEmail" class="inp_f_reg" type="text" title="E-mail, �� ������� ������� ������ ��� ���������� ����������" value="<?= $rEmail ?>" maxlength="20" data-placement="right">
		 </td>
		</tr>
		<tr>
		 <td>Skype:</td>
		 <td>
			<input name="rSkype" class="inp_f_reg" type="text" title="��� ������� ����� (��������� �� �����������)" value="<?= $rSkype ?>" maxlength="20" data-placement="right">
		 </td>
		</tr>
		<tr>
		 <td>�������:</td>
		 <td>
			<input name="rPhone" class="inp_f_reg" type="text" title="��� ������� (��������� �� �����������)" value="<?= $rPhone ?>" maxlength="20" data-placement="right">
		 </td>
		</tr>
		<tr>
		 <td style="padding-right: 30px">����������� ���:*</td>
		 <td>
			<input name="rPkey" id="captcha" class="inp_f_reg" type="text" title="����� �����. ���� �� �����, ������� �� ������� �� ���������" value="������ �� �����" maxlength="20" data-placement="right">
		 </td>
		</tr>
		<tr>
		 <td>��������:</td>
		 <td>
			<div style="margin: 10px 0 -10px 30px;"><?php dsp_crypt('cryptographp.cfg.php', 1); ?></div>
		 </td>
		</tr>
	 </table>
	 <br>

	 <div align="center"><input class="metall_knopka" name="ok" type="submit" value="���������"></div>
	</form>
 </div>
 </div>
 <div class="cont-list" style="margin: 0 0 0 10%;">
	<div class="drop-shadow lifted" style="padding: 15px 25px 3px 25px;">
	 <p id="for_reg_cont">
		����������� ���������� ��� ��������, ������� ��� ����������� ���������� ���������� �� ���������. ��� ����
		������������������ �������������, ������� ����������� ������� � ������������ �� ����������, ������������� ���������
		������ � �����, � ��� �������������, ��� ���������� ������� ���� � ����� ��������� �������� � ������� - �����������
		�����������. </p>

	 <p id="for_reg_cont">����������, ����������� ��������� ��� ���� � ������� ������ "���������". ���������� �������
		������������ email, �� ���� ����� ��������� ������ ��� ���������� ��������� ���� ����������. ��������! � �����
		������������, ������ �� ����������� ���� ����� � ������! ������ � ����� ����� �������� ������ �� ��������� ����,
		���� ��� �������������. ���������� ������������ ������ ������ ������ ������ ��������, ���������� � ���� �����, �
		����� ������� � ��������� �����. ����, ���������� ����������, ��������� �����������.</p>
	</div>
 </div>
 <div class="end_content"></div>
 </div>
<?php include ('inc/footer.php');
?>