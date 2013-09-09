<?php 
$cryptinstall="cryptographp.fct.php";
include $cryptinstall; 
?>


<html>
<form action="verifier.php?<?php echo SID; ?>" method="post">
<table cellpadding=1>
  <tr><td align="center"><?php dsp_crypt(0,1); ?></td></tr>
  <tr><td align="center">Введите код:<br><input type="text" name="code"></td></tr>
  <tr><td align="center"><input type="submit" name="submit" value="Проверить"></td></tr>
</table>
</form>
</html>

