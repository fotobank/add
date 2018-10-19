<?php

  define ('ROOT_PATH', realpath(__DIR__).'/', true);

  include (ROOT_PATH.'inc/head.php');
  if (!isset($_SESSION['logged'])) {
    $rLogin      = '��� ��� ����� (Login)';
    $rPass       = '';
    $rPass2      = '';
    $rEmail      = '������� E-mail';
    $rSkype      = '�� �����������';
    $rPhone      = '����� ������ �����';
    $rName_us    = '��������� ���';
    $rSurName_us = '�������';
    $rCity       = '�����';
    $ok_msg      = false;
    $err_msg     = NULL;
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
      $rLogin      = trim($_POST['rLogin']);
      $rPass       = trim($_POST['rPass']);
      $rPass2      = trim($_POST['rPass2']);
      $rEmail      = trim($_POST['rEmail']);
      $rName_us    = trim($_POST['rName_us']);
      $rSurName_us = trim($_POST['rSurName_us']);
      $rPhone      = trim($_POST['rPhone']);
      $rSkype      = trim($_POST['rSkype']);
      $rPkey       = trim($_POST['rPkey']);
      $rCity       = trim($_POST['rCity']);
      $rIp         = Get_IP();
      if ($rLogin !== '��� ��� ����� (Login)') {
        if (preg_match('/[?a-zA-Z�-��-�0-9_-]{3,20}$/u', $rLogin)) {
          if ($rEmail !== '������� E-mail') {
            if (($rName_us !== '' && $rName_us !== '��������� ���') || preg_match('/[?a-zA-Z�-��-�0-9_-]{2,20}$/u', $rName_us)) {
              $rName_us = ($rName_us === '��������� ���') ? '' : $rName_us;
              if ($rSurName_us === '' || $rSurName_us === '�������' || preg_match('/[?a-zA-Z�-��-�0-9_-]{2,20}$/u', $rSurName_us)) {
                $rSurName_us = ($rSurName_us === '�������') ? '' : $rSurName_us;
                if (preg_match("/[0-9a-z_]+@[0-9a-z_^\.-]+\.[a-z]{2,3}/i", $rEmail)) {
                  if ($rPass !== '' || $rPass2 !== '') {
                    if ($rPass === $rPass2) {
                      if (preg_match("/^[0-9a-z\_\-\!\~\*\:\<\>\+\.]{8,20}$/i", $rPass)) {
                        $mdPassword = md5($rPass);
                        $cnt  = (int)go\DB\query('select count(*) cnt from users where login = ?string',
                                      array($rLogin), 'el');
                        if ($cnt <= 0) {
                          $cnt = (int)go\DB\query('select count(*) cnt from users where email = ?string', array($rEmail),'el');
                          if ($cnt <= 0) {
                            if ($rPhone === '����� ������ �����') {
                              $rPhone = '';
                            }
                            if ((strlen($rPhone) == '') || ((strlen($rPhone) >= 7)
                                                            && (!preg_match("/[%a-z_@.,^=:;�-�\"*&$#�!?<>\~`|[{}\]]/iu",
                                                 $rPhone)))
                            ) {
                              if ($rCity !== '��� �������� ���������� ���������� ( ����� ������ ����� )'
                                  || preg_match('/[?a-zA-Z�-��-�0-9_-]{2,30}$/u', $rCity)
                              ) {
                                $rCity = ($rCity === '��� �������� ���������� ���������� ( ����� ������ ����� )') ? '' : $rCity;
                                if ($rSkype === '�� �����������') {
                                  $rSkype = '';
                                }
                                $time = time();
                                // �������� �����
                                if ($rPkey === chk_crypt($rPkey)) {
                                  // ������������� ���������� � ��(�� �������� ���������� ���� �������� ������-�����-������)
                                  try {
                                    // �������� Id, ��� ������� ���� ��������� � ����
                                    $id = $db('INSERT INTO users (login, pass, email, us_name, timestamp, ip, phone, skype, city, us_surname)
                                                 VALUES (?string,?string,?string,?string,?i,?string,?string,?string,?string,?string)',
                                      array(
                                           $rLogin, $mdPassword,
                                           $rEmail,
                                           $rName_us, $time, $rIp,
                                           $rPhone, $rSkype, $rCity,
                                           $rSurName_us
                                      ), 'id');
                                  }
                                  catch (go\DB\Exceptions\Exception  $e) {
                                    trigger_error('������ ��� ������ � ����� ������ �� ����� ����������� ������������! ���� - registr.php.');
                                    $err_msg = '������ ��� ������ � ����� ������!';
                                    die("<div align='center' class='err_f_reg'>������ ��� ������ � ����� ������!</div>");
                                  }
                                  // ���������� "keystring" ��� ���������
                                  $key  = md5(substr($rEmail, 0, 2).$id.substr($rLogin, 0, 2));
                                  $date = date("d.m.Y", $time);
                                  // ��������� ������
                                  $title = '����������� ����������� �� ����� Creative line studio';
                                  $headers = "Content-type: text/plain; charset=windows-1251\r\n";
                                  $headers .= "From: ������������� Creative line studio <webmaster@aleks.od.ua> \r\n";
                                  $subject = '=?koi8-r?B?'.base64_encode(convert_cyr_string($title, "w", "k")).'?=';
                                  $letter  = <<< LTR
													  ������������, $rName_us.
													  �� ������� ������������������ �� Creative Line Studio.
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
                                    go\DB\query('DELETE FROM users WHERE login= (?string) LIMIT 1',
                                      array($rLogin));
                                    $err_msg =
                                           '��������� ������ ��� �������� ������.<br> ���������� ������������������ ��� ���.';
                                  } else {
                                    $ok_msg = true;

                                  }
                                } else {
                                  $err_msg = '����������� ���� ������������ �����!';
                                }

                              } else {
                                $err_msg = '������ � �������� ������!';
                              }
                            } else {
                              $err_msg = '������� ������ �����������! (������ ���� ������ 6 ����)<br> ������: (067)-123-45-67';
                            }
                          } else {
                            $err_msg = '������������ � ����� E-mail ��� ����������!<br>������� �� �������������� ������<br> ��� ����������������� �� ������ E-mail.';
                          }
                        } else {
                          $err_msg = '������������ � ����� ������� ��� ����������!';
                        }

                      } else {
                        $err_msg = '� ���� `������` ������� ������������ �������<br> ��� ����� ������ 8 ��������.<br> ����������� ������ ���������� �������, ����� � �����<br>  . - _ ! ~ * : < > + ';
                      }
                    } else {
                      $err_msg = '������ �� ���������!';
                    }
                  } else {
                    $err_msg = '���� `������` �� ���������!';
                  }
                } else {
                  $err_msg = '��������� `E-mail` ����� ������������ ������!';
                }
              } else {
                $err_msg = '��������� ���� `�������`!';
              }
            } else {
              $err_msg = '��������� ���� `���� ���`!';
            }
          } else {
            $err_msg = '���� `E-mail` �� ���������!';
          }

        } else {
          $err_msg = '����� ����� �������� �� ����, ����, ������� � �������������.<br> ����� �� 3 �� 20 ��������.';
        }
      } else {
        $err_msg = '���� `�����` �� ���������!';
      }

    }

    $regData    = array(
      'rLogin'      => $rLogin,
      'rPass'       => $rPass,
      'rPass2'      => $rPass2,
      'rName_us'    => $rName_us,
      'rEmail'      => $rEmail,
      'rSkype'      => $rSkype,
      'rPhone'      => $rPhone,
      'err_msg'     => $err_msg,
      'ok_msg'      => $ok_msg,
      'rCity'       => $rCity,
      'rSurName_us' => $rSurName_us
    );
    $renderData = array_merge($renderData, $regData);

    $loadTwig('.twig', $renderData);
    if (isset($err_msg)) {
      unset ($err_msg);
    }

  } else {
    echo "<script type='text/javascript'>window.document.location.href='/index.php'</script>";
  }
  include (ROOT_PATH.'inc/footer.php');
