<?
$title = "Система статистики на файловой базе от PLAHOV -  Поисковые запросы";
$menu_id = 5;

$action = htmlspecialchars($_GET['action']);
$day = htmlspecialchars($_GET['day']);
$bot = htmlspecialchars($_GET['bot']);

function convertdate($dat, $type)
{
  $dat=strtotime($dat); 
  if ($type==0) return strftime("%d-%m-%Y ",$dat);  
}

include("inc/head.php");

echo "<br><div align=center class=maintop><b>Поисковые запросы</b></div>";


               // Сегодня
               $today = @file("../../data/zapros/".date("Y-m-d"));
               $today_rambler= 0;
               $today_google= 0;
               $today_yandex= 0;
               $today_aport=0;
               $today_msnbot=0;

               if($today)
               {
                for($t=0;$t<count($today);$t++)
                 { 
                  list($i,$k,$f,$h) = explode('<<>>',$today[$t]);
                  if($h == "rambler") {$today_rambler++;}
                  if($h == "google") {$today_google++;}
                  if($h == "yandex") {$today_yandex++;}
                  if($h == "aport") {$today_aport++;}
                  if($h == "msn") {$today_msnbot++;}
                 }
                }

               // вычисляем проценты за сегодня
               $per_t = $today_rambler+$today_google+$today_yandex+$today_aport+$today_msnbot;			   
			   $pert_t = @(100/$per_t);
			   $today_rambler_per = $today_rambler*$pert_t;
               $today_google_per = $today_google*$pert_t;
               $today_yandex_per = $today_yandex*$pert_t;
               $today_aport_per = $today_aport*$pert_t; 
               $today_msnbot_per = $today_msnbot*$pert_t;      
			             
               // Вчера
               $yestoday = @file("../../data/zapros/".date('Y-m-d', strtotime("-1 day")));
               $yestoday_rambler= 0;
               $yestoday_google= 0;
               $yestoday_yandex= 0;
               $yestoday_aport=0;
               $yestoday_msnbot=0;

               if($yestoday)
               {
                for($y=0;$y<count($yestoday);$y++)
                 { 
                  list($i,$k,$f,$hy) = explode('<<>>',$yestoday[$y]);
                  if($hy == "rambler") {$yestoday_rambler++;}
                  if($hy == "google") {$yestoday_google++;}
                  if($hy == "yandex") {$yestoday_yandex++;}
                  if($hy == "aport") {$yestoday_aport++;}
                  if($hy == "msn") {$yestoday_msnbot++;}
                 }
                }
 
               $per_tt = $yestoday_rambler+$yestoday_google+$yestoday_yandex+$yestoday_aport+$yestoday_msnbot;			   
			   $pert_tt = @(100/$per_tt);
			   $yestoday_rambler_per = $yestoday_rambler*$pert_tt;
               $yestoday_google_per = $yestoday_google*$pert_tt;
               $yestoday_yandex_per = $yestoday_yandex*$pert_tt;
               $yestoday_aport_per = $yestoday_aport*$pert_tt; 
               $yestoday_msnbot_per = $yestoday_msnbot*$pert_tt;  
 
             // за 7 дней
             for($sev=0;$sev<7;$sev++)
              {
               $seven[] = date('Y-m-d', strtotime("-".$sev." day"));
              }

               $seven_rambler= 0;
               $seven_google= 0;
               $seven_yandex= 0;
               $seven_aport=0;
               $seven_msnbot=0;

             $dir = opendir("../../data/zapros/"); 
             while (($file = readdir($dir)) !== false) 
              { 
                if($file != "." && $file != "..") 
                 { 
                   if(is_file("../../data/zapros/".$file)) 
                    { 
                      if(in_array($file, $seven))
                       {
                         $per = @file("../../data/zapros/".$file);
                         for($ts=0;$ts<count($per);$ts++)
                         {
                          list($i,$k,$f,$tss) = explode('<<>>',$per[$ts]);
                          if($tss == "rambler") {$seven_rambler++;}
                          if($tss == "google") {$seven_google++;}
                          if($tss == "yandex") {$seven_yandex++;}
                          if($tss == "aport") {$seven_aport++;}
                          if($tss == "msn") {$seven_msnbot++;}
                         }
                       }
                    }
                 } 
              }

               $per_ttt = $seven_rambler+$seven_google+$seven_yandex+$seven_aport+$seven_msnbot;			   
			   $pert_ttt = @(100/$per_ttt);
			   $seven_rambler_per = $seven_rambler*$pert_ttt;
               $seven_google_per = $seven_google*$pert_ttt;
               $seven_yandex_per = $seven_yandex*$pert_ttt;
               $seven_aport_per = $seven_aport*$pert_ttt; 
               $seven_msnbot_per = $seven_msnbot*$pert_ttt; 

             // за 30 дней
             for($tri=0;$tri<30;$tri++)
              {
               $trith[] = date('Y-m-d', strtotime("-".$tri." day"));
              }

               $trith_rambler= 0;
               $trith_google= 0;
               $trith_yandex= 0;
               $trith_aport=0;
               $trith_msnbot=0;

             $dir = opendir("../../data/zapros/"); 
             while (($file = readdir($dir)) !== false) 
              { 
                if($file != "." && $file != "..") 
                 { 
                   if(is_file("../../data/zapros/".$file)) 
                    { 
                      if(in_array($file, $trith))
                       {
                         $per = @file("../../data/zapros/".$file);
                         for($trr=0;$trr<count($per);$trr++)
                         {
                          list($i,$k,$f,$tsr) = explode('<<>>',$per[$trr]);
                          if($tsr == "rambler") {$trith_rambler++;}
                          if($tsr == "google") {$trith_google++;}
                          if($tsr == "yandex") {$trith_yandex++;}
                          if($tsr == "aport") {$trith_aport++;}
                          if($tsr == "msn") {$trith_msnbot++;}
                         }
                       }
                    }
                 } 
              }

               $per_tttt = $trith_rambler+$trith_google+$trith_yandex+$trith_aport+$trith_msnbot;			   
			   $pert_tttt = @(100/$per_tttt);
			   $trith_rambler_per = $trith_rambler*$pert_tttt;
               $trith_google_per = $trith_google*$pert_tttt;
               $trith_yandex_per = $trith_yandex*$pert_tttt;
               $trith_aport_per = $trith_aport*$pert_tttt; 
               $trith_msnbot_per = $trith_msnbot*$pert_tttt;

             // за все время
               $total_rambler= 0;
               $total_google= 0;
               $total_yandex= 0;
               $total_aport=0;
               $total_msnbot=0;

             $dir = opendir("../../data/zapros/"); 
             while (($file = readdir($dir)) !== false) 
              { 
                if($file != "." && $file != "..") 
                 { 
                   if(is_file("../../data/zapros/".$file)) 
                    { 
                     $pere = @file("../../data/zapros/".$file);
                     for($tt=0;$tt<count($pere);$tt++)
                     {
                       list($i,$k,$f,$tr) = explode('<<>>',$pere[$tt]);
                       if($tr == "rambler") {$total_rambler++;}
                       if($tr == "google") {$total_google++;}
                       if($tr == "yandex") {$total_yandex++;}
                       if($tr == "aport") {$total_aport++;}
                       if($tr == "msn") {$total_msnbot++;}
                     }
                   }
                } 
              }
              
               $per_ttttt = $total_rambler+$total_google+$total_yandex+$total_aport+$total_msnbot;			   
			   $pert_ttttt = @(100/$per_ttttt);
			   $total_rambler_per = $total_rambler*$pert_ttttt;
               $total_google_per = $total_google*$pert_ttttt;
               $total_yandex_per = $total_yandex*$pert_ttttt;
               $total_aport_per = $total_aport*$pert_ttttt; 
               $total_msnbot_per = $total_msnbot*$pert_ttttt;
              
     echo "<br>
            <table width=80% align=center cellspacing=1 cellpadding=2 bgcolor=#cccccc>
               <tr align=center class=pagerhead>
                 <td width=30%>&nbsp;</td>
                 <td>Сегодня</td>
                 <td>Вчера</td>
                 <td>За 7 дней</td>
                 <td>За 30 дней</td>
                 <td>За все время</td>
               </tr>
               <tr class=pager>
                  <td align=center><b>Поисковые запросы от</b></td> <td colspan=5>&nbsp;</td>
               </tr>
               <tr class=pager>
                 <td><p style='padding-left:15px;'>Rambler</td>
                 <td align=center><a href=zapros.php?action=showzapros&bot=rambler&day=today class=linkip>".$today_rambler." <span class=grey>(".sprintf("%.2f", $today_rambler_per)." %)</span></a></td>
                 <td align=center><a href=zapros.php?action=showzapros&bot=rambler&day=lastday class=linkip>".$yestoday_rambler." <span class=grey>(".sprintf("%.2f", $yestoday_rambler_per)." %)</span></a></td>
                 <td align=center><a href=zapros.php?action=showzapros&bot=rambler&day=seven class=linkip>".$seven_rambler." <span class=grey>(".sprintf("%.2f", $seven_rambler_per)." %)</span></a></td>
                 <td align=center><a href=zapros.php?action=showzapros&bot=rambler&day=trith class=linkip>".$trith_rambler." <span class=grey>(".sprintf("%.2f", $trith_rambler_per)." %)</span></a></td>
                 <td align=center><a href=zapros.php?action=showzapros&bot=rambler&day=total class=linkip>".$total_rambler." <span class=grey>(".sprintf("%.2f", $total_rambler_per)." %)</span></a></td>
               </tr>
               <tr class=pager>
                 <td><p style='padding-left:15px;'>Google</td>
                 <td align=center><a href=zapros.php?action=showzapros&bot=google&day=today class=linkip>".$today_google." <span class=grey>(".sprintf("%.2f", $today_google_per)." %)</span></a></td>
                 <td align=center><a href=zapros.php?action=showzapros&bot=google&day=lastday class=linkip>".$yestoday_google." <span class=grey>(".sprintf("%.2f", $yestoday_google_per)." %)</span></a></td>
                 <td align=center><a href=zapros.php?action=showzapros&bot=google&day=seven class=linkip>".$seven_google." <span class=grey>(".sprintf("%.2f", $seven_google_per)." %)</span></a></td>
                 <td align=center><a href=zapros.php?action=showzapros&bot=google&day=trith class=linkip>".$trith_google." <span class=grey>(".sprintf("%.2f", $trith_google_per)." %)</span></a></td>
                 <td align=center><a href=zapros.php?action=showzapros&bot=google&day=total class=linkip>".$total_google." <span class=grey>(".sprintf("%.2f", $total_google_per)." %)</span></a></td>
               </tr>
               <tr class=pager>
                 <td><p style='padding-left:15px;'>Yandex</td>
                 <td align=center><a href=zapros.php?action=showzapros&bot=yandex&day=today class=linkip>".$today_yandex." <span class=grey>(".sprintf("%.2f", $today_yandex_per)." %)</span></a></td>
                 <td align=center><a href=zapros.php?action=showzapros&bot=yandex&day=lastday class=linkip>".$yestoday_yandex." <span class=grey>(".sprintf("%.2f", $yestoday_yandex_per)." %)</span></a></td>
                 <td align=center><a href=zapros.php?action=showzapros&bot=yandex&day=seven class=linkip>".$seven_yandex." <span class=grey>(".sprintf("%.2f", $seven_yandex_per)." %)</span></a></td>
                 <td align=center><a href=zapros.php?action=showzapros&bot=yandex&day=trith class=linkip>".$trith_yandex." <span class=grey>(".sprintf("%.2f", $trith_yandex_per)." %)</span></a></td>
                 <td align=center><a href=zapros.php?action=showzapros&bot=yandex&day=total class=linkip>".$total_yandex." <span class=grey>(".sprintf("%.2f", $total_yandex_per)." %)</span></a></td>
               </tr>
               <tr class=pager>
                 <td><p style='padding-left:15px;'>Aport</td>
                 <td align=center><a href=zapros.php?action=showzapros&bot=aport&day=today class=linkip>".$today_aport." <span class=grey>(".sprintf("%.2f", $today_aport_per)." %)</span></a></td>
                 <td align=center><a href=zapros.php?action=showzapros&bot=aport&day=lastday class=linkip>".$yestoday_aport." <span class=grey>(".sprintf("%.2f", $yestoday_aport_per)." %)</span></a></td>
                 <td align=center><a href=zapros.php?action=showzapros&bot=aport&day=seven class=linkip>".$seven_aport." <span class=grey>(".sprintf("%.2f", $seven_aport_per)." %)</span></a></td>
                 <td align=center><a href=zapros.php?action=showzapros&bot=aport&day=trith class=linkip>".$trith_aport." <span class=grey>(".sprintf("%.2f", $trith_aport_per)." %)</span></a></td>
                 <td align=center><a href=zapros.php?action=showzapros&bot=aport&day=total class=linkip>".$total_aport." <span class=grey>(".sprintf("%.2f", $total_aport_per)." %)</span></a></td>
               </tr>
               <tr class=pager>
                 <td><p style='padding-left:15px;'>MNS</td>
                 <td align=center><a href=zapros.php?action=showzapros&bot=msn&day=today class=linkip>".$today_msnbot." <span class=grey>(".sprintf("%.2f", $today_msnbot_per)." %)</span></a></td>
                 <td align=center><a href=zapros.php?action=showzapros&bot=msn&day=lastday class=linkip>".$yestoday_msnbot." <span class=grey>(".sprintf("%.2f", $yestoday_msnbot_per)." %)</span></a></td>
                 <td align=center><a href=zapros.php?action=showzapros&bot=msn&day=seven class=linkip>".$seven_msnbot." <span class=grey>(".sprintf("%.2f", $seven_msnbot_per)." %)</span></a></td>
                 <td align=center><a href=zapros.php?action=showzapros&bot=msn&day=trith class=linkip>".$trith_msnbot." <span class=grey>(".sprintf("%.2f", $trith_msnbot_per)." %)</span></a></td>
                 <td align=center><a href=zapros.php?action=showzapros&bot=msn&day=total class=linkip>".$total_msnbot." <span class=grey>(".sprintf("%.2f", $total_msnbot_per)." %)</span></a></td>
               </tr>
