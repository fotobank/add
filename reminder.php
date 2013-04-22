<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Jurii
 * Date: 22.04.13
 * Time: 14:24
 * To change this template use File | Settings | File Templates.
 */

$cryptinstall = '/inc/captcha/cryptographp.fct.php';
include  'inc/captcha/cryptographp.fct.php';
?>
<!-- восстановление пароля data-focus-on="input:first" -->
<div id="vosst" class="modal hide fade in animated fadeInDown" style="position: absolute; top: 40%; left: 50%; z-index: 1;
	" data-keyboard="false" data-width="460" data-backdrop="static" tabindex="-1" aria-hidden="false">
	<div class="modal-header" style="background: rgba(229,229,229,0.53)">
		<button type="button" class="close" data-dismiss="modal" aria-hidden="true" onClick="$('#result').empty();reload('kontakti.cfg.php','.<?=SID?>.');">x
		</button>
		<div>
			<h3>
				<span style="font-weight: bold;"><legend>Восстановление пароля:</legend></span>
			</h3>
		</div>
		<div id="result"></div>
	</div>
	<div class="modal-body" style="height: 180px;">
		<form action="" id="reminder" >
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
<input class="btn" type="reset" value="Напомнить"
	onClick="ajaxPostQ('/inc/SendData.php','#result',$('#reminder').serialize()); reload(0,'.<?=SID?>.');"
	style="float: left; margin: 0 0 0 90px;"/>

</form>

</div>
<div class="modal-footer">
	<button type="button" data-dismiss="modal" class="btn" onClick="$('#result').empty();reload('kontakti.cfg.php','.<?=SID?>.');"> Закрыть</button>
</div>
</div>
