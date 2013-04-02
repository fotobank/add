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
         echo  'Неверный каталог '.$dir;
         return false;
      }
}
