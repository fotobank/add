<?php

// ----------------------------------------------------------------------------
//
// Этот класс может быть использован для хранения и получения постоянных значений параметров сессии, которые могут быть восстановлены даже после сеансов истекает. Он использует PHP сессии для хранения значений при переходе пользователя на сайте. Он использует куки для хранения значения за указанный период времени (10 дней по умолчанию), так что эти значения могут быть восстановлены, когда пользователь заходит на сайт позже с помощью новой сессии.
//
// Requirements:
//   PHP >= 4.1.0
//
// ----------------------------------------------------------------------------


class ParamList
{

  var $params = array();
  var $cookie_expired = 0xd2f00;

  function ParamList($init_params, $sess_start = TRUE)
  {
    if ($sess_start)
    {
      session_start();
    }
    if (is_array($init_params))
    {
      $this->params = $init_params;
    }
  }

  function Proceed()
  {
    foreach ($this->params as $key => $value)
    {
      if (isset($_GET[$key]))
      {
        $_SESSION['__sl'][$key] = $_GET[$key];
      }
      elseif (isset($_SESSION['__sl'][$key]))
      {
        $_SESSION['__sl'][$key] = $_SESSION['__sl'][$key];
      }
      elseif (isset($_COOKIE['__sl'][$key]))
      {
        $_SESSION['__sl'][$key] = $_COOKIE['__sl'][$key];
      }
      else
      {
        $_SESSION['__sl'][$key] = $value;
      }
      $this->params[$key] = $_SESSION['__sl'][$key];
      @setcookie("__sl[$key]", $_SESSION['__sl'][$key], time() + $this->cookie_expired);
    }
  }

}

?>