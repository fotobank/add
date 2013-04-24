<?php
   set_time_limit(0);
   include (dirname(__FILE__).'/../inc/config.php');
   include (dirname(__FILE__).'/../inc/func.php');

  // Удаление непустых директорий:
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
         die  ('Неверный каталог '.$dir);
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
         }
      ok_exit('Удален каталог: ' .$_POST['confirm_del'], '../canon68452/index.php');
      }

   session_destroy();
?>