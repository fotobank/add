<?php
		//session_start();
     require_once(__DIR__.'/../../inc/secureSession.php');
	  startSession();

		 require_once (__DIR__.'/../../classes/dump_r/dump_r.php');
		 try {
					require_once (__DIR__.'/../../classes/autoload.php');
					autoload::getInstance();
		 } catch (Exception $e) {

					if(check_Session::getInstance()->has('DUMP_R')) dump_r($e->getMessage());

		 }

		 $session = check_Session::getInstance();

		 $session->set('cryptdir', dirname($cryptinstall));



function dsp_crypt($cfg = 0, $reload = 1)
	{
			 $session = check_Session::getInstance();
		// Отображает криптограммы
		echo"<table><tr><td><img id='cryptogram' src='".$session->get('cryptdir')."/cryptographp.php?cfg=".$cfg."&".SID."'></td>";
		if ($reload)
			{
				echo"<td><a title='".($reload == 1 ? '' : $reload)
					."' style=\"cursor:pointer\"
					onclick=
					\"$(' #cryptogram ').attr('src', '".$session->get('cryptdir')."/cryptographp.php?cfg=".$cfg."&".SID."&'+Math.round(Math.random(0)*1000)+1);\">
					<img src=\"".$session->get('cryptdir')."/images/reload.png\"></a></td>";
			}
		echo "</tr></table>";
	}


function chk_crypt($code)
	{
			 $session = check_Session::getInstance();
	  if($code != false || $code != '')
		 {
		// Проверка корректности кода


if($session->has('configfile')) {

		include_once ($session->get('configfile'));
		$code = addslashes($code);
		$code = str_replace(' ', '', $code); // удаление введенных по ошибке пробелов
		$code = ($difuplow ? $code : strtoupper($code));
		switch (strtoupper($cryptsecure))
		{
			case "MD5"  :
					$code = md5($code);
					break;
			case "SHA1" :
					$code = sha1($code);
					break;
		}
		if ($session->get('cryptcode') == $code)
			{
					 $session->del('cryptreload');

				if ($cryptoneuse)
					{
						$session->del('cryptcode');
					}

				return true;
			}
		else
			{
					 $session->set('cryptreload', true);

				return false;
			}

		 } else return true;

	}
			 return false;
	}
?>