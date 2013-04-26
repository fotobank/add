<form action="<?=$clean_self;?>" method="post" name="Sad_Raven_Guestbook">
<table class="tb_send_f">
<tr>
<td bgcolor=#333333>
<table class="send_f">
<tr><td><table>
<tr><td width=83 align=right class=p>*Ваше имя:</td><td><input class=inp_f_reg style="width: <?=$SENDWIDTH;?>px;" type=text name=name value="<?=htmlspecialchars(stripslashes($name));?>"></td></tr>
<tr><td width=83 align=right class=p>E-mail:</td><td><input class=inp_f_reg style="width: <?=$SENDWIDTH;?>px;" type=text name=mail value="<?=htmlspecialchars(stripslashes($mail));?>"></td></tr>
<tr><td width=83 align=right class=p>URL:</td><td><input class=inp_f_reg style="width: <?=$SENDWIDTH;?>px;" type=text name=url  value="<?=htmlspecialchars(stripslashes($url));?>"></td></tr>
<tr><td width=83 align=right class=p>Город:</td><td><input class=inp_f_reg style="width: <?=$SENDWIDTH;?>px;" type=text name=city value="<?=htmlspecialchars(stripslashes($city));?>"></td></tr>
<tr><td width=83 align=right class=p valign=top>*Сообщение:</td><td><textarea class=form2 style="width: <?=$SENDWIDTH;?>px; font-size:16px; height: 100px;" name=mess rows=5><?=htmlspecialchars(stripslashes($mess));?></textarea></td></tr>
</table></td>
  <td class=p align=center valign=top><div align="center">   
    </div>
    <table width="150" border=0 cellpadding=0 cellspacing=1 bgcolor=#CCCCCC>
        <tr>
          <td height="25" align=center valign=middle bgcolor=<?=$LIGHT;?>><a href="JavaScript: smile(' :smile: ');"><img src=img/smile.gif border=0 width=20 height=20></a></td>
          <td height="25" align=center valign=middle bgcolor=<?=$LIGHT;?>><a href="JavaScript: smile(' :razz: ');"><img src=img/razz.gif border=0 width=20 height=20></a></td>
          <td align=center valign=middle bgcolor=<?=$LIGHT;?>><a href="JavaScript: smile(' :D: ');"><img src=img/biggrin.gif border=0 width=20 height=20></a></td>
          <td align=center valign=middle bgcolor=<?=$LIGHT;?>><a href="JavaScript: smile(' :cool: ');"><img src=img/cool.gif border=0 width=18 height=18></a></td>
          <td align=center valign=middle bgcolor=<?=$LIGHT;?>><a href="JavaScript: smile(' :hm: ');"><img src=img/hm.gif border=0 width=20 height=20></a></td>
        </tr>
        <tr>
          <td height="25" align=center valign=middle bgcolor=<?=$LIGHT;?>><a href="JavaScript: smile(' :wink: ');"><img src=img/wink.gif border=0 width=18 height=18></a></td>
          <td height="25" align=center valign=middle bgcolor=<?=$LIGHT;?>><a href="JavaScript: smile(' :mad: ');"><img src=img/mad.gif border=0 width=20 height=20></a></td>
          <td align=center valign=middle bgcolor=<?=$LIGHT;?>><a href="JavaScript: smile(' :sad: ');"><img src=img/sad.gif border=0 width=20 height=20></a></td>
          <td align=center valign=middle bgcolor=<?=$LIGHT;?>><a href="JavaScript: smile(' :cry: ');"><img src=img/cry.gif border=0 width=18 height=18></a></td>
          <td align=center valign=middle bgcolor=<?=$LIGHT;?>><a href="JavaScript: smile(' :confused: ');"><img src=img/confused.gif width=20 height="20" border=0></a></td>
        </tr>
        <tr>
          <td height="25" align=center valign=middle bgcolor=<?=$LIGHT;?>><a href="JavaScript: smile(' :crazy: ');"><img src=img/crazy.gif border=0 width=20 height=20></a></td>
          <td height="25" align=center valign=middle bgcolor=<?=$LIGHT;?>><a href="JavaScript: smile(' :unsure: ');"><img src=img/unsure.gif border=0 width=20 height=20></a></td>
          <td align=center valign=middle bgcolor=<?=$LIGHT;?>><a href="JavaScript: smile(' :reply: ');"><img src=img/reply.gif border=0 width=19 height=19></a></td>
          <td align=center valign=middle bgcolor=<?=$LIGHT;?>><a href="JavaScript: smile(' :vsk: ');"><img src=img/vsk.gif border=0 width=19 height=19></a></td>
          <td align=center valign=middle bgcolor=<?=$LIGHT;?>><a href="JavaScript: smile(' :vop: ');"><img src=img/vop.gif border=0 width=19 height=19></a></td>
        </tr>
      </table>    
      <a class="sml" href="javascript:;"  onClick="openBrWindow('design/smiles.php','smiles','scrollbars=yes,resizable=yes,width=380,height=400');return false;">Еще смайлики</a><br>    
      <br>
      <table width="150" border="0" cellspacing="1" cellpadding="2">
      <tr align="center">
        <td><a href="javascript:inserttags('[b]','[/b]')"><img src="img/bold.gif" alt="Жирный" width="16" height="16" border="0"></a></td>
        <td><a href="javascript:inserttags('[i]','[/i]')"><img src="img/italic.gif" alt="Курсив" width="16" height="16" border="0"></a></td>
        <td class=p><a href="javascript:inserttags('[font=red]','[/font]')"><img src="img/redfont.gif" alt="Красный текст" width="16" height="16" border="0"></a></td>
        <td class=p><a href="javascript:inserttags('[font=blue]','[/font]')"><img src="img/bluefont.gif" alt="Синий текст" width="16" height="16" border="0"></a></td>
        <td class=p><a href="javascript:inserttags('[img]','[/img]')"><img src="img/img.gif" alt="Вставка рисунка" width="16" height="16" border="0"></a></td>
      </tr>
    </table></td></tr>
<tr>
  <td colspan="2"><span class="p">
  
<? if ($spamcontrol == "yes") { 
  echo "<table width='100%'  border='0' cellspacing='0' cellpadding='0'><tr><td class='p'  width='40%'>*Введите код, указанный на картинке: &nbsp;&nbsp;</td><td width='80' align='center' class='p'><a href=img/inc.php><img src='gd_gen.php' border='0'></a></td><td width='30' align='center' class='p'>==></td><td class='p' align='left'><input name='f_antispam' type='text' id='f_antispam' class='inp_fent' size='6' maxlength='".$spamcontrol_length."'></td></tr></table>";
 } else echo "<img src='img/spacer.gif' alt='' width='1' height='3' />"; 
?>

  </span></td>
  </tr>
<tr>
  <td colspan="2"><table width="100%" border="0" cellspacing="0" cellpadding="0">
    <tr>
      <td width="83"><img src="img/spacer.gif" alt="" width="1" height="25" /></td>
      <td valign="top">
        <input class="metall_knopka" style="width:125px;cursor:pointer;" type="submit" value="Отправить" name="add" onmouseover="this.style.backgroundColor='<?=$DARK;?>';" onmouseout="this.style.backgroundColor='<?=$LIGHT;?>';" />
                    </td>
      <td valign="top"><span class="psmall">* - поля обязательные для заполнения.</span></td>
    </tr>
  </table></td>
  </tr>
</table>
</td>
</tr></table></form>
<table border=0 cellpadding=0 cellspacing=0 width=100% height=4><tr><td height=4></td></tr></table>
