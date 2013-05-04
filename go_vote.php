<?php
include (dirname(__FILE__).'/inc/config.php');
include (dirname(__FILE__).'/inc/func.php');
ob_start();
$id = intval($_POST['id']);
$status = 'ERR';
$msg = 'File not found!';
if(!isset($_SESSION['logged']))
{
  $msg = 'Голосование доступно только загегистрированным пользователям. Пожалуйста, зарегистрируйтесь и войдите на сайт под своим именем!';
}
else
{
  if($id > 0)
  {
    $rs = $db->query('select id from photos where id = ?i', array($id), 'el');
    if($rs)
    {
      $balans = floatval($db->query('select balans from users where id = ?i', array($_SESSION['userid']), 'el'));
      $vote_price = floatval(get_param('vote_price'));
      if($vote_price <= $balans)
      {
	      $db->query('insert into votes (id_user, id_photo) values (?i,?i)',array($_SESSION['userid'], $id));
	      $db->query('update photos set votes = votes + 1 where id = ?i',array($id));
	      $db->query('update users set balans = balans - ? where id = ?i', array($vote_price, $_SESSION['userid']));
        $status = 'OK';
      }
      else
      {
        $msg = 'На Вашем счете недостаточно денег!';
      }
    }
  }
}
ob_end_clean();

echo json_encode(array('status' => $status, 'msg' => $msg));

$db->close(true);
?>
