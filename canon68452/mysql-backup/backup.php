<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Jurii
 * Date: 12.07.13
 * Time: 14:29
 * To change this template use File | Settings | File Templates.
 */


  /**
	* Скачать базу с сервера
	*/

  if (isset($_POST['loadDB']))
	 {
		require_once (dirname(__FILE__).'/mysql_backup.class.php');

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
		$backup_obj->backup_dir = '';

//Default file name format.
		$backup_obj->fname_format = 'd_m_y__H_i_s';

//--------------------- END - OPTIONAL PREFERENCE VARIABLES ---------------------

//---------------------- EDIT - REQUIRED EXECUTE VARIABLES ----------------------

		/*
			Task:
				MSB_STRING - Return SQL commands as a single output string.
				MSB_SAVE - Create the backup file on the server.
				MSB_DOWNLOAD - Download backup file to the user's computer.

		*/
		$task = MSB_DOWNLOAD;

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