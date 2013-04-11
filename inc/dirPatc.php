<?php




	/**
	 * Created by JetBrains PhpStorm.
	 * User: Jurii
	 * Date: 07.04.13
	 * Time: 8:02
	 * To change this template use File | Settings | File Templates.
	 */
	class DirPatc
	{
		public static $current_album;
		public static $current_cat;
		public static $album_name;



		public static function __set($property, $value)
			{

				if ($property == "current_album")
					{
						self::$current_album = $value;
					}
				elseif ($property == "current_cat")
					{
						self::$current_cat = $value;
					}
				elseif ($property == "album_name")
					{
						self::$album_name = $value;
					}
			}


		public static function __get($property)
			{

				if ($property == "current_album")
					{
						return self::$current_album;
					}
				elseif ($property == "current_cat")
					{
						return self::$current_cat;
					}
				elseif ($property == "album_name")
					{
						return self::$album_name;
					}
				else
					{
						return NULL;
					}
			}



		protected static $inst;  // object instance
		private function __construct(){ /* ... @return Singleton */ }  // Защищаем от создания через new Singleton
		private function __clone()    { /* ... @return Singleton */ }  // Защищаем от создания через клонирование
		private function __wakeup()   { /* ... @return Singleton */ }  // Защищаем от создания через unserialize

		public static function getInst() {    // Возвращает единственный экземпляр класса. @return Singleton
			if ( is_null(self::$inst) ) {
				self::$inst = new DirPatc ();
			}
			return self::$inst;
		}



		public function destory($property)
			{
				if ($property == "current_album")
					{
						self::$current_album = NULL;
					}
				elseif ($property == "current_cat")
					{
						self::$current_cat = NULL;
					}
				elseif ($property == "album_name")
					{
						self::$album_name  = NULL;
					}
			}


	}


