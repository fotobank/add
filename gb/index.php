<?php
       define('ROOT_PATH', dirname(__DIR__, 1) . DIRECTORY_SEPARATOR , true);
       error_reporting(E_ALL);
       ini_set('display_errors', 1);
       define('SR_DENIED', true);
       if (!include 'config.inc.php') {
              die('Не найден рабочий файл конфигурации');
       }
       if (!isset($_GET['messref'])) {
              $messref = 0;
       } else {
              $messref = 1;
       }
       include __DIR__.'/function.php';

       ///////////   устанавливаем в кукисы данные пользователя, вынимаем переменные из POST   ////////////
       if (isset($_POST['name']) && $_POST['name'] !== '') {
              $name = $_POST['name'];
              setcookie('cookname', cutty($name), time() + 15552000);
       }
       if (isset($_POST["mail"])) {
              $mail = $_POST["mail"];
              setcookie("cookmail", cutty($mail), time() + 15552000);
       }
       if (isset($_POST["url"])) {
              $url = $_POST["url"];
              setcookie("cookurl", cutty($url), time() + 15552000);
       }
       if (isset($_POST["city"])) {
              $city = $_POST["city"];
              setcookie("cookcity", cutty($city), time() + 15552000);
       }
       if (isset($_POST["mess"])) {
              $mess = $_POST["mess"];
       }
       ///////////   вынимаем из кукисов данные пользователя для вставки в форму   ////////////
       if (!isset($_POST["add"])):
              if (!isset($_COOKIE["cookname"])) {
                     $cookname = "";
              } else {
                     $cookname = $_COOKIE["cookname"];
              }
              if (!isset($_COOKIE["cookmail"])) {
                     $cookmail = "";
              } else {
                     $cookmail = $_COOKIE["cookmail"];
              }
              if (!isset($_COOKIE["cookurl"])) {
                     $cookurl = "";
              } else {
                     $cookurl = $_COOKIE["cookurl"];
              }
              if (!isset($_COOKIE["cookcity"])) {
                     $cookcity = "";
              } else {
                     $cookcity = $_COOKIE["cookcity"];
              }
              if (!isset($name) or $name == "") {
                     $name = $cookname;
              }
              if (!isset($mail)) {
                     $mail = $cookmail;
              }
              if (!isset($url)) {
                     $url = $cookurl;
              }
              if (!isset($city)) {
                     $city = $cookcity;
              }
              if (!isset($mess)) {
                     if (isset($_COOKIE['cookmess']) && $messref == 1) {
                            $mess = $_COOKIE['cookmess'];
                            setcookie("cookmess", "", time() + 15552000);
                     } else {
                            $mess = "";
                     }
              }
       endif;

       ///////////   выясняем IP-адрес пользователя   ////////////
       if (getenv('HTTP_X_FORWARDED_FOR')) {
              if (trim(getenv('HTTP_X_FORWARDED_FOR')) <> "") {
                     $ip = getenv('HTTP_X_FORWARDED_FOR');
              } else {
                     $ip = getenv('REMOTE_ADDR');
              }
       } else {
              $ip = getenv('REMOTE_ADDR');
       }

       ///////////   проверяем на отсутствие ошибок перед записью сообщения  ////////////
       if (isset($_POST["add"])):
              if (!isset($name)) {
                     $name = "";
              }
              if (!isset($mail)) {
                     $mail = "";
              }
              if (!isset($url)) {
                     $url = "";
              }
              if (!isset($city)) {
                     $city = "";
              }
              if (!isset($mess)) {
                     $mess = "";
              }
              if (($name == "") || (cutHTMLtags($mess) == "")) {
                     $error[] = "Вы заполнили не все обязательные поля.";
              }
              if (strlen($name) > $maxword) {
                     $error[] = "Имя должно быть не длиннее $maxmail символов.";
              }
              if (strlen($mail) > $maxmail) {
                     $error[] = "Адрес e-mail не должен превышать $maxmail символов.";
              }
              if ($mail != "" && !preg_match("/^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*$/i", $mail)) {
                     $error[] = "Таких адресов e-mail не бывает.";
              }
              if (strlen($url) > $maxurl) {
                     $error[] = "Адрес URL не должен превышать $maxurl символов.";
              }
              if (strlen($city) > $maxcity) {
                     $error[] = "Название города не должно превышать $maxcity символов.";
              }
              if (strlen($mess) > $maxlenght) {
                     $error[] = "Сообщение не должно превышать $maxlenght символов.";
              }
              if (preg_match("/[^ ]{".$maxword.",}/i", $mess)) {
                     $error[] = "Слова в сообщении не должны превышать $maxword символов.";
              }
              $data_array = file("$data");
              $cnt        = count($data_array) - 1;
              $ch_name    = cutty($name);
              $ch_mess    = cutty($mess);
              for ($i = $cnt; $i >= 0; $i--) {
                     list($cname, $cmess, $cmail, $curl, $ccity, $cdate, $canswer) = explode("|", $data_array[$i]);
                     $check = "$ch_name|$ch_mess";
                     if ($check == "$cname|$cmess") {
                            $error[] = "Такое сообщение уже есть в базе данных.";
                     }
              }
              $temp_string = $mess;
              while ($temp_string = strstr($temp_string, '[img]')) {
                     preg_match('/(\[img\])(http://.[-a-zA-Z0-9@:%_\+.~#?&//=]+)(\[/img\])/i', $temp_string,
                                $pic_array);
                     $imgurl  = $pic_array[2];
                     $picfile = @fopen("$imgurl", "r");
                     if (!$picfile) {
                            $error[] = "Не найден файл вставляемого в сообщение рисунка.";
                     } else {
                            $imagesize = GetImageSize("$imgurl");
                            if (!isset($imagesize[2])) {
                                   $error[] = "Вы пытаетесь вставить рисунок недопустимого формата.";
                            } else {
                                   if ($imagesize[0] > $PICWIDTH) {
                                          $error[] =
                                                 "Ширина вставляемого рисунка больше максимально возможной (".$PICWIDTH
                                                 ." пикс.)";
                                   }
                                   if ($imagesize[1] > $PICHEIGHT) {
                                          $error[] =
                                                 "Высота вставляемого рисунка больше максимально возможной (".$PICHEIGHT
                                                 ." пикс.)";
                                   }
                            }
                     }
                     $cutlength   = strlen($pic_array[0]);
                     $temp_string = substr($temp_string, $cutlength);
              }
       endif;

       ///////////   проверяем, не редиска ли нам пишет    ////////////
       $banip    = file("$banlist");
       $banlines = count($banip);
       for ($i = 0; $i < $banlines; $i++) {
              list($badip, $why, $who) = explode("|", $banip[$i]);
              if (strstr($ip, $badip)) {
                     include("$header");
                     echo "<table width=100% border=0 cellspacing=0 cellpadding=0 class=p><tr><td align=center>";
                     echo "<table width=100% bgcolor=$BORDER border=0 cellspacing=1 cellpadding=3 class=p><tr><td bgcolor=#FF0000 align=center style=\"color:#FFFFFF\"><b>Доступ запрещен!</b></td></tr>";
                     echo "<tr><td bgcolor=$LIGHT align=center>Для Вас гостевая книга закрыта.<br>Причина: $why</td></tr></table>";
                     include("$footer");
                     exit;
              }
              if ((cutty($name) == cutty($who)) && (cutty($name) <> "")) {
                     $error[] = "Вам запрещено добавлять сообщения. Причина: $why";
              }
       }
       ///////////   если передается содержание формы и ошибок нет, то грузим файл write.php    ////////////
       if ($name != "" && $mess != "" && isset($_POST["add"]) && (!isset($error) || empty($error))) {
              include("write.php");
              exit;
       }
       ///////////   загружаем  шапку   ////////////
       $gb = dirname($_SERVER['PHP_SELF']);
       include("$header");
       echo "<table width=100% border=0 cellspacing=0 cellpadding=0 class=p><tr><td align=center>";
       ///////////   загружаем  сообщения об ошибках   ////////////
       if ($name != '' && $mess != '' && isset($_POST['add']) && (!isset($error) || empty($error))):
       elseif (isset($error) || !empty($error)):
              echo "<table width=\"100%\" border=\"0\" cellspacing=\"1\" cellpadding=\"3\" bgcolor=\"$BORDER\">";
              echo "<tr><td align=\"center\" class=\"error\" bgcolor=\"#FF0000\"><b>Ошибка!</b></td></tr>";
              echo "<tr><td align=\"left\" class=\"p\" bgcolor=\"$LIGHT\">";
              foreach ($error as $value) {
                     echo "<li>$value<br>";
              }
              echo "</td></tr>";
              echo "</table>";
              echo "<table border=0 cellpadding=0 cellspacing=0 width=100% height=4><tr><td height=4></td></tr></table>";
       endif;
       ///////////   определяем, на какой мы странице   ////////////
       if (!isset($_GET["page"])) {
              $page = 1;
       } else {
              $page = (int)$_GET["page"];
       }
       ///////////   определяем страницу, на которой находимся. чистим от дерьма   ////////////
       $clean_self  = $_SERVER['PHP_SELF'];
       $clean_rules = [
              'chr(', 'chr=', 'chr%20', '%20chr', 'wget%20', '%20wget', 'wget(',
              'cmd=', '%20cmd', 'cmd%20', 'rush=', '%20rush', 'rush%20',
              'union%20', '%20union', 'union(', 'union=', 'echr(', '%20echr', 'echr%20', 'echr=',
              'esystem(', 'esystem%20', 'cp%20', '%20cp', 'cp(', 'mdir%20', '%20mdir', 'mdir(',
              'mcd%20', 'mrd%20', 'rm%20', '%20mcd', '%20mrd', '%20rm',
              'mcd(', 'mrd(', 'rm(', 'mcd=', 'mrd=', 'mv%20', 'rmdir%20', 'mv(', 'rmdir(',
              'chmod(', 'chmod%20', '%20chmod', 'chmod(', 'chmod=', 'chown%20', 'chgrp%20', 'chown(', 'chgrp(',
              'locate%20', 'grep%20', 'locate(', 'grep(', 'diff%20', 'kill%20', 'kill(', 'killall',
              'passwd%20', '%20passwd', 'passwd(', 'telnet%20', 'vi(', 'vi%20',
              'insert%20into', 'select%20', 'nigga(', '%20nigga', 'nigga%20', 'fopen', 'fwrite', '%20like', 'like%20',
              '$_request', '$_get', '$request', '$get', '.system', 'http_php', '&aim', '%20getenv', 'getenv%20',
              'new_password', '&icq', '/etc/password', '/etc/shadow', '/etc/groups', '/etc/gshadow',
              'http_user_agent', 'http_host', '/bin/ps', 'wget%20', 'uname\x20-a', '/usr/bin/id',
              '/bin/echo', '/bin/kill', '/bin/', '/chgrp', '/chown', '/usr/bin', 'g\+\+', 'bin/python',
              'bin/tclsh', 'bin/nasm', 'perl%20', 'traceroute%20', 'ping%20', '.pl', '/usr/x11r6/bin/xterm', 'lsof%20',
              '/bin/mail', '.conf', 'motd%20', 'http/1.', '.inc.php', 'config.php', 'cgi-', '.eml',
              'file\://', 'window.open', '<script>', 'javascript\://', 'img src', 'img%20src', '.jsp', 'ftp.exe',
              'xp_enumdsn', 'xp_availablemedia', 'xp_filelist', 'xp_cmdshell', 'nc.exe', '.htpasswd',
              'servlet', '/etc/passwd', 'wwwacl', '~root', '~ftp', '.js', '.jsp', 'admin_', '.history',
              'bash_history', '.bash_history', '~nobody', 'server-info', 'server-status', 'reboot%20', 'halt%20',
              'powerdown%20', '/home/ftp', '/home/www', 'secure_site, ok', 'chunked', 'org.apache', '/servlet/con',
              '<script', '/robot.txt', '/perl', 'mod_gzip_status', 'db_mysql.inc', '.inc', 'select%20from',
              'select from', 'drop%20', '.system', 'getenv', 'http_', '_php', 'php_', 'phpinfo()', "'", '<', '>',
              'sql=',
              '.php/'
       ];
       $clean_self  = str_replace($clean_rules, '', $clean_self);
       ///////////   загружаем  форму   ////////////
       if (!preg_match("/\%/i", $TABWIDTH)) {
              $SENDWIDTH = $TABWIDTH - 300;
       } else {
              $SENDWIDTH = 300;
       }
       include $send_form;

       ///////////   загружаем содержимое файла базы сообщений   ////////////
       $file_array  = file($data);
       $lines       = count($file_array);
       $print_pages = getPages($lines, $page, "$clean_self?", $maxmess);
       ///////////   печатаем перечень страниц   ////////////
       echo "<table><tr><td class='td_klmess'><b>Всего сообщений : $lines</b></td></tr><tr><td class='td_klmess'><b>Страницы : |$print_pages</b></td></tr></table>";
       echo "<table border=0 cellpadding=0 cellspacing=0 width=100% height=4><tr><td height=4></td></tr></table>";
       $from = $lines - ($page * $maxmess - 1);
       $to   = $lines - (($page - 1) * $maxmess);
       if ($from < 0) {
              $from = 1;
       }
       ///////////   печатаем сообщения   ////////////
       for ($i = $to - 1; $i >= $from - 1; $i--) {
              $id = $i;
              list($name, $mess, $mail, $url, $city, $date, $answer) = explode("|", $file_array[$i]);
              if (!($name == "" && $mess == "")):
                     $messnum = $id + 1;
                     $name    = replace_short($name);
                     $mess    = replace($mess, "light");
                     $mess    = getHTMLtags($mess);
                     $url     = replace($url, "dark");
                     $city    = replace_short($city);
                     $answer  = replace($answer, "answ");
                     mess($name, $mess, $mail, $url, $city, $date, $answer, $messnum);
              endif;
       }
       ///////////   печатаем перечень страниц и подвал   ////////////
       echo "<table><tr><td class='td_klmess'><b>Страницы : |$print_pages</b></td></tr><tr><td class='td_klmess'><b>Всего сообщений : $lines</b></td></tr></table>";
       echo "</table><tr><td><table border=0 cellpadding=0 cellspacing=0 width=100% height=2><tr><td height=2></td></tr></table>
";
       $loadTwig('_footer.twig', $renderData);
       include(__DIR__.'/../inc/footer.php');
