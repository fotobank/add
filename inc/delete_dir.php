<?php
   set_time_limit(0);
   include __DIR__.'/../inc/config.php';
   include __DIR__.'/../inc/func.php';

  // �������� �������� ����������:
function deleteDir($dir)
{
   if ($dir != $_SERVER['DOCUMENT_ROOT'])
      {
        return is_file($dir)?
        @unlink($dir):
        array_map('deleteDir',glob($dir.'/*'))==@rmdir($dir);
      }
   else
      {
         die  ('�������� ������� '.$dir);
        // return false;
      }
}



   if (isset($_POST['confirm_del']))
      {
      if ($_POST['confirm_del'] != '0')
         {
         $id = intval($_POST['confirm_id']);
         $patch = $_POST['confirm_del'];
         deleteDir($patch);
         mysql_query('delete from photos where id_album = '.$id);
         $album_foto = mysql_result(mysql_query('select img from albums where id = '.$id), 0);
         unlink("../images/$album_foto");
         mysql_query('delete from albums where id = '.$id);
         //echo  '������ �������: '.$patch;

         }
      main_redir('../canon68452/index.php');
      }