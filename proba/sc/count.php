<?
    $ip = $_SERVER['REMOTE_ADDR']; 
    if(empty($ip)) $ip = '0.0.0.0';
    $reff = urldecode($_SERVER['HTTP_REFERER']);
    if(empty($title)) $title = "unknow_page";
    $timer = date("H:i:s");

   $banan = file($path."data/ban/ban");
   $count = count($banan);
   for($i=0;$i<$count;$i++)
   {
    list($ip_ban,$date_bann,$zz)=explode("<<>>", $banan[$i]);
    if($ip== $ip_ban)
     {
       Header("HTTP/1.0 404 Not Found");
       exit();
     }
   }

    if(file_exists($path."data/pages/".$title.".".date("Y-m-d")))
       {
              $peref = file($path."data/pages/".$title.".".date("Y-m-d"));
              $fppere = fopen($path."data/pages/".$title.".".date("Y-m-d"), "w");
              flock($fppere, LOCK_EX);
              fwrite($fppere, "$ip<<>>$timer<<>>\r\n");
              for($g=0;$g<count($peref);$g++)
               {
                 fwrite($fppere, $peref[$g]);
               }
              flock($fppere, LOCK_UN);
              fclose($fppere);
       }

    if(!file_exists($path."data/pages/".$title.".".date("Y-m-d")))
       {
            $filesss = @file($path."data/pages/".$title.".".date("Y-m-d"));
            $fpsss = fopen($path."data/pages/".$title.".".date("Y-m-d"), "w");
            flock($fpsss, LOCK_EX);
            fwrite($fpsss, "$ip<<>>$timer<<>>\r\n");
            flock($fpsss, LOCK_UN);
            fclose($fpsss);
      }

      $useragent = $_SERVER['HTTP_USER_AGENT'];

      $browser = 'none';
      // �������� �������
      if(strpos($useragent, "Mozilla") !== false) $browser = 'mozilla';
      if(strpos($useragent, "MSIE")    !== false) $browser = 'msie';
      if(strpos($useragent, "MyIE")    !== false) $browser = 'myie';
      if(strpos($useragent, "Opera")   !== false) $browser = 'opera';
      if(strpos($useragent, "Netscape")!== false) $browser = 'netscape';
      if(strpos($useragent, "Firefox") !== false) $browser = 'firefox';

    if(file_exists($path."data/broz/".date("Y-m-d")))
       {
              $pere = file($path."data/broz/".date("Y-m-d"));
              for($i=0;$i<count($pere);$i++)
               {
                list($ipp2,$broz) = explode('<<>>',$pere[$i]);
                $ar[] = $ipp2;
              }

            if(!in_array($ip, $ar))
              {
              $fppere = fopen($path."data/broz/".date("Y-m-d"), "w");
              flock($fppere, LOCK_EX);
              fwrite($fppere, "$ip<<>>$browser<<>>\r\n");
              for($g=0;$g<count($pere);$g++)
               {
                 fwrite($fppere, $pere[$g]);
               }
              flock($fppere, LOCK_UN);
              fclose($fppere);
              }
       }

    if(!file_exists($path."data/broz/".date("Y-m-d")))
       {
            $filesss = @file($path."data/broz/".date("Y-m-d"));
            $fpsss = fopen($path."data/broz/".date("Y-m-d"), "w");
            flock($fpsss, LOCK_EX);
            fwrite($fpsss, "$ip<<>>$browser<<>>\r\n");
            flock($fpsss, LOCK_UN);
            fclose($fpsss);
      }

      // �������� ������������ �������
      $os = 'none';
      if(strpos($useragent, "Win")      !== false) $os = 'win';
      if(strpos($useragent, "Linux")    !== false 
      || strpos($useragent, "Lynx")     !== false
      || strpos($useragent, "Unix")     !== false) $os = 'un';
      if(strpos($useragent, "Macintosh")!== false) $os = 'mac';
      if(strpos($useragent, "PowerPC")  !== false) $os = 'mac';


      // �������� �������������� � ��������� �������
      if(strpos($useragent, "StackRambler") !== false) $os = 'robot_rambler';
      if(strpos($useragent, "Googlebot")    !== false) $os = 'robot_google';
      if(strpos($useragent, "Mediapartners-Google")    !== false) $os = 'robot_google';
      if(strpos($useragent, "Yandex")       !== false) $os = 'robot_yandex';
      if(strpos($useragent, "Aport")        !== false) $os = 'robot_aport';
      if(strpos($useragent, "msnbot")       !== false) $os = 'robot_msnbot';

    if(file_exists($path."data/os/".date("Y-m-d")))
       {
              $pere = file($path."data/os/".date("Y-m-d"));
              for($i=0;$i<count($pere);$i++)
               {
                list($ipp2,$broz) = explode('<<>>',$pere[$i]);
                $a[] = $ipp2;
              }

            if(!in_array($ip, $a))
              {
              $fppere = fopen($path."data/os/".date("Y-m-d"), "w");
              flock($fppere, LOCK_EX);
              fwrite($fppere, "$ip<<>>$os<<>>\r\n");
              for($g=0;$g<count($pere);$g++)
               {
                 fwrite($fppere, $pere[$g]);
               }
              flock($fppere, LOCK_UN);
              fclose($fppere);
              }
       }

    if(!file_exists($path."data/os/".date("Y-m-d")))
       {
            $filesss = @file($path."data/os/".date("Y-m-d"));
            $fpsss = fopen($path."data/os/".date("Y-m-d"), "w");
            flock($fpsss, LOCK_EX);
            fwrite($fpsss, "$ip<<>>$os<<>>\r\n");
            flock($fpsss, LOCK_UN);
            fclose($fpsss);
      }


      $search = 'none';
      // �������� �������������� � ��������� ��������
      if(strpos($reff,"yandex"))  $search = 'yandex';
      if(strpos($reff,"rambler")) $search = 'rambler';
      if(strpos($reff,"google"))  $search = 'google';
      if(strpos($reff,"aport"))   $search = 'aport';
      if(strpos($reff,"mail") && strpos($reff,"search"))   $search = 'mail';
      if(strpos($reff,"msn") && strpos($reff,"results"))   $search = 'msn';
      $server_name = $_SERVER["SERVER_NAME"];
      if(substr($_SERVER["SERVER_NAME"],0,4) == "www.") $server_name = substr($_SERVER["SERVER_NAME"],4);
      if(strpos($reff,$server_name)) $search = 'own_site';

      if(!empty($reff) && $search  =="none")
      {
        $reff = str_replace("'","`",$reff);

        $ref_time = date("H:i:s");

     if(file_exists($path."data/refer/".date("Y-m-d")))
       {
              $pere = file($path."data/refer/".date("Y-m-d"));
              for($i=0;$i<count($pere);$i++)
               {
                list($broz,$ttii,$cou) = explode('<<>>',$pere[$i]);
                $aaa[] = $broz;
              }

            if(in_array($reff, $aaa))
              {
              $fppere = fopen($path."data/refer/".date("Y-m-d"), "w");
              flock($fppere, LOCK_EX);
              for($www=0;$www<count($pere);$www++)
               {
                  list($bro,$tti,$co) = explode('<<>>',$pere[$www]);
                  if($reff == $bro)
                  {
                   $ddd = $co+1;
                   $pere[$www] = "$reff<<>>$ref_time<<>>$ddd<<>>\r\n";
                  }
                  fwrite($fppere, $pere[$www]);
               }

               flock($fppere, LOCK_UN);
               fclose($fppere);
              }


            if(!in_array($reff, $aaa))
              {
              $fppere = fopen($path."data/refer/".date("Y-m-d"), "w");
              flock($fppere, LOCK_EX);
              fwrite($fppere, "$reff<<>>$ref_time<<>>1<<>>\r\n");
              for($g=0;$g<count($pere);$g++)
               {
                 fwrite($fppere, $pere[$g]);
               }
              flock($fppere, LOCK_UN);
              fclose($fppere);
              }

       }

    if(!file_exists($path."data/refer/".date("Y-m-d")))
       {
            $filesss = @file($path."data/refer/".date("Y-m-d"));
            $fpsss = fopen($path."data/refer/".date("Y-m-d"), "w");
            flock($fpsss, LOCK_EX);
            fwrite($fpsss, "$reff<<>>$ref_time<<>>1<<>>\r\n");
            flock($fpsss, LOCK_UN);
            fclose($fpsss);
      }
  }
  
  
      if(file_exists($path."data/total/".date("Y-m-d")))
       {
              $peref = file($path."data/total/".date("Y-m-d"));
              for($i=0;$i<count($peref);$i++)
               {
                list($ipp1,$xit1) = explode('<<>>',$peref[$i]);
                $arr[] = $ipp1;
              }
               
              $now_time = date("H:i");
 
              if(in_array($ip, $arr))
              {
              $lin = file($path."data/total/".date("Y-m-d"));
              $fppere = fopen($path."data/total/".date("Y-m-d"), "w");
              flock($fppere, LOCK_EX);
              for($i=0;$i<count($lin);$i++)
               {
                list($ipp,$xit) = explode('<<>>',$lin[$i]);
                if ($ip == $ipp) {$xitt = $xit+1; $lin[$i] = "$ip<<>>$xitt<<>>$now_time<<>>$search<<>>\r\n"; }
                fwrite($fppere, $lin[$i]);
               }
              flock($fppere, LOCK_UN);
              fclose($fppere);
              }

            if(!in_array($ip, $arr))
              {
              $fppere = fopen($path."data/total/".date("Y-m-d"), "w");
              flock($fppere, LOCK_EX);
              fwrite($fppere, "$ip<<>>1<<>>$now_time<<>>$search<<>>\r\n");
              for($g=0;$g<count($peref);$g++)
               {
                 fwrite($fppere, $peref[$g]);
               }
              flock($fppere, LOCK_UN);
              fclose($fppere);
              }

       }

    if(!file_exists($path."data/total/".date("Y-m-d")))
       {
            $now_time = date("H:i");
            $filesss = @file($path."data/total/".date("Y-m-d"));
            $fpsss = fopen($path."data/total/".date("Y-m-d"), "w");
            flock($fpsss, LOCK_EX);
            fwrite($fpsss, "$ip<<>>1<<>>$now_time<<>>$search<<>>\r\n");
            flock($fpsss, LOCK_UN);
            fclose($fpsss);
      }
  
  
  
  
    //������ ��������� ������ � ��������������� ����
    if(!empty($reff) && $search!="none" && $search != "own_site")
    {
       switch($search)
       {
         case 'yandex':
         {
             eregi("text=([^&]*)", $reff."&", $query); 
             if(strpos($reff,"yandpage")!=null)
               $quer=convert_cyr_string(urldecode($query[1]),"k","w");
             else
               $quer=$query[1];
           break;
         }
         case 'rambler':
         {
           eregi("words=([^&]*)", $reff."&", $query); 
           $quer = $query[1];
           break;
         }
         case 'mail':
         {
           eregi("q=([^&]*)", $reff."&", $query); 
           $quer = $query[1];
           break;
         }
         case 'google':
         {
           eregi("q=([^&]*)", $reff."&", $query); 
           $quer = utf8_win($query[1]); 
           break;
         }
         case 'msn':
         {
           eregi("q=([^&]*)", $reff."&", $query); 
           $quer = utf8_win($query[1]);
           break;
         }
         case 'aport':
         {
           eregi("r=([^&]*)", $reff."&", $query); 
           $quer = $query[1];
           break;
         }
     }//����� ��� switch

        $symbols = array("\"", "'", "(", ")", "+", ",", "-"); 
        $quer = str_replace($symbols, " ", $quer); 
        $quer = trim($quer); 
        $quer = preg_replace('|[\s]+|',' ',$quer); 
        $quer_time = date("H:i:s");


     if(file_exists($path."data/zapros/".date("Y-m-d")))
       {
              $pere = file($path."data/zapros/".date("Y-m-d"));
              for($i=0;$i<count($pere);$i++)
               {
                list($ipp2,$broz,$cou,$rrr) = explode('<<>>',$pere[$i]);
                $aaaa[] = $ipp2;
              }

            if(in_array($quer, $aaaa))
              {
              $fppere = fopen($path."data/zapros/".date("Y-m-d"), "w");
              flock($fppere, LOCK_EX);
              for($www=0;$www<count($pere);$www++)
               {
                  list($bro,$tti,$co,$kkk) = explode('<<>>',$pere[$www]);
                  if($quer == $bro)
                  {
                   $co++;
                   $pere[$www] = "$quer<<>>$quer_time<<>>$co<<>>$search<<>>\r\n";
                  }
                  fwrite($fppere, $pere[$www]);
               }

               flock($fppere, LOCK_UN);
               fclose($fppere);
              }

            if(!in_array($quer, $aaaa))
              {
              $fppere = fopen($path."data/zapros/".date("Y-m-d"), "w");
              flock($fppere, LOCK_EX);
              fwrite($fppere, "$quer<<>>$quer_time<<>>1<<>>$search<<>>\r\n");
              for($g=0;$g<count($pere);$g++)
               {
                 fwrite($fppere, $pere[$g]);
               }
              flock($fppere, LOCK_UN);
              fclose($fppere);
              }
       }

    if(!file_exists($path."data/zapros/".date("Y-m-d")))
       {
            $filesss = @file($path."data/zapros/".date("Y-m-d"));
            $fpsss = fopen($path."data/zapros/".date("Y-m-d"), "w");
            flock($fpsss, LOCK_EX);
            fwrite($fpsss, "$quer<<>>$quer_time<<>>1<<>>$search<<>>\r\n");
            flock($fpsss, LOCK_UN);
            fclose($fpsss);
      }
}

