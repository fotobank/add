<?php
       /**
        * Created by JetBrains PhpStorm.
        * User: Jurii
        * Date: 12.04.13
        * Time: 12:55
        * To change this template use File | Settings | File Templates.
        */
       /**
        *  ajax ������ �������������� ������
        */
       header('Content-type: text/html; charset=windows-1251');
       require_once __DIR__.'/../alex/fotobank/Framework/Boot/config.php';
       $error_processor = Error_Processor::getInstance();
       $session = check_Session::getInstance();
       // �����
       $cryptinstall = '/classes/dsp/cryptographp.fct.php';
       require_once(__DIR__.'/../classes/dsp/cryptographp.fct.php');
       /**
        * @param $where
        * @param $type
        *
        * @return string
        */
       function checkData($where, $type) {

              $user_data = NULL;
              $error     = false;
              $session   = check_Session::getInstance();
              try {
                     $user_data = go\DB\query('select * from users where ?col = ?', array($type, $where), 'row');

              }
              catch (go\DB\Exceptions\Exception  $e) {
                     $session->set('err_msg', '������ ��� ������ � ����� ������');
                     $error = true;
              }
              if ($error != true && $user_data) {
                     $title   = '�������������� ������ �� ����� Creative line studio';
                     $headers = "Content-type: text/plain; charset=windows-1251\r\n";
                     $headers .= "From: ������������� Creative line studio \r\n";
                     $subject = '=?koi8-r?B?'.base64_encode(convert_cyr_string($title, "w", "k")).'?=';
                     $letter  = "������������,".iconv('utf-8', 'windows-1251', $user_data['us_name'])."!\r\n";
                     $letter  .= "���-�� (��������, ��) �������� �������������� ������ �� ����� Creative line studio.\r\n";
                     $letter  .= "������ ��� ����� �� ����:\r\n";
                     $letter  .= "   �����: ".iconv('utf-8', 'windows-1251', $user_data['login'])."\r\n";
                     // �������� ������ ������
                     //$password = genpass(10, 3); // ������ � ������������ ������� ���������
                     $password = genPassword(10); // ������������������� ������
                     // �������� � ������ � ����
                     getPassword($password, $user_data['id']) or die("������!");
                     $letter .= "   ������: $password\r\n";
                     $letter .= "���� �� �� ����������� �������������� ������, ����������, ���������� ��������� � �������������� �����!\r\n";
                     // ���������� ������
                     if (!mail($user_data['email'], $subject, $letter, $headers)) {
                            $session->set('err_msg', '�� ������� ��������� ������. ����������, ���������� �����.<br>');
                     } else {
                            $session->set('ok_msg2',
                                   '������ ��������.<br>����� ������ ��������� �� E-mail,<br> ��������� ���� ��� �����������.<br>');

                     }
                     $ret = 'true';
              } else {
                     $session->set('err_msg', "������������ � ������ '$type' �� ������.<br>");
                     $ret = 'false';
              }
              go\DB\Storage::getInstance()->get()->close();

              return $ret;
       }

       //�������� ������
       if (!$session->has('previos_data')
           || $session->get('previos_data') != md5(trim($_POST['login']).trim($_POST['email']).trim($_POST['pkey']))
       ) {
              if (iconv("utf-8", "windows-1251", $_POST['login'].$_POST['email'].$_POST['pkey']) == "������� ��� �����:��� E-mail:��� ������������:"
              ) {
                     $session->set('err_msg', "���������� ��������� ���� �� �����.<br>");
              } else {
                     if ($_POST['pkey'] == chk_crypt($_POST['pkey'])) {
                            if (isset($_POST['login']) && $_POST['login'] != '') {
                                   $dataLogin = iconv("utf-8", "windows-1251", $_POST['login']);
                                   if ($dataLogin != "������� ��� �����:") {
                                          $login = trim(htmlspecialchars($dataLogin));
                                          if (!preg_match("/[?a-zA-Z�-��-�0-9_-]{3,16}$/", $login)) {
                                                 $session->set('err_msg2',
                                                        "����� ����� �������� �� ����, ����, ������� � �������������. ����� �� 3 �� 16 ��������.<br>");
                                                 $where = 'false';
                                          } else {
                                                 $login = iconv("windows-1251", "utf-8", $login);
                                                 $where = checkData($login, 'login');
                                          }
                                   }
                            }
                            if (isset($_POST['email']) && $_POST['email'] != '') {
                                   $dataEmail = iconv("utf-8", "windows-1251", $_POST['email']);
                                   if ($dataEmail != "��� E-mail:") {
                                          $email = trim(htmlspecialchars($dataEmail));
                                          if (!preg_match("/[0-9a-z_]+@[0-9a-z_^\.-]+\.[a-z]{2,3}/i", $email)) {
                                                 $session->set('err_msg2', "��������� 'E-mail' (������: a@b.c)!<br>");
                                                 $where = 'false';
                                          } else {
                                                 $where = checkData($email, 'email');
                                          }
                                   }
                            }
                            if (empty($_POST['email']) && empty($_POST['login'])) {
                                   $where = '';
                            }
                            if ($where == '') {
                                   $session->set('err_msg', "����������, ��������� ���� �� �����!<br>");
                            }
                            if ($where == 'false') {
                                   $session->set('err_msg', "������������ �� ������.");
                            }

                     } else {
                            $session->set('err_msg', "������������ ���� ������������ �����!<br>");
                     }
              }
       } elseif ($session->get('previos_data') == "b894200597453166c8ff8dd7d7488263") {
              $session->set('err_msg', "<p class='ttext_red'>��� ����������� ������ ���������� ���������<br> ���� �� �����.</p><br>");
       } else {
              $session->set('err_msg', "<p class='ttext_red'>��������� ���� ���������� ������!</p><br>");
       }
       if ($session->has('ok_msg2')) {
              $_SESSION['ok_msg2'] = "<p class='ttext_blue'>".$_SESSION['ok_msg2']."</p>";
              echo $session->get('ok_msg2');
              $session->del('ok_msg2');
       } else {
              if ($session->has('err_msg2')) {
                     echo $session->get('err_msg2');
              } elseif ($session->has('err_msg')) {
                     echo $session->get('err_msg');
              }

       }
       $session->set('previos_data', md5(trim($_POST['login']).trim($_POST['email']).trim($_POST['pkey'])));
       $session->del('err_msg');
       $session->del('err_msg2');
       $session->del('ok_msg2');
       $session->del('secret_number');
