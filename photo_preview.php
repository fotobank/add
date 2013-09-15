<?php
// error_reporting(E_ALL);
// ini_set('display_errors', 1);

error_reporting(0);
include (dirname(__FILE__).'/inc/config.php');
include (dirname(__FILE__).'/inc/func.php');
header('Content-type: text/html; charset=windows-1251');


$id = $_GET['id'];
if ($id > 0)
    {
        $rs = $db->query('select * from `photos` where `id` = ?i',array($id),'row');
        if ($rs)
            {
                $photo_data = $rs;
                $rs = $db->query('select `id` from `photos` where `id_album`= ?i and id > ?i order by `id` asc limit 0, 1',array($photo_data['id_album'], $id), 'el');
                if ($rs)
                    {
                        $right_id = intval($rs);
                    }
                else
                    {
                        $right_id = false;
                    }
	             $rs = $db->query('select `id` from `photos` where `id_album`= ?i and id < ?i order by `id` desc limit 0, 1',array($photo_data['id_album'], $id), 'el');
                if ($rs)
                    {
                        $left_id = intval($rs);
                    }
                else
                    {
                        $left_id = false;
                    }

                $source = $_SERVER['DOCUMENT_ROOT'].fotoFolder().$photo_data['id_album'].'/'.$photo_data['img'];
                $sz = @getimagesize($source);
                $sz_string = 'width: '.($sz[0]).'px;';
                ?>

                <? if ($left_id): ?>
                <div class="left_pointer2" onClick="preview('<?=$left_id?>');"></div>
            <? endif; ?>

                <? if ($right_id): ?>
                <div class="right_pointer2" onClick="preview('<?=$right_id?>');"></div>
            <? endif; ?>


                <div style="<?= $sz_string ?>">
                    <div style="text-align: center; width: 100%;">
                        <img src="dir.php?num=<?= substr(($photo_data['img']), 2, -4) ?>" alt="<?=$photo_data['nm']?>"
								 title="Фотография № <?=$photo_data['nm']?><?=$right_id?>. Нажмите,чтобы закрыть." onClick="hidePreview();"/>
                    </div>
                    <div>
                        <table border="0" cellspacing="10px" width="100%">
                            <tr>
                                <td class="ph_orig_nm" valign="top" colspan="4" align="center">фотография №
                                    <?=$photo_data['nm']?>
                                    <br>
                                    <?
            //Вместо * можно подставить тэг <img> с картинкой - печать звездочек
                                    echo str_repeat('<img src="/img/reyt.png"/>', floor($photo_data['votes'] / 5));
                                    ?>
                                </td>
                            </tr>
                            <tr>
                                <td align="left">
                                    <? if ($left_id): ?>
                                        <div class="left_pointer" onClick="preview('<?=$left_id?>');"></div>
                                    <? else: ?>
                                        <div class="pointer_hidden" onClick="hidePreview();"></div>
                                    <? endif; ?>
                                </td>
                                <td valign="top" width="33%" align="left">
                                    <input type="button" value="В корзину" style="cursor: pointer;" onClick="basketAdd(<?=$photo_data['id']?>);"/><br/>
                                    Цена: <?=(floatval($photo_data['price']) > 0 ? $photo_data['price'].'грн.' : 'бесплатно')?>
                                </td>
                                <td valign="top" width="33%" align="right">
	                                <?
	                                $id_album = isset($_SESSION['current_album']) ? $_SESSION['current_album'] : null;
	                                $vote_price = floatval($db->query('select vote_price from albums where id = ?i', array($id_album), 'el'));
											  $user_balans = $db->query('select balans from users where id = ?i',array($_SESSION['userid']),'el');
	                                ?>
                          <input type="button" value="Голосовать" style="cursor: pointer;" onClick="goVote('<?=$user_balans?>','<?=$vote_price?>','<?=$photo_data['id']?>');"/><br/>
                                    Голосов: (<?=$photo_data['votes']?>)
                                </td>

										<script type="text/javascript">
										  $(document).keyup(function (event){
											 clearTimeout($.data(this, 'timer'));
											 var wait = setTimeout(keyN, 100);
											 $(this).data('timer', wait);


											 function keyN(){
												switch (event.keyCode ) {
												case  27: hidePreview();
												  break;
												case 37 : <?=$left_id?>?preview('<?=$left_id?>'):hidePreview();
												  break;
												case 40 : <?=$left_id?>?preview('<?=$left_id?>'):hidePreview();
												  break;
												case 39:	 <?=$right_id?>?preview('<?=$right_id?>'):hidePreview();
												  break;
												case 38:	 <?=$right_id?>?preview('<?=$right_id?>'):hidePreview();
												  break;
												case 13: basketAdd(<?=$photo_data['id']?>);
												  break;
												case 32:	goVote('<?=$user_balans?>','<?=$vote_price?>','<?=$photo_data['id']?>');
												  break;
											 }
											 }
										  });
										</script>


                                <td align="right">
                                    <? if ($right_id): ?>
                                        <div class="right_pointer" onClick="preview('<?=$right_id?>');">
                                    <? else: ?>
                                        <div class="pointer_hidden" onClick="hidePreview();"></div>
                                    <? endif; ?>

                                </td>

                            </tr>
                            <!--        <tr>
                                      <td colspan="2" align="center">
                                          <span style="cursor: pointer;" onClick="JavaScript: hide_preview();">
                                           закрыть
                                          </span>
                                      </td>
                                    </tr>
                                    -->
                        </table>
                    </div>
                </div>
            <?
            }
    }
		$db->close(true);

?>

<script type='text/javascript'>
  $('img').error(function(){
     $(this).attr('src', 'img/404.png');
  });
</script>