function utf8_win($s)
{
    $s=str_replace("\xD0\xB0","�",$s);  $s=str_replace("\xD0\x90","�",$s);
    $s=str_replace("\xD0\xB1","�",$s);  $s=str_replace("\xD0\x91","�",$s);
    $s=str_replace("\xD0\xB2","�",$s);  $s=str_replace("\xD0\x92","�",$s);
    $s=str_replace("\xD0\xB3","�",$s);  $s=str_replace("\xD0\x93","�",$s);
    $s=str_replace("\xD0\xB4","�",$s);  $s=str_replace("\xD0\x94","�",$s);
    $s=str_replace("\xD0\xB5","�",$s);  $s=str_replace("\xD0\x95","�",$s);
    $s=str_replace("\xD1\x91","�",$s);  $s=str_replace("\xD0\x81","�",$s);
    $s=str_replace("\xD0\xB6","�",$s);  $s=str_replace("\xD0\x96","�",$s);
    $s=str_replace("\xD0\xB7","�",$s);  $s=str_replace("\xD0\x97","�",$s);
    $s=str_replace("\xD0\xB8","�",$s);  $s=str_replace("\xD0\x98","�",$s);
    $s=str_replace("\xD0\xB9","�",$s);  $s=str_replace("\xD0\x99","�",$s);
    $s=str_replace("\xD0\xBA","�",$s);  $s=str_replace("\xD0\x9A","�",$s);
    $s=str_replace("\xD0\xBB","�",$s);  $s=str_replace("\xD0\x9B","�",$s);
    $s=str_replace("\xD0\xBC","�",$s);  $s=str_replace("\xD0\x9C","�",$s);
    $s=str_replace("\xD0\xBD","�",$s);  $s=str_replace("\xD0\x9D","�",$s);
    $s=str_replace("\xD0\xBE","�",$s);  $s=str_replace("\xD0\x9E","�",$s);
    $s=str_replace("\xD0\xBF","�",$s);  $s=str_replace("\xD0\x9F","�",$s);
    $s=str_replace("\xD1\x80","�",$s);  $s=str_replace("\xD0\xA0","�",$s);
    $s=str_replace("\xD1\x81","�",$s);  $s=str_replace("\xD0\xA1","�",$s);
    $s=str_replace("\xD1\x82","�",$s);  $s=str_replace("\xD0\xA2","�",$s);
    $s=str_replace("\xD1\x83","�",$s);  $s=str_replace("\xD0\xA3","�",$s);
    $s=str_replace("\xD1\x84","�",$s);  $s=str_replace("\xD0\xA4","�",$s);
    $s=str_replace("\xD1\x85","�",$s);  $s=str_replace("\xD0\xA5","�",$s);
    $s=str_replace("\xD1\x86","�",$s);  $s=str_replace("\xD0\xA6","�",$s);
    $s=str_replace("\xD1\x87","�",$s);  $s=str_replace("\xD0\xA7","�",$s);
    $s=str_replace("\xD1\x88","�",$s);  $s=str_replace("\xD0\xA8","�",$s);
    $s=str_replace("\xD1\x89","�",$s);  $s=str_replace("\xD0\xA9","�",$s);
    $s=str_replace("\xD1\x8A","�",$s);  $s=str_replace("\xD0\xAA","�",$s);
    $s=str_replace("\xD1\x8B","�",$s);  $s=str_replace("\xD0\xAB","�",$s);
    $s=str_replace("\xD1\x8C","�",$s);  $s=str_replace("\xD0\xAC","�",$s);
    $s=str_replace("\xD1\x8D","�",$s);  $s=str_replace("\xD0\xAD","�",$s);
    $s=str_replace("\xD1\x8E","�",$s);  $s=str_replace("\xD0\xAE","�",$s);
    $s=str_replace("\xD1\x8F","�",$s);  $s=str_replace("\xD0\xAF","�",$s);
    return $s;
} 



?>