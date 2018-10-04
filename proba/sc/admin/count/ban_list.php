<?
$title = "Система статистики на файловой базе от PLAHOV -  Бан-лист";
$menu_id = 7;

include("inc/head.php");

echo "<br><div align=center class=maintop><b>Бан-лист</b></div><br>";

   // инициализация переменных
   $function = $_GET['function'];
   $ip = $_GET['ip'];
   $z = $_GET['z'];

   function get_fid()
    {
    function make_seed()
      {     
       list($usec, $sec) = explode(' ', microtime());
       return (float) $sec + ((float) $usec * 100000);
      }    
    mt_srand(make_seed());
    $chars="1234567890QWERTYUIOPASDFGHJKLZXCVBNM";
    $retval="";
    $nmax=strlen($chars)-1;
    for ($i=0;$i<25;$i++) $retval=$retval.$chars[mt_rand(0,$nmax)];
    return $retval;
   }

///////////////////////// Пустая функция //////////////////////////////

   if ($function == "")
    {
     echo "
            <table width=60% align=center cellspacing=1 cellpadding=2 bgcolor=#cccccc>
               <tr align=center class=pagerhead>
                 <td>Забаненый ip</td>
                 <td>Дата забанивания</td>
                 <td>Действия</td>
               </tr>";
        $banna = @file("../../data/ban/ban");
        $count = count($banna);
        if($count == 0) {echo "<center><div class=maintop><b>Забаненых IP нет</b></div></center><br><br>";}
        for($i=0;$i<$count;$i++)
          {
            list($ip_bann,$datn,$ee)=explode("<<>>", $banna[$i]);
            echo "
              <tr class=pager align=center>
                <td>".$ip_bann."</td>
                <td>".$datn."</td>
                <td align=center>
                 <a style='cursor:hand;' onClick=\"if(confirm('Вы уверены?')){document.location.href = 'ban_list.php?function=del&z=$ee'}\">Разбанить</a>
                </td>
             </tr>";
          } 
      } 
  echo"</table>";

//////////////////////////////// функция добавления бана /////////////////////////////////


    if($function == "adder")
     {
      $ipeha = trim($_GET['ip']);

      ////////////////// проверка на уже забаненый ip /////////////
      $rec=0;
      $chaters_l = @file("../../data/ban/ban");
      $chat_count = count($chaters_l);
      for($y=0;$y<$chat_count;$y++)
        {
         list($ip_bann,$date_bann,$ee)=explode("<<>>", $chaters_l[$y]);
         if($ipeha == $ip_bann) { $rec++;}
        }
      if($rec>0) { exit("<p class=maintop align=center>IP <font color=red size=3>".$ipeha."</font> на данный момент забанен.</font></p>"); } 

     $code = get_fid();
     $dater = date("d-m-Y");

     $filesss = @file("../../data/ban/ban");
     $fpsss = fopen("../../data/ban/ban", "w");
     flock($fpsss, LOCK_EX);
     fwrite($fpsss, "$ipeha<<>>$dater<<>>$code<<>>\r\n");
     for($i=0;$i<count($filesss);$i++)
      {
       fwrite($fpsss, $filesss[$i]);
      }
     flock($fpsss, LOCK_UN);
     fclose($fpsss);
    print" <html><head>\n";
    print "<META HTTP-EQUIV='Refresh' CONTENT='0; URL=ban_list.php'>"; 
    print"</head></html>\n";
   }

////////////////////////////////// Функция разбана //////////////////////////////////////   

   if ($function == "del" && isset($z))
    {
     $lines=@file("../../data/ban/ban");
     $fp=fopen("../../data/ban/ban", 'w');
     for($i=0;$i<count($lines);$i++)
      {
       list($ip_bann,$date_bann,$zz)=explode('<<>>',$lines[$i]);
       if ($zz != $z){ fwrite($fp,$lines[$i]); }
      }
     fclose($fp);
     print" <html><head>\n";
     print "<META HTTP-EQUIV='Refresh' CONTENT='0; URL=ban_list.php'>"; 
     print"</head></html>\n";
   }
include("inc/bottom.php");
?>
