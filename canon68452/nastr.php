<?
if(!isset($_SESSION['admin_logged']))
  die();

if(isset($_POST['go_update']))
{
	foreach($_POST as $i => $v)
	{
		if($i != 'go_update')
		  mysql_query('update nastr set param_value = \''.mysql_escape_string($v).'\' where param_name = \''.mysql_escape_string($i).'\'');
	}
}

$rs = mysql_query('select * from nastr order by id asc');
if(mysql_num_rows($rs) > 0)
{
	?>
	<form action="index.php" method="post">
  	<table border="0">
    	<?
    	while($ln = mysql_fetch_assoc($rs))
    	{
    	?>
    	<tr>
    	  <td><?=$ln['param_descr']?></td>
    	  <td><input type="text" name="<?=$ln['param_name']?>" value="<?=$ln['param_value']?>" style="margin-bottom: 10px;"  />
    	</tr>
    	<?
    	}
    	?>
	    <tr>
	      <td colspan="2" align="center">
	        <input class="btn  btn-success" type="hidden" name="go_update" value="1" />
	        <input class="btn btn-success" type="submit" value="Применить" style="margin-top: 5px; margin-left: 20px;">
	      </td>
	    </tr>
	  </table>
	</form>
	<?
}
?>
