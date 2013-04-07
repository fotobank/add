<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Jurii
 * Date: 07.04.13
 * Time: 8:02
 * To change this template use File | Settings | File Templates.
 */

class SetDirPatc {

	static private $instance = NULL;

	private  $current_album;
	private  $current_cat;
	private  $album_name;


	public function setCurrentAlbum ($album_id)
		{
			$this->current_album = intval($album_id);
		}

	public function getCurrentAlbum()
		{
			   return $this->current_album;
	   }

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
					self::$instance = new SetDirPatc ("0","0","0");
				}
			return self::$instance;
		}


    public function __construct( $current_album, $current_cat, $album_name )
		{
         $this->current_album = $current_album;
			$this->current_cat = $current_cat;
			$this->album_name = $album_name;
		}
	protected function __clone() { }
	protected function __wakeup()  { }

}



	class Member {

		 const MEMBER = 1;
		 const MODERATOR = 2;
		 const ADMINISTRATOR = 3;

		 private $username;
		 private $level;

		 public function __construct( $username, $level ) {
		   $this->username = $username;
	      $this->level = $level;
	 }

		 public function getUsername() {
		   return $this->username;
	 }

		 public function getLevel() {
		   if ( $this->level == self::MEMBER ) return "a member";
			 if ( $this->level == self::MODERATOR ) return "a moderator";
	   if ( $this->level == self::ADMINISTRATOR ) return "an administrator";
	   return "unknown";
	 }
		}

	$aMember = new Member( "fred", Member::MEMBER );
	$anotherMember = new Member( "mary", Member::ADMINISTRATOR );
	echo $aMember->getUsername() . " is " . $aMember->getLevel() . "<br>";  // отобразит "fred is a member"
	echo $anotherMember->getUsername() . " is " . $anotherMember->getLevel() . "<br>";  // отобразит "mary is an administrator"