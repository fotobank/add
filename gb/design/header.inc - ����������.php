<?
include (__DIR__.'/../../inc/config.php');
include (__DIR__.'/../../inc/func.php');




header('Content-type: text/html; charset=windows-1251');
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//RU" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=windows-1251" />
<meta name="google-site-verification" content="uLdE_lzhCOntN_AaTM1_sQNmIXFk1-Dsi5AWS0bKIgs" />


<?php
include (__DIR__.'/../../inc/title.php');
?>
<link href="../../css/gb.css" rel="stylesheet" type="text/css" />
<link rel="shortcut icon" href="../../img/ico_nmain.gif" />
<link href="../../css/main.css" rel="stylesheet" type="text/css" />
<link href="../../css/bootstrap.css" rel="stylesheet" />

<script src="../../js/jquery.js"></script>
<script src="../../js/bootstrap.min.js"></script>
<script src="../../js/main.js"></script>

<? if(strstr($_SERVER['PHP_SELF'], 'folder_for_prototype')): ?>
<script type="text/javascript" src="../../js/prototype.js"></script>
<script type="text/javascript" src="../../js/scriptaculous.js?load=effects"></script>
<script type="text/javascript" src="../../js/lightbox.js"></script>
<? endif; ?>



<script language=JavaScript>
function clickIE4()
{
  if (event.button==2)
  {
    return false;
  }

}

function clickNS4(e)
{
  if (document.layers||document.getElementById&&!document.all)
  {
    if (e.which==2||e.which==3)
    {
      return false;
    }

  }
}
if (document.layers)
{


  document.captureEvents(Event.MOUSEDOWN);
  document.onmousedown=clickNS4;
}
else if (document.all && !document.getElementById)
{
  document.onmousedown=clickIE4;
}
document.oncontextmenu=new Function("return false");
</script>






<script language=JavaScript type="text/javascript">


function smile(str){
	obj = document.Sad_Raven_Guestbook.mess;
	obj.focus();
	obj.value =	obj.value + str;
}
function openBrWindow(theURL,winName,features){
  	window.open(theURL,winName,features);
}
function inserttags(st_t, en_t){
	obj = document.Sad_Raven_Guestbook.mess;
	obj2 = document.Sad_Raven_Guestbook;
	if ((document.selection)) {
		obj.focus();
		obj2.document.selection.createRange().text = st_t+obj2.document.selection.createRange().text+en_t;
	}
	else
	{
		obj.focus();
		obj.value += st_t+en_t;
	}
}
</script>


<script type="text/javascript">	
$(document).ready(function() {
    $(".vhod").tooltip();
});
</script>

<script type="text/javascript">	
$(document).ready(function() {
    $("input").tooltip();
});
</script>

<script type="text/javascript">
	$(document).ready(function() {
    $("a[rel=popover]")
        .popover({
        offset: 10,		
        })
        .click(function(e) {
            e.preventDefault()
        })
});
</script>

<script type="text/javascript">
$(document).ready(function(){
 $(".registracia").tooltip({offset: 10,}); 
});  
</script>


<script language=JavaScript type="text/javascript">
jQuery(window).load(function(){
      if(jQuery("#fixed-menu") && jQuery("#fixed-menu").length){
        var pos = jQuery("#fixed-menu").offset();
        if(pos && typeof pos.top != "undefined" && pos.top){
          jQuery("#fixed-menu").affix({offset: pos.top});
        };
      };
      if(jQuery("#scrolled-sidebar") && jQuery("#scrolled-sidebar").length){
          jQuery(document.body).scrollspy({target: "#scrolled-sidebar", offset: 5});
      };
    });


</script>

</head>

<body> 
<div id="maket">
<div id="photo_preview_bg" class="hidden" onClick="JavaScript: hidePreview();"></div>
<div id="photo_preview"  class="hidden"></div>


<!--������ ������-->
<div id="head">
	<table class="tb_head">
    <tr>
