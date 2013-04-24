<?php include (dirname(__FILE__).'/inc/head.php');
?>

<div id="main">
<h2>Активация.</h2>
 <?
if (isset($_GET['login']) && isset($_GET['key'])) {
   $login = $_GET['login'];
   $key = $_GET['key'];
   // Делаем проверку login на нехорошие символы
   if (!preg_match("/^\w{3,}$/", $login)) {
      die('Неправильная ссылка!');
   }
   $time = time();
      $res = mysql_query("SELECT id, email, status, timestamp FROM users WHERE login='$login' LIMIT 1");
      // Есть ли пользователь с таким логином?
      if (mysql_num_rows($res) != 1) {
         mysql_close();
         die("<div id='form_reg'>Такого пользователя нет!</div>");
      }
      $user = mysql_fetch_row($res);
      // Может он уже активен?
      if ($user[2] == 1) {
         mysql_close();
         die("<div id='form_reg'><h2>Данный логин уже подтвержден!</h2></div>");
      }
      // Успел ли юзер активировать логин? (если нет - удаляем из базы)
      if ($user[3] - $time > 5*24*60*60) {
         mysql_query("DELETE FROM users WHERE login='$login' LIMIT 1");
         mysql_close();
         die("<div id='form_reg'>Срок активации истёк! Регистрируйтесь заново.</div>");
      }
      $key1 = md5(substr($user[1], 0 ,2).$user[0].substr($login, 0 ,2));
      // Поверяем "keystring"
      if ($key1 != $key) {
         mysql_close();
         die("<div id='form_reg'>Неправильная контрольная сумма!</div>");
      }
      // Если все проверки пройдены - активируем логин!
      mysql_query("UPDATE users SET status = 1 WHERE login='$login'");
      mysql_close();
	  echo "<div id='form_reg'> Активация прошла успешно.</div>";
}
?>
<div class="end_content"></div>
</div>
<?php include (dirname(__FILE__).'/inc/footer.php');
?>