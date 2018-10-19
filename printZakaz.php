<?php
       /**
        * Created by JetBrains PhpStorm.
        * User: Jurii
        * Date: 25.05.13
        * Time: 11:56
        * To change this template use File | Settings | File Templates.
        */
       define('ROOT_PATH', realpath(__DIR__).'/', true);
       include ROOT_PATH.'inc/head.php';

       use Framework\Core\Mail\Sender;

       if ($link->referralSeed) {
              if ($link->check($_SERVER['SCRIPT_NAME'].'?go='.trim($_GET['go'] ?? ''))) {
                     // �������� ����
                     //	print "<br>checked link: ${_SERVER['REQUEST_URI']}<br />\n";
                     if (!isset($_SESSION['logged'])) {
                            err_exit('��� ������������� ������ ���������� ������������ �� �����!');
                     }
                     if (!isset($_GET['key'])) {
                            err_exit('���� �� ������!');
                     }
                     $key = $_GET['key'];
                     $data = go\DB\query('select * from `print` where `key` = ?string', [$key], 'row');
                     //		  dump_r($data);
                     $renderData['block'] = false;
                     $renderData['id'] = false;
                     $renderData['summ'] = false;
                     $renderData['balans'] = false;
                     if (!$data) {
                            err_exit('���� �� ������!');
                     }
                     else {
                            if ((time() - (int)$data['dt'] > 172800) && $data['id_nal'] !== '���������� ������� �����') {
                                   //����������������� ��������� ������, ���� ���� ������� ������������ ������ � ����
                                   // go\DB\query('delete from print where id = ?',array($data['id']));
                                   // go\DB\query('delete from order_print where id_print = ?',array($data['id']));
                                   $renderData['block'] = 'time';
                            }
                            else {
                                   $balans = $user_balans - $data['summ'];
                                   if ($balans < 0 && $data['id_nal'] !== '���������� ������' &&
                                          (int)$data['zakaz'] != 1) {
                                          $_SESSION['order_msg'] =
                                                 '������������ ������� �� �������! ����������  '.$data['summ'].' ��. ��������� ���� ���� �� ����� �����<br> ��������� ��� ��������.
				 ��� �������� ����� ����� ���������� ��������.';
                                          $renderData['block'] = 'limit';
                                          $renderData['summ'] = $data['summ'];
                                   }
                                   else {
                                          if ((int)$data['zakaz'] == 1 &&
                                                 $data['status'] == 0) // ���� ����� ��� ��� �����������
                                          {
                                                 $renderData['block'] = 'oldZakaz';
                                                 $renderData['id'] = $data['id'];
                                          }
                                          else {
                                                 /** ����� �����*/
                                                 try {
                                                        go\DB\query('UPDATE `print` SET `zakaz` = ?b WHERE id = ?i',
                                                               ['1', $data['id']]);
                                                        if ($data['id_nal'] !== '���������� ������') {
                                                               go\DB\query('UPDATE `users` SET `balans` = ?f WHERE id = ?i',
                                                                      [$balans, $_SESSION['userid']]);
                                                        }
                                                 } catch (go\DB\Exceptions\Exception $e) {
                                                        if (check_Session::getInstance()->has('DUMP_R')) {
                                                               dump_r('<br><br><br>������ ��� ������ � ����� ������: '.
                                                                      $e);
                                                        }
                                                 }
                                                 if ($data['id_nal'] !== '���������� ������') {
                                                        $renderData['block'] = 'nalPlat';
                                                        $renderData['balans'] = $balans;
                                                 }
                                                 $renderData['block'] = 'ok';
                                                 $renderData['id'] = $data['id'];
                                                 /** ������ ��������� */
                                                 $letter = '<html><body><h2>����� �'.$data['id'].'</h2>';
                                                 $user = go\DB\query('SELECT * FROM `users` WHERE `id` = ?i',
                                                        [$data['id_user']], 'row');
                                                 $letter .= "<b>������������:</b> ".$user['us_name'].' '.
                                                        $user['us_surname']."<br>";
                                                 $letter .= "<b>E-mail ������������:</b> ".$data['email']."<br>";
                                                 $letter .= "<b>Id ������������:</b> ".$data['id_user']."<br>";
                                                 $letter .= "<b>���� ������:</b> ".date('d.m.Y  H.i', $data['dt']).
                                                        "<br>";
                                                 $letter .= "<b>����������:</b> ".$data['name'].'  '.$data['subname'].
                                                        "<br>";
                                                 $letter .= "<b>����� �������� ����������:</b> ".$data['phone']."<br>";
                                                 $letter .= "<b>������ ����������:</b> ".$data['format']." ��.<br>";
                                                 $letter .= "<b>������:</b> ".$data['mat_gl']."<br>";
                                                 $letter .= ($data['id_nal'] == '������') ?
                                                        "<b>������ ������ ��������� �������������:</b> '".
                                                        $data['user_opl'].",<br>" :
                                                        "<b>������ ������:</b> ".$data['id_nal']."<br>";
                                                 $letter .= ($data['id_dost'] == '������') ?
                                                        "<b>������ �������� ��������� �������������:</b> '".
                                                        $data['user_dost'].",<br>" :
                                                        "<b>��� ��������:</b> ".$data['id_dost']."<br>";
                                                 if ($data['id_dost'] ==
                                                        '��������� �� ��������� ��������� ������ ������' ||
                                                        $data['id_dost'] ==
                                                        '�������� �� ����� �������� ������� (����� ������)') {
                                                        $letter .= "<b>������������ ������ ��������:</b> ".
                                                               $data['subname'].",<br>";
                                                        $letter .= "<b>����� ��������� ��������� ��� ����������:</b><br> ".
                                                               $data['subname']."<br>";
                                                 }
                                                 if ($data['id_dost'] ==
                                                        '��������� �� ������ (� ������)') $letter .= "<b>����� ������ ��� ��������� ����������:</b> '".
                                                        $data['adr_studii']."'<br>";
                                                 $letter .= "<b>���������� ������������:</b><br>".$data['comm']."<br>";
                                                 $nmAlb =
                                                        go\DB\query('SELECT a.nm FROM albums a, photos p, order_print o WHERE a.id = p.id_album  AND o.id_photo = p.id AND o.id_print = ?i LIMIT 1',
                                                               [$data['id']], 'el');
                                                 $photo_data =
                                                        go\DB\query('select * from `order_print` where `id_print` = ?i',
                                                               [$data['id']], 'assoc');
                                                 $letter .= "<br><b>�������� �������:</b> '".$nmAlb."'<br>";
                                                 $letter .= "<b>����� � ���������� ����������:</b><br>";
                                                 $koll = 0;
                                                 foreach ($photo_data as $val) {
                                                        $name = go\DB\query('select `nm` from `photos` where id =?i',
                                                               [$val['id_photo']], 'el');
                                                        $letter .= "���������� � ".$name." - ".$val['koll']."��.<br>";
                                                        $koll += $val['koll'];
                                                 }
                                                 $letter .= "<b>�����:</b> ".$koll." ��.<br>";
                                                 $letter .= "<b>� ������:</b> ".$data['summ']."��. (".
                                                        str_digit_str($data['summ'])."��.)<br><br>";
                                                 $letter .= '</body></html>';
                                                 $mail = new Sender();
                                                 $mail->from_addr = $data['email'];
                                                 $mail->from_name = $data['name'];
                                                 $mail->to = 'aleksjurii@gmail.com';
                                                 $mail->subj = '����� ����������';
                                                 $mail->body_type = 'text/html';
                                                 $mail->body = $letter;
                                                 $mail->priority = 1;
                                                 $mail->prepare_letter();
                                                 $mail->send_letter();
                                                 /** ��������� ������ �� FTP � ��������� SMS */
                                                 $http = new http();
                                                 /** ������� ����� */
                                                 $zakazPrint =
                                                        $http->post('http://'.$_SERVER['HTTP_HOST'].'/security.php',
                                                               ['idZakaz' => $data['id']]);
                                                 // echo $zakazPrint;
                                                 // dump_r($zakazPrint);
                                                 /** SMS � ����������� ������ */
                                                 $zakaz = '����� �'.$data['id'].' ��: '.$user['us_name'].' '.
                                                        $user['us_surname'].' '.$data['format'].'-'.$koll.
                                                        ' ��. �� ����� '.$data['summ'].'��.';
                                                 // ��������� ����������� ���������� SOAP
                                                 if (extension_loaded('soap')) {
                                                        $sendSMS = $http->post('http://'.$_SERVER['HTTP_HOST'].
                                                               '/inc/lib/sms/sendSMS.php',
                                                               ['sendSMS' => $zakaz, 'number' => '+380949477070']);
                                                        //	echo  iconv ('utf-8', 'windows-1251', $sendSMS);
                                                 }
                                                 else {
                                                        $sendSMS = $http->post('http://'.$_SERVER['HTTP_HOST'].
                                                               '/inc/lib/sms/sendSMS.php',
                                                               ['sendFluSMS' => $zakaz, 'number' => '380949477070']);
                                                        // echo $sendSMS;
                                                 }
                                          }
                                   }
                            }
                     }
                     /* todo: ���� - ������� ����� */
                     //  $http = new http;
                     //  $result = $http->post('http://'.$_SERVER['HTTP_HOST'].'/inc/sobrZakaz.php', array('idZakaz' => $data['id']));
                     //  echo $result;
                     // ��������� ����������� ���������� SOAP
                     /* if (extension_loaded('soap')){
                     $test = '�������� ��������� sendSMS';
                     $sendSMS = $http->post('http://'.$_SERVER['HTTP_HOST'].'/inc/lib/sms/sendSMS.php', array('sendSMS' => $test, 'number' => '+380949477070'));
                     echo "Extensions SOAP loaded.";
                     echo  iconv ('utf-8', 'windows-1251', $sendSMS);
                      } else {
                     $test2 = '�������� ��������� sendFluSMS';
                     $sendSMS = $http->post('http://'.$_SERVER['HTTP_HOST'].'/inc/lib/sms/sendSMS.php', array('sendFluSMS' => $test2, 'number' => '380949477070'));
                      echo "Extensions SOAP is not loaded.";
                      echo  $sendSMS;
                      }*/
                     go\DB\Storage::getInstance()->get()->close();
              }
              else {
                     //	print "<br>link invalid: ${_SERVER['REQUEST_URI']} \n";
                     include(__DIR__.'/error_.php');
              }
       }
       else include(__DIR__.'/error_.php');
       // ������ ��������
       $loadTwig('.twig', $renderData);
       include(ROOT_PATH.'inc/footer.php');
