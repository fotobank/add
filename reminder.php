<?php
	//	include  __DIR__.'./inc/head.php';
	//	include __DIR__.'./inc/config.php';
	//	include __DIR__.'./inc/func.php';
	//	include __DIR__.'./inc/lib_mail.php';
	//	include __DIR__.'./inc/lib_ouf.php';
	//	include __DIR__.'./inc/lib_errors.php';
	//	$error_processor = Error_Processor::getInstance();
?>
	<!--<link rel="shortcut icon" type="image/vnd.microsoft.icon" href="/favicon.ico"/>
	<link rel="shortcut icon" href="/img/ico_nmain.gif"/>
	<link href="/css/dynamic-to-top.css" rel="stylesheet" type="text/css"/>
	<!-- кнопка вверх -->
	<!--<link href="/css/bootstrap.css" rel="stylesheet"/>
	<link rel="stylesheet" href="/css/lightbox.css" type="text/css" media="screen"/>


	<script src="/js/jquery.js"></script>
	<script src="/js/bootstrap.min.js"></script>
	<script src="/js/main.js"></script>-->

	<!--        <script src="/js/no-copy.js"></script>-->


	<!--<link href="/css/animate.css" rel="stylesheet" type="text/css"/>
	<link href="/css/bootstrap-modal.css" rel="stylesheet" type="text/css"/>
	<script src="/js/bootstrap-modalmanager.js"></script>
	<script src="/js/bootstrap-modal.js"></script>-->

	<!--сообщения-->
	<!--<link href="/js/jsmessage/codebase/themes/message_default.css" rel="stylesheet" type="text/css"/>
	<script type="text/javascript" src="/js/jsmessage/codebase/message.js"></script>
-->

	<!--сообщения-->
	<!--	<link href="/js/humane/themes/jackedup.css" rel="stylesheet" type="text/css"/>-->
	<!--        <link href="/js/humane/themes/libnotify.css" rel="stylesheet" type="text/css"/>-->
	<!--        <link href="/js/humane/themes/bigbox.css" rel="stylesheet" type="text/css"/>-->
	<!--	<script type="text/javascript" src="/js/humane/humane.js"></script>-->

	<!--	<link href="/css/main.css" rel="stylesheet" type="text/css"/>-->
<?

	/*if (isset($_SERVER["HTTP_REFERER"]) and !isset($_SESSION["back"]))
		{*/
	if (isset($_POST['reminder']))
		{
			$_SESSION["back"] = $_SERVER["HTTP_REFERER"];
			/*}*/
			$modal = intval($_POST['reminder']);
		}
//	$modal = 1;
	if (isset($_POST['go_rem']))
		{
			$where = '';
			$msg   = '';
			if (!empty($_POST['email']))
				{
					$where = ' email = \''.mysql_escape_string($_POST['email']).'\'';
				}
			elseif (!empty($_POST['login']))
				{
					$where = ' login = \''.mysql_escape_string($_POST['login']).'\'';
				}
			else
				{
					$msg = "Ошибка:<br>Необходимо заполнить<br> одно из полей.";
				}
			if ($where != '')
				{
					$rs = mysql_query('select * from users where '.$where);
					if (mysql_errno() == 0 && mysql_num_rows($rs) > 0)
						{
							$user_data = mysql_fetch_assoc($rs);
							$title     = 'Восстановление пароля на сайте Creative line studio';
							$headers   = "Content-type: text/plain; charset=windows-1251\r\n";
							$headers .= "From: Администрация Creative line studio \r\n";
							$subject = '=?koi8-r?B?'.base64_encode(convert_cyr_string($title, "w", "k")).'?=';
							$letter  = "Здравствуйте, $user_data[us_name]!\r\n";
							$letter .= "Кто-то (возможно, Вы) запросил восстановление пароля на сайте Creative line studio.\r\n";
							$letter .= "Данные для входа на сайт:\r\n";
							$letter .= "   логин: $user_data[login]\r\n";
							$letter .= "   пароль: $user_data[pass]\r\n";
							$letter .= "Если вы не запрашивали восстановление пароля, пожалуйста, немедленно свяжитесь с администрацией сайта!\r\n";
							// Отправляем письмо
							if (!mail($user_data['email'], $subject, $letter, $headers))
								{
									$msg = "Ошибка:<br> Не удалось отправить письмо. Пожалуйста, попробуйте позже.";
								}
							else
								{
									echo "<script type='text/javascript'>
										        dhtmlx.message({ type:'warning', text:'Запрос выполнен.<br>Новый пароль отправлен<br> на Ваш email.'});
										        </script>";
									$modal = 0;
								}
						}
					else
						{
							$msg = "Ошибка:<br> Пользователь не найден.";
						}
				}
			if ($msg != '')
				{
					echo
					"<script type='text/javascript'>
				           dhtmlx.message({ type:'error', text:'$msg'})
				       </script>";
				}
		}
	if ($modal == 1)
		{
			?>
			<script type='text/javascript'>
				$('#vosst').modal('show');
			</script>
		<?
		}
	else
		{
			$back = $_SESSION["back"];
			unset($_SESSION["back"]);
			?>
			<script type='text/javascript'>
				window.document.location.href = '<?=$back?>'
			</script>
		<?
		}


?>

	<!--	<div id="main">-->


	<!-- восстановление пароля -->
	<div id="vosst" class="modal hide fade in animated fadeInDown" style="position: absolute; top: 40%; left: 50%; z-index: 1;
	" data-keyboard="false" data-width="460" data-focus-on="input:first" data-backdrop="static" tabindex="-1" aria-hidden="false">
		<div class="modal-header" style="background: rgba(229,229,229,0.53)">
			<div>
				<h3>
					<b>Восстановление пароля захода на сайт:</b>
				</h3>
			</div>
		</div>
		<div class="modal-body">
			<div class="form_reg" style="color:#000; font-size:16px;">
				<form action="index.php" method="post">
					<label>Введите Ваш логин:
						<input data-tabindex="2" maxlength="20" class="inp_f_reg" style="margin-left: 8px; width: 150px" type="text" name="login" value=""/>
					</label> <label style="float: left"> или E-mail:
						<input data-tabindex="1" maxlength="20" class="inp_f_reg" style="margin-left: 60px; width: 150px" type="text" name="email" value=""/>
					</label> <input type="hidden" name="go_rem" value="1"/>
					<input class="btn" type="submit" value="Напомнить" style="float: right; margin: -10px 0 0 0 "/>
				</form>
			</div>
		</div>
		<div class="modal-footer">
			<form action="/inc/redirect.php" method="post">
				<button type="submit" class="btn" name="redirect" value="<?= $_SESSION['back'] ?>"> Назад</button>
			</form>
		</div>
	</div>



	<!--	</div>-->

	<!--	<div class="end_content"></div>
		</div>
	--><?php
	/*	include ('inc/footer.php');
	*/
?>