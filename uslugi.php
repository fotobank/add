<?php include (dirname(__FILE__).'/inc/head.php');
?>

<div id="main">
<div id="cont_fb">
	<div class="cont-list" style="margin: -10px 10px 60px 40%;"><div class="drop-shadow lifted">
			<h2><span style="color: #00146e;"> ������ ������</span></h2>
		</div></div>
<br>
	<? echo $db->query('select txt from content where id = ?i',array(17),'el'); ?>

			<table width="100%" border="0">
            <tr>
            <td>
<table class="tb_usl_foto" border="0">
  <tr>
    <td class="td_usl_ph">&nbsp;</td>
    <td class="td_usl_ph_sp"><a class=" usl_svad" href="/f_svadbi.php"></a></td>
    <td class="td_usl_ph_sp"><a class="usl_deti" href="/f_deti.php"></a></td>
  </tr>
  <tr>
    <td class="td_usl_ph_sp"><a class="usl_bankety" href="/f_bankety.php"></a></td>
    <td class="td_usl_ph_sp"><a class="usl_phknigi" href="/photoboock.php"></a></td>
    <td class="td_usl_ph_sp"><a class="usl_vipusk" href="/f_vipusk.php"></a></td>
    
  </tr>
  <tr>
  	<td class="td_usl_ph_sp"><a class="usl_raznoe" href="/f_raznoe.php"></a></td>
    <td class="td_usl_ph_sp">&nbsp;</td>
    <td class="td_usl_ph_sp">&nbsp;</td>
  </tr>
</table>
				</td>
                <td>
<table class="tb_usl_video" border="0">
  <tr>
    <td class="td_usl_vd"></td>
    <td class="td_usl_vd_sp"><a class="usl_v_svad" href="/v_svadby.php"></a></td>
    <td class="td_usl_vd_sp"><a class="usl_v_deti" href="/v_deti.php"></a></td>
  </tr>
  <tr>
    <td class="td_usl_vd_sp"><a class="usl_v_vipusk" href="/v_vipusk.php"></a></td>
    <td class="td_usl_vd_sp"><a class="sl_show" href="/v_sl_show.php"></a></td>
    <td class="td_usl_vd_sp"><a class="usl_v_bankety" href="/v_bankety.php"></a></td>
  </tr>
  <tr>
    <td class="td_usl_vd_sp"><a class="usl_v_raznoe" href="/v_raznoe.php"></a></td>
    <td class="td_usl_vd_sp">&nbsp;</td>
    <td class="td_usl_vd_sp">&nbsp;</td>
  </tr>
</table>
				</td>
				</tr>
                </table>				
				



</div>
</div>
<div class="end_content"></div>
<? echo $db->query('select txt from content where id = ?i',array(18),'el'); ?>
<div class="end_content" style="margin-top: -40px;"></div>
</div>
<?php include (dirname(__FILE__).'/inc/footer.php');
?>
