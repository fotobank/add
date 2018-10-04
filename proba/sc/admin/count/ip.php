<?php
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

$title = "Система статистики на файловой базе от PLAHOV - ip-адреса";
$menu_id = 3;

function convertdate($dat, $type)
{
  $dat=strtotime($dat); 
  if ($type==0) return strftime("%d-%m-%Y ",$dat);  
}

$action = htmlspecialchars($_GET['action']);

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

$ip_p = htmlspecialchars($_GET['ip']);

if(!empty($_GET['ip'])) { if(!preg_match("/^[\d]{1,3}\.[\d]{1,3}\.[\d]{1,3}\.[\d]{1,3}$/",$_GET['ip'])) { exit("Введены не допустимые символы в ip-адресе");} }

include("inc/head.php");

echo"<form action=ip.php?action=showday method=POST><p class=maintop>Общий поиск по дате&nbsp;&nbsp;&nbsp;";

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

if($action == "") {

     $pe = @file("../../data/total/".$date);
     if($pe)
     {
     
     echo "<br><div align=center class=maintop><b>Зарегестрированные ip за ".convertdate($date, 0)."</b></div>";
     echo "<br>
            <table width=60% align=center><tr class=pager><td><<< <a href=ip.php?action=showday&data=".lastday($date)."  class=linkip>".convertdate(lastday($date), 0)."</a></td><td align=right><a href=ip.php?action=showday&data=".nextday($date)." class=linkip>".convertdate(nextday($date), 0)."</a> >>></td></tr></table>
            <table width=80% align=center cellspacing=1 cellpadding=2 bgcolor=#cccccc>
               <tr align=center class=pagerhead>
                 <td>ip</td>
                 <td>Хост</td>
                 <td>Просмотров</td>
                 <td>Последнее посещение</td>
                 <td>Бан ip</td>
               </tr>";

               $pere = @file("../../data/total/".date("Y-m-d"));
               for($i=0;$i<count($pere);$i++)
                {
                  list($iq,$h,$t) = explode('<<>>',$pere[$i]);
                  echo"<tr class=pager><td width=20%><a href=ip.php?action=show&ip=".$iq."&data=".date("Y-m-d")."  class=linkip>".$iq."</a></td><td>".@gethostbyaddr($iq)."</td><td align=center>".$h."</td><td align=center>".convertdate($date, 0)." в ".$t."</td><td align=center><a href=ban_list.php?function=adder&ip=".$iq." class=linkip>Забанить</a></td></tr>";
              }
  
  echo"</table>";
     }
     if(!$pe) { echo "<br><div align=center class=maintop><b>Статистика ip-адресов за ".convertdate($date, 0)." отсутствует</b></div>
	             <br><table width=60% align=center><tr class=pager><td><<< <a href=ip.php?action=showday&data=".lastday($date)."  class=linkip>".convertdate(lastday($date), 0)."</a></td><td align=right><a href=ip.php?action=showday&data=".nextday($date)." class=linkip>".convertdate(nextday($date), 0)."</a> >>></td></tr></table>";}

}

if($action == "showday") {

     $pe = @file("../../data/total/".$date);
     if($pe)
     {
      echo "<br><div align=center class=maintop><b>Зарегестрированные ip за ".convertdate($date, 0)."</b></div>";
      echo "<br>
            <table width=60% align=center><tr class=pager><td><<< <a href=ip.php?action=showday&data=".lastday($date)."  class=linkip>".convertdate(lastday($date), 0)."</a></td><td align=right><a href=ip.php?action=showday&data=".nextday($date)." class=linkip>".convertdate(nextday($date), 0)."</a> >>></td></tr></table>
            <table width=80% align=center cellspacing=1 cellpadding=2 bgcolor=#cccccc>
               <tr align=center class=pagerhead>
                 <td>ip</td>
                 <td>Хост</td>
                 <td>Просмотров</td>
                 <td>Последнее посещение</td>
                 <td>Бан ip</td>
               </tr>";

               $pere = @file("../../data/total/".$date);
               for($i=0;$i<count($pere);$i++)
                {
                  list($iq,$h,$t) = explode('<<>>',$pere[$i]);
                  echo"<tr class=pager><td width=20%><a href=ip.php?action=show&ip=".$iq."&data=".$date."  class=linkip>".$iq."</a></td><td>".@gethostbyaddr($iq)."</td><td align=center>".$h."</td><td align=center>".convertdate($date, 0)." в ".$t."</td><td align=center><a href=ban_list.php?function=adder&ip=".$iq." class=linkip>Забанить</a></td></tr>";
              }
  
      echo"</table>";
     }
     if(!$pe) { echo "<br><div align=center class=maintop><b>Статистика ip-адресов за ".convertdate($date, 0)." отсутствует</b></div>
	             <br><table width=60% align=center><tr class=pager><td><<< <a href=ip.php?action=showday&data=".lastday($date)."  class=linkip>".convertdate(lastday($date), 0)."</a></td><td align=right><a href=ip.php?action=showday&data=".nextday($date)." class=linkip>".convertdate(nextday($date), 0)."</a> >>></td></tr></table>";}

}


if($action == "show"&& $date !="" && $ip_p !="")
 {
       $str = "";
       $dir = opendir("../../data/pages/"); 
       while (($file = readdir($dir)) !== false) 
        { 
         if($file != "." && $file != "..") 
         { 
           if(is_file("../../data/pages/".$file)) 
           { 
            $rrt = explode('.',$file);
            if($rrt[1] == $date)
              {
               $eee = 0;
               $pere = @file("../../data/pages/".$file);
               for($r=0;$r<count($pere);$r++)
               { 
                 list($i,$t) = explode('<<>>',$pere[$r]);
                 if($ip_p == $i)
                 {
                  $eee++;
                  $time[] = $t;
                 }
               }
                @rsort($time);
                if($eee !=0) {$str.="<tr class=pager><td width=60%>".$rrt[0]."</td><td align=center>".$eee."</td><td align=center>".$date." в ".$time[0]."</td></tr>";}
             }
           } 
         }
       }

     if($str != "") {
     echo "<br><div align=center class=maintop><b>История ip (".$ip_p.") за ".convertdate($date, 0)."</b></div>";
     echo "<br>
            <table width=60% align=center><tr class=pager><td><<< <a href=ip.php?action=show&data=".lastday($date)."&ip=".$ip_p."  class=linkip>".convertdate(lastday($date), 0)."</a></td><td align=right><a href=ip.php?action=show&data=".nextday($date)."&ip=".$ip_p." class=linkip>".convertdate(nextday($date), 0)."</a> >>></td></tr></table>
            <table width=60% align=center cellspacing=1 cellpadding=2 bgcolor=#cccccc>
               <tr align=center class=pagerhead>
                 <td>Название страницы</td>
                 <td>Просмотров</td>
                 <td>Последнее посещение</td>
               </tr>";
    echo $str;
    echo"</table>";
   }
   else { echo "<br><div align=center class=maintop><b>История ip (".$ip_p.") за ".convertdate($date, 0)." отсутствует</b></div>";}
 }

include("inc/bottom.php");
?>