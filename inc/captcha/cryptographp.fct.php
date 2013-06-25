<?php
/*if (session_id() == "")
	{*/
		//session_start();
     require_once(__DIR__.'/../../inc/secureSession.php');
	  startSession();
//	}

$_SESSION['cryptdir'] = dirname($cryptinstall);


function dsp_crypt($cfg = 0, $reload = 1)
	{
		// Отображает криптограммы
		echo"<table><tr><td><img id='cryptogram' src='".$_SESSION['cryptdir']."/cryptographp.php?cfg=".$cfg."&".SID."'></td>";
		if ($reload)
			{
				echo"<td><a title='".($reload == 1 ? '' : $reload)
					."' style=\"cursor:pointer\"
					onclick=
					\"$(' #cryptogram ').attr('src', '".$_SESSION['cryptdir']."/cryptographp.php?cfg=".$cfg."&".SID."&' +Math.round(Math.random(0)*1000)+1);\">
					<img src=\"".$_SESSION['cryptdir']."/images/reload.png\"></a></td>";
			}
		echo "</tr></table>";
	}


function chk_crypt($code)
	{
	  if($code != false || $code != '')
		 {
		// Проверка корректности кода
		include ($_SESSION['configfile']);
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
		if ($_SESSION['cryptcode'] and ($_SESSION['cryptcode'] == $code))
			{
				unset($_SESSION['cryptreload']);
				if ($cryptoneuse)
					{
						unset($_SESSION['cryptcode']);
					}

				return true;
			}
		else
			{
				$_SESSION['cryptreload'] = true;

				return false;
			}

		 } else 	 return true;
	}
?>