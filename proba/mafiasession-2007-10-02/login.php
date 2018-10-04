<?php
################################
require_once ("_autoload.php");
################################
$Objeto = new mafiasession();

if($_GET['acao']=="entrar")
{
$Objeto->registersession();
exit;
}else{
extract($Objeto->newserverkey(),EXTR_OVERWRITE);
}
?>
<script src="md5.js" type="text/javascript"></script>
<script src="sha1.js" type="text/javascript"></script>
<script src="base64.js" type="text/javascript"></script>

<form action="login.php?acao=entrar" method="post"
onsubmit="javascript:username.value=encode64(username.value),password.value=encode64(hex_hmac_md5(hex_md5(password.value), salt.value)+'|'+hex_hmac_sha1(hex_sha1(password.value), salt.value ))">
<input type="hidden" name="salt" value="<?=$serverkey?>">
<input type="hidden" name="id" value="<?=$idkey?>">
<p style="text-align:center">
 <table cellspacing="0" class="lined">
   <tr><th>Usuário</th><td class="control"><input type="text"
name="username" size="20" value=""></td></tr>
   <tr><th>Senha</th><td class="control"><input type="password"
name="password" size="20"></td></tr>
   <tr><td colspan="2" class="control"><input type="submit"
value="Entrar"></td></tr>
 </table>
</p>
</form>