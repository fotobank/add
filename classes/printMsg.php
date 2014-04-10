<?php
			/**
				* Created by JetBrains PhpStorm.
				* User: Jurii
				* Date: 08.09.13
				* Time: 20:15
				* To change this template use File | Settings | File Templates.
				*
				* СООБЩЕНИЕ ОБ ОШИБКЕ
				*/
			class printMsg {

						private $err_msg = NULL;
						private $ok_msg = NULL;
						private $ok_msg2 = NULL;
						private $msg = NULL;


						function __construct() {

									global $error;
									$session = check_Session::getInstance();
									if (!empty($error))	{
												$this->err_msg = $error;
												unset($error);
									}
									if ($session->has('err_msg') && $session->get('err_msg') != '')	{
												$this->err_msg = $session->get('err_msg');
												$session->del('err_msg');
									}
									// <!-- СООБЩЕНИЕ О УПЕШНОМ ЗАВЕРШЕНИИ-->
									if ($session->has('ok_msg') && $session->get('ok_msg') != '')	{
												$this->ok_msg = $session->get('ok_msg');
												$session->del('ok_msg');
									}
									if ($session->has('ok_msg2') && $session->get('ok_msg2') != '')	{
												$this->ok_msg2 = $session->get('ok_msg2');
												$session->del('ok_msg2');
									}
									   $this->msg = $this->err_msg.$this->ok_msg.$this->ok_msg2;
						}


           /*  public function __toString() {
                    return $this->msg;
             }*/


						public function withJs() {

									if (isset($this->ok_msg2)) {
												echo "
	<script type='text/javascript'>
		dhtmlx.message.expire = 6000;
		dhtmlx.message({ type: 'warning', text: {$this->ok_msg2} });
	</script>";
									}
									if (isset($this->ok_msg2)) {
												$session = check_Session::getInstance();
												echo "
		<script type='text/javascript'>
			humane.success('Добро пожаловать, {$session->get('us_name')}!<br><span>{$this->ok_msg}</span>');
		</script>";
									}
									if (isset($this->err_msg)) {
												echo "
		<script type='text/javascript'>
			dhtmlx.message.expire = 6000; // время жизни сообщения
			dhtmlx.message({ type: 'error', text: 'Ошибка!<br>{$this->err_msg}'});
		</script>";
									}
						}


						public function noJs() {

									?>
									<NOSCRIPT >
												<?
												if (!empty($this->msg)) {
															?>
															<div class="centerErr1" >
																		<div class="centerErr2" >
																					<div align='center' class='drop-shadow lifted center centerErr3' >
																								<?=$this->msg?>
																					</div >
																		</div >
															</div >
												<?
												}
												?>
									</NOSCRIPT >
						<?
						}

			}