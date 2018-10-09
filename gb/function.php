<?php
       /**
        * Created by PhpStorm.
        * User: Jurii
        * Date: 09.10.2018
        * Time: 18:36
        */

       ///////////   ФУНКЦИИ   ////////////
       /////////// автозамена с автоматической вставкой ссылок и картинок ////////////
       function replace($string, $id) {

              global $exech;
              $string = " ".$string;
              $string = str_replace('"', "&quot;", $string);
              if ($id === 'answ') {
                     $string =
                            preg_replace("'[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*'", "<a href=\"mailto:\\0\" class=answ>\\0</a>", $string);
                     $string =
                            preg_replace("'([[:space:]]|\n|<br>)(www.[-a-zA-Z0-9@:%_\+.~#?&//=]+)'", '\\1<a href="http://\\2" target="_blank" class=answ>\\2</a>', $string);
                     $string =
                            preg_replace("'([[:space:]]|\n|<br>)(http://.[-a-zA-Z0-9@:%_\+.~#?&//=]+)'", '\\1<a href="\\2" target="_blank" class=answ>\\2</a>', $string);
              } else if ($id == "dark") {
                     $string =
                            preg_replace("'[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*'", "<a href=\"mailto:\\0\" class=dark>\\0</a>", $string);
                     $string =
                            preg_replace("'([[:space:]]|\n|<br>)(www.[-a-zA-Z0-9@:%_\+.~#?&//=]+)'", '\\1<a href="http://\\2" target="_blank" class=dark>\\2</a>', $string);
                     $string =
                            preg_replace("'([[:space:]]|\n|<br>)(http://.[-a-zA-Z0-9@:%_\+.~#?&//=]+)'", '\\1<a href="\\2" target="_blank" class=dark>\\2</a>', $string);
              } else {
                     $string =
                            preg_replace("'[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*'", "<a href=\"mailto:\\0\">\\0</a>", $string);
                     $string =
                            preg_replace("'([[:space:]]|\n|<br>)(www.[-a-zA-Z0-9@:%_\+.~#?&//=]+)'", '\\1<a href="http://\\2" target="_blank">\\2</a>', $string);
                     $string =
                            preg_replace("'([[:space:]]|\n|<br>)(http://.[-a-zA-Z0-9@:%_\+.~#?&//=]+)'", '\\1<a href="\\2" target="_blank">\\2</a>', $string);
              }
              $string     =
                     preg_replace("'(\[img\])(http://.[-a-zA-Z0-9@:%_\+.~#?&//=]+)(\[/img\])'", '<img src="\\2">', $string);
              $autochange = file($exech);
              $lines      = count($autochange);
              for ($i = 0; $i < $lines; $i++) {
                     list($change1, $change2) = explode("|", $autochange[$i]);
                     $string = preg_replace("'$change1'", "$change2", $string);
              }

              return trim($string);
       }

       /////////// простая автозамена ////////////
       function replace_short($string) {

              global $exech;
              $string     = " ".$string;
              $string     = str_replace('"', "&quot;", $string);
              $autochange = file($exech);
              $lines      = count($autochange);
              for ($i = 0; $i < $lines; $i++) {
                     list($change1, $change2) = explode("|", $autochange[$i]);
                     $string = preg_replace("'$change1'", "$change2", $string);
              }

              return trim($string);
       }

       /////////// очистка ввода пользователя ////////////
       function cutty($string) {

              $string = trim($string);
              $string = stripslashes($string);
              $string = str_replace("<", "&lt;", $string);
              $string = str_replace(">", "&gt;", $string);
              $string = preg_replace('/\\\"/', "&quot;", $string);
              $string = preg_replace("/\\\'/", "&quot;", $string);
              $string = preg_replace("/\&quot;/", "&quot;", $string);
              $string = preg_replace("/\'/", "'", $string);
              $string = preg_replace("/'/", "`", $string);
              $string = str_replace("\r", "", $string);
              $string = str_replace("\n", "<br>", $string);
              $string = str_replace("%", "&#37;", $string);
              $string = str_replace("!", "&#33;", $string);
              $string = str_replace("^ +", "", $string);
              $string = str_replace(" +$", "", $string);
              $string = str_replace("|", "l", $string);

              return ($string);
       }

       /////////// замена тегов гостевой тегами html ////////////
       function getHTMLtags($text) {

              $text = str_replace("[b]", "<strong>", $text);
              $text = str_replace("[/b]", "</strong>", $text);
              $text = str_replace("[i]", "<i>", $text);
              $text = str_replace("[/i]", "</i>", $text);
              $text = str_replace("[font=red]", "<font color=ff0000>", $text);
              $text = str_replace("[font=blue]", "<font color=003399>", $text);
              $text = str_replace("[/font]", "</font>", $text);

              return $text;
       }

       /////////// вырезание тегов гостевой ////////////
       function cutHTMLtags($text) {

              $text = str_replace("[b]", "", $text);
              $text = str_replace("[/b]", "", $text);
              $text = str_replace("[i]", "", $text);
              $text = str_replace("[/i]", "", $text);
              $text = str_replace("[font=red]", "", $text);
              $text = str_replace("[font=blue]", "", $text);
              $text = str_replace("[/font]", "", $text);

              return $text;
       }

       /////////// форматирование дат сообщений ////////////
       function mydate($date, $messnum = '') {

              $min        = date($date);
              $date       = getdate($date);
              $mymon      = array(
                     "", "января", "февраля", "марта", "апреля", "мая", "июня", "июля", "августа", "сентября", "октября",
                     "ноября", "декабря"
              );
              $m          = $date['mon'];
              $myday      = array(
                     "в воскресенье", "в понедельник", "во вторник", "в среду", "в четверг", "в пятницу", "в субботу"
              );
              $d          = $date['wday'];
              $real_month = $mymon[$m];
              if ($real_month == "") {
                     $real_month = "декабря";
              }
              $date = "Сообщение #".$messnum.", написано ".$myday[$d].", $date[mday] ".$real_month
                      ." $date[year] года, в $date[hours]:".date("i", $min);

              return $date;
       }

       /////////// отображение сообщения ////////////
       function mess($name, $mess, $mail, $url, $city, $date, $answer, $messnum) {

              global $BORDER, $DARK, $LIGHT, $ANSW, $anti_email, $PICHEIGHT, $PICWIDTH;
              if (($mail != "") && ($anti_email <> "yes")) {
                     $mess_mail = replace($mail, "dark");
              } else if (($mail != "") && ($anti_email == "yes")) {
                     list($mm2, $mm1) = explode("@", $mail);
                     $mess_mail =
                            "<a class='snd_ml' href=\"javascript:;\"  onClick=\"openBrWindow('send_mail.php?mm1=$mm1&mm2=$mm2','send_mail','scrollbars=yes,resizable=yes,width=420,height=270');return false;\"><img src=\"mail.php?mm1=$mm1&mm2=$mm2\" align=\"absmiddle\" border=0 /></a>";
              }
              echo "\n<table class='tb_mess'>\n";
              echo "<tr><td class='td_name' colspan=2>\n";
              if ($city == "") {
                     echo"<a class='sml' href=\"javascript: smile(':reply: [b]".$name
                         ."[/b] \\n');\"><b>$name</b></a></td></tr>";
              } else {
                     echo"<a class='sml' href=\"javaScript: smile(':reply: [b]".$name." (".$city
                         .")[/b] \\n');\"><b>$name</b> ($city)</a></td></tr>\n";
              }
              echo "<tr><td class='td_mess_txt'>$mess</td></tr>\n";
              echo "<tr><td class='mees_inf' colspan=2>".mydate($date, $messnum)."</td></tr>\n";
              if (!($answer == "")) {
                     echo "<tr><td align=left bgcolor=$ANSW class=pansw colspan=2>";
                     echo "<b>Ответ :</b> $answer";
                     echo "</td></tr>\n";
              }
              echo "</table>\n";
              echo "<table border=0 cellpadding=0 cellspacing=0 width=100% height=4><tr><td height=4></td></tr></table>\n";
       }

       /////////// отображение ссылок на страницы гостевой ////////////
       function getPages($total, $page, $link, $perpage) {

              $mpp       = $perpage;
              $prev_page = $page - 1;
              $next_page = $page + 1;
              if ($total <= $mpp) {
                     $pages = 1;
              }
              elseif ($total % $mpp == 0) {
                     $pages = $total / $mpp;
              } else {
                     $pages = $total / $mpp + 1;
              }
              $pages   = (int)$pages;
              $s_pages = $page < 7 ? 1 : floor($page / 7) * 7;
              $e_pages = $page + 6;
              if ($e_pages > $pages) {
                     $e_pages = $pages;
              }
              $s = "";
              if ($pages > 6) {
                     if ($prev_page != 0) {
                            $s = "<a href=\"".$link."page=1\" class=\"mid\"> &lt;&lt; </a>| \n";
                     }
                     if ($prev_page) {
                            $s .= "<a href=\"".$link."page=$prev_page\" class=\"mid\"> &lt; </a>| \n";
                     }
              }
              for ($i = $s_pages; $i <= $e_pages; $i++) {
                     if ($i != $page) {
                            $s .= "<a href=\"".$link."page=$i\" class=\"mid\"> $i </a>| \n";
                     } elseif ($i != 1) {
                            $s .= " <b> $i |</b> ";
                     } elseif ($page != $pages) {
                            $s .= " <b> 1 |</b> ";
                     }
              }
              if ($page != $pages && $pages > 6) {
                     $s .= "<a href=\"".$link."page=$next_page\" class=\"mid\"> &gt; </a>| \n";
                     $s .= "<a href=\"".$link."page=$pages\" class=\"mid\"> &gt;&gt; </a>| \n";
              }
              if (!isset($s) || $s == "") {
                     $s = " <b> 1 |</b> ";
              }

              return $s;
       }

       ///////////   КОНЕЦ ВСЕХ ФУНКЦИЙ   ////////////
