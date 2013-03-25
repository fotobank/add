<?php
include ('inc/config.php');
ob_start();
$id = intval($_POST['id']);
$status = 'ERR';
$msg = 'File not found!';
if(!isset($_SESSION['logged']))
{
  $msg = 'Пожалуйста, зарегистрируйтесь и войдите на сайт под своим именем.';
}
else
{
  if($id > 0)
  {
    $rs = mysql_query('select id from photos where id = '.$id);
    if(mysql_num_rows($rs) > 0)
    {
      if(!isset($_SESSION['basket']))
        $_SESSION['basket'] = array();
      $_SESSION['basket'][$id] = 1;
      $status = 'OK';
    }
  }
}
ob_end_clean();

echo json_encode(array('status' => $status, 'msg' => $msg));

mysql_close();
?>
