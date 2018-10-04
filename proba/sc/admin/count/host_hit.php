<?
$title = "Система статистики на файловой базе от PLAHOV -  Хосты и хиты";
$menu_id = 1;

function convertdate($dat, $type)
{
  $dat=strtotime($dat); 
  if ($type==0) return strftime("%d-%m-%Y ",$dat);  
}

$action = htmlspecialchars($_GET['action']);

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
echo"<form action=host_hit.php?action=showday method=POST><p class=maintop>Общий поиск по дате&nbsp;&nbsp;&nbsp;";

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

echo "<br><div align=center class=maintop><b>Хосты и хиты</b></div>";

               // Сегодня все хосты и хиты
               $today = @file("../../data/total/".date("Y-m-d"));
               if($today)
               {
               global $today_hit;
               for($t=0;$t<count($today);$t++)
                {
                 list($i,$h,$g,$w) = explode('<<>>',$today[$t]);
                $today_hit += $h;
                }
                $today_host = count($today);
                }
               if(!$today)
               {
                $today_host = 0;
                $today_hit = 0;
               }

               // Сегодня засчитанные хосты и хиты
               $today_z = @file("../../data/total/".date("Y-m-d"));
               if($today_z)
               {
               global $today_hit_z;
               $today_host_z = 0;
               for($t_z=0;$t_z<count($today_z);$t_z++)
                {
                 list($i_z,$h_z,$g_z,$w_z) = explode('<<>>',$today[$t_z]);
                 if($w_z == "own_site")
			     {
                   $today_hit_z += $h_z;
                 }
                }
               for($tt_z=0;$tt_z<count($today_z);$tt_z++)
               {
                list($i_z,$h_z,$t_z,$w_z) = explode('<<>>',$today[$tt_z]);
                if($w_z == "own_site")
	    		 {
		    	  $today_host_z++;
		    	 } 
               }      
   
                }
               if(!$today_z)
               {
                $today_host_z = 0;
                $today_hit_z = 0;
               }


               // Вчера
               $yestoday = @file("../../data/total/".date('Y-m-d', strtotime("-1 day")));
               if($yestoday)
               { 
               global $yestoday_hit;
               for($y=0;$y<count($yestoday);$y++)
                {
                 list($iy,$hy) = explode('<<>>',$yestoday[$y]);
                 $yestoday_hit += $hy;
                }
                $yestoday_host = count($yestoday);
               }
               if(!$yestoday)
               { 
                 $yestoday_host = 0;
                 $yestoday_hit = 0;
               }
               
               
                // Вчера засчитанные хосты и хиты
               $yestoday_z = @file("../../data/total/".date("Y-m-d", strtotime("-1 day")));
               if($yestoday_z)
               {
               global $yestoday_hit_z;
               $yestoday_host_z = 0;
               for($y_z=0;$y_z<count($yestoday);$y_z++)
                {
                 list($iy_z,$hy_z,$gy_z,$wy_z) = explode('<<>>',$yestoday[$y_z]);
                 if($wy_z == "own_site")
			     {
                   $yestoday_hit_z += $hy_z;
                 }
                }
               for($tty_z=0;$tty_z<count($yestoday_z);$tty_z++)
               {
                list($iy_z,$hy_z,$ty_z,$wy_z) = explode('<<>>',$yestoday[$tty_z]);
                if($wy_z == "own_site")
	    		 {
		    	  $yestoday_host_z++;
		    	 } 
               }      
   
                }
               if(!$yestoday_z)
               {
                $yestoday_host_z = 0;
                $yestoday_hit_z = 0;
               }
 
 
             // все хиты и хосты за 7 дней
             for($sev=0;$sev<7;$sev++)
              {
               $seven[] = date('Y-m-d', strtotime("-".$sev." day"));
              }

             $dir = opendir("../../data/total/"); 
             while (($file = readdir($dir)) !== false) 
              { 
                global $seven_host;
                global $seven_hit;
                if($file != "." && $file != "..") 
                 { 
                   if(is_file("../../data/total/".$file)) 
                    { 
                      if(in_array($file, $seven))
                       {
                         $per = @file("../../data/total/".$file);
                         for($ts=0;$ts<count($per);$ts++)
                         {
                          list($is,$tss) = explode('<<>>',$per[$ts]);
                          $seven_hit += $tss; 
                         }
                         $seven_host += count($per);
                       }
                    }
                 } 
              }

             // засчитанные хосты и хиты за 7 дней
             $dirz = opendir("../../data/total/"); 
             while (($filez = readdir($dirz)) !== false) 
              { 
                global $seven_host_z;
                global $seven_hit_z;
                if($filez != "." && $filez != "..") 
                 { 
                   if(is_file("../../data/total/".$filez)) 
                    { 
                      if(in_array($filez, $seven))
                       {
                         $perz = @file("../../data/total/".$filez);
                         for($tsz=0;$tsz<count($perz);$tsz++)
                         {
                          list($isz,$tssz,$gzs,$wsz) = explode('<<>>',$perz[$tsz]);
                          if($wsz == "own_site")
                          {                          
                           $seven_hit_z += $tssz; 
                          }
                         }
                         
                         $s_host_z=0;
                         for($tssz=0;$tssz<count($perz);$tssz++)
                         {
                          list($issz,$tsssz,$gzss,$wssz) = explode('<<>>',$perz[$tssz]);
                          if($wssz == "own_site")
                          {                          
                           $s_host_z++; 
                          }
                         }
						 $seven_host_z += $s_host_z;
                       }
                    }
                 } 
              }


             // за 30 дней
             for($tri=0;$tri<30;$tri++)
              {
               $trith[] = date('Y-m-d', strtotime("-".$tri." day"));
              }

             $dir = opendir("../../data/total/"); 
             while (($file = readdir($dir)) !== false) 
              { 
                global $tri_host;
                global $tri_hit;
                if($file != "." && $file != "..") 
                 { 
                   if(is_file("../../data/total/".$file)) 
                    { 
                      if(in_array($file, $trith))
                       {
                         $per = @file("../../data/total/".$file);
                         for($trr=0;$trr<count($per);$trr++)
                         {
                          list($is,$tsr) = explode('<<>>',$per[$trr]);
                          $tri_hit += $tsr; 
                         }
                         $tri_host += count($per);
                       }
                    }
                 } 
              }

             // засчитанные хосты и хиты за 30 дней
             $dirz = opendir("../../data/total/"); 
             while (($filez = readdir($dirz)) !== false) 
              { 
                global $tri_host_z;
                global $tri_hit_z;
                if($filez != "." && $filez != "..") 
                 { 
                   if(is_file("../../data/total/".$filez)) 
                    { 
                      if(in_array($filez, $trith))
                       {
                         $perzt = @file("../../data/total/".$filez);
                         for($ttsz=0;$ttsz<count($perzt);$ttsz++)
                         {
                          list($itsz,$ttssz,$gtzs,$wtsz) = explode('<<>>',$perzt[$ttsz]);
                          if($wtsz == "own_site")
                          {                          
                           $tri_hit_z += $ttssz; 
                          }
                         }
                         
                         $t_host_z=0;
                         for($ttssz=0;$ttssz<count($perzt);$ttssz++)
                         {
                          list($itssz,$ttsssz,$gtzss,$wtssz) = explode('<<>>',$perzt[$ttssz]);
                          if($wtssz == "own_site")
                          {                          
                           $t_host_z++; 
                          }
                         }
						 $tri_host_z += $t_host_z;
                       }
                    }
                 } 
              }


             // за все время
             $dir = opendir("../../data/total/"); 
             while (($file = readdir($dir)) !== false) 
              { 
                global $total_host;
                global $total_hit;
                if($file != "." && $file != "..") 
                 { 
                   if(is_file("../../data/total/".$file)) 
                    { 
                     $pere = @file("../../data/total/".$file);
                     for($tt=0;$tt<count($pere);$tt++)
                     {
                       list($ir,$tr) = explode('<<>>',$pere[$tt]);
                       $total_hit += $tr; 
                     }
                     $total_host += count($pere);
                    }
                } 
              }


             // засчитанные хосты и хиты за все время
             $dirz = opendir("../../data/total/"); 
             while (($filez = readdir($dirz)) !== false) 
              { 
                global $total_host_z;
                global $total_hit_z;
                if($filez != "." && $filez != "..") 
                 { 
                   if(is_file("../../data/total/".$filez)) 
                    { 
                      if(in_array($filez, $trith))
                       {
                         $perztt = @file("../../data/total/".$filez);
                         for($tttsz=0;$tttsz<count($perztt);$tttsz++)
                         {
                          list($ittsz,$tttssz,$gttzs,$wttsz) = explode('<<>>',$perztt[$tttsz]);
                          if($wttsz == "own_site")
                          {                          
                           $total_hit_z += $tttssz; 
                          }
                         }
                         
                         $tt_host_z=0;
                         for($ttttssz=0;$ttttssz<count($perztt);$ttttssz++)
                         {
                          list($itttssz,$ttttsssz,$gtttzss,$wtttssz) = explode('<<>>',$perztt[$ttttssz]);
                          if($wtttssz == "own_site")
                          {                          
                           $tt_host_z++; 
                          }
                         }
						 $total_host_z += $tt_host_z;
                       }
                    }
                 } 
              }
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
               <tr align=center class=pager>
                 <td align=left><b>Засчитанные Хосты</b></td>
                 <td>".$today_host_z."</td>
                 <td>".$yestoday_host_z."</td>
                 <td>".$seven_host_z."</td>
                 <td>".$tri_host_z."</td>
                 <td>".$total_host_z."</td>
               </tr>
               <tr align=center class=pager>
                 <td align=left width=150><b>Засчитанные хиты</b></td>
                 <td>".$today_hit_z."</td>
                 <td>".$yestoday_hit_z."</td>
                 <td>".$seven_hit_z."</td>
                 <td>".$tri_hit_z."</td>
                 <td>".$total_hit_z."</td>
               </tr>
               <tr align=center class=pager>
                 <td align=left><b>Все Хосты</b></td>
                 <td>".$today_host."</td>
                 <td>".$yestoday_host."</td>
                 <td>".$seven_host."</td>
                 <td>".$tri_host."</td>
                 <td>".$total_host."</td>
               </tr>
               <tr align=center class=pager>
                 <td align=left><b>Все Хиты</b></td>
                 <td>".$today_hit."</td>
                 <td>".$yestoday_hit."</td>
                 <td>".$seven_hit."</td>
                 <td>".$tri_hit."</td>
                 <td>".$total_hit."</td>
               </tr>";
  echo"</table>";
}

if($action == "showday")
  {
               // Выбранный день
               $day = @file("../../data/total/".$date);
               if($day)
               {
               global $day_hit;
               for($t=0;$t<count($day);$t++)
                {
                 list($i,$h) = explode('<<>>',$day[$t]);
                $day_hit += $h;
                }
                $day_host = count($day);

               // засчитанные хосты и хиты за выбранный день
               global $day_hit_z;
               $day_host_z = 0;
               for($td_z=0;$td_z<count($day);$td_z++)
                {
                 list($id_z,$hd_z,$gd_z,$wd_z) = explode('<<>>',$day[$td_z]);
                 if($wd_z == "own_site")
			     {
                   $day_hit_z += $hd_z;
                 }
                }
               for($ttd_z=0;$ttd_z<count($day);$ttd_z++)
               {
                list($idd_z,$hdd_z,$tdd_z,$wdd_z) = explode('<<>>',$day[$ttd_z]);
                if($wdd_z == "own_site")
	    		 {
		    	  $day_host_z++;
		    	 } 
               }

               echo "<br><div align=center class=maintop><b>Хосты и хиты за ".convertdate($date, 0)."</b></div><br>";
               echo "<table width=250 align=center cellspacing=1 cellpadding=5 bgcolor=#cccccc>
                          <tr class=pager>
                            <td width=70%><b>Засчитанные Хосты</b></td>
                            <td align=center>".$day_host_z."</td>
                          </tr>
                          <tr class=pager>
                            <td><b>Засчитанные Хиты</b></td>
                            <td align=center>".$day_hit_z."</td>
                          </tr>
                          <tr class=pager>
                            <td width=70%><b>Все Хосты</b></td>
                            <td align=center>".$day_host."</td>
                          </tr>
                          <tr class=pager>
                            <td><b>Все Хиты</b></td>
                            <td align=center>".$day_hit."</td>
                          </tr>
                        </table>";
                }
               if(!$day)
               {
                 echo "<br><div align=center class=maintop><b>Статистика за ".convertdate($date, 0)." отсутствует</b></div>";
               }

  }
include("inc/bottom.php");
?>