</table><br><br>";

if($action == "showzapros")
  {
         if($day == "today") {$ry = "за сегодня";}
         if($day == "lastday") {$ry = "за вчера";}
         if($day == "seven") {$ry = "за 7 дней";}
         if($day == "trith") {$ry = "за 30 дней";}
         if($day == "total") {$ry = "за все время";}

               echo "<table width=80% align=center cellspacing=1 cellpadding=2 bgcolor=#cccccc>
                          <tr align=center class=pagerhead>
                           <td width=60%>Запросы от ".$bot." ".$ry."</td>
                           <td>Обращений</td>
                           <td>Последнее обращение</td>
                          </tr>";
    if($day == "today")
       {
               $today1 = @file("../../data/zapros/".date("Y-m-d"));
               if($today1)
               {
                for($t=0;$t<count($today1);$t++)
                 { 
                  list($i,$k,$f,$h) = explode('<<>>',$today1[$t]);
                  if($h == $bot) {echo "<tr class=pager><td>".$i."</td><td align=center>".$f."</td><td align=center>Сегодня в ".$k."</td></tr>";}
                 }
                }
       }

    if($day == "lastday") 
      {
               $yestoday1 = @file("../../data/zapros/".date('Y-m-d', strtotime("-1 day")));
               if($yestoday1)
               {
                for($y=0;$y<count($yestoday1);$y++)
                 { 
                  list($i,$k,$f,$hy) = explode('<<>>',$yestoday[$y]);
                  if($hy == $bot) {echo "<tr class=pager><td>".$i."</td><td align=center>".$f."</td><td align=center>Вчера в ".$k."</td></tr>";}
                 }
                }
     }     

   if($day == "seven")
    {
             for($sev=0;$sev<7;$sev++)
              {
               $seve[] = date('Y-m-d', strtotime("-".$sev." day"));
              }

             $dir = opendir("../../data/zapros/"); 
             while (($file = readdir($dir)) !== false) 
              { 
                if($file != "." && $file != "..") 
                 { 
                   if(is_file("../../data/zapros/".$file)) 
                    { 
                      if(in_array($file, $seve))
                       {
                         $per = @file("../../data/zapros/".$file);
                         for($ts=0;$ts<count($per);$ts++)
                         {
                          list($i,$k,$f,$tss) = explode('<<>>',$per[$ts]);
                          if($tss == $bot) {echo "<tr class=pager><td>".$i."</td><td align=center>".$f."</td><td align=center>".convertdate($file,0)." в ".$k."</td></tr>";}
                         }
                       }
                    }
                 } 
              }
     }

   if($day == "trith")
    {
             for($tri=0;$tri<30;$tri++)
              {
               $trit[] = date('Y-m-d', strtotime("-".$tri." day"));
              }

             $dir = opendir("../../data/zapros/"); 
             while (($file = readdir($dir)) !== false) 
              { 
                if($file != "." && $file != "..") 
                 { 
                   if(is_file("../../data/zapros/".$file)) 
                    { 
                      if(in_array($file, $trit))
                       {
                         $per = @file("../../data/zapros/".$file);
                         for($trr=0;$trr<count($per);$trr++)
                         {
                          list($i,$k,$f,$tsr) = explode('<<>>',$per[$trr]);
                          if($tsr ==  $bot) {echo "<tr class=pager><td>".$i."</td><td align=center>".$f."</td><td align=center>".convertdate($file,0)." в ".$k."</td></tr>";}
                         }
                       }
                    }
                 } 
              }
    }

   if($day == "total")
    {
             $dir = opendir("../../data/zapros/"); 
             while (($file = readdir($dir)) !== false) 
              { 
                if($file != "." && $file != "..") 
                 { 
                   if(is_file("../../data/zapros/".$file)) 
                    { 
                     $pere = @file("../../data/zapros/".$file);
                     for($tt=0;$tt<count($pere);$tt++)
                     {
                       list($i,$k,$f,$tr) = explode('<<>>',$pere[$tt]);
                       if($tr == $bot) {echo "<tr class=pager><td>".$i."</td><td align=center>".$f."</td><td align=center>".convertdate($file,0)." в ".$k."</td></tr>";}
                     }
                   }
                } 
              }

    }
 echo "</table>";
  }


include("inc/bottom.php");
?>