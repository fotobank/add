<?
if(!isset($_SESSION['admin_logged']))
  die();


  require_once (dirname(__FILE__).'/mysql-backup/mysql_restore.class.php');
  require_once (dirname(__FILE__).'/mysql-backup/mysql_backup.class.php');


 ?>
  <a class="btn btn-info">Восстановление</a>
  <a class="btn btn-info">Восстановление с локального файла</a>
  <a class="btn btn-success">Скачать базу с сервера</a>
  <a class="btn btn-success">Зарезервировать на сервере</a>
<?

$backup_obj = new MySQL_Backup();

//----------------------- EDIT - REQUIRED SETUP VARIABLES -----------------------

$backup_obj->server = 'localhost';
$backup_obj->port = 3306;
$backup_obj->username = 'canon632';
$backup_obj->password = 'fianit8546';
$backup_obj->database = 'creative_ls';

//Tables you wish to backup. All tables in the database will be backed up if this array is null.
$backup_obj->tables = array();

//------------------------ END - REQUIRED SETUP VARIABLES -----------------------

//-------------------- OPTIONAL PREFERENCE VARIABLES ---------------------

//Add DROP TABLE IF EXISTS queries before CREATE TABLE in backup file.
$backup_obj->drop_tables = true;

//Only structure of the tables will be backed up if true.
$backup_obj->struct_only = false;

//Include comments in backup file if true.
$backup_obj->comments = true;

//Directory on the server where the backup file will be placed. Used only if task parameter equals MSB_SAVE.
$backup_obj->backup_dir = $_SERVER['DOCUMENT_ROOT'].'/canon68452/mysql-backup/backup/';

//Default file name format.
$backup_obj->fname_format = 'm_d_Y';

//--------------------- END - OPTIONAL PREFERENCE VARIABLES ---------------------

//---------------------- EDIT - REQUIRED EXECUTE VARIABLES ----------------------

/*
	Task:
		MSB_STRING - Return SQL commands as a single output string.
		MSB_SAVE - Create the backup file on the server.
		MSB_DOWNLOAD - Download backup file to the user's computer.

*/
$task = MSB_SAVE;

//Optional name of backup file if using 'MSB_SAVE' or 'MSB_DOWNLOAD'. If nothing is passed, the default file name format will be used.
$filename = '';

//Use GZip compression if using 'MSB_SAVE' or 'MSB_DOWNLOAD'?
$use_gzip = true;

//--------------------- END - REQUIRED EXECUTE VARIABLES ----------------------

//-------------------- NO NEED TO ANYTHING BELOW THIS LINE --------------------

/*if (!$backup_obj->Execute($task, $filename, $use_gzip))
  {
	 $output = $backup_obj->error;
  }
else
  {
	 $output = 'Operation BACKUP Completed Successfully At: <b>' . date('g:i:s A') . '</b><i> ( Local Server Time )</i>';
  }

echo $output;*/



  $restore_obj = new MySQL_Restore();

  $restore_obj->server = 'localhost';
  $restore_obj->username = 'canon632';
  $restore_obj->password = 'fianit8546';
  $restore_obj->database = 'creative_ls';
  /*if (!$restore_obj->Execute($backup_obj->backup_dir.'07_11_2013.sql.gz', MSR_FILE,  true, false))
	 {
		$output = $restore_obj->error;
	 }
  else
	 {
		$output = 'Operation RESTORE Completed Successfully At: <b>' . date('g:i:s A') . '</b><i> ( Local Server Time )</i>';
	 }

  echo $output;*/

/*
  function Execute($param, $mode = MSR_STRING, $is_compressed = false, $split_only = false)
$param - filename or SQL commands string;
$mode - Type of SQL data: MSR_STRING - param is the string of SQL commands;
  MSR_FILE - param is the filename of SQL file.
 $is_compressed - decompress GZip compressed SQL data (file or string)?
 $split_only - only split SQL content to separate queries without executing them.
*/
?>
<span id="timer" long="30:00">30:00</span>

<script>
  var t = setInterval (function ()
  {
	 function f (x) {return (x / 100).toFixed (2).substr (2)}
	 var o = document.getElementById ('timer'), w = 60, y = o.innerHTML.split (':'),
	  v = y [0] * w + (y [1] - 1), s = v % w, m = (v - s) / w; if (s < 0)
	 var v = o.getAttribute ('long').split (':'), m = v [0], s = v [1];
	 o.innerHTML = [f (m), f (s)].join (':');
  }, 1000);
</script>