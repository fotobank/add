<?
if(!isset($_SESSION['admin_logged']))
  die();

if(isset($_POST['go_update']))
{
	foreach($_POST as $i => $v)
	{
		if($i != 'go_update')
		  $db->query('update nastr set `param_value` = (?string) where `param_name` = (?string)', array($v,$i));
	}
}

$rs = $db->query('select * from nastr order by id asc', null, 'assoc');
if($rs)
{
	?>

	<form action="index.php" method="post" >
	  <table border="0" style="float: left;margin-bottom: 100px;">
    	<?
	      foreach($rs as $ln)
    	{
    	?>
    	<tr>
    	  <td><?=$ln['param_descr']?></td>
    	  <td><input type="text" name="<?=$ln['param_name']?>" value="<?=$ln['param_value']?>" style="margin-bottom: 10px; width: 600px;"  />
    	</tr>
    	<?
    	}
    	?>
	    <tr>
	      <td colspan="2" align="center">
	        <input class="btn  btn-success" type="hidden" name="go_update" value="1" />
	        <input class="btn btn-success" type="submit" value="Применить" style="margin-top: 15px; margin-left: 20px;">
	      </td>
	    </tr>
	  </table>
	</form>
	<?
}
?>
