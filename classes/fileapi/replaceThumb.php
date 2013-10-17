<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Jurii
 * Date: 16.10.13
 * Time: 23:39
 * To change this template use File | Settings | File Templates.
 * скрипт замены картинки в превью альбома (админка)
 */
 
       include (__DIR__.'/../../inc/config.php');
       include (__DIR__.'/../../inc/func.php');

       error_reporting(1);
       ini_set('display_errors', 1);


       function errLogin(){
              echo '<div style="position: absolute;width: 260px; left: 50%; top:5%; margin-left: -130px;"><div class="block red">Не правильный логин или пароль!</div></div>';
       }


       if (isset($_POST['_filedata'])) {
              if (isset($_FILES['filedata']) && $_FILES['filedata']['size'] != 0) {
                            $ext         = strtolower(substr($_FILES['filedata']['name'], 1 + strrpos($_FILES['filedata']['name'], ".")));
                            $id_album    = trim($_SESSION['current_album']); // название альбома

                            /** загрузка картинки ---------------------------------------------------------------------------------------- */
                            $sImage = new fileapi_resizeUploadedImg();
                            $array  = array (
                                   "_FILESname"   => 'filedata', // имя загружаемого файла в массиве $_FILES
                                   "newThumbName" => 'id'.$id_album.'.'.$ext, // имя конечного файла
                                   "upload_dir"   => './../../images/', // папка для загрузки
                                   "maxThumbSize" => 200, // ширина конечной картинки
                            );
                            if(!$sImage->set($array)){
                                   dump_r('Не могу загрузить файл');
                            }
                            /** загрузка картинки ---------------------------------------------------------------------------------------- */
              } else {
                     dump_r('Битый файл!');
              }
              unset($sImage);
       }