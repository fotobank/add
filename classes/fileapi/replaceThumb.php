<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Jurii
 * Date: 16.10.13
 * Time: 23:39
 * To change this template use File | Settings | File Templates.
 * ������ ������ �������� � ������ ������� (�������)
 */
 
       include __DIR__.'/../../alex/fotobank/Framework/Boot/config.php';
       if (isset($_SESSION['admin_logged'])) {

       if (isset($_POST['_filedata'])) {
              if (isset($_FILES['filedata']) && $_FILES['filedata']['size'] != 0) {
                            $ext         = strtolower(substr($_FILES['filedata']['name'], 1 + strrpos($_FILES['filedata']['name'], ".")));
                            $id_album    = trim($_SESSION['current_album']); // �������� �������

                            /** �������� �������� ---------------------------------------------------------------------------------------- */
                            $sImage = new fileapi_resizeUploadedImg();
                            $array  = array (
                                   "_FILESname"   => 'filedata', // ��� ������������ ����� � ������� $_FILES
                                   "newThumbName" => 'id'.$id_album.'.'.$ext, // ��� ��������� �����
                                   "upload_dir"   => './../../images/', // ����� ��� ��������
                                   "maxThumbSize" => 200, // ������ �������� ��������
                            );
                            if(!$sImage->set($array)){
                                   dump_r('�� ���� ��������� ����');
                            }
                            /** �������� �������� ---------------------------------------------------------------------------------------- */
              } else {
                     dump_r('����� ����!');
              }
              unset($sImage);
           }
       } else {
              echo '<div style="position: absolute;width: 260px; left: 50%; top:5%; margin-left: -130px;"><div class="block red">�� ���������� ����� ��� ������!</div></div>';
       }
