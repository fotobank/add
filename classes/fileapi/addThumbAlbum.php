<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Jurii
 * Date: 17.10.13
 * Time: 21:49
 * To change this template use File | Settings | File Templates.
 * ������ ���������� �������� � ������ ������� ��� �������� �������
 */


       include (__DIR__.'/../../inc/config.php');
       include (__DIR__.'/../../inc/func.php');

       error_reporting(1);
       ini_set('display_errors', 1);


       if (isset($_SESSION['admin_logged'])) {

       if (isset($_POST['_filedata'])) {
              if (isset($_FILES['filedata']) && $_FILES['filedata']['size'] != 0) {
                            $ext         = strtolower(substr($_FILES['filedata']['name'], 1 + strrpos($_FILES['filedata']['name'], ".")));

                            /** �������� �������� ---------------------------------------------------------------------------------------- */
                            $aImage = new fileapi_resizeUploadedImg();
                            $array  = array (
                                   "_FILESname"   => 'filedata', // ��� ������������ ����� � ������� $_FILES
                                   "newThumbName" => 'tmp.'.$ext, // ��� ��������� �����
                                   "upload_dir"   => './../../tmp/tmp_img/', // ����� ��� ��������
                                   "maxThumbSize" => 200, // ������ �������� ��������
                            );
                            if(!$aImage->set($array)){
                                   dump_r('�� ���� ��������� ����');
                            }
                            /** �������� �������� ---------------------------------------------------------------------------------------- */
              } else {
                     dump_r('����� ����!');
              }
              unset($aImage);
       }
       } else {
              echo '<div style="position: absolute;width: 260px; left: 50%; top:5%; margin-left: -130px;"><div class="block red">�� ���������� ����� ��� ������!</div></div>';
       }