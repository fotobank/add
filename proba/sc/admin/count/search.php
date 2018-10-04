<?
$title = "Система статистики на файловой базе от PLAHOV -  Поисковики";
$menu_id = 4;

include("inc/head.php");

echo "<br><div align=center class=maintop><b>Поисковики</b></div>";

               // Сегодня
               $today = @file("../../data/os/".date("Y-m-d"));
               $today_rambler= 0;
               $today_google= 0;
               $today_yandex= 0;
               $today_aport=0;
               $today_msnbot=0;

               if($today)
               {
                for($t=0;$t<count($today);$t++)
                 { 
                  list($i,$h) = explode('<<>>',$today[$t]);
                  if($h == "robot_rambler") {$today_rambler++;}
                  if($h == "robot_google") {$today_google++;}
                  if($h == "robot_yandex") {$today_yandex++;}
                  if($h == "robot_aport") {$today_aport++;}
                  if($h == "robot_msnbot") {$today_msnbot++;}
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
               $yestoday = @file("../../data/os/".date('Y-m-d', strtotime("-1 day")));
               $yestoday_rambler= 0;
               $yestoday_google= 0;
               $yestoday_yandex= 0;
               $yestoday_aport=0;
               $yestoday_msnbot=0;

               if($yestoday)
               {
                for($y=0;$y<count($yestoday);$y++)
                 { 
                  list($iy,$hy) = explode('<<>>',$yestoday[$y]);
                  if($hy == "robot_rambler") {$yestoday_rambler++;}
                  if($hy == "robot_google") {$yestoday_google++;}
                  if($hy == "robot_yandex") {$yestoday_yandex++;}
                  if($hy == "robot_aport") {$yestoday_aport++;}
                  if($hy == "robot_msnbot") {$yestoday_msnbot++;}
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

             $dir = opendir("../../data/os/"); 
             while (($file = readdir($dir)) !== false) 
              { 
                if($file != "." && $file != "..") 
                 { 
                   if(is_file("../../data/os/".$file)) 
                    { 
                      if(in_array($file, $seven))
                       {
                         $per = @file("../../data/os/".$file);
                         for($ts=0;$ts<count($per);$ts++)
                         {
                          list($is,$tss) = explode('<<>>',$per[$ts]);
                          if($tss == "robot_rambler") {$seven_rambler++;}
                          if($tss == "robot_google") {$seven_google++;}
                          if($tss == "robot_yandex") {$seven_yandex++;}
                          if($tss == "robot_aport") {$seven_aport++;}
                          if($tss == "robot_msnbot") {$seven_msnbot++;}
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

             $dir = opendir("../../data/os/"); 
             while (($file = readdir($dir)) !== false) 
              { 
                if($file != "." && $file != "..") 
                 { 
                   if(is_file("../../data/os/".$file)) 
                    { 
                      if(in_array($file, $trith))
                       {
                         $per = @file("../../data/os/".$file);
                         for($trr=0;$trr<count($per);$trr++)
                         {
                          list($is,$tsr) = explode('<<>>',$per[$trr]);
                          if($tsr == "robot_rambler") {$trith_rambler++;}
                          if($tsr == "robot_google") {$trith_google++;}
                          if($tsr == "robot_yandex") {$trith_yandex++;}
                          if($tsr == "robot_aport") {$trith_aport++;}
                          if($tsr == "robot_msnbot") {$trith_msnbot++;}
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

             $dir = opendir("../../data/os/"); 
             while (($file = readdir($dir)) !== false) 
              { 
                if($file != "." && $file != "..") 
                 { 
                   if(is_file("../../data/os/".$file)) 
                    { 
                     $pere = @file("../../data/os/".$file);
                     for($tt=0;$tt<count($pere);$tt++)
                     {
                       list($ir,$tr) = explode('<<>>',$pere[$tt]);
                       if($tr == "robot_rambler") {$total_rambler++;}
                       if($tr == "robot_google") {$total_google++;}
                       if($tr == "robot_yandex") {$total_yandex++;}
                       if($tr == "robot_aport") {$total_aport++;}
                       if($tr == "robot_msnbot") {$total_msnbot++;}
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
                  <td align=center><b>Поисковые роботы</b></td> <td colspan=5>&nbsp;</td>
               </tr>
               <tr class=pager>
                 <td><p style='padding-left:15px;'>Rambler</td>
                 <td align=center>".$today_rambler." <span class=grey>(".sprintf("%.2f", $today_rambler_per)." %)</span></td>
                 <td align=center>".$yestoday_rambler." <span class=grey>(".sprintf("%.2f", $yestoday_rambler_per)." %)</span></td>
                 <td align=center>".$seven_rambler." <span class=grey>(".sprintf("%.2f", $seven_rambler_per)." %)</span></td>
                 <td align=center>".$trith_rambler." <span class=grey>(".sprintf("%.2f", $trith_rambler_per)." %)</span></td>
                 <td align=center>".$total_rambler." <span class=grey>(".sprintf("%.2f", $total_rambler_per)." %)</span></td>
               </tr>
               <tr class=pager>
                 <td><p style='padding-left:15px;'>Google</td>
                 <td align=center>".$today_google." <span class=grey>(".sprintf("%.2f", $today_google_per)." %)</span></td>
                 <td align=center>".$yestoday_google." <span class=grey>(".sprintf("%.2f", $yestoday_google_per)." %)</span></td>
                 <td align=center>".$seven_google." <span class=grey>(".sprintf("%.2f", $seven_google_per)." %)</span></td>
                 <td align=center>".$trith_google." <span class=grey>(".sprintf("%.2f", $trith_google_per)." %)</span></td>
                 <td align=center>".$total_google." <span class=grey>(".sprintf("%.2f", $total_google_per)." %)</span></td>
               </tr>
               <tr class=pager>
                 <td><p style='padding-left:15px;'>Yandex</td>
                 <td align=center>".$today_yandex." <span class=grey>(".sprintf("%.2f", $today_yandex_per)." %)</span></td>
                 <td align=center>".$yestoday_yandex." <span class=grey>(".sprintf("%.2f", $yestoday_yandex_per)." %)</span></td>
                 <td align=center>".$seven_yandex." <span class=grey>(".sprintf("%.2f", $seven_yandex_per)." %)</span></td>
                 <td align=center>".$trith_yandex." <span class=grey>(".sprintf("%.2f", $trith_yandex_per)." %)</span></td>
                 <td align=center>".$total_yandex." <span class=grey>(".sprintf("%.2f", $total_yandex_per)." %)</span></td>
               </tr>
               <tr class=pager>
                 <td><p style='padding-left:15px;'>Aport</td>
                 <td align=center>".$today_aport." <span class=grey>(".sprintf("%.2f", $today_aport_per)." %)</span></td>
                 <td align=center>".$yestoday_aport." <span class=grey>(".sprintf("%.2f", $yestoday_aport_per)." %)</span></td>
                 <td align=center>".$seven_aport." <span class=grey>(".sprintf("%.2f", $seven_aport_per)." %)</span></td>
                 <td align=center>".$trith_aport." <span class=grey>(".sprintf("%.2f", $trith_aport_per)." %)</span></td>
                 <td align=center>".$total_aport." <span class=grey>(".sprintf("%.2f", $total_aport_per)." %)</span></td>
               </tr>
               <tr class=pager>
                 <td><p style='padding-left:15px;'>MNS</td>
                 <td align=center>".$today_msnbot." <span class=grey>(".sprintf("%.2f", $today_msnbot_per)." %)</span></td>
                 <td align=center>".$yestoday_msnbot." <span class=grey>(".sprintf("%.2f", $yestoday_msnbot_per)." %)</span></td>
                 <td align=center>".$seven_msnbot." <span class=grey>(".sprintf("%.2f", $seven_msnbot_per)." %)</span></td>
                 <td align=center>".$trith_msnbot." <span class=grey>(".sprintf("%.2f", $trith_msnbot_per)." %)</span></td>
                 <td align=center>".$total_msnbot." <span class=grey>(".sprintf("%.2f", $total_msnbot_per)." %)</span></td>
               </tr>
</table>";

include("inc/bottom.php");
?>