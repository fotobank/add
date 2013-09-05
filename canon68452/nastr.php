<?
if (!isset($_SESSION['admin_logged'])) {
	die();
}

if (isset($_POST['go_update'])) {
	$nam = array();
	foreach ($_POST as $i => $val) {
		if ($i != 'go_update') {
			$nam = explode("|", $i);
			$db->query('update `nastr` set `param_value` = ?string where `param_name` = ?string and `param_index` = ?i',
						  array($val, $nam['0'], $nam['1']));
		}
	}
}

$rs = $db->query('select * from nastr order by id asc', NULL, 'assoc');
if ($rs) {
	?>

	<form action="index.php" method="post">
		<table border="0" style="float: left;margin-bottom: 100px;">
			<?
			foreach ($rs as $ln) {
				?>
				<tr>
					<td><?=$ln['param_descr']?></td>
					<td><label> <input type="text" name="<?= $ln['param_name'].'|'
							 .$ln['param_index'] ?>" value="<?= $ln['param_value'] ?>" style="margin-bottom: 10px; width: 600px;"/>
						</label>
				</tr>
			<?
			}
			?>
			<tr>
				<td colspan="2" align="center">
					<input class="btn  btn-success" type="hidden" name="go_update" value="1"/>
					<input class="btn btn-success" type="submit" value="Применить" style="margin-top: 15px; margin-left: 20px;">
				</td>
			</tr>
		</table>
	</form>
<?
}
?>
