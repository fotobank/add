<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Jurii
 * Date: 07.04.13
 * Time: 8:02
 * To change this template use File | Settings | File Templates.
 */


class set_Dir_Patc
{

	static private $instance = NULL;






	function currentAlbum ()
		{

			$album_id =	intval($_GET['album_id']);
           return $album_id;

		}

	/**
	 * function Singleton
	 * Создание объекта в единственном экземпляре
	 *
	 * @return Error_Processor|null
	 *
	 */

	static function getInstance1()
		{
			if (self::$instance == NULL)
				{
					self::$instance = new set_Dir_Patc();
				}
			return self::$instance;
		}

	/**
	 *   __construct()
	 */
	protected  function __construct()
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