<?php
include ('inc/head.php');


?>





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
    $msg = '<span style="color: #E89339; font-size:18px;">Ошибка: "Ни одно из полей не заполнено". Пожалуйста, будьте внимательны.</span>';
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
      $msg = '<span style="color: #E89339; font-size:18px;">Ошибка: "Пользователь не найден."</span>';
    }
	}
	if($msg != '')
	{
		?>
		<div style="color: #E89339; font-size:18px;"><?=$msg?></div>
		<?
	}
}

?>



    <!-- восстановление пароля -->


    <div id="static" class="modal hide fade in animated fadeInDown" data-keyboard="false" data-backdrop="static" tabindex="-1" aria-hidden="false">
        <div class="modal-header">
            <div style="text-align: center;">
                <div>
                    <h2>
                        <hremind><b>Восстановление пароля:</b></hremind>
                    </h2>
                </div>
            </div>
        </div>
        <div class="modal-body">
            <div class="form_reg" style="padding: -10px; color:#ccc; font-size:18px;">
                <br>
                <form action="reminder.php" method="post">
                    <table border="0" cellspacing="5">
                        <tr>
                            <td>E-mail:</td>
                            <td><label> <input class="inp_f_reg" type="text" name="email" value=""/> </label></td>
                        </tr>
                        <tr>
                            <td>или логин:</td>
                            <td><label> <input class="inp_f_reg" type="text" name="login" value=""/> </label></td>
                        </tr>
                        <tr>
                            <td colspan="2" align="center">
                                <input type="hidden" name="go_rem" value="1"/>
                                <input class="metall_knopka" type="submit" value="Напомнить" style="margin-top: 20px;"/>
                            </td>
                        </tr>
                    </table>
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