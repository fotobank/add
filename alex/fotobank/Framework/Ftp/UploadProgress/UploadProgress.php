<?php
       /**
        * Created by PhpStorm.
        * User: Jurii
        * Date: 05.10.2018
        * Time: 2:30
        */

       namespace Framework\Ftp\UploadProgress;




       class UploadProgress {

       }



       //--------------------------------------------------------------------------
       //       ----------------------------------------------------------------------------
       //       �� ����� ���� ���������� ����� � ������� ������� ��������� FTP URL :
       $url = "ftp://username:password@ftp.example.com/remote/source/path/file.zip";
       $size = filesize($url) or die("Cannot retrieve size file");
       $hin = fopen($url, "rb") or die("Cannot open source file");
       $hout = fopen("/local/dest/path/file.zip", "wb") or die("Cannot open destination file");
       while (!feof($hin)) {
              $buf = fread($hin, 10240);
              fwrite($hout, $buf);
              echo "\r".(int)(ftell($hout) / $size * 100).'%';
       }
       echo "\n";
       fclose($hout);
       fclose($hin);
       //-----------------------------------------------------------------------------------------
       //��� �������� ����� ������� ������������� ftp_nb_get:
       //The filesize �������� ����������, ������� �������� ��� ��������� ��� ������� ��� �� �� ����� ��������. �� ������ ��������� clearstatcache.
       //������ ���, ���:
       $conn_id = ftp_connect("ftp.example.com");
       ftp_login($conn_id, "username", "password");
       ftp_pasv($conn_id, true);
       $local_path  = "/local/dest/path/file.zip";
       $remote_path = "/remote/source/path/file.zip";
       $size        = ftp_size($conn_id, $remote_path);
       $ret = ftp_nb_get($conn_id, $local_path, $remote_path, FTP_BINARY);
       while ($ret == FTP_MOREDATA) {
              clearstatcache(false, $local_path);
              echo "\r".(int)(filesize($local_path) / $size * 100).'%';
              $ret = ftp_nb_continue($conn_id);
       }
       echo "\n";


       //----------------------------------------------------------------------
        // 3 ������

       $conn_id = ftp_connect($ftp_server);
       $login_result = ftp_login($conn_id, $ftp_user_name, $ftp_user_pass);
       if (ftp_get($conn_id, $local_file, $server_file, FTP_BINARY)) {
              echo "Successfully written to $local_file\n";
       } else {
              echo "There was a problem\n";
       }
       ftp_close($conn_id);
       //  � ������� , ftp_nb_get ��� ��� ��� ��� �����. �� ���������� �������� � �������, ������ �� ��������� ��� � ��������.
       $ret = ftp_nb_get($conn_id, $local_file, $server_file, FTP_BINARY, $size);
       while ($ret == FTP_MOREDATA) {
              echo round((filesize($local_file) / $server_size) * 100)."%\n";
              $ret = ftp_nb_continue($conn_id);
       }
