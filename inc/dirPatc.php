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

		static private $instance = NULL;

		private $current_album;
		private $current_cat;
		private $album_name;


		public function __set($property, $value)
			{

				if ($property == "current_album")
					{
						$this->current_album = intval($value);
					}
				elseif ($property == "current_cat")
					{
						$this->current_cat = $value;
					}
				elseif ($property == "album_name")
					{
						$this->album_name = $value;
					}
			}


		public function __get($property)
			{

				if ($property == "current_album")
					{
						return $this->current_album;
					}
				elseif ($property == "current_cat")
					{
						return $this->current_cat;
					}
				elseif ($property == "album_name")
					{
						return $this->album_name;
					}
				else
					{
						return NULL;
					}
			}


		/**
		 * function Singleton
		 * Создание объекта в единственном экземпляре
		 *
		 * @return null|DirPatc
		 */
		static function getInstance()
				{

					if (self::$instance == NULL)
						{
							self::$instance = new DirPatc ('','','');
						}

					return self::$instance;
				}


	   public function __construct($album_name, $current_album, $current_cat)
			{

				$this->album_name    = $album_name;
				$this->current_album = $current_album;
				$this->current_cat   = $current_cat;
			}

		/*public function __construct()
				{
				}*/

		protected function __clone()
				{
				}

		protected function __wakeup()
				{
				}


	    function  __destruct()
		    {
			    $this->album_name ;
			    $this->current_album;
			    $this->current_cat;

		    }
	}



	class Member
	{

		const MEMBER        = 1;
		const MODERATOR     = 2;
		const ADMINISTRATOR = 3;

		private $username;
		private $level;

		public function __construct($username, $level)
			{

				$this->username = $username;
				$this->level    = $level;
			}

		public function getUsername()
			{

				return $this->username;
			}

		public function getLevel()
			{

				if ($this->level == self::MEMBER)
					{
						return "a member";
					}
				if ($this->level == self::MODERATOR)
					{
						return "a moderator";
					}
				if ($this->level == self::ADMINISTRATOR)
					{
						return "an administrator";
					}

				return "unknown";
			}
	}

	$aMember       = new Member("fred", Member::MEMBER);
	$anotherMember = new Member("mary", Member::ADMINISTRATOR);
	echo $aMember->getUsername()." is ".$aMember->getLevel()."<br>"; // отобразит "fred is a member"
	echo $anotherMember->getUsername()." is ".$anotherMember->getLevel()."<br>"; // отобразит "mary is an administrator"

