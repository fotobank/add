<?php

  // �������� �������� ����������:
function deleteDir($dir)
{
  return is_file($dir)?
  @unlink($dir):
  array_map('deleteDir',glob($dir.'/*'))==@rmdir($dir);
} 
 ?>