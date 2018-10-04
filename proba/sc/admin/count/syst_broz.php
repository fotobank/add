<?
$title = "Система статистики на файловой базе от PLAHOV -  Системы и броузеры";
$menu_id = 2;

include("inc/head.php");

echo "<br><div align=center class=maintop><b>Системы и броузеры</b></div>";

               // Сегодня
               $today = @file("../../data/os/".date("Y-m-d"));
               $today_win = 0;
               $today_unix = 0;
               $today_mac = 0;
               $today_or =0;
               if($today)
               {
                for($t=0;$t<count($today);$t++)
                 { 
                  list($i,$h) = explode('<<>>',$today[$t]);
                  if($h == "win") {$today_win++;}
                  if($h == "un") {$today_unix++;}
                  if($h == "mac") {$today_mac++;}
                  if($h == "none") {$today_or++;}
                 }
               }
               
               // вычисляем проценты за сегодня
               $per_t = $today_win+$today_unix+$today_mac+$today_or;			   
			   $pert_t = @(100/$per_t);
			   $today_win_per = $today_win*$pert_t;
               $today_unix_per = $today_unix*$pert_t;
               $today_mac_per = $today_mac*$pert_t;
               $today_or_per = $today_or*$pert_t; 

               // Вчера
               $yestoday = @file("../../data/os/".date('Y-m-d', strtotime("-1 day")));
               $yestoday_win = 0;
               $yestoday_unix = 0;
               $yestoday_mac = 0;
               $yestoday_or =0;
               if($yestoday)
               {
                for($y=0;$y<count($yestoday);$y++)
                 { 
                  list($iy,$hy) = explode('<<>>',$yestoday[$y]);
                  if($hy == "win") {$yestoday_win++;}
                  if($hy == "un") {$yestoday_unix++;}
                  if($hy == "mac") {$yestoday_mac++;}
                  if($hy == "none") {$yestoday_or++;}
                 }
               }
               // вычисляем проценты за вчера  
               $per_y = $yestoday_win+$yestoday_unix+$yestoday_mac+$yestoday_or;			   
			   $pert_y = @(100/$per_y);
			   $yestoday_win_per = $yestoday_win*$pert_y;
               $yestoday_unix_per = $yestoday_unix*$pert_y;
               $yestoday_mac_per = $yestoday_mac*$pert_y;
               $yestoday_or_per = $yestoday_or*$pert_y;  
 
             // за 7 дней
             for($sev=0;$sev<7;$sev++)
              {
               $seven[] = date('Y-m-d', strtotime("-".$sev." day"));
              }

               $seven_win = 0;
               $seven_unix = 0;
               $seven_mac = 0;
               $seven_or =0;

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
                          if($tss == "win") {$seven_win++;}
                          if($tss == "un") {$seven_unix++;}
                          if($tss == "mac") {$seven_mac++;}
                          if($tss == "none") {$seven_or++;}
                         }
                       }
                    }
                 } 
              }
               // вычисляем проценты за 7 дней  
               $per_s = $seven_win+$seven_unix+$seven_mac+$seven_or;			   
			   $pert_s = @(100/$per_s);
			   $seven_win_per = $seven_win*$pert_s;
               $seven_unix_per = $seven_unix*$pert_s;
               $seven_mac_per = $seven_mac*$pert_s;
               $seven_or_per = $seven_or*$pert_s;
			    
             // за 30 дней
             for($tri=0;$tri<30;$tri++)
              {
               $trith[] = date('Y-m-d', strtotime("-".$tri." day"));
              }

               $trith_win = 0;
               $trith_unix = 0;
               $trith_mac = 0;
               $trith_or =0;

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
                          if($tsr == "win") {$trith_win++;}
                          if($tsr == "un") {$trith_unix++;}
                          if($tsr == "mac") {$trith_mac++;}
                          if($tsr == "none") {$trith_or++;}
                         }
                       }
                    }
                 } 
              }

               // вычисляем проценты за 30 дней  
               $per_tt = $trith_win+$trith_unix+$trith_mac+$trith_or;			   
			   $pert_tt = @(100/$per_tt);
			   $trith_win_per = $trith_win*$pert_tt;
               $trith_unix_per = $trith_unix*$pert_tt;
               $trith_mac_per = $trith_mac*$pert_tt;
               $trith_or_per = $trith_or*$pert_tt;
               
             // за все время

               $total_win = 0;
               $total_unix = 0;
               $total_mac = 0;
               $total_or =0;

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
                       if($tr == "win") {$total_win++;}
                       if($tr == "un") {$total_unix++;}
                       if($tr == "mac") {$total_mac++;}
                       if($tr == "none") {$total_or++;}
                     }
                   }
                } 
              }

               // вычисляем проценты за все время  
               $per_ttt = $total_win+$total_unix+$total_mac+$total_or;			   
			   $pert_ttt = @(100/$per_ttt);
			   $total_win_per = $total_win*$pert_ttt;
               $total_unix_per = $total_unix*$pert_ttt;
               $total_mac_per = $total_mac*$pert_ttt;
               $total_or_per = $total_or*$pert_ttt;
               
               // Сегодня
               $today1 = @file("../../data/broz/".date("Y-m-d"));
               $today_ie = 0;
               $today_net = 0;
               $today_o = 0;
               $today_f = 0;
               $today_m = 0;
               $today_none =0;
               if($today)
               {
                for($t=0;$t<count($today1);$t++)
                 { 
                  list($i,$h) = explode('<<>>',$today1[$t]);
                  if($h == "msie") {$today_ie++;}
                  if($h == "netscape") {$today_net++;}
                  if($h == "opera") {$today_o++;}
                  if($h == "firefox") {$today_f++;}
                  if($h == "mozilla") {$today_m++;}
                  if($h == "none") {$today_none++;}
                 }
                }
                
               //  вычисляем проценты за сегодня браузеры
               $per_b = $today_ie+$today_net+$today_o+$today_f+$today_m+$today_none;			   
			   $pert_b = @(100/$per_b);
			   $today_ie_per = $today_ie*$pert_b;
               $today_net_per = $today_net*$pert_b;
               $today_o_per = $today_o*$pert_b;
               $today_f_per = $today_f*$pert_b;
               $today_none_per = $today_none*$pert_b;
               $today_m_per = $today_m*$pert_b;

               // Вчера
               $yestoday1 = @file("../../data/broz/".date('Y-m-d', strtotime("-1 day")));
               $yestoday_ie = 0;
               $yestoday_net = 0;
               $yestoday_o = 0;
               $yestoday_f = 0;
               $yestoday_m = 0;
               $yestoday_none =0;
               if($yestoday)
               {
                for($y=0;$y<count($yestoday1);$y++)
                 { 
                  list($iy,$hy) = explode('<<>>',$yestoday1[$y]);
                  if($hy == "msie") {$yestoday_ie++;}
                  if($hy == "netscape") {$yestoday_net++;}
                  if($hy == "opera") {$yestoday_o++;}
                  if($hy == "firefox") {$yestoday_f++;}
                  if($hy == "mozilla") {$yestoday_m++;}
                  if($hy == "none") {$yestoday_none++;}
                 }
                }
 
               //  вычисляем проценты за вчера браузеры
               $per_bb = $yestoday_ie+$yestoday_net+$yestoday_o+$yestoday_f+$yestoday_m+$yestoday_none;			   
			   $pert_bb = @(100/$per_bb);
			   $yestoday_ie_per = $yestoday_ie*$pert_bb;
               $yestoday_net_per = $yestoday_net*$pert_bb;
               $yestoday_o_per = $yestoday_o*$pert_bb;
               $yestoday_f_per = $yestoday_f*$pert_bb;
               $yestoday_none_per = $yestoday_none*$pert_bb;
               $yestoday_m_per = $yestoday_m*$pert_bb;
 
             // за 7 дней
             for($sev=0;$sev<7;$sev++)
              {
               $seven1[] = date('Y-m-d', strtotime("-".$sev." day"));
              }

               $seven_ie = 0;
               $seven_net = 0;
               $seven_o = 0;
               $seven_f = 0;
               $seven_m = 0;
               $seven_none =0;

             $dir = opendir("../../data/broz/"); 
             while (($file = readdir($dir)) !== false) 
              { 
                if($file != "." && $file != "..") 
                 { 
                   if(is_file("../../data/broz/".$file)) 
                    { 
                      if(in_array($file, $seven1))
                       {
                         $per = @file("../../data/broz/".$file);
                         for($ts=0;$ts<count($per);$ts++)
                         {
                          list($is,$tss) = explode('<<>>',$per[$ts]);
                          if($tss == "msie") {$seven_ie++;}
                          if($tss == "netscape") {$seven_net++;}
                          if($tss == "opera") {$seven_o++;}
                          if($tss == "firefox") {$seven_f++;}
                          if($tss == "mozilla") {$seven_m++;}
                          if($tss == "none") {$seven_none++;}
                         }
                       }
                    }
                 } 
              }
              
               //  вычисляем проценты за вчера браузеры
               $per_bbb = $seven_ie+$seven_net+$seven_o+$seven_f+$seven_m+$seven_none;			   
			   $pert_bbb = @(100/$per_bbb);
			   $seven_ie_per = $seven_ie*$pert_bbb;
               $seven_net_per = $seven_net*$pert_bbb;
               $seven_o_per = $seven_o*$pert_bbb;
               $seven_f_per = $seven_f*$pert_bbb;
               $seven_none_per = $seven_none*$pert_bbb;
               $seven_m_per = $seven_m*$pert_bbb;

             // за 30 дней
             for($tri=0;$tri<30;$tri++)
              {
               $trith1[] = date('Y-m-d', strtotime("-".$tri." day"));
              }

               $trith_ie = 0;
               $trith_net = 0;
               $trith_o = 0;
               $trith_f = 0;
               $trith_m = 0;
               $trith_none =0;

             $dir = opendir("../../data/broz/"); 
             while (($file = readdir($dir)) !== false) 
              { 
                if($file != "." && $file != "..") 
                 { 
                   if(is_file("../../data/broz/".$file)) 
                    { 
                      if(in_array($file, $trith1))
                       {
                         $per = @file("../../data/broz/".$file);
                         for($trr=0;$trr<count($per);$trr++)
                         {
                          list($is,$tsr) = explode('<<>>',$per[$trr]);
                          if($tsr == "msie") {$trith_ie++;}
                          if($tsr == "netscape") {$trith_net++;}
                          if($tsr == "opera") {$trith_o++;}
                          if($tsr == "firefox") {$trith_f++;}
                          if($tsr == "mozilla") {$trith_m++;}
                          if($tsr == "none") {$trith_none++;}
                         }
                       }
                    }
                 } 
              }
               //  вычисляем проценты за вчера браузеры
               $per_bbbb = $trith_ie+$trith_net+$trith_o+$trith_f+$trith_m+$trith_none;			   
			   $pert_bbbb = @(100/$per_bbbb);
			   $trith_ie_per = $trith_ie*$pert_bbbb;
               $trith_net_per = $trith_net*$pert_bbbb;
               $trith_o_per = $trith_o*$pert_bbbb;
               $trith_f_per = $trith_f*$pert_bbbb;
               $trith_none_per = $trith_none*$pert_bbbb;
               $trith_m_per = $trith_m*$pert_bbbb;


             // за все время

               $total_ie = 0;
               $total_net = 0;
               $total_o = 0;
               $total_f = 0;
               $total_m = 0;
               $total_none =0;

             $dir = opendir("../../data/broz/"); 
             while (($file = readdir($dir)) !== false) 
              { 
                if($file != "." && $file != "..") 
                 { 
                   if(is_file("../../data/broz/".$file)) 
                    { 
                     $pere = @file("../../data/broz/".$file);
                     for($tt=0;$tt<count($pere);$tt++)
                     {
                       list($ir,$tr) = explode('<<>>',$pere[$tt]);
                       if($tr == "msie") {$total_ie++;}
                       if($tr == "netscape") {$total_net++;}
                       if($tr == "opera") {$total_o++;}
                       if($tr == "firefox") {$total_f++;}
                       if($tr == "mozilla") {$total_m++;}
                       if($tr == "none") {$total_none++;}
                     }
                   }
                } 
              }
               //  вычисляем проценты за вчера браузеры
               $per_bbbbb = $total_ie+$total_net+$total_o+$total_f+$total_m+$total_none;			   
			   $pert_bbbbb = @(100/$per_bbbbb);
			   $total_ie_per = $total_ie*$pert_bbbbb;
               $total_net_per = $total_net*$pert_bbbbb;
               $total_o_per = $total_o*$pert_bbbbb;
               $total_f_per = $total_f*$pert_bbbbb;
               $total_none_per = $total_none*$pert_bbbbb;
               $total_m_per = $total_m*$pert_bbbbb;



     echo "<br>
            <table width=80% align=center cellspacing=1 cellpadding=2 bgcolor=#cccccc>
               <tr align=center class=pagerhead>
                 <td>&nbsp;</td>
                 <td>Сегодня</td>
                 <td>Вчера</td>
                 <td>За 7 дней</td>
                 <td>За 30 дней</td>
                 <td>За все время</td>
               </tr>
               <tr class=pager>
                  <td align=center><b>Операционные системы</b></td> <td colspan=5>&nbsp;</td>
               </tr>
               <tr class=pager>
                 <td><p style='padding-left:15px;'>Windows</td>
                 <td align=center>".$today_win." <span class=grey>(".sprintf("%.2f", $today_win_per)." %)</span></td>
                 <td align=center>".$yestoday_win."  <span class=grey>(".sprintf("%.2f", $yestoday_win_per)." %)</span></td>
                 <td align=center>".$seven_win."  <span class=grey>(".sprintf("%.2f", $seven_win_per)." %)</span></td>
                 <td align=center>".$trith_win."  <span class=grey>(".sprintf("%.2f", $trith_win_per)." %)</span></td>
                 <td align=center>".$total_win."  <span class=grey>(".sprintf("%.2f", $total_win_per)." %)</span></td>
               </tr>
               <tr class=pager>
                 <td><p style='padding-left:15px;'>Linux & Unix</td>
                 <td align=center>".$today_unix." <span class=grey>(".sprintf("%.2f", $today_unix_per)." %)</span></td>
                 <td align=center>".$yestoday_unix." <span class=grey>(".sprintf("%.2f", $yestoday_unix_per)." %)</span></td>
                 <td align=center>".$seven_unix." <span class=grey>(".sprintf("%.2f", $seven_unix_per)." %)</span></td>
                 <td align=center>".$trith_unix." <span class=grey>(".sprintf("%.2f", $trith_unix_per)." %)</span></td>
                 <td align=center>".$total_unix." <span class=grey>(".sprintf("%.2f", $total_unix_per)." %)</span></td>
               </tr>
               <tr class=pager>
                 <td><p style='padding-left:15px;'>Macintosh</td>
                 <td align=center>".$today_mac." <span class=grey>(".sprintf("%.2f", $today_mac_per)." %)</span></td>
                 <td align=center>".$yestoday_mac." <span class=grey>(".sprintf("%.2f", $yestoday_mac_per)." %)</span></td>
                 <td align=center>".$seven_mac." <span class=grey>(".sprintf("%.2f", $seven_mac_per)." %)</span></td>
                 <td align=center>".$trith_mac." <span class=grey>(".sprintf("%.2f", $trith_mac_per)." %)</span></td>
                 <td align=center>".$total_mac." <span class=grey>(".sprintf("%.2f", $total_mac_per)." %)</span></td>
               </tr>
               <tr class=pager>
                 <td><p style='padding-left:15px;'>Другие</td>
                 <td align=center>".$today_or." <span class=grey>(".sprintf("%.2f", $today_or_per)." %)</span></td>
                 <td align=center>".$yestoday_or." <span class=grey>(".sprintf("%.2f", $yestoday_or_per)." %)</span></td>
                 <td align=center>".$seven_or." <span class=grey>(".sprintf("%.2f", $seven_or_per)." %)</span></td>
                 <td align=center>".$trith_or." <span class=grey>(".sprintf("%.2f", $trith_or_per)." %)</span></td>
                 <td align=center>".$total_or." <span class=grey>(".sprintf("%.2f", $total_or_per)." %)</span></td>
               </tr>
               <tr class=pager>
                  <td align=center><b>Броузеры</b></td> <td colspan=5>&nbsp;</td>
               </tr>
               <tr class=pager>
                 <td><p style='padding-left:15px;'>Internet Explorer</td>
                 <td align=center>".$today_ie." <span class=grey>(".sprintf("%.2f", $today_ie_per)." %)</span></td>
                 <td align=center>".$yestoday_ie." <span class=grey>(".sprintf("%.2f", $yestoday_ie_per)." %)</span></td>
                 <td align=center>".$seven_ie." <span class=grey>(".sprintf("%.2f", $seven_ie_per)." %)</span></td>
                 <td align=center>".$trith_ie." <span class=grey>(".sprintf("%.2f", $trith_ie_per)." %)</span></td>
                 <td align=center>".$total_ie." <span class=grey>(".sprintf("%.2f", $total_ie_per)." %)</span></td>
               </tr>
               <tr class=pager>
                 <td><p style='padding-left:15px;'>Netscape</td>
                 <td align=center>".$today_net." <span class=grey>(".sprintf("%.2f", $today_net_per)." %)</span></td>
                 <td align=center>".$yestoday_net." <span class=grey>(".sprintf("%.2f", $yestoday_net_per)." %)</span></td>
                 <td align=center>".$seven_net." <span class=grey>(".sprintf("%.2f", $seven_net_per)." %)</span></td>
                 <td align=center>".$trith_net." <span class=grey>(".sprintf("%.2f", $trith_net_per)." %)</span></td>
                 <td align=center>".$total_net." <span class=grey>(".sprintf("%.2f", $total_net_per)." %)</span></td>
               </tr>
               <tr class=pager>
                 <td><p style='padding-left:15px;'>Opera</td>
                 <td align=center>".$today_o." <span class=grey>(".sprintf("%.2f", $today_o_per)." %)</span></td>
                 <td align=center>".$yestoday_o." <span class=grey>(".sprintf("%.2f", $yestoday_o_per)." %)</span></td>
                 <td align=center>".$seven_o." <span class=grey>(".sprintf("%.2f", $seven_o_per)." %)</span></td>
                 <td align=center>".$trith_o." <span class=grey>(".sprintf("%.2f", $trith_o_per)." %)</span></td>
                 <td align=center>".$total_o." <span class=grey>(".sprintf("%.2f", $total_o_per)." %)</span></td>
               <tr class=pager>
                 <td><p style='padding-left:15px;'>Mozilla</td>
                 <td align=center>".$today_m." <span class=grey>(".sprintf("%.2f", $today_m_per)." %)</span></td>
                 <td align=center>".$yestoday_m." <span class=grey>(".sprintf("%.2f", $yestoday_m_per)." %)</span></td>
                 <td align=center>".$seven_m." <span class=grey>(".sprintf("%.2f", $seven_m_per)." %)</span></td>
                 <td align=center>".$trith_m." <span class=grey>(".sprintf("%.2f", $trith_m_per)." %)</span></td>
                 <td align=center>".$total_m." <span class=grey>(".sprintf("%.2f", $total_m_per)." %)</span></td>
               </tr>
               </tr>
               <tr class=pager>
                 <td><p style='padding-left:15px;'>Firefox</td>
                 <td align=center>".$today_f." <span class=grey>(".sprintf("%.2f", $today_f_per)." %)</span></td>
                 <td align=center>".$yestoday_f." <span class=grey>(".sprintf("%.2f", $yestoday_f_per)." %)</span></td>
                 <td align=center>".$seven_f." <span class=grey>(".sprintf("%.2f", $seven_f_per)." %)</span></td>
                 <td align=center>".$trith_f." <span class=grey>(".sprintf("%.2f", $trith_f_per)." %)</span></td>
                 <td align=center>".$total_f." <span class=grey>(".sprintf("%.2f", $total_f_per)." %)</span></td>
               </tr>
               <tr class=pager>
                 <td><p style='padding-left:15px;'>Другие</td>
                 <td align=center>".$today_none." <span class=grey>(".sprintf("%.2f", $today_noneper)." %)</span></td>
                 <td align=center>".$yestoday_none." <span class=grey>(".sprintf("%.2f", $yestoday_none_per)." %)</span></td>
                 <td align=center>".$seven_none." <span class=grey>(".sprintf("%.2f", $seven_none_per)." %)</span></td>
                 <td align=center>".$trith_none." <span class=grey>(".sprintf("%.2f", $trith_none_per)." %)</span></td>
                 <td align=center>".$total_none." <span class=grey>(".sprintf("%.2f", $total_none_per)." %)</span></td>
               </tr>
</table>";

include("inc/bottom.php");
?>