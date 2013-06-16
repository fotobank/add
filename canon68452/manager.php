<?
if(!isset($_SESSION['admin_logged']))
  die();

//include (dirname(__FILE__).'/../eXtplorer/index.php');


include (dirname(__FILE__).'/backup_restore_mysql/backup_restore.php');
/**/?><!--
<frameset rows="50%,50%">
<frame src="../eXtplorer/index.php" name="frame1">
</frameset>
<a href="../eXtplorer/index.php" >eXtplorer</a>-->


<!--<a href="../canon68452/DBbackup/index.php" >DB</a>-->
<?
$obj=new Backuprestoresql();   // you can specify information of your server or make it
// default as localhost and user root with no pass
$obj->setDbs('creative_ls');            // leave it blank or * and it will backup entire server
// or specify dbs "more one db1,db2,..."
// caution :: make sure you have rights to write on dbs you choose
$obj->selectTable();        // leave it blank or * and it will backup all tables
// or specify tables "more one table1,table2,..."
$obj->backupData(0,1);     // here will be the backup you can choose compression (0,1)
// ftp (0,1) if you specify ftp you must specify at least host



