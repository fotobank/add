<?php
       require_once __DIR__.'/../../inc/secureSession.php';
       require_once __DIR__.'/../../inc/config.php';
       startSession();



       class check_Session {

              /// Свойства класса

              /**
               * Singleton instance
               *
               * @var check_Session
               */
              private static $_instance;


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
               *
               * @return check_Session
               */
              public static function getInstance(): \check_Session {

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

                     $a = explode('/', $key);
                     $b = array();
                     foreach ($a as $ln) {
                            if ($ln !== '') {
                                   $b[] = $ln;
                            }
                     }

                     return $b;
              }


              /**
               * Get a session value by its key.
               *
               * @param string $key
               *
               * @return mixed
               */
              public function get($key) {

                     if (!$this->has($key)) {
                            return NULL;
                     }
                     $arg   = $this->arrKey($key);
                     $total = count($arg);
                     if ($total === 1) {
                            return $_SESSION[$arg[0]];
                     }
                     if ($total === 2) {
                            return $_SESSION[$arg[0]][$arg[1]];
                     }
                     if ($total === 3) {
                            return $_SESSION[$arg[0]][$arg[1]][$arg[2]];
                     }

                     return false;
              }


              /**
               * @param $key
               * @param $value
               *
               * @return bool | array
               */
              public function set($key, $value) {

                     $arg   = $this->arrKey($key);
                     $total = count($arg);
                     if ($total === 1) {
                            return $_SESSION[$arg[0]] = $value;
                     }
                     if ($total === 2) {
                            return $_SESSION[$arg[0]][$arg[1]] = $value;
                     }
                     if ($total === 3) {
                            /** @noinspection UnsupportedStringOffsetOperationsInspection */
                            return $_SESSION[$arg[0]][$arg[1]][$arg[2]] = $value;
                     }

                     return false;
              }


              /**
               * @param     $key
               * @param int $value
               *
               * @return bool
               */
              public function inc($key, $value = 1): bool {

                     $this->set($key, $this->get($key) + $value);

                     return true;
              }


              /**
               * @param     $key
               * @param int $value
               *
               * @return bool
               */
              public function dec($key, $value = 1): bool {

                     $this->set($key, $this->get($key) - $value);

                     return true;
              }


              /**
               * Check whether the session has a key.
               *
               * @param  $key
               *
               * @return bool
               */
              public function has($key): bool {

                     $arg = $this->arrKey($key);
                     foreach ($arg as $total => $fold) {
                            if ($total === 0) {
                                   if ($this->multi_array_key_exists($fold, $_SESSION) === false) {
                                          return false;
                                   }
                            } elseif ($total === 1) {
                                   if ($this->multi_array_key_exists($fold, $_SESSION[$arg[0]]) === false) {
                                          return false;
                                   }
                            } elseif ($total === 2) {
                                   if ($this->multi_array_key_exists($fold, $_SESSION[$arg[0]][$arg[1]]) === false) {
                                          return false;
                                   }
                            }
                     }

                     return true;
              }


              /**
               * multi_array_key_exists function.
               *
               * @param mixed $needle   The key you want to check for
               * @param mixed $haystack The array you want to search
               *
               * @return bool
               */
              private function multi_array_key_exists($needle, $haystack): bool {

                     foreach ($haystack as $key => $value) :
                            if ($needle === (string)$key) {
                                   return true;
                            }
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
               *
               * @param $key
               *
               * @return void
               */
              public function del($key): void {

                     if (!$this->has($key)) {
                            return;
                     }
                     $arg   = $this->arrKey($key);
                     $total = count($arg);
                     if ($total === 1) {
                            unset($_SESSION[$arg[0]]);
                     } elseif ($total === 2) {
                            unset($_SESSION[$arg[0]][$arg[1]]);
                     } elseif ($total === 3) {
                            unset($_SESSION[$arg[0]][$arg[1]][$arg[2]]);
                     }

              }
       }
