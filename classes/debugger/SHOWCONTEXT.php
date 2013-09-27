<?php
       /**
        * создание дампа перемменных
        * Class debugger_SHOWCONTEXT
        */
       class debugger_SHOWCONTEXT	{

								/**
									* информация SHOW CONTEXT
									*
									* @return string
									*/
								public static function notify() {

												$body[] = '<ul>'.self::_makeSection("SESSION", self::varExport(isset($_SESSION) ? $_SESSION : NULL));
												$body[] = self::_makeSection("GET", self::varExport($_GET));
												$body[] = self::_makeSection("POST", self::varExport($_POST));
												$body[] = self::_makeSection("COOKIES", self::varExport($_COOKIE));
												$body[] = self::_makeSection("SERVER", self::varExport($_SERVER)).'</ul>';

												return join("<br>", $body);
								}

								/**
									* @param $name
									* @param $body
									*
									* @return string
									*/
								private static function _makeSection($name, $body) {

												$id = uniqid();
												$body = rtrim($body);
												if ($name) $body = preg_replace('/^/m', '    ', $body);
												$body = preg_replace('/^([ \t\r]*\n)+/s', '', $body);
												$body = "<span class=\"contextValeur\" id=\"$id\" style=\"display: none;\">$body</span>";
												$body    = iconv('windows-1251', 'utf-8', $body);
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

												return $return
																			.str_repeat($tab, $level)
																			.(is_array($var) ? ')' : '))');
								}
				}
