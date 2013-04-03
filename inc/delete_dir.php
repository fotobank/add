<?php

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
        // return false;
      }
}
