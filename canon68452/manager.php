<?
if(!isset($_SESSION['admin_logged']))
  die();



/**
 * Зарезервировать на сервере
 */

if (isset($_POST['rezerv']))
  {
	 require_once (dirname(__FILE__).'/mysql-backup/mysql_backup.class.php');

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

	 if (!$backup_obj->Execute($task, $filename, $use_gzip))
		{
		  $output = $backup_obj->error;
		}
	 else
		{
		  $output = 'Operation BACKUP Completed Successfully At: <b>' . date('g:i:s A') . '</b><i> ( Local Server Time )</i>';
		}

	 echo $output;

  }



/**
 * Восстановление (файл на сервере)
 */
if (isset($_POST['vosst']))
  {
	 require_once (dirname(__FILE__).'/mysql-backup/mysql_restore.class.php');
	 $_SESSION['vosst'] = trim($_POST['qzNameDb']);
	 $restore_obj = new MySQL_Restore();
	 $restore_obj->server = 'localhost';
	 $restore_obj->username = 'canon632';
	 $restore_obj->password = 'fianit8546';
	 $restore_obj->database = 'creative_ls';
	 if (!$restore_obj->Execute($_SESSION['vosst'], MSR_FILE,  true, false))
		 {
			$output = $restore_obj->error;
		 }
	  else
		 {
			$output = 'Operation RESTORE Completed Successfully At: <b>' . date('g:i:s A') . '</b><i> ( Local Server Time )</i>';
		 }

	  echo $output;

	 /*
	  function Execute($param, $mode = MSR_STRING, $is_compressed = false, $split_only = false)
	$param - filename or SQL commands string;
	$mode - Type of SQL data: MSR_STRING - param is the string of SQL commands;
	  MSR_FILE - param is the filename of SQL file.
	 $is_compressed - decompress GZip compressed SQL data (file or string)?
	 $split_only - only split SQL content to separate queries without executing them.
	*/

  }

/**
 * Удаление (файл на сервере)
 */
if (isset($_POST['deleteDB']))
{
  if(isset($_POST['qzNameDb']))
  {
  unlink(trim($_POST['qzNameDb']));
  $_SESSION['vosst'] = 0;
  }
}


/**
 * Восстановление с локального файла
 */
if (isset($_POST['vosstLoc']))
  {
	 require_once (dirname(__FILE__).'/mysql-backup/mysql_restore.class.php');

	 $uploaddir = './../tmp/';
	 $uploadDB = $uploaddir . basename($_FILES['fileDB']['name']);
	 move_uploaded_file($_FILES['fileDB']['tmp_name'], $uploadDB) ;

	 $restore_obj = new MySQL_Restore();

	 $restore_obj->server = 'localhost';
	 $restore_obj->username = 'canon632';
	 $restore_obj->password = 'fianit8546';
	 $restore_obj->database = 'creative_ls';
	 if (!$restore_obj->Execute($uploadDB, MSR_FILE,  true, false))
		 {
			$output = $restore_obj->error;
		 }
	  else
		 {
			$output = 'Operation RESTORE Completed Successfully At: <b>' . date('g:i:s A') . '</b><i> ( Local Server Time )</i>';
		 }

	  echo $output;

	 /*
	  function Execute($param, $mode = MSR_STRING, $is_compressed = false, $split_only = false)
	$param - filename or SQL commands string;
	$mode - Type of SQL data: MSR_STRING - param is the string of SQL commands;
	  MSR_FILE - param is the filename of SQL file.
	 $is_compressed - decompress GZip compressed SQL data (file or string)?
	 $split_only - only split SQL content to separate queries without executing them.
	*/
  }



?>
<h2>Работа с базой данных:</h2>
<table border="0">
  <tr>
	 <td>
		Скачать дамр базы с сервера:
	 </td>
	 <td>
		&nbsp;
	 </td>
	 <td>
		<form action="/canon68452/mysql-backup/backup.php" method="post">
		  <input class="btn btn-success" type="submit" name="loadDB" value="Backup" style="margin-top: 20px; margin-left: 33px; position: relative;">
		</form>
	 </td>
  </tr>
  <tr>
	 <td>
		Зарезервировать дамп на сервере:
	 </td>
	 <td>
		&nbsp;
	 </td>
	 <td>
		<form action="/canon68452/index.php?page=9" method="post">
		  <input class="btn btn-success" type="submit" name="rezerv" value="Backup" style="margin-top: 20px; margin-left: 33px; position: relative;">
		</form>
	 </td>
  </tr>
  <tr>
	 <td colspan="3">
		Восстановление с резервной копии,<br> расположенной на сервере:

<?
  $dir = 'mysql-backup/backup';
  $files = glob($dir."/*.sql*"); // Получаем все sql.gz-файлы из директории

  $current = isset($_SESSION['vosst'])?trim($_SESSION['vosst']):0;
?>
  <div class="controls">
	 <div class="input-append">
		<form action="/canon68452/index.php?page=9" method="post">
		  <label> <select class="span3" name="qzNameDb" style="height: 28px; float: left;">
			 <?
			 foreach ($files as $key =>  $ln)
				{
				  ?>
				  <option value="<?= $files[$key] ?>" <?=($current == $files[$key] ? 'selected="selected"' : '')?>> <?= basename($files[$key]) ?></option>
				  <?
				}
			 ?>
		  </select>
			 <input class="btn btn-info" type="submit" name="vosst" value="Restore">
			</label>
		</form>
	 </div>
  </div>
  <hr/>
	 </td>
  </tr>
  <tr>
	 <td colspan="3">
		Удаление резервной копии,<br> расположенной на сервере:
		<div class="controls">
		  <div class="input-append">
			 <form action="/canon68452/index.php?page=9" method="post">
				<label> <select class="span3" name="qzNameDb" style="height: 28px; float: left;">
					 <?
					 foreach ($files as $key =>  $ln)
						{
						  ?>
						  <option value="<?= $files[$key] ?>" <?=($current == $files[$key] ? 'selected="selected"' : '')?>> <?= basename($files[$key]) ?></option>
						<?
						}
					 ?>
				  </select>
				  <input class="btn btn-info" type="submit" name="deleteDB" value="Delete">
				</label>
			 </form>
		  </div>
		</div>
		<hr/>
	 </td>
  </tr>
  <tr>
	 <td colspan="3">
		Восстановление с локального файла:
  <form action="/canon68452/index.php?page=9" method="post"  enctype='multipart/form-data'>
	 <input type="hidden" name="MAX_FILE_SIZE" value="15000000" />
	 <input type = "file" name = "fileDB"  style="float: left; position: relative; width: 273px;">
	 <input class="btn btn-info" type="submit" name="vosstLoc" value="Restore" style=" position: relative;">
  </form>
	 </td>
  </tr>
</table>