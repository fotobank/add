<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Jurii
 * Date: 11.04.13
 * Time: 18:02
 * To change this template use File | Settings | File Templates.
 */

	include __DIR__.'/../inc/config.php';
	include __DIR__.'/../inc/func.php';


	if (isset($_POST['redirect']))
		{
			main_redir($_POST['redirect']);
			 // ok_exit('Удален каталог: ' .'redirect', $_POST['redirect']);
		}