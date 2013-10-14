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

   if (!isset($_POST['confirm_del']))
      {

		  deleteDir($_POST['path']);

      if ($_POST['thumb'] == '/')
         {
         $id = $_POST['confirm_id'];
         go\DB\query('delete from photos  where id_album = ?i', array($id));
	       go\DB\query('delete from accordions where id_album = ?i', array($id));
         $album_foto = go\DB\query('select img from albums where id = ?i', array($id), 'el');
         if(file_exists("../images/$album_foto")) {
         @unlink("../images/$album_foto");
         }
	      go\DB\query('delete from albums where id = ?i', array($id));
         }

      ok_exit('Удален каталог: ' .$_POST['path'], '../canon68452/index.php');
		destroySession();

      }
  main_redir();
?>