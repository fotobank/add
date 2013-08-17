<?
//системные функции
  error_reporting(E_WARNING);

  function admin_only()
  {
	 if (isset($_COOKIE['admnews']) && $_COOKIE['admnews'] != md5(login().'///'.pass()));
		  {
    if(!$_SESSION['admin_logged']){
		  echo '<div class="title2">Извините ,данная функция доступна только для администратора<br/><a href="index.php">Админка</a></div>';
	 }
  }
}


  function if_adm($str)
  {
	 if (isset($_COOKIE['admnews']) && $_COOKIE['admnews'] == md5(login().'///'.pass()));
		{
  if(!$_SESSION['admin_logged']){
		  return $str;
		}
	 return false;
  }
}


  function login()
  {
	 $db = go\DB\Storage::getInstance()->get('db-for-data');
	    return $db->query('SELECT `admnick` FROM `config` WHERE id=1', '', 'el');
  }


  function pass()
  {
	 $db = go\DB\Storage::getInstance()->get('db-for-data');
	       return $db->query('SELECT `admpass` FROM `config` WHERE id=1', '', 'el');
  }