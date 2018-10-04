<?
    if(!file_exists("../../data/begin.count"))
       {
            $data_begin = date("d.m.Y");
            $filesss = @file("../../data/begin.count");
            $fpsss = fopen("../../data/begin.count", "w");
            flock($fpsss, LOCK_EX);
            fwrite($fpsss, "$ip<<>>$data_begin<<>>\r\n");
            flock($fpsss, LOCK_UN);
            fclose($fpsss);
      }
      
$title = "Система статистики на файловой базе от PLAHOV";
$menu_id = 0;
function convertdate($dat, $type)
{
  $dat=strtotime($dat); 
  if ($type==0) return strftime("%d-%m-%Y ",$dat);  
}

$action = htmlspecialchars($_GET['action']);

if(!empty($_POST))
 {
  $date = htmlspecialchars($_POST['date_year']."-".$_POST['date_month']."-".$_POST['date_day']);
  $date_month = htmlspecialchars($_POST['date_month']);
  $date_day = htmlspecialchars($_POST['date_day']);
  $date_year = htmlspecialchars($_POST['date_month']);
 }

if(empty($date))
 { 
  $date = date("Y-m-d"); 
  $date_month = date("m");
  $date_day = date("d");
  $date_year = date("Y");
 }

include("inc/head.php");

echo"<form action=index.php method=POST><p class=maintop>Общий поиск по дате&nbsp;&nbsp;&nbsp;";

     echo "<select title='День' class=input type=text name='date_day'>";
     for($i = 1; $i <= 31; $i++)
     {
       if($date_day == $i) $temp = "selected";
       else $temp = "";
       echo "<option value=".sprintf("%02d", $i)." $temp>".sprintf("%02d", $i);
     }
     echo "</select>";
     echo "<select class=input type=text name='date_month'>";
     for($i = 1; $i <= 12; $i++)
     {
       if($date_month == $i) $temp = "selected";
       else $temp = "";
       echo "<option value=".sprintf("%02d", $i)." $temp>".sprintf("%02d", $i);
     }
     echo "</select>";
     echo "<select class=input type=text name='date_year'>";
     for($i = 2007; $i <= 2010; $i++)
     {
       if($date_year == $i) $temp = "selected";
       else $temp = "";
       echo "<option value=$i $temp>$i";
     }
     echo "</select>&nbsp;&nbsp;&nbsp;<input type=submit value='Поиск'></p></form>";

     echo "<br><div align=center class=maintop><b>Страницы на которые заходили ".convertdate($date, 0)."</b></div>";


        $dir = opendir("../../data/pages/"); 
        $total =0;
        $rrrtrt = "";
	    while (($file = readdir($dir)) !== false) 
        { 
         if($file != "." && $file != "..") 
         { 
           if(is_file("../../data/pages/".$file)) 
           { 
            $rrt = explode('.',$file);
            if($rrt[1] == $date)
              {
               $total++;
               $rrrtrt.= $rrt[0].",";   
              }
           } 
         }
       }

     include("inc/navi.php");
     
     echo "<br>
            <table width=80% align=center cellspacing=1 cellpadding=2 bgcolor=#cccccc>
               <tr align=center class=pagerhead>
                 <td>Название страницы</td>
                 <td>Количество просмотров</td>
                 <td>Последнее посещение</td>
               </tr>";

       $mass = explode(",",$rrrtrt);
       for($i=$begin;$i<$end;$i++)
        {
          $pere1 = @file("../../data/pages/".$mass[$i].".".$date);
          list($ir,$tr) = explode("<<>>",$pere1[0]);
          if($pere1)
		  {
           echo"<tr class=pager><td width=60%>".$mass[$i]."</td><td align=center>".count($pere1)."</td><td align=center>".convertdate($date, 0)." в ".$tr."</td></tr>";
          }
        }      
  
  echo"</table>
 <br><br><br>

          <a style='cursor:hand; font-size:14;' onClick=\"if(confirm('Вы уверены?')){document.location.href = 'clean_bd.php'}\" class=linkip>Обнулить базу</a><br>";

include("inc/bottom.php");
?>