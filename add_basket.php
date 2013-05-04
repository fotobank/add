<?php
include (dirname(__FILE__).'/inc/config.php');
ob_start();
$id = $_POST['id'];
$status = 'ERR';
$msg = 'File not found!';
if(!isset($_SESSION['logged']))
{
  $msg = 'Пожалуйста, зарегистрируйтесь и войдите на сайт под своим именем.';
}
else
{
  if($id)
  {
    $rs = $db->query('select id from photos where id = ?i', array($id), 'el');
    if($rs)
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
$db->close(true);
?>