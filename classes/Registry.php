<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Jurii
 * Date: 04.09.13
 * Time: 23:00
 * To change this template use File | Settings | File Templates.
 */
	/**
	 * Class Registry
	 * использование объекта как массива
	 *
	 * Устанавливаем некоторое значение
	 * $registry['name'] = 'Dennis Pallett';
	 *
	 * Получаем значение, используя get()
	 * echo $registry->get ('name');
	 *
	 * Получаем значение, используя доступ как к массиву
	 *
	 * echo $registry['name'];
	 * $registry->set ('db', $db);
	 *
	 */

	Class Registry Implements ArrayAccess {

		private $vars = array();

		function set($key, $var) {

			if (isset($this->vars[$key]) == true) {
				throw new Exception('Unable to set var `' . $key . '`. Already set.');
			}
			$this->vars[$key] = $var;
			return true;
		}

		function get($key) {

			if (isset($this->vars[$key]) == false) {
				return NULL;
			}
			return $this->vars[$key];
		}

		function remove($key) {
			unset($this->vars[$key]);
		}

		function offsetExists($offset) {
			return isset($this->vars[$offset]);
		}

		function offsetGet($offset) {
			return $this->get($offset);
		}

		function offsetSet($offset, $value) {
			$this->set($offset, $value);
		}

		function offsetUnset($offset) {
			unset($this->vars[$offset]);
		}
	}