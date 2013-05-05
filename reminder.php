<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Jurii
 * Date: 22.04.13
 * Time: 14:24
 * To change this template use File | Settings | File Templates.
 */
header('Content-type: text/html; charset=windows-1251');
$cryptinstall = '/inc/captcha/cryptographp.fct.php';
include  'inc/captcha/cryptographp.fct.php';
?>
<!-- восстановление пароля data-focus-on="input:first" -->
	<div class="modal-header" style="background: rgba(229,229,229,0.53)">
		<a class="close" data-dismiss="modal" aria-hidden="true" onClick="$('#result').empty();setTimeout(returnCaptcha (), 1000);">&times;</a>

			<div class="cont-list" style="margin-left: 20%"><div class="drop-shadow curved curved-vt-2">
					<h3><span style="color: #c95030">Восстановление пароля:</span></h3>
				</div></div>
<div style="clear: both"></div><br>
		<div id="result"></div>
	</div>
	<div class="modal-body" style="height: 180px;">
		<form action="" id="reminder" style="margin-top: 15px;">
			<label>
				<input id="name" class="autoclear" data-tabindex="2" title="Ваш логин:" maxlength="20"
					style="margin-left: 8px; width: 250px" type="text" value="Введите Ваш логин:" name="login"/>
			</label> <label>
				<input id="email" class="autoclear" data-tabindex="1"  title="или E-mail:" maxlength="20"
					style="margin-left: 8px; width: 250px" type="text" value="или E-mail:" name="email"/>
			</label> <label style="float: left">
				<input id="captcha" class="autoclear" data-tabindex="3"  title="Проверочное число:" maxlength="20"
					style="margin-left: 8px; width: 250px" type="text" value="Код безопасности:" name="pkey"/>
			</label>
			<div style="margin-top: 5px;"><?php dsp_crypt('cryptographp.cfg.php',1); ?></div>
</form>
</div>
<div class="modal-footer">
	<a class="btn btn-primary" type="reset" onClick="ajaxPostQ('/inc/SendData.php','#result',$('#reminder').serialize()); reload(0,'.<?=SID?>.');">Напомнить</a>
	<a class="btn" data-dismiss="modal"  onClick="$('#result').empty(); setTimeout( 'returnCaptcha ()', 1000);">Закрыть</a>
</div>

