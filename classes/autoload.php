<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Jurii
 * Date: 05.09.13
 * Time: 13:52
 * To change this template use File | Settings | File Templates.
 */
   //    require_once (__DIR__.'/../classes/go/DB/autoload.php');
	// автозагрузка классов

class autoload {

	static private $instance = NULL;

	/**
	 * function Singleton
	 * Создание объекта в единственном экземпляре
	 *
	 * @return Error_Processor|null
	 *
	 */

	static function getInstance()
	{
		if (self::$instance == NULL)
		{
			self::$instance = new autoload();
		}
		return self::$instance;
	}


	/**
	 *
	 */
      protected function __construct() {

			if (version_compare(phpversion(), '5.1.0', '<') == true) { die ('PHP5.1 Only'); }
			// Константы:
			define ('DIRSEP', DIRECTORY_SEPARATOR);
			// Узнаём путь до файлов сайта
			$site_path = realpath(__DIR__ . DIRSEP . '..' . DIRSEP) . DIRSEP;
			define ('site_path', $site_path);

		spl_autoload_extensions(".php");
		spl_autoload_register(function ($className) {

			$className = ltrim($className, '\\');
			$fileName  = '';
			$namespace = '';

			if (strpos($className, 'Twig') === 0) {
				return false;
			}

			if ($lastNsPos = strrpos($className, '\\')) {
				$namespace = substr($className, 0, $lastNsPos);
				$className = substr($className, $lastNsPos + 1);
				$fileName  = str_replace('\\', DIRECTORY_SEPARATOR, $namespace).DIRECTORY_SEPARATOR;
			}
			$fileName .= str_replace('_', DIRECTORY_SEPARATOR, $className).'.php';
			$file = site_path.'classes'.DIRSEP.$fileName;

			try {
//		echo $file.'<br>';
				require_once $file;
			} catch (Exception $e) {

						 if (check_Session::getInstance()->has('DUMP_R')) {
										dump_r($e->getMessage());
						 }
			}

			return true;
		});
	}

	function __destruct()
	{

	}

	/**
	 *  __clone()
	 */
	protected function __clone()
	{
	}

	/**
	 *  __wakeup()
	 */
	protected function __wakeup()  { }

}