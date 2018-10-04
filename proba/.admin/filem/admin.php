<?php
include 'func.php';
include 'conf.php';
error_reporting(0);
session_start();
header("http/1.0 200 Ok");
header("Cache-Control: no-store, no-cache, must-revalidate");  // HTTP/1.1
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache");
if(!isset($_SESSION['Adm'])) die('������ �������������� ����� ������ � ���� ��������');


$defpath=$_SERVER['DOCUMENT_ROOT'];

if(isset($_GET['act'])) $act=$_GET['act'];
else $act='nothing';

$show=0;
ob_start();

if($_SESSION['st']!='') define('STAT', $_SESSION['st']);
$_SESSION['st']='';
switch($act)
{
       case 'new_user':

            if(isset($_POST['postok']))
            {
                     $name=escape_dir($_POST['Name']);
                     $pass=md5($_POST['Pass']);
                     $d=$_POST['Dir'];

                     $f=fopen('./users/'.$name, 'w+');
                     fwrite($f, $pass."\n");
                     fwrite($f, $d."\n");
                     if(isset($_POST['IsAdm'])) fwrite($f, 'Admin');
                     fclose($f);
                     $_SESSION['st']="<font color=green>������������ ������</font>";

            }

            ?>
              <b>����� ������������</b><br><br>
              <form name="Form" action="admin.php?act=new_user" method="post">
              <input name="postok" type="hidden" value="1">
              ��� ������������:<br> <input name="Name" type="text" value=""><br>
              ������:<br> <input name="Pass" type="text" value=""><br>
              ����������:<br> <input name="Dir" type="text" value="<?=$defpath?>"> (������ '\' ������� ������ '/' ���� Windows ��������) <br>
              �����? <input name="IsAdm" type="checkbox" value=""><br>
              <br>
              ���������? <input type="submit" value="�������">
              </form>

            <?php
          break;

       case 'change_user':

         if(!isset($_POST['Name'])) $name=$_GET['uname'];
          else  $name=$_POST['Name'];

            if(isset($_POST['postok']))
            {
                     $name=escape_dir($_POST['Name']);
                     $pass=md5($_POST['Pass']);
                     $d=$_POST['Dir'];

                    //////////////////////////////////////////////
                     $str=f_get('./users/'.$name);
                     $str=str_replace("\r\n", "\n", $str);
                     $arr=explode("\n", $str);
                     $oldpass=$arr[0];
                    //////////////////////////////////////////////

                    if(isset($_POST['NoChangePass'])) $pass=$oldpass;

                     unlink('./users/'.$name);

                     $f=fopen('./users/'.$name, 'w+');
                     fwrite($f, $pass."\n");
                     fwrite($f, $d."\n");


                     if(isset($_POST['IsAdm'])) fwrite($f, 'Admin');
                     fclose($f);
                     $_SESSION['st']="<font color=green>������������ ������</font>";
                    redir('admin.php');
            }


             $str=f_get('./users/'.$name);

             $str=str_replace("\r\n", "\n", $str);
             $arr=explode("\n", $str);

             $pass=$arr[0];
             $d=$arr[1];

             if($arr[2]=="Admin") $ad="checked=\"checked\"";
             else $ad='';


            ?>
              <b>�������� ������������ <?=$name?></b><br><br>
              <form name="Form" action="admin.php?act=change_user" method="post">
              <input name="postok" type="hidden" value="1">
              <input name="Name" type="hidden" value="<?=$name?>">
              ��� ������������:<br> <b><?=$name?></b><br><br>
              <b>�����</b> ������:<br> <input name="Pass" type="text" value="">
              <input name="NoChangePass" type="checkbox" checked="checked">(�� ������ ������)<br>
              ����������:<br> <input name="Dir" type="text" value="<?=$d?>"> (������ '\' ������� ������ '/' ���� Windows ��������)<br>
              �����? <input name="IsAdm" type="checkbox" <?=$ad?>><br>
              <br>
              ���������? <input type="submit" value="���������">
              </form>

            <?php

            break;

         case 'del_user':

                $name=$_GET['uname'];
                unlink('./users/'.$name);

                $_SESSION['st']="<font color=green>������������ �����</font>";

                $show=1;

         break;

         default:
         $show=1;
         break;
}


if($show)
{ $i=1;
  print '<br> <br>';
   if ($handle = opendir('./users')) {
         while (false !== ($f = readdir($handle))) {
             if ($f != "." && $f != "..") {
                 if($f{0}=='.') continue;
                    $arr[$i]=$f;
                    $i++;
             }
         }
         closedir($handle);
     }


foreach($arr as $s)
{

        echo $s."&nbsp;";
        echo('<a href="admin.php?act=change_user&uname='.$s.'">[�������������]</a>&nbsp;');
        echo('<a href="admin.php?act=del_user&uname='.$s.'">[�������]</a>&nbsp;');
        echo('<br><br>');

}
}
define('CONTENT', ob_get_clean());
 define('STAT', $_SESSION['st']);
include './tpl/tpl_admin.php';

?>