<?php
   set_time_limit(0);
   include (dirname(__FILE__).'/../inc/config.php');
   include (dirname(__FILE__).'/../inc/func.php');

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
      }
}

   if (isset($_POST['confirm_del']))
      {
      if ($_POST['confirm_del'] != '0')
         {
         $id = $_POST['confirm_id'];
         $patch = $_POST['confirm_del'];
         deleteDir($patch);
         $db->query('delete from photos where id_album = ?i', array($id));
         $album_foto = $db->query('select img from albums where id = ?i', array($id), 'el');
         unlink("../images/$album_foto");
	      $db->query('delete from albums where id = ?i', array($id));
         }
      ok_exit('������ �������: ' .$_POST['confirm_del'], '../canon68452/index.php');
      }
   session_destroy();
?>