<?php
include ('inc/config.php');
include ('inc/func.php');
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
    $rs = mysql_query('select id from photos where id = '.$id);
    if(mysql_num_rows($rs) > 0)
    {
      $balans = floatval(mysql_result(mysql_query('select balans from users where id = '.intval($_SESSION['userid'])),0));
      $vote_price = floatval(get_param('vote_price'));
      if($vote_price <= $balans)
      {
        mysql_query('insert into votes (id_user, id_photo) values ('.intval($_SESSION['userid']).', '.$id.')');
        mysql_query('update photos set votes = votes + 1 where id = '.$id);
        mysql_query('update users set balans = balans - '.$vote_price.' where id = '.intval($_SESSION['userid']));
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

mysql_close();
?>