<td>
	    <?
      if ($_SESSION['us_name'] == 'test')
        {
		$time = microtime();
        $time = explode(' ', $time);
        $time = $time[1] + $time[0];
        $start = $time;
        ?>
       <div class="ttext_orange" style="position:absolute">
        <?
            echo "������ � ������: ".memory_get_usage()." ���� \n";	
        ?>
        </div>
	    <?
	    }
	    ?>		
	    <div class="td_head_logo">	
                    <div id="flash-container">
                    <object classid="clsid:D27CDB6E-AE6D-11cf-96B8-444553540000" width="910" height="218" id="flash-object">
                    	<param name="movie" value="../img/container.swf">
                    	<param name="quality" value="high">
                    	<param name="scale" value="default">
                    	<param name="wmode" value="transparent">
                    	<param name="flashvars" value="color1=0xFFFFFF&amp;alpha1=.50&amp;framerate1=24&amp;loop=true&amp;wmode=transparent&amp;clip=../img/flash.swf&amp;radius=4&amp;clipx=-50&amp;clipy=0&amp;initalclipw=900&amp;initalcliph=200&amp;clipw=1000&amp;cliph=200&amp;width=900&amp;height=200&amp;textblock_width=0&amp;textblock_align=no&amp;hasTopCorners=true&amp;hasBottomCorners=true">
                        <param name="swfliveconnect" value="true">
                    	<!--[if !IE]>-->
                    	<object type="application/x-shockwave-flash" data="../img/container.swf" width="910" height="218">
                    	    <param name="quality" value="high">
                    	    <param name="scale" value="default">
                    	    <param name="wmode" value="transparent">
                        	<param name="flashvars" value="color1=0xFFFFFF&amp;alpha1=.50&amp;framerate1=24&amp;loop=true&amp;wmode=transparent&amp;clip=../img/flash.swf&amp;radius=4&amp;clipx=-50&amp;clipy=0&amp;initalclipw=900&amp;initalcliph=200&amp;clipw=1000&amp;cliph=200&amp;width=900&amp;height=200&amp;textblock_width=0&amp;textblock_align=no&amp;hasTopCorners=true&amp;hasBottomCorners=true">
                            <param name="swfliveconnect" value="true">
                    	<!--<![endif]-->
                    		<div class="flash-alt"><a href="http://www.adobe.com/go/getflashplayer"><img src="http://www.adobe.com/images/shared/download_buttons/get_flash_player.gif" alt="Get Adobe Flash player"></a></div>
                    	<!--[if !IE]>-->
                    	</object>
                    	<!--<![endif]-->
                    </object>
                    </div>
    <a class="logo" href="/index.php"></a>      
	<div id="zagol">
            <h1>
    		����������������<br>
 			���� � ����������� <br>
			� ������
    		</h1>
        <script type="text/javascript">
            Cufon.replace('h1', {
                color: '-linear-gradient(#f2a401, 0.1=#fff, 0.9=#f2a401, rgb(0, 0, 0))',
                textShadow: "2px 3px rgba(0, 0, 0, 0.3)"
            });
        </script>

    </div>
  

</div>
    </td>
    <td class="td_form_ent">
   

    <div id="form_ent">

<? if(isset($_SESSION['logged'])): ?>
<center>
  <span style="color:#bb5">������������,<br> <b><?=$_SESSION['us_name']?></b><br>
  <?
  $user_balans = floatval(mysql_result(mysql_query('select balans from users where id = '.intval($_SESSION['userid'])), 0));
  ?>
  ��� ������: <b><?=$user_balans?></b> ��.<br></span></center>

  
<div style="margin-top: 8px;">
  <a class="korzina" href="/basket.php">�������</a> 
 
 <a class="vihod" href="/enter.php?logout=1" >�����</a>
 </div>
<div style="margin-top: 8px;">
  <a class="scet" href="#scet_form">���������� �����</a>
  </div>
<? else: ?>
    <u>����� �����:</u><br>

    <form action="../enter.php" method="post">
    <table>
    <tr>
    <td> �����: </td> <td><input class="inp_fent" name="login"></td>
    </tr>
    <tr>
     <td> ������: </td> <td> <input class="inp_fent" type="password" name="password"></td>
     </tr>
      <tr></tr>
	 <tr>
	 <td><input data-placement="left" rel="tooltip" class="vhod" name="submit" type="submit" value="����" title="����� ����������!" data-original-title="Tooltip on left"></td> 
	  
	<td><a href="../registr.php" class="registracia" data-placement="right" data-original-title="����������� �� ���� �������!" >�����������</a></td>	 
    </tr>	 	 	 	 
    </table>
    <a href="../reminder.php" style="color: #fff; text-decoration: none;">������ ������?</a>
    </form>

	<? endif; ?>

    </div>
    </td>
	
	<tr>
	<td></td>
	<td>
</table>     
  <a href="#x" class="overlay" id="scet_form"></a>
    <div id="popup">          
         ���������� �����
      <a class="close2" href="#close"></a>
    </div> 


<!-- ��������� �� ������-->
<?
if(isset($_SESSION['err_msg']))
{		  
?>	
<div id="error" class="modal hide fade"  tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="err_msg">
    <div class="modal-header"> 
       <button class="close" data-dismiss="modal">x</button>
       <h3 style="color:red">������!</h3>
    </div> 	
    <div class="modal-body">
	<div style="float:left">
	 <span class="ttext_red"><?=$_SESSION['err_msg']?></span>	   
    </div> 		
        <a style="float:right" class="btn" data-dismiss="modal" href="#">�������</a>   
	</div></div>
</div>						                   					
<?
    echo "<script type='text/javascript'>
         $(document).ready(function(){
         $('#error').modal('show');
         });
		 function gloze() {
		 $('#error').modal('hide');
		 };
	     setTimeout('gloze()', 4000);
         </script>";		 	
    unset($_SESSION['err_msg']);
}
?>

