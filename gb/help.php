<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<?
header('Content-type: text/html; charset=windows-1251');
?>
<?
define('SR_DENIED', true);
include ("config.inc.php");
?>
<title><?=$gname?></title>
<meta http-equiv="Content-Type" content="text/html; charset=windows-1251">
<? require ("design/css.inc.php"); ?>
</head>

<body bgcolor=<?=$BACKGROUND?>>
<table width=100%  border=0 cellpadding=2 cellspacing=1 bgcolor=<?=$BORDER;?>>
  <tr bgcolor="<?=$DARK;?>">
    <td colspan="2" class=pdark><p class=pdark><strong><font size="+1">Справка по возможностям гостевой книги</font></strong></p>
      <ul>
	  <li><a href="#1" class=dark>Вставка ссылок в сообщение</a></li>
      <li><a href="#2" class=dark>Вставка смайликов</a></li>
      <li><a href="#3" class=dark>Изменение формата текста</a></li>
      <li><a href="#4" class=dark>Вставка рисунка в сообщение</a></li>
	  </ul>	      </td>
  </tr>
  <tr bgcolor="<?=$LIGHT;?>">
    <td height="5" colspan="2"></td>
  </tr>
  <tr bgcolor="<?=$ANSW;?>">
    <td colspan="2" class="pansw"><p class="pansw"><a name="1" id="1"></a><span class="panswbig"><strong>Вставка ссылок 
          в сообщение</strong></span><br>
