<?php
       /**
        * создание дампа перемменных
        * Class debugger_SHOWCONTEXT
        */
       class debugger_SHOWCONTEXT	{


              /**
               * @param $html
               * Compresses the html before render
               * string	$html	some html code
               * @return mixed
               */
              protected static function _compressHtml( $html )
              {
                            $html = preg_replace( '!/\*[^*]*\*+([^/][^*]*\*+)*/!' , '' , $html ); // remove comments
                            $html = str_replace( array ( "\r\n" , "\r" , "\n" , "\t" , '  ' , '    ' , '    ' ) , '' , $html ); // tabs,newlines,etc.
                     return $html;
              }

              /**
               * Formats phpinfo() function
               */
              protected static function _buildPhpInfo( )
              {
                     $php_array = static::_phpInfoArray( );
                     $php_array[ 'version' ] = @phpversion( );
                     $php_array[ 'os' ] = @php_uname( );
                     $php_array[ 'extensions' ] = @get_loaded_extensions( );
                     ksort( $php_array );
                     return $php_array;
              }

              /**
               * @return string
               */
              public static function php_INFO() {
               //      $body = '<ul>'.self::_makeSection("phpINFO", self::varExport(self::_phpInfoArray())).'</ul>';
                     $body[] = '<ul>';
                     foreach (self::_buildPhpInfo() as $arr => $arrData){
                         $body[] = self::_makeSection($arr, self::varExport($arrData));
                     }
                     $body[] = '</ul>';
                     $body = join("<div></div>", $body);
                     $body = '<ul>'.self::_makeSection("phpINFO", $body).'</ul>';

                     return $body;

              }

              /**
               * @return string
               */
              public static function php_INFO_mail() {
                     return htmlspecialchars(self::php_INFO(), ENT_QUOTES);
              }


								/**
									* информация SHOW CONTEXT
									*
									* @return string
									*/
								public static function notify() {
                       $body[] = '<ul>';
                       $body[] = self::_makeSection("GET", self::varExport($_GET));
                       $body[] = self::_makeSection("POST", self::varExport($_POST));
								 		   $body[] = self::_makeSection("SESSION", self::varExport(isset($_SESSION) ? $_SESSION : NULL));
										   $body[] = self::_makeSection("SERVER", self::varExport($_SERVER));
                       $body[] = self::_makeSection("COOKIES", self::varExport($_COOKIE));
                       $body[] = '</ul>';
											 return self::_compressHtml(htmlspecialchars(join("<div></div>", $body), ENT_QUOTES));
								}

								/**
									* @param $name
									* @param $body
									*
									* @return string
									*/
								private static function _makeSection($name, $body) {

												$id   = uniqid();
												$body = rtrim($body);
												if ($name) $body = preg_replace('/^/m', '    ', $body);
								//			$body = preg_replace('/^([ \t\r]*\n)+/s', '', $body);
                //      $body = self::_compressHtml($body);
												$body = "<span class=\"contextValeur\" id=\"$id\" style=\"display: none;\">$body</span>";
												$body = iconv('windows-1251', 'utf-8//IGNORE', $body);
												$name = "<span class=\"contextTitre\"
								onclick=\"document.getElementById('$id').style.display=(document.getElementById('$id').style.display == 'block')?'none':'block';\"
								>$name</span>:";

												return '<li>'.$name.$body.'</li>';
								}


								/**
									* var_export clone, without using output buffering.
									* (For calls in ob_handler)
									*
									* @param mixed   $var      to be exported
									* @param integer $maxLevel (recursion protect)
									* @param integer $level    of current indent
									*
									* @return string
									*/
								private static function varExport($var, $maxLevel = 10, $level = 0)	{

												$escapes = "\"\r\t\x00\$";
												$tab     = '    ';
												if (is_bool($var)) {
																return $var ? 'TRUE' : 'FALSE';
												} elseif (is_string($var)) {
																return '"'.addcslashes($var, $escapes).'"';
												} elseif (is_float($var) || is_int($var)) {
																return $var;
												} elseif (is_null($var)) {
																return 'NULL';
												} elseif (is_resource($var)) {
																return 'NULL /* '.$var.' */';
												}
												if ($maxLevel < $level) {
																return 'NULL /* '.(string)$var.' MAX LEVEL '.$maxLevel." REACHED*/";
												}
												if (is_array($var)) {
																$return = "array(<br>";
												} else {
																$return = get_class($var)."::__set_state(array(<br>";
												}
												$offset = str_repeat($tab, $level + 1);
												foreach ((array)$var as $key => $value) {
																$return .= $offset;
																if (is_int($key)) {
																				$return .= $key;
																} else {
																				$return .= '"'.addcslashes($key, $escapes).'"';
																}
																$return .= ' => '.self::varExport($value, $maxLevel, $level + 1).",<br>";
												}

												return $return.str_repeat($tab, $level).(is_array($var) ? ')' : '))');
								}

              /**
               * Formats phpinfo() into an array
               */
              protected static function _phpInfoArray()
              {
                     ob_start();
                     phpinfo();
                     $info_arr = array();
                     $info_lines = explode( "\n" , strip_tags( ob_get_clean() , "<tr><td><h2>" ) );
                     $cat= 'General';
                     $reg_ex = "~<tr><td[^>]+>([^<]*)</td><td[^>]+>([^<]*)</td><td[^>]+>([^<]*)</td></tr>~";
                     foreach ( $info_lines as $line )
                     {
                            preg_match( "~<h2>(.*)</h2>~" , $line , $title) ? $cat = $title[ 1 ] : NULL;	// new cat?
                            if ( preg_match( "~<tr><td[^>]+>([^<]*)</td><td[^>]+>([^<]*)</td></tr>~" , $line , $val ) )
                            {
                                   $info_arr[ $cat ][ $val[ 1 ] ] = $val[ 2 ];
                            }
                            else if ( preg_match( $reg_ex , $line , $val ) )
                            {
                                   $info_arr[ $cat ][ $val[1] ] = array( 'local' => $val[ 2 ] , 'master' => $val[ 3 ] );
                            }
                     }
                     return $info_arr;
              }
				}
