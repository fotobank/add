<?php
			define ('BASEPATH', realpath(__DIR__).'/', true);
			include_once (BASEPATH.'inc/head.php');
			$uname  = "";
			$uphone = "";
			$skype  = "";
			$utext  = "";
			$umail  = "";
			$umail  = "";
			$eAll   = NULL;
			$e1     = $e2 = $e3 = $e4 = $e5 = "";
			if (isset($_POST["go"])) {
						$e1    = NULL;
						$uname = trim(htmlspecialchars($_POST["uname"]));
						if (strlen($uname) == "0" || (!preg_match("/[^a-zA-Z�-��-�0-9_-]{3,16}$/", $uname))) {
									$e1 .= "������������ �������!";
						}
						$e2    = NULL;
						$utext = trim(htmlspecialchars($_POST["utext"]));
						if (strlen($utext) == "0") {
									$e2 .= "��������� ���� '����� ���������'";
						}
						$e3    = NULL;
						$umail = trim(htmlspecialchars($_POST["umail"]));
						if ((strlen($umail) == "0") || (!preg_match("/[0-9a-z_]+@[0-9a-z_^\.-]+\.[a-z]{2,3}/i",	$umail))
						) {
									$e3 .= "�������� E-Mail";
						}
						$e4     = NULL;
						$uphone = trim(htmlspecialchars($_POST["uphone"]));
						if ((strlen($uphone) < 5) || (preg_match("/[%a-z_@.,^=:;�-�\"*&$#�!?<>\~`|[{}\]]/i", $uphone))
						) {
									$e4 .= "�������� �������!";
						}
						$skype = trim(htmlspecialchars($_POST["skype"]));
						$e5    = NULL;
						$umath = trim(htmlspecialchars($_POST["umath"]));
						if ($umath != chk_crypt($umath)) {
									$e5 .= "������� �������� ����������� �����";
						}
						$eAll = $e1.$e2.$e3.$e4.$e5;
			}
			$dataDB       = $db->query('select txt from content where id = ?i', array(4), 'el');
			$dataKontakty = array(
						// ������ �� ������� ���� ������
						'dataDB' => $dataDB,
						// ������
						'e1'     => $e1,
						'e2'     => $e2,
						'e3'     => $e3,
						'e4'     => $e4,
						'e5'     => $e5,
						// ��� ���������� ������ � �����
						'uname'  => $uname,
						'uphone' => $uphone,
						'skype'  => $skype,
						'umail'  => $umail,
						'utext'  => $utext
			);

			// ��������� ������
			if (isset($_POST["go"]) && $eAll == NULL) {
						$dt = date("d F Y, H:i:s");
						// ���� � �����
						$mail = "aleksjurii@gmail.com";
						// e-mail ���� ����� ������
						$title = "��������� � ����� �������� ����� aleks.od.ua";
						// ���������(����) ������
						$subject = '=?koi8-r?B?'.base64_encode(convert_cyr_string($title, "w", "k")).
											 '?=';
						$utext   = str_replace("\r\n", "<br>", $utext);
						// ������������
						$mess = "<u><b>��������� � ����� �������� ����� :</b></u><br>";
						$mess .= "<b>���: </b> $uname<br>";
						$mess .= "<b>E-Mail:  </b> <a href='mailto:$umail'>$umail</a><br>";
						$mess .= "<b>Skype:  </b>$skype<br>";
						$mess .= "<b>�������:  </b>$uphone<br>";
						$mess .= "<b>���� � �����:  </b>$dt<br><br>";
						$mess .= "<u><b>����� ���������:  </b></u><br><br>";
						$mess .= "$utext<br>";
						$headers = "MIME-Version: 1.0\r\n";
						$headers .= "Content-type: text/html; charset=windows-1251\r\n";
						//���������
						$headers .= "From: jurii@aleks.od.ua \r\n";
						// ������ ������ (��������������� ������)
						mail($mail, $subject, $mess, $headers);
						// ����������
						// ������� ����������� �� ������ �������� � ������������� ���������
						echo  "<script language='Javascript' type='text/javascript'>
								 humane.success('�������.<br> ���� ��������� �����������.');
								 function reLoad()
								 {location = \"kontakty.php\"};
								 setTimeout('reLoad()', 6000);
								 </script>";
						$renderData['kontakt_Msg'] = '�������. ���� ��������� �����������!';
			}
			$renderData   = array_merge($renderData, $dataKontakty);
			// ������ ��������
			$loadTwig('.twig', $renderData);
			include_once (BASEPATH.'inc/footer.php');