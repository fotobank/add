<?php
include ('inc/head.php');


?>
<div id="main">

<center>
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
    $msg = '<span style="color: #E89339; font-size:18px;">������: "�� ���� �� ����� �� ���������". ����������, ������ �����������.</span>';
	}
	if($where != '')
	{
    $rs = mysql_query('select * from users where '.$where);
    if(mysql_errno() == 0 && mysql_num_rows($rs) > 0)
    {
      $user_data = mysql_fetch_assoc($rs);

      $title = '�������������� ������ �� ����� Creative line studio';
      $headers  = "Content-type: text/plain; charset=windows-1251\r\n";
      $headers .= "From: ������������� Creative line studio \r\n";
      $subject = '=?koi8-r?B?'.base64_encode(convert_cyr_string($title, "w","k")).'?=';
      $letter = "������������, $user_data[us_name]!\r\n";
      $letter.= "���-�� (��������, ��) �������� �������������� ������ �� ����� Creative line studio.\r\n";
      $letter.= "������ ��� ����� �� ����:\r\n";
      $letter.= "   �����: $user_data[login]\r\n";
      $letter.= "   ������: $user_data[pass]\r\n";
      $letter.= "���� �� �� ����������� �������������� ������, ����������, ���������� ��������� � �������������� �����!\r\n";
      // ���������� ������
      if (!mail($user_data['email'], $subject, $letter, $headers))
      {
        $msg = '<span style="color: #E89339; font-size:18px;">������: "�� ������� ��������� ������." ����������, ���������� �����.</span>';
      }
    }
    else
    {
      $msg = '<span style="color: #E89339; font-size:18px;">������: "������������ �� ������."</span>';
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
</center>

<div class="form_reg" style="padding: -10px; color:#ccc; font-size:18px;">
    <center><div><h2><hremind><b>�������������� ������:</b></hremind></h2></div></centerp><br>
    <form action="reminder.php" method="post">
      <table border="0" cellspacing="5">
        <tr>
          <td>E-mail:</td>
          <td><input class="inp_f_reg" type="text" name="email" value="" /></td>
        </tr>
        <tr>
          <td>��� �����:</td>
          <td><input class="inp_f_reg" type="text" name="login" value="" /></td>
        </tr>
        <tr>
          <td colspan="2" align="center">
            <input type="hidden" name="go_rem" value="1" />
            <input class="metall_knopka" type="submit" value="���������"style="margin-top: 20px;"  />
          </td>
        </tr>
      </table>
    </form>
  </div>
</div>
<div class="end_content"></div>
</div>
<?php include ('inc/footer.php');
?>