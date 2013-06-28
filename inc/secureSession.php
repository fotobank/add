<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Jurii
 * Date: 20.06.13
 * Time: 21:57
 * To change this template use File | Settings | File Templates.
 */

  /**
	* @param bool $isUserActivity
	* @param null $prefix
	* старт сессии
	* @return bool
	*/
  function startSession($isUserActivity=true, $prefix=NULL) {
	 $sessionLifetime = 600; // “аймаут отсутстви€ активности пользовател€ (в секундах)
	 $idLifetime = 60;  // ¬рем€ жизни идентификатора сессии

	 if ( session_id() ) return true;
	 // ≈сли в параметрах передан префикс пользовател€,
	 // устанавливаем уникальное им€ сессии, включающее этот префикс,
	 // иначе устанавливаем общее дл€ всех пользователей им€ (например, SID)
	 session_name('SID'.($prefix ? '_'.$prefix : ''));
	 // ”станавливаем врем€ жизни куки до закрыти€ браузера (контролировать все будем на стороне сервера)
	 ini_set('session.cookie_lifetime', 0);
	 if (!session_start())
		{
		  session_regenerate_id(true);
		}
	 else
		{
		  return false;
		}

	 $t = time();

	 if ( $sessionLifetime ) {
		// ≈сли таймаут отсутстви€ активности пользовател€ задан,
		// провер€ем врем€, прошедшее с момента последней активности пользовател€
		// (врем€ последнего запроса, когда была обновлена сессионна€ переменна€ lastactivity)
		if ( isset($_SESSION['lastactivity']) && isset($_SESSION['logged']) && isset($_SESSION['logged']) == true && $t-$_SESSION['lastactivity'] >= $sessionLifetime ) {
		  // ≈сли врем€, прошедшее с момента последней активности пользовател€,
		  // больше таймаута отсутстви€ активности, значит сесси€ истекла, и нужно завершить сеанс
		  destroySession();
		  return false;
		}
		else {
		  // ≈сли таймаут еще не наступил,
		  // и если запрос пришел как результат активности пользовател€,
		  // обновл€ем переменную lastactivity значением текущего времени,
		  // продлева€ тем самым врем€ сеанса еще на sessionLifetime секунд
		  if ( $isUserActivity ) $_SESSION['lastactivity'] = $t;
		}
	 }

	 if ( $idLifetime ) {
		// ≈сли врем€ жизни идентификатора сессии задано,
		// провер€ем врем€, прошедшее с момента создани€ сессии или последней регенерации
		// (врем€ последнего запроса, когда была обновлена сессионна€ переменна€ starttime)
		if ( isset($_SESSION['starttime']) ) {
		  if ( $t-$_SESSION['starttime'] >= $idLifetime ) {
			 // ¬рем€ жизни идентификатора сессии истекло
			 // √енерируем новый идентификатор
		//	 session_write_close();
			 session_regenerate_id(true);
			 $_SESSION['starttime'] = $t;
		  }
		}
		else {
		  // —юда мы попадаем, если сесси€ только что создана
		  // ”станавливаем врем€ генерации идентификатора сессии в текущее врем€
		  $_SESSION['starttime'] = $t;
		}
	 }

	 return true;
  }

  /**
	* уничтожение сессии
	*/
  function destroySession() {
	 if ( session_id() ) {
		session_unset();
		setcookie(session_name(), session_id(), time()-60*60*24);
		session_destroy();
	 }
  }