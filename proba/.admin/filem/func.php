<?php
// FileManager - функции

// функции для работы с файлами и папками / Абсолютные пути без конечного слеша


ini_set("magic_quotes_runtime",0);
ini_set("magic_quotes_gpc", 0);


function my_copy($p1, $p2)
{


$from=$p1;
$to=$p2;

if(is_file($from)) {copy($from, $to); return;}

mkdir($p2,0777);
my_copy_ex($p1,$p2);

}

function my_copy_ex($p1, $p2)
{


         $from=$p1;
         $to=$p2;

         if(is_file($from)) {copy($from, $to); return;}
         else
         {


                  if ($handle = opendir($from)) {
                      while (false !== ($str = readdir($handle))) {
                          if ($str != "." && $str != "..") {

                          $a=$from.'/'.$str;
                          $b=$to.'/'.$str;


                              if(is_file($a)) copy($a, $b);
                              else if(is_dir($a)) {
                                      mkdir($b,0777); my_copy_ex($a, $b);

                             }

                          }
                      }
                      closedir($handle);
                  }

         }

}


function my_delete($p1)
{


         $from=$p1;
        //  echo($from);

         if(is_file($from)) {unlink($from);            return;}

         else
         {
                     //echo($from);

                  if ($handle = opendir($from)) {
                      while (false !== ($str = readdir($handle))) {
                          if ($str != "." && $str != "..")
                          {

                          $a=$from.'/'.$str;
                         //  echo($a);

                              if(is_file($a)) unlink($a);
                              else  my_delete($a);

                              }


                           }

                     }

                      closedir($handle);


              rmdir($from);
         }

}


function my_chmod($p1, $perms)
{


         $from=$p1;
        //  echo($from);

         if(is_file($from)) {chmod($from, $perms);            return;}

         else
         {
                     //echo($from);

                  if ($handle = opendir($from)) {
                      while (false !== ($str = readdir($handle))) {
                          if ($str != "." && $str != "..")
                          {

                          $a=$from.'/'.$str;
                         //  echo($a);

                              if(is_file($a)) chmod($a, $perms);
                              else  my_chmod($a, $perms);

                              }


                           }

                     }

                      closedir($handle);


           chmod($from, $perms);
         }

}

function list_dir($arg)
{
         $path=$arg;
         $i=0;
          if ($handle = opendir($arg)) {
                  while (false !== ($str = readdir($handle))) {
                          if ($str != "." && $str != "..") {

                              $a=$arg.'/'.$str;

                              $arr[$i]['name']=htmlspecialchars($str);;
                              $arr[$i]['size']='---';
                              $arr[$i]['pm']='---';

                              if(is_file($a))
                              {

                                         $arr[$i]['type']=1;
                                         $arr[$i]['size']=filesize($a);
                                         $arr[$i]['pm']=formperms(fileperms($a));

                                         //echo(fileperms($a).'<br>');
                                        // echo( '<b>'. $arr[$i]['pm'].'</b>'. '<br>');
                              }

                              else { $arr[$i]['pm']=formperms(fileperms($a)); $arr[$i]['type']=0;};
                           $i++;
                          }
                      }
                      closedir($handle);
                      if($i==0) $arr[0]="";
          }
          else return 0;
          usort($arr, "sort_proc");

          return $arr;
}

function sort_proc($a, $b)
{
 $s1=strtolower($a['name']);
 $s2=strtolower($b['name']);

 if(strcmp($s1,$s2)==1) return TRUE;
 else return FALSE;

}

function f_get($arg)
{

         $f=fopen($arg, "r");
         $str=fread($f, filesize($arg));
         fclose($f);
         return $str;

}

function format_dir($arr)
{
$c=1;
if($arr[0]!=''){
ob_start();

    foreach($arr as $v )
    {

          $sz=$v['size'];

       $pm=$v['pm'];
       if($v['type']==0) {$name=$v['name'];  $c++;   eval(TPL_SUB); }


    }


    foreach($arr as $v )
    {

          $sz=$v['size'];

       $pm=$v['pm'];
       if($v['type']==1) {$name=$v['name'];   $c++;   eval(TPL_FILE); }


    }
    echo("\n". '<input name="fcount" type="hidden" value="'.$c.'">');
    $contents=ob_get_clean();
@ob_end_clean();
return $contents;
}

else return '';


}


function split_dir($str)
{

         $arr=explode('/', $str);
         $f=1; $g=1;

         $ret='<a href="index.php?dir=/">&lt;корень&gt;</a>';

         $p='';
 if($str!='/') {
         foreach($arr as $v)
         {

              //   $ret.=' / ';
                 $ret.='<a href="index.php?dir='.$p.$v.'">'.$v.'</a>';
                 if($f==0) $f=1;
                 else $ret.=' / ';

                 $p.=$v;
                 if($g==0) $g=1;
                 else $p.='/';
         }

  }


        return $ret;
}

function getpostfiles()
{
$i=0;

for($t=1; $t<=$_POST['fcount']; $t++)
{

 if(!isset($_POST['file_'.$t])) continue;


  $query_arr[$i]=escape_dir($_POST['name_'.$t]);
  $i++;
}

return $query_arr;

}


function escape_dir($str)
{
$ret=str_replace("/../", '/', $str);
$ret=str_replace("/./", '/', $ret);
$ret=str_replace("/..", '/', $str);
$ret=str_replace("/./", '/', $ret);
$ret=str_replace("\\", "", $ret);
     return $ret;


}

function paste($act)
{
$p=$_SESSION['path'];
 foreach($_SESSION['buffer'] as $v)
 {

 //echo($v);
     if($act==1) my_copy(makepath($p,$v), makepath(CDIR,$v));
     else rename(makepath($p,$v), makepath(CDIR,$v));

 }

}



function makepath($CurDir, $NewFile)
{
         $str=$_SESSION['User_Path'];
         $a='';
         $a.='/'.$CurDir;
         $a.='/'.$NewFile;


         // Bug Check
         $a=str_replace("//", "/", $a);
         $a=str_replace("\\/", "/", $a);
         $a=str_replace("\\", "", $a);
         $str.=$a;
         $str=escape_dir($str);


 return $str;
}

function makeperms($p1)
{


$p=$p1;
$p=octdec($p);
//echo($p);
if((!is_numeric($p))||(strlen($p)!=3)) return '0775';

$a=$p; $p='0'.$a;

return $p;

}


function redir($str)
{

ob_clean();
header("Location: $str");
ob_flush();
?>
<html>
<head>
<meta http-equiv="refresh" content="0; url=<?=$str?>">
<title>Подождите</title>
</head>
<body>
Подождите немного... <p>
<a href="<?=$str?>">Или нажмите сюда</a>
</body>
</html>
<?php
exit();
}

function formperms($v)
{

 $s=substr(sprintf('%o', $v), -4);

 return $s;

}
?>