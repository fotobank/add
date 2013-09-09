<?php

  require_once(__DIR__.'/../../inc/secureSession.php');
  require_once(__DIR__.'/../../inc/config.php');

  startSession();


class check_Session {

/// Свойства класса

    /**
     * Singleton instance
     * @var check_Session
     */
    private static $_instance = NULL;


    /**
     * Private constructor (singleton class)
     */
    private function __construct() {

    }

    /**
     * Private clone (singleton class)
     */
    private function __clone() {
        //void
    }

    /**
     * Return the singleton instance.
     * @return check_Session
     */
    public static function getInstance() {
        if (self::$_instance === NULL) {
            self::$_instance = new self();
        }
        return self::$_instance;
    }


/// Методы для обработки данных сессии
	 /**
	  * @param $key
	  *
	  * @return mixed
	  */
	private function arrKey($key) {
	   $a = explode("/", $key);
		$b = array();
	foreach ($a as $ln)
		{
		  if($ln != '') $b[] = $ln;
		}
	 return $b;
  }


    /**
     * Get a session value by its key.
     * @param array $key
     * @return mixed
     */

	 public function get($key) {
        if (!$this->has($key)) {
            return NULL;
        }
		$arg = $this->arrKey($key);
		$kol = count($arg);
		if($kol == 1)
		  {
			 return $_SESSION[$arg[0]];
		  }
		 elseif($kol == 2) {
		    return $_SESSION[$arg[0]][$arg[1]];
		  }
		 elseif($kol == 3) {
		    return $_SESSION[$arg[0]][$arg[1]][$arg[2]];
		  }
		 return false;
     }


	 /**
	  * @param $key
	  * @param $value
	  *
	  * @return bool
	  */
	 public function set($key, $value) {

		$arg = $this->arrKey($key);
      $kol = count($arg);
		if($kol == 1)
		{
		  return $_SESSION[$arg[0]] = $value;
		}
		elseif($kol == 2) {
		  return $_SESSION[$arg[0]][$arg[1]] = $value;
		}
		elseif($kol == 3) {
		  return $_SESSION[$arg[0]][$arg[1]][$arg[2]] = $value;
		}
		return false;
    }

    /**
     * Check whether the session has a key.
     * @param  $key
     * @return bool
     */
    public function has($key) {

		$arg = $this->arrKey($key);

		foreach($arg as $kol => $fold)
		  {
			 if($kol == 0)
				{
				  if($this->multi_array_key_exists($fold, $_SESSION) == false) return false;
				}
			 elseif($kol == 1) {
				  if($this->multi_array_key_exists($fold, $_SESSION[$arg[0]]) == false) return false;
			   }
			 elseif($kol == 2) {
				  if($this->multi_array_key_exists($fold, $_SESSION[$arg[0]][$arg[1]]) == false) return false;
			   }
		   }

		return true;
    }


	 /**
	  * multi_array_key_exists function.
	  *
	  * @param mixed $needle The key you want to check for
	  * @param mixed $haystack The array you want to search
	  * @return bool
	  */
	 private function multi_array_key_exists( $needle, $haystack ) {

		foreach ( $haystack as $key => $value ) :

			 if ( $needle === strval($key) )
				return true;

			 /*if ( is_array( $value ) ) :
				  if ( $this->multi_array_key_exists( $needle, $value ) === true )
					 return true;
				  else
					 continue;
			 endif;*/

		endforeach;
		return false;
	 }



	 /**
     * Delete a value from session by its key.
     * @param $key
     * @return void
     */

	 public function del($key) {
        if (!$this->has($key)) {
            return;
        }
		$arg = $this->arrKey($key);
		$kol = count($arg);
		if($kol == 1)
		  {
			 unset($_SESSION[$arg[0]]);
		  }
		elseif($kol == 2) {
		    unset($_SESSION[$arg[0]][$arg[1]]);
		  }
		elseif($kol == 3) {
		    unset($_SESSION[$arg[0]][$arg[1]][$arg[2]]);
		  }

      }
}