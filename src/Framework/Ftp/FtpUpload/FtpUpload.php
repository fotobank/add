<?php
       /**
        * Created by PhpStorm.
        * User: Jurii
        * Date: 05.10.2018
        * Time: 0:51
        */

       namespace Framework\Ftp\FtpUpload;




       /**
        * Class FtpUpload
        *
        * @package Framework\Ftp\FtpUpload
        *
        * � ����� ���� ������ �� php.net, ������� ��������� ��� ��������� ����� �� ������.������
        * ���� ����������� ��������, �������� ����������:������
        * 1% �������������
        * 2% �������������
        * 3% ��������� � ��� ����� ...
        *
        */
       class FtpUpload {

       public $ftp_server    = 'some server';
       public $ftp_user_name = 'blabnlalba';
       public $ftp_user_pass = 'blablavla';
       public $remote_file = 'NewsML_1.2-doc-Guidelines_1.00.pdf';
       public $local_file  = 'NewsML_1.2-doc-Guidelines_1.00.pdf';


              /**
               * FtpUpload constructor.
               */
              public function __construct() {


                     ob_end_flush();

                     $fp           = fopen($this->local_file, 'rb');
                     $conn_id      = ftp_connect($this->ftp_server);
                     $login_result = ftp_login($conn_id, $this->ftp_user_name, $this->ftp_user_pass);
                     $ret          = ftp_nb_fput($conn_id, $this->remote_file, $fp, FTP_BINARY);
                     $remote_file_size = 0;

                     while ($ret == FTP_MOREDATA) {
                            // ���������� ����� ����������� � FTP-�������
                            if (!isset($conn_id2)) {
                                   $conn_id2      = ftp_connect($this->ftp_server);
                                   $login_result2 = ftp_login($conn_id2, $this->ftp_user_name, $this->ftp_user_pass);
                            }
                            // �������� ������ ������������ �����.
                            if ($conn_id2 !== NULL) {
                                   clearstatcache(); // <- ��� ������ ���� ��������!!
                                   $remote_file_size = ftp_size($conn_id2, $this->remote_file);
                            }
                            // Calculate upload progress
                            $local_file_size = filesize($this->local_file);
                            if ($remote_file_size !== NULL && $remote_file_size > 0) {
                                   $i = ($remote_file_size / $local_file_size) * 100;
                                   printf('%d%% uploaded', $i);
                                   flush();

                            }
                            $ret = ftp_nb_continue($conn_id);

                     }
                     if ($ret != FTP_FINISHED) {
                            print('��������� ������ ��� �������� �����...<br>');
                            exit(1);
                     } else {
                            print('������.<br>');
                     }
                     fclose($fp);
              }

       }
