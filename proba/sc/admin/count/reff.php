<?
function lastday($dar)
 {
  list($y, $m, $d) = explode("-",$dar); 
  $date = mktime(0, 0, 0, $m, $d, $y); 
  $yesterday = strtotime("-1 day", $date);
  return  date("Y-m-d", $yesterday);
 }

function nextday($dar)
 {
  list($y, $m, $d) = explode("-",$dar); 
  $date = mktime(0, 0, 0, $m, $d, $y); 
  $yesterday = strtotime("+1 day", $date);
  return  date("Y-m-d", $yesterday);
 }

$title = "Система статистики на файловой базе от PLAHOV - Рефферы";
$menu_id = 6;

function convertdate($dat, $type)
{
  $dat=strtotime($dat); 
  if ($type==0) return strftime("%d-%m-%Y ",$dat);  
}

if(!empty($_GET['data']))
 {
  $date = htmlspecialchars($_GET['data']); 
  $date_month = substr($_GET['data'],5,2);
  $date_day = substr($_GET['data'],8,2);
  $date_year = substr($_GET['data'],0,4);
 }

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

echo"<form action=reff.php method=POST><p class=maintop>Общий поиск по дате&nbsp;&nbsp;&nbsp;";

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

     $pere = @file("../../data/refer/".$date);
     if($pere) {
     echo "<br><div align=center class=maintop><b>Зарегестрированные 	рефферы за ".convertdate($date, 0)."</b></div>";
     echo "<br>
            <table width=60% align=center><tr class=pager><td><<< <a href=reff.php?data=".lastday($date)."  class=linkip>".convertdate(lastday($date), 0)."</a></td><td align=right><a href=reff.php?data=".nextday($date)." class=linkip>".convertdate(nextday($date), 0)."</a> >>></td></tr></table>
            <table width=60% align=center cellspacing=1 cellpadding=2 bgcolor=#cccccc>
               <tr align=center class=pagerhead>
                 <td width=60%>Реффер</td>
                 <td>Обращений</td>
                 <td>Последнее посещение</td>
               </tr>";
               for($i=0;$i<count($pere);$i++)
                {
                  list($iq,$h,$t) = explode('<<>>',$pere[$i]);
                  echo"<tr class=pager><td><a href=".$iq."  class=linkip target=_blank>".$iq."</a></td><td align=center>".$t."</td><td align=center>".convertdate($date, 0)." в ".$h."</td></tr>";
              }
  
  echo"</table>";
}
if(!$pere) {     echo "<br><div align=center class=maintop><b>Зарегестрированных рефферов за ".convertdate($date, 0)." <font color=red>нет</font></b></div><br>
            <table width=60% align=center><tr class=pager><td><<< <a href=reff.php?data=".lastday($date)."  class=linkip>".convertdate(lastday($date), 0)."</a></td><td align=right><a href=reff.php?data=".nextday($date)." class=linkip>".convertdate(nextday($date), 0)."</a> >>></td></tr></table>
";}

include("inc/bottom.php");
?>