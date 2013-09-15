<?php
			define ( 'BASEPATH' , realpath ( __DIR__ ) . '/' , TRUE );
			include (BASEPATH.'inc/head.php');
			if (!isset($_SESSION['logged'])) {
						$rLogin   = '��� ��� ����� (Login)';
						$rPass    = '';
						$rPass2   = '';
						$rEmail   = '������� E-mail';
						$rSkype   = '�� �����������';
						$rPhone   = '����� ������ �����';
						$rName_us = '��������� ���';
						$ok_msg = false;
						$err_msg = NULL;
						if ($_SERVER['REQUEST_METHOD'] == 'POST') {
									$rLogin   = trim($_POST['rLogin']);
									$rPass    = trim($_POST['rPass']);
									$rPass2   = trim($_POST['rPass2']);
									$rEmail   = trim($_POST['rEmail']);
									$rName_us = trim($_POST['rName_us']);
									$rPhone   = trim($_POST['rPhone']);
									$rSkype   = trim($_POST['rSkype']);
									$rPkey    = trim($_POST['rPkey']);
									$rIp      = Get_IP();
									if ($rLogin != '��� ��� ����� (Login)') {
												if (preg_match("/[?a-zA-Z�-��-�0-9_-]{3,20}$/", $rLogin)) {
															if ($rEmail != '������� E-mail') {
																		if ($rName_us != '��������� ���' || preg_match("/[?a-zA-Z�-��-�0-9_-]{2,20}$/", $rName_us)) {
																					if (preg_match("/[0-9a-z_]+@[0-9a-z_^\.-]+\.[a-z]{2,3}/i", $rEmail)) {
																								if ($rPass != '' || $rPass2 != '') {
																											if ($rPass === $rPass2) {
																														if (preg_match("/^[0-9a-z\_\-\!\~\*\:\<\>\+\.]{8,20}$/i", $rPass)) {
																																	$mdPassword = md5($rPass);
																																	$cnt        = intval($db->query('select count(*) cnt from users where login = ?string',
																																																																	array($rLogin), 'el'));
																																	if ($cnt <= 0) {
																																				$cnt = intval($db->query('select count(*) cnt from users where email = ?string',
																																																													array($rEmail),
																																																													'el'));
																																				if ($cnt <= 0) {
																																							if ($rPhone == '����� ������ �����') {
																																										$rPhone = '';
																																							}
																																							if ((strlen($rPhone) == '')
																																											|| (strlen($rPhone) >= 7)
																																														&& (!preg_match("/[%a-z_@.,^=:;�-�\"*()&$#�!?<>\~`|[{}\]]/i",
																																																														$rPhone))
																																							) {
																																										if ($rSkype == '�� �����������') {
																																													$rSkype = '';
																																										}
																																										$time = time();
																																										// �������� �����
																																										if ($rPkey == chk_crypt($rPkey)) {
																																													// ������������� ���������� � ��(�� �������� ���������� ���� �������� ������-�����-������)
																																													try {
																																																// �������� Id, ��� ������� ���� ��������� � ����
																																																$id = $db->query('INSERT INTO users (login, pass, email, us_name, timestamp, ip, phone, skype)
                                																																	 VALUES (?,?,?,?,?i,?,?,?)',
																																																																	 array(
																																																																									$rLogin, $mdPassword, $rEmail,
																																																																									$rName_us, $time, $rIp,
																																																																									$rPhone, $rSkype
																																																																	 ), 'id');
																																													}
																																													catch (go\DB\Exceptions\Exception  $e) {
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
																																													$title   =
																																																'����������� ����������� �� ����� Creative line studio';
																																													$headers =
																																																"Content-type: text/plain; charset=windows-1251\r\n";
																																													$headers .= "From: ������������� Creative line studio <webmaster@aleks.od.ua> \r\n";
																																													$subject = '=?koi8-r?B?'
																																																								.base64_encode(convert_cyr_string($title,
																																																																																										"w",
																																																																																										"k")).'?=';
																																													$letter  = <<< LTR
													  ������������, $rName_us.
													  �� ������� ������������������ �� Creative line studio.
													  ����� ��������� �������� ��� ������ �������� ����������, ������� ��� ����������� �� ������������� ����������.
													  ��� �� ��� ���� ������������������ ������������� ������������� ��������� ������ � ������.
													  ���� ��������������� ������:
														  �����: $rLogin
														  ������: $rPass

													  ��� ��������� �������� ��� ������� ������ �� ������:
													  http://$_SERVER[HTTP_HOST]/activation.php?login=$rLogin&key=$key

													  ������ ������ ����� �������� � ������� 5 ����.

													  $date
LTR;
															// ���������� ������
															if (!mail($rEmail,
																									$subject,
																									$letter,
																									$headers)
															) {
																		// ���� ������ �� �����������, ������� ����� �� ����
																		$db->query('DELETE FROM users WHERE login= (?string) LIMIT 1',
																													array($rLogin));
																		$err_msg =
																					"��������� ������ ��� �������� ������.<br> ���������� ������������������ ��� ���.";
															} else {

																$ok_msg = true;

																																													}
																																										} else {
																																													$err_msg = "����������� ���� ������������ �����!";
																																										}

																																							} else {
																																										$err_msg =
																																													"������� ������ �����������! (������ ���� ������ 6 ����)";
																																							}
																																				} else {
																																							$err_msg
																																										=
																																										"������������ � ����� E-mail ��� ����������!<br>������� �� �������������� ������ ��� ����������������� �� ������ E-mail.";
																																				}
																																	} else {
																																				$err_msg = "������������ � ����� ������� ��� ����������!";
																																	}

																														} else {
																																	$err_msg =
																																				"� ���� `������` ������� ������������ �������<br> ��� ����� ������ 8 ��������.<br> ����������� ������ ���������� �������, ����� � �����<br>  . - _ ! ~ * : < > + ";
																														}
																											} else {
																														$err_msg = "������ �� ���������!";
																											}
																								} else {
																											$err_msg = "���� `������` �� ���������!";
																								}
																					} else {
																								$err_msg = "��������� `E-mail` ����� ������������ ������!";
																					}

																		} else {
																					$err_msg = "��������� ���� `���� ���`!";
																		}
															} else {
																		$err_msg = "���� `E-mail` �� ���������!";
															}

												} else {
															$err_msg = "����� ����� �������� �� ����, ����, ������� � �������������.<br> ����� �� 3 �� 20 ��������.";
												}
									} else {
												$err_msg = "���� `�����` �� ���������!";
									}

						}
			   $regData = array(	'rLogin'   => $rLogin,
																								'rPass'    => $rPass,
																								'rPass2'   => $rPass2,
																								'rName_us' => $rName_us,
																								'rEmail'   => $rEmail,
																								'rSkype'   => $rSkype,
																								'rPhone'   => $rPhone,
																								'err_msg'  => $err_msg,
																								'ok_msg' 		=> $ok_msg

																					);
						$renderData        = array_merge($renderData, $regData);
						$loadTwig('.twig', $renderData);

						if (isset($err_msg)) {
									unset ($err_msg);
						}
						?>


			<?
			} else {
						echo "<script type='text/javascript'>window.document.location.href='/index.php'</script>";
			}
?>



			<script type='text/javascript' >
						function parseField(id) {
									var obj = '[name="' + id + '"]';
									var str = new String(jQuery(obj).val());
									if (str.match(/[^0-9-_]+/gi)) {

												jQuery(obj).css({'border-color': '#980000', 'background-color': '#EDCECE'});
												jQuery(obj).val(str.replace(/[^0-9-_]+/gi, ''));

												setTimeout(function () {
															jQuery(obj).css({'border-color': '#85BFF2', 'background-color': '#FFFFFF'});
												}, 1000)
									}
						}
			</script >

<?php include (BASEPATH.'inc/footer.php');
?>