Вы можете вставлять в сообщение гиперссылки и email-ссылки. Текст преобразуется
в ссылку автоматически. Для этого достаточно написать ссылку, указав тип используемого
протокола (<strong>http://</strong>, <strong>ftp://</strong> и
    т.п.). Если ссылка начинается
    с<strong> www</strong>, то указывать тип протокола не обязательно. <br>
    <span class="textRed">Обязательное условие!!!</span> Отделяйте пробелами текст ссылки от других слов,
    спецсимволов и знаков препинания.<br>
    <strong>Примеры:</strong>
    </p>    </td>
  </tr>
  <tr bgcolor="<?=$LIGHT;?>" class="pmid">
    <td width="50%"><strong> Написано </strong></td>
    <td width="50%"><strong>Будет отображено </strong></td>
  </tr>
  <tr bgcolor="<?=$LIGHT;?>" class="p">
    <td>http://www.yandex.ru</td>
    <td><a href="http://www.yandex.ru" target="_blank">http://www.yandex.ru</a></td>
  </tr>
  <tr bgcolor="<?=$LIGHT;?>" class="p">
    <td>www.yandex.ru</td>
    <td><a href="http://www.yandex.ru" target="_blank">www.yandex.ru</a></td>
  </tr>
  <tr bgcolor="<?=$LIGHT;?>" class="p">
    <td>admin@site.ru</td>
    <td><a href="mailto:admin@site.ru">admin@site.ru</a></td>
  </tr>
  <tr bgcolor="<?=$LIGHT;?>" class="pmid">
    <td colspan="2" class="textRed">Возможные ошибки при вставке гиперссылок</td>
  </tr>
  <tr bgcolor="<?=$LIGHT;?>" class="pmid">
    <td class="pmid"><strong>Написано</strong></td>
    <td class="pmid"><strong>Причина ошибки </strong></td>
  </tr>
  <tr bgcolor="<?=$LIGHT;?>" class="pmid">
    <td  class="pmid">Адрес: www.yandex.ru.</td>
    <td class="pmid">После текста ссылки стоит точка. Для правильного формирования ссылки
      нужно отделить точку пробелом.<br>
      Правильное написание:<br>      <span class=p>Адрес: www.yandex.ru 
      .</span></td>
  </tr>
  <tr bgcolor="<?=$LIGHT;?>" class="pmid">
    <td class="pmid">[i]www.yandex.ru[/i]</td>
    <td class="pmid">Текст ссылки не отделен пробелами от служебного тега. Для правильного
      формирования ссылки окружите ее пробелами.<br>
      Правильное написание:<br>      <span class=p>[i] www.yandex.ru [/i]</span></td>
  </tr>
  <tr bgcolor="<?=$LIGHT;?>" class="pmid">
    <td class="pmid">Адрес: yandex.ru</td>
    <td class="pmid">Адрес ссылки не начинается с &quot;www&quot;.&nbsp;В этом случае обязательно
      нужно начинать ссылку с &quot;http://&quot;<br>
      Правильное написание:<br>
      <span class=p>Адрес: http://yandex.ru</span></td>
  </tr>
  <tr bgcolor="<?=$LIGHT;?>">
    <td height="5" colspan="2"></td>
  </tr>
  <tr bgcolor="<?=$ANSW;?>">
    <td colspan="2" class="pansw"><p class="pansw"><a name="2" id="2"></a><span class="panswbig"><strong>Вставка смайликов</strong></span><br>
      Смайлики, или эмотиконы — это маленькие рисунки, которые могут быть использованы
      для выражения чувств. Для вставки смайлика  в сообщение нужно написать специальный
      код, соответствующий требуемому рисунку.<br>
      <span class="textRed">Не следует злоупотреблять применением смайликов! Это делает сообщение нечитаемым
        и считается признаком дурного тона в интернете.</span><br>
      <br>
    <strong>Пример смайлика:</strong></p></td>
  </tr>
  <tr bgcolor="<?=$LIGHT;?>" class=pmid>
    <td><strong> Написано </strong></td>
    <td><strong>Будет отображено </strong></td>
  </tr>
  <tr bgcolor="<?=$LIGHT;?>" class=pmid>
    <td> :crazy: </td>
    <td><img src="img/crazy.gif" width="20" height="20"></td>
  </tr>
  <tr bgcolor="<?=$LIGHT;?>">
    <td height="5" colspan="2"></td>
  </tr>
  <tr bgcolor="<?=$ANSW;?>">
    <td colspan="2" class="pansw"><div align="center">
      <div align="justify">
        <p class="pansw"><a name="3" id="3"></a><span class="panswbig"><strong>Изменение формата текста</strong></span><br>
          Вы можете написать часть сообщения <strong>жирным шрифтом</strong> или <em>курсивом</em>.
          Кроме того, можно изменить цвет текста. Для этого нужно заключить нужный
          текст в специальные служебные теги (выделены красным):</p>
      </div>
      <div align="center"> 
        <p><span class="textRed">[b]</span><strong>жирный текст</strong><span class="textRed">[/b]</span><br>
          <span class="textRed">[i]</span><em>курсив</em><span class="textRed">[/i]</span><br>
          <span class="textRed">[b][i]</span><strong><em>жирный курсив</em></strong><span class="textRed">[/i][/b]<br>
          [font=red]текст красного цвета[/font]<br>
          [font=blue]</span><span class="textBlue">текст синего цвета</span><span class="textRed">[/font]              <br>
          </span></p>
      </div>
	    <div align="left">
	      <p><strong>Примеры:</strong></p>
    </div>	</td>
  </tr>
  <tr bgcolor="<?=$LIGHT;?>">
    <td class="pmid"><strong> Написано </strong></td>
    <td class="pmid"><strong>Будет отображено </strong></td>
  </tr>
  <tr bgcolor="<?=$LIGHT;?>">
    <td class="pmid">[b]Внимание! Внимание![/b]</td>
    <td class="pmid"><strong>Внимание! Внимание!</strong></td>
  </tr>
  <tr bgcolor="<?=$LIGHT;?>">
    <td class="pmid">[i]завтра в 18.30[/i]</td>
    <td class="pmid"><em>завтра в 18.30</em></td>
  </tr>
  <tr bgcolor="<?=$LIGHT;?>">
    <td class="pmid">[font=red]Привет![/font]</td>
    <td class="pmid"><font color="#FF0000">Привет!</font></td>
  </tr>
  <tr bgcolor="<?=$LIGHT;?>">
    <td class="pmid">[font=blue]Привет![/font]</td>
    <td class="pmid"><font color="#003399">Привет!</font></td>
  </tr>
  <tr bgcolor="<?=$LIGHT;?>" class="pmid">
    <td colspan="2" class="textRed">Возможные ошибки при форматировании текста </td>
  </tr>
  <tr bgcolor="<?=$LIGHT;?>" class="pmid">
    <td><strong>Написано</strong></td>
    <td><strong>Причина ошибки </strong></td>
  </tr>
  <tr bgcolor="<?=$LIGHT;?>">
    <td class="pmid">[b]Внимание! Внимание![b]</td>
    <td class="pmid">Не вставлен слеш (косая черта) в закрывающем теге. <br>
    Правильное написание:<br>    <span class=p>[b]Внимание! Внимание![/b]</span></td>
  </tr>
  <tr bgcolor="<?=$LIGHT;?>">
    <td class="pmid">[font = blue]Привет![/font]</td>
    <td class="pmid">Лишние пробелы внутри служебного тега. <br>
    Правильное написание:<br>
    <span class=p>[font=blue]Привет![/font]</span></td>
  </tr>
  <tr bgcolor="<?=$LIGHT;?>">
    <td height="5" colspan="2"></td>
  </tr>
  <tr bgcolor="<?=$ANSW;?>">
    <td colspan="2"class="pansw"><a name="4" id="4"></a><span class="panswbig"><strong>Вставка рисунка в сообщение</strong></span><br>
      Вы можете вставлять в свое сообщение рисунки. Вы не можете загружать рисунки
        на наш сервер! Возможно только указание ссылки на 
 рисунок, который находится на общедоступном сервере.<br>
 Для вставки рисунка в сообщение используйте тег <span class="textRed">[img][/img]</span>,
 внутрь которого (без пробелов и с обязательным написанием <strong>http://</strong>)
 вставьте ссылку на рисунок.<br>
 Вы можете вставлять рисунки форматов <strong>JPG, GIF или PNG</strong> размером <strong>не более
<?=$PICWIDTH;?>х<?=$PICHEIGHT;?> пикселей</strong>. <br> 
 <span class="textRed">Вставляйте рисунки в сообщения только если это необходимо! Не пытайтесь вставлять
 рисунки, которые заведомо не интересны посетителям гостевой - они будут удалены
 модератором. Не пытайтесь вставлять рисунки, если Вы недостаточно хорошо поняли,
 как это делается. </span><br><br>
 <strong>Пример вставки рисунка:</strong></td>
  </tr>
  <tr bgcolor="<?=$LIGHT;?>">
    <td class="pmid"><strong> Написано </strong></td>
    <td class="pmid"><strong>Будет отображено </strong></td>
  </tr>
  <tr bgcolor="<?=$LIGHT;?>">
    <td bgcolor="<?=$LIGHT;?>" class="pmid"><nobr class="textsmall">[img]http://www.yandex.ru/logo1.gif[/img]</nobr></td>
    <td class="pmid"><img src="http://www.yandex.ru/logo1.gif" width="77" height="32"></td>
  </tr>
  <tr bgcolor="<?=$LIGHT;?>" class="pmid">
    <td colspan="2" class="textRed">Возможные ошибки при вставке рисунков </td>
  </tr>
  <tr bgcolor="<?=$LIGHT;?>">
    <td class="pmid"><strong>Написано</strong></td>
    <td class="pmid"><strong>Причина ошибки </strong></td>
  </tr>
  <tr bgcolor="<?=$LIGHT;?>" class="pmid">
    <td bgcolor="<?=$LIGHT;?>" class="pmid"><span class="psmall"><nobr>[img]http://www.yandex.ru/logo1.gif[img]</nobr></span></td>
    <td>Не вставлен слеш (косая черта) в закрывающем теге. <br>
    Правильное написание:<br>    <span class="psmall"><nobr>[img]http://www.yandex.ru/logo1.gif[/img]</nobr></span></td>
  </tr>
  <tr bgcolor="<?=$LIGHT;?>">
    <td bgcolor="<?=$LIGHT;?>" class="pmid"><span class="psmall">[img] http://www.yandex.ru/logo1.gif[/img]</span></td>
    <td class="pmid">Лишний пробел между тегом рисунка и текстом ссылки.<br>
      Правильное написание:<br>
      <span class="psmall"><nobr>[img]http://www.yandex.ru/logo1.gif[/img]</nobr></span> </td>
  </tr>
</table>
</body>
</html>