<!-- ��������� � ������� ����������-->
<?
if(isset($_SESSION['ok_msg']))
{
?>

<div id="ok" class="modal hide fade"  tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="ok_msg">
    <div class="modal-header"> 
       <button class="close" data-dismiss="modal">x</button>
       <h3>����� ����������!</h3>
    </div> 	
    <div class="modal-body">
	<div style="float:left">
	 <span><?=$_SESSION['ok_msg']?></span>	   
    </div> 		
        <a style="float:right" class="btn" data-dismiss="modal" href="#">�������</a>   
	</div></div>
</div>						                   					
<?
    echo "<script type='text/javascript'>
         $(document).ready(function(){
         $('#ok').modal('show');
         });
		 function gloze() {
		 $('#ok').modal('hide');
		 };
	     setTimeout('gloze()', 4000);
         </script>";		 	
    unset($_SESSION['ok_msg']);
}
?>

    <div id="main_menu">
 <?PHP
	$value= $_SERVER['PHP_SELF'];

if ($value=='/index.php') {$act_ln='gl_act'; $key='�������';
echo "
	<a href='$value' class='$act_ln'>$key</a>
	<a class='bt_fb' href='/fotobanck.php'>����-����</a>
	<a class='bt_usl' href='/uslugi.php'>������</a>
	<a class='bt_ceny' href='/ceny.php'>����</a>
	<a class='bt_konty' href='/kontakty.php'>��������</a>
	<a class='bt_gb' href='/gb/'>��������</a>"

	;}elseif ($value=='/fotobanck.php') {$act_ln='fb_act'; $key='����-����';
	echo "
	<a class='bt_gl' href='/index.php'>�������</a>
	<a href='$value' class='$act_ln'>$key</a>
	<a class='bt_usl' href='/uslugi.php'>������</a>
	<a class='bt_ceny' href='/ceny.php'>����</a>
	<a class='bt_konty' href='/kontakty.php'>��������</a>
	<a class='bt_gb' href='/gb/'>��������</a>"

	;}elseif ($value=='/uslugi.php') {$act_ln='usl_act'; $key='������';
	echo "
	<a class='bt_gl' href='/index.php'>�������</a>
	<a class='bt_fb' href='/fotobanck.php'>����-����</a>
	<a href='$value' class='$act_ln'>$key</a>
	<a class='bt_ceny' href='/ceny.php'>����</a>
	<a class='bt_konty' href='/kontakty.php'>��������</a>
	<a class='bt_gb' href='/gb/'>��������</a>"

	;}elseif ($value=='/ceny.php') {$act_ln='cn_act'; $key='����';
	echo "
	<a class='bt_gl' href='/index.php'>�������</a>
	<a class='bt_fb' href='/fotobanck.php'>����-����</a>
	<a class='bt_usl' href='/uslugi.php'>������</a>
	<a href='$value' class='$act_ln'>$key</a>
	<a class='bt_konty' href='/kontakty.php'>��������</a>
	<a class='bt_gb' href='/gb/'>��������</a>"

	;}elseif ($value=='/kontakty.php') {$act_ln='konty_act'; $key='��������';
	echo "
	<a class='bt_gl' href='/index.php'>�������</a>
	<a class='bt_fb' href='/fotobanck.php'>����-����</a>
	<a class='bt_usl' href='/uslugi.php'>������</a>
	<a class='bt_ceny' href='/ceny.php'>����</a>
	<a href='$value' class='$act_ln'>$key</a>
	<a class='bt_gb' href='/gb/'>��������</a>"

	;}elseif ($value=='/gb/index.php') {$act_ln='gb_act'; $key='��������';
	echo "
	<a class='bt_gl' href='/index.php'>�������</a>
	<a class='bt_fb' href='/fotobanck.php'>����-����</a>
	<a class='bt_usl' href='/uslugi.php'>������</a>
	<a class='bt_ceny' href='/ceny.php'>����</a>
	<a class='bt_konty' href='/kontakty.php'>��������</a>
	<a href='$value' class='$act_ln'>$key</a>"

	;}elseif ($value=='/registr.php' or'/activation.php') {$act_ln='gb_act'; $key='��������';
	echo "
	<a class='bt_gl' href='/index.php'>�������</a>
	<a class='bt_fb' href='/fotobanck.php'>����-����</a>
	<a class='bt_usl' href='/uslugi.php'>������</a>
	<a class='bt_ceny' href='/ceny.php'>����</a>
	<a class='bt_konty' href='/kontakty.php'>��������</a>
	<a class='bt_gb' href='/gb/'>��������</a>"
	;}
?>
</div>
</div>
<!--������ �����-->

<?
if($value == '/gb/index.php'): ?>
<div id="main">
  <div class="drop-shadow lifted" style="margin: 20px 0 10px 300px;">
	 <h1><div style="font-family: Georgia, 'Times New Roman', Times, serif; font-size: 30px; color: #001590; text-shadow: none;">����� ������� Creative line studio</div></h1>
  </div>
<div style="clear: both"></div>
<table class="tb_main"><tr><td>
</td></tr><tr><td>
<? endif;?> 

