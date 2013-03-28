<?php
include ('inc/head.php');


?>

echo "
<script type='text/javascript'>
    $(document).ready(function load() {
        $('#vosst').modal('show');
    });
</script>";

<div id="main">
<?
if(isset($_POST['go_rem']))
{
  $where = '';
  $msg = '';
  if(!empty($_POST['email']))
  {
    $where = ' email = \''.mysql_escape_string($_POST['email']).'\'';
  }
  elseif(!empty($_POST['login']))
  {
    $where = ' login = \''.mysql_escape_string($_POST['login']).'\'';
  }
  else
  {
    $msg = "Ошибка: <br>Ни одно из полей не заполнено. Пожалуйста, будьте внимательны.";
	}
	if($where != '')
	{
    $rs = mysql_query('select * from users where '.$where);
    if(mysql_errno() == 0 && mysql_num_rows($rs) > 0)
    {
      $user_data = mysql_fetch_assoc($rs);

      $title = 'Восстановление пароля на сайте Creative line studio';
      $headers  = "Content-type: text/plain; charset=windows-1251\r\n";
      $headers .= "From: Администрация Creative line studio \r\n";
      $subject = '=?koi8-r?B?'.base64_encode(convert_cyr_string($title, "w","k")).'?=';
      $letter = "Здравствуйте, $user_data[us_name]!\r\n";
      $letter.= "Кто-то (возможно, Вы) запросил восстановление пароля на сайте Creative line studio.\r\n";
      $letter.= "Данные для входа на сайт:\r\n";
      $letter.= "   логин: $user_data[login]\r\n";
      $letter.= "   пароль: $user_data[pass]\r\n";
      $letter.= "Если вы не запрашивали восстановление пароля, пожалуйста, немедленно свяжитесь с администрацией сайта!\r\n";
      // Отправляем письмо
      if (!mail($user_data['email'], $subject, $letter, $headers))
      {
        $msg = '<span style="color: #E89339; font-size:18px;">Ошибка: "Не удалось отправить письмо." Пожалуйста, попробуйте позже.</span>';
      }
    }
    else
    {
      $msg = "Ошибка:<br> Пользователь не найден.";
    }
	}
	if($msg != '')
	{
		echo
        "<script type='text/javascript'>
        dhtmlx.message({ type:'error', text:'$msg'})
        </script>";

	}
}

?>


    <!-- восстановление пароля -->


    <div id="vosst" class="modal hide fade in animated fadeInDown" data-keyboard="false" data-backdrop="static" tabindex="-1" aria-hidden="false">
        <div class="modal-header" style="background: rgba(229,229,229,0.53)">
            <div>
                <h3>
                    <b>Восстановление пароля захода на сайт:</b>
                </h3>
            </div>
        </div>
        <div class="modal-body">
            <div class="form_reg" style="color:#000; font-size:16px;">
                <form action="/reminder.php" method="post">
                   <label> Введите E-mail:  <input class="inp_f_reg" style="margin-left: 8px; width: 200px" type="text" name="email" value=""/> </label>
                    <label style="float: left">или логин:  <input class="inp_f_reg" style="margin-left: 35px; width: 200px" type="text" name="login" value=""/> </label>
                    <input type="hidden" name="go_rem" value="1"/>
                    <input class="btn" type="submit" value="Напомнить" style="float: right; margin: -10px 0 0 0 "/>
                </form>
            </div>
        </div>
        <div class="modal-footer">
            <button type="button" data-dismiss="modal" class="btn" onClick="window.document.location.href='/index.php'">
                Закрыть
            </button>
        </div>
    </div>
</div>


    <div class="end_content"></div>
</div>
<?php include ('inc/footer.php');
?>