<?php
set_magic_quotes_runtime(0);
error_reporting(0);


include 'conf.php';
include 'func.php';
// Стартуем сессию
session_start();
header("http/1.0 200 Ok");
 header("Cache-Control: no-store, no-cache, must-revalidate");  // HTTP/1.1
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache");                          // HTTP/1.0
if(!isset($_SESSION['Ok'])) redir('login.php');

clearstatcache();
//die($_POST['fcount']);
// Lets go

//my_delete('F:\\TEMP\\New_Folder\\zviir.zip');





// Загрузим шаблоны
define('TPL_FILE', f_get("./tpl/tpl_file.php"));
define('TPL_SUB', f_get("./tpl/tpl_sub.php"));


// Админ?
if(isset($_SESSION['Adm'])) define('ADM_REF', '<a href="admin.php">Администрирование</a>&nbsp;&nbsp;');
else define('ADM_REF', '');

/////////////////////////// Текущая директория ////////////////////
// Получить список директории + отформатировать его

if(!isset($_GET['dir'])) $_GET['dir']='/';
else $_GET['dir']=escape_dir($_GET['dir']);

define ('CDIR', $_GET['dir']);
if(CDIR=='/') define('CD', "");
else define('CD', CDIR);
define('DIR_HISTORY', split_dir(CDIR));

////////////////////////////////////////

////////////////////// Буферизуем данные от пользователя + выполним его действие////////////////
if(isset($_POST['act'])) $act=$_POST['act'];
else $act=0;


if(($act==1)||($act==2)||($act==4)||($act==6)||($act==7)||($act==8)||($act==9)||($act==10))
$arr=getpostfiles();


switch($act)
{
       case 1:    // Копировать

              unset($_SESSION['buffer']);
              $_SESSION['action']=1;
              $_SESSION['buffer']=$arr;
              $_SESSION['path']=$_POST['curdir'];

       break;

       case 2:   // Вырезать

              unset($_SESSION['buffer']);
              $_SESSION['action']=2;
              $_SESSION['buffer']=$arr;
              $_SESSION['path']=$_POST['curdir'];

       break;

       case 3:   // Вставить

            paste($_SESSION['action']);
         /*   if($_SESSION['action']==2) */unset($_SESSION['buffer']);

       break;

       case 4:   // Удалить

            foreach($arr as $v) my_delete(makepath($_POST['curdir'],$v));

            break;

       case 5:   // Новая папка

            $n=$_POST['str'];

            if($n=='') break;

            $n=escape_dir($n);

            mkdir(makepath($_POST['curdir'],$n),0777);
            break;

       case 6:    // Смена прав

              $p=makeperms($_POST['str']);

              foreach($arr as $v)  chmod(makepath($_POST['curdir'],$v),$p);

        break;

       case 7:  // Смена прав (рекурсивно)

              $p=makeperms($_POST['str']);

              foreach($arr as $v) my_chmod(makepath($_POST['curdir'],$v),$p);
              break;

       case 8:  // Раззиповать

            include 'zip.php';
             //die('unzip');
           foreach($arr as $v)
       {

           $p=makepath($_POST['curdir'], $v.'_unzipped');


           $t=microtime();
           $tmp_nam=time().$t{2}.$t{4};

           $s='./tmp/'.$tmp_nam;

           mkdir($s);
           $z=new PclZip(makepath($_POST['curdir'],$v));
           @$z->extract($s);

           @rename($s, makepath($_POST['curdir'],$v.'_unzipped'));
           @my_delete($s);

       };
       case 9:    // Переименовать

           foreach($arr as $v)
           {
               $n=$_POST['str'];

               $n=escape_dir($n);

               rename(makepath($_POST['curdir'], $v), makepath($_POST['curdir'], $n));
               break;

           }
           break;

       case 10:      // Зиповать
       $old_dir=getcwd();
       chdir(makepath($_POST['curdir'],''));

       $i=0;

       $n=$_POST['str']; $n=escape_dir($n);

           foreach($arr as $v)
           {


             $arr2[$i]=$v;
             $i++;

           }
       // Zip It !

       include 'zip.php';
       $z=new PclZip($n);
       $z->create($arr2, PCLZIP_OPT_ADD_PATH,0 );
        chdir($old_dir);
       break;


       default: break;
}



// + сделаем из них нормальную строку для вывода
 if(isset($_SESSION['buffer']))
    {

       $rstr='<b>Буфер обмена (действие: ';

       switch($_SESSION['action'])
       {
          case 1: $rstr.='копировать';
               break;
          case 2: $rstr.='переместить';
               break;

          default: $rstr.='???';
       }
       $rstr.=')</b><br>';

       foreach($_SESSION['buffer'] as $v)
       {
               $rstr.=$v.'<br>';

       }
      define('BUFF', $rstr);
    }
    else define('BUFF', '');



///////////////////////////////////////////////////////////////////
$to_dir=makepath('', CDIR);
$arr=list_dir($to_dir);
$dlist=format_dir($arr);
define('FILES_LIST', $dlist);
///////////////////////////////////////////////////
ob_start("ob_gzhandler");
include './tpl/tpl_main.php';
ob_end_flush();


?>