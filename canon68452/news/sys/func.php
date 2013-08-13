<?
//системные функции
error_reporting(E_WARNING);

function admin_only()
{
  $db = go\DB\Storage::getInstance()->get('db-for-data');
  $rpa = $db->query('SELECT `admnick` FROM `config` WHERE id=1','','el');
  $rpp = $db->query('SELECT `admpass` FROM `config` WHERE id=1','','el');
if(@$_COOKIE['admnews'] != "$rpa///$rpp"){
		echo '<div class="title2">Извините ,данная функция доступна только для администратора<br/><a href="admin.php">Админка</a></div>';
		}
}

function if_adm($str){
  $db = go\DB\Storage::getInstance()->get('db-for-data');
  $rpa = $db->query('SELECT `admnick` FROM `config` WHERE id=1','','el');
  $rpp = $db->query('SELECT `admpass` FROM `config` WHERE id=1','','el');
if(@$_COOKIE['admnews'] == "$rpa///$rpp"){
		return $str;
  }
  return false;
}