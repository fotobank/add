<?php include (dirname(__FILE__).'/inc/head.php');
?>

<div id="main">
<h2>���������.</h2>
 <?
if (isset($_GET['login']) && isset($_GET['key'])) {
   $login = $_GET['login'];
   $key = $_GET['key'];
   // ������ �������� login �� ��������� �������
   if (!preg_match("/^\w{3,}$/", $login)) {
      die('������������ ������!');
   }
   $time = time();
      $res = mysql_query("SELECT id, email, status, timestamp FROM users WHERE login='$login' LIMIT 1");
      // ���� �� ������������ � ����� �������?
      if (mysql_num_rows($res) != 1) {
         mysql_close();
         die("<div id='form_reg'>������ ������������ ���!</div>");
      }
      $user = mysql_fetch_row($res);
      // ����� �� ��� �������?
      if ($user[2] == 1) {
         mysql_close();
         die("<div id='form_reg'><h2>������ ����� ��� �����������!</h2></div>");
      }
      // ����� �� ���� ������������ �����? (���� ��� - ������� �� ����)
      if ($user[3] - $time > 5*24*60*60) {
         mysql_query("DELETE FROM users WHERE login='$login' LIMIT 1");
         mysql_close();
         die("<div id='form_reg'>���� ��������� ����! ��������������� ������.</div>");
      }
      $key1 = md5(substr($user[1], 0 ,2).$user[0].substr($login, 0 ,2));
      // �������� "keystring"
      if ($key1 != $key) {
         mysql_close();
         die("<div id='form_reg'>������������ ����������� �����!</div>");
      }
      // ���� ��� �������� �������� - ���������� �����!
      mysql_query("UPDATE users SET status = 1 WHERE login='$login'");
      mysql_close();
	  echo "<div id='form_reg'> ��������� ������ �������.</div>";
}
?>
<div class="end_content"></div>
</div>
<?php include (dirname(__FILE__).'/inc/footer.php');
?>