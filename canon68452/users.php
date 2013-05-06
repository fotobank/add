<?
if (!isset($_SESSION['admin_logged'])) die();

define('RECORDS_PER_PAGE', 25);

if (isset($_POST['update_balans']))
    {
        $id = $_POST['update_balans'];
        $balans = floatval($_POST['balans']);
        $db->query('update users set balans = ?scalar where id = ?i', array($balans, $id));
    }

if (isset($_POST['update_level']))
	{
		$id = $_POST['update_level'];
		$level = intval($_POST['level']);
		$db->query('update users set level = ?i where id = ?i', array($level, $id));
	}

if (isset($_POST['checkbox']))
	{
		$id = $_POST['checkbox'];
		$block = $_POST['block'];
		$block = ($block == 0) ? 1 : 0;
		$db->query('update users set block = ?i where id = ?i', array($block, $id));
	}

if (isset($_POST['delete_user']))
    {
        $id = $_POST['delete_user'];
	    $db->query('delete from users where id = ?i',array($id));
    }

$pg = isset($_GET['pg']) ? intval($_GET['pg']) : 1;
if ($pg < 1)
	{
		$pg = 1;
	}
$start = ($pg - 1) * RECORDS_PER_PAGE;

$rs = $db->query('SELECT  SQL_CALC_FOUND_ROWS u.* FROM  users u order by id desc limit ?i, ?i', array($start,RECORDS_PER_PAGE), 'assoc');
if ($rs)
{
$record_count = intval($db->query('SELECT FOUND_ROWS() as cnt',null, 'el'));
?>

<table class="table table-striped table-bordered table-condensed span12">

    <tr class="success">
        <td><b>ID</b></td>
        <td><b>Логин</b></td>
        <td><b>Имя</b></td>
        <td><b>E-mail</b></td>
	     <td><b>Skype</b></td>
	     <td><b>Телефон</b></td>
	     <td><b>Ip регистр.</b></td>
        <td><b>t регистр.</b></td>
        <td><b>Подтв.рег.</b></td>
	     <td><b>Бан</b></td>
	     <td><b>Уровень</b></td>
	     <td><b>Ip захода</b></td>
	     <td><b>t захода</b></td>
	     <td><b>Подписка</b></td>
        <td><b>Баланс</b></td>
        <td><b>Заказы</b></td>
        <td><b>Удалить</b></td>
    </tr>

    <tbody>
    <?

	    foreach ($rs as $ln)
        {
            ?>
            <tr class="warning">
                <td style="text-align: left; vertical-align: middle"><?=$ln['id']?></td>
                <td style="text-align: left; vertical-align: middle"><?=$ln['login']?></td>
                <td style="text-align: left; vertical-align: middle"><?=$ln['us_name']?></td>
                <td style="text-align: left; vertical-align: middle"><?=$ln['email']?></td>
	             <td style="text-align: left; vertical-align: middle"><?=$ln['skype']?></td>
	             <td style="text-align: left; vertical-align: middle"><?=$ln['phone']?></td>
	             <td style="text-align: left; vertical-align: middle">
		             <a class="map"  href="/map.php"><?=$ln['ip']?></a>
	             </td>
                <td style="text-align: left; vertical-align: middle"><?=date('H:i d.m.Y', $ln['timestamp'])?></td>
                <td style="text-align: center; vertical-align: middle"><?=($ln['status'] == 1) ? 'да' : 'нет';?></td>

<!--	            <td style="text-align: center; vertical-align: middle">--><?//=($ln['block'] == 1) ? 'нет' : 'да';?><!--</td>-->
	            <td style="text-align: center; vertical-align: middle">

	            <div class="slideThree">
		            <input id="<?=$ln['id']?>" type='checkbox' NAME='block' VALUE='<?=$ln['block']?>'
			         onClick="ajaxPostQ('/canon68452/index.php','','<?= 'checkbox='.$ln['id'].'&block='.$ln['block'] ?>')"
			            <?if ($ln['block'])
			            {
				            echo 'checked="checked"';
			            }?> /> <label for="<?=$ln['id']?>"></label>
	            </div>

	            </td>
	            <td style="text-align: center">
			            <div class="input-append">
				            <form action="index.php?pg=<?= $pg ?>" method="post" style="margin-bottom: 0; margin-top: 10px;">
					            <label for="appendedInputButton"></label><input id="appendedInputButton" style="height: 16px; padding-top: 2px;
                                 padding-bottom: 3px; width: 40px;" class="span1" type="text" name="level" value="<?= $ln['level'] ?>"/>
					            <input class="btn btn-primary" type="hidden" name="update_level" value="<?= $ln['id'] ?>"/>
					            <input class="btn-mini btn-primary" type="submit" value="ok"/>
				            </form>
			            </div>
	            </td>

	            <td style="text-align: center; vertical-align: middle">
		            <a class="map"  href="/map.php"><?=$ln['ip_vhod'];?></a></td>
	            <td style="text-align: left; vertical-align: middle"><?=($ln['time_vhod'] != 0) ? date('H:i d.m.Y', $ln['time_vhod']) : '------';?></td>
	            <td style="text-align: center; vertical-align: middle"><?=$ln['action'];?></td>

                <td style="text-align: center">
                        <div class="input-append">
                            <form action="index.php?pg=<?= $pg ?>" method="post" style="margin-bottom: 0; margin-top: 10px;">
                                <label for="appendedInputButton"></label><input id="appendedInputButton" style="height: 16px; padding-top: 2px;
                                 padding-bottom: 3px; width: 60px;" class="span1" type="text" name="balans" value="<?= $ln['balans'] ?>"/>
                                <input class="btn btn-primary" type="hidden" name="update_balans" value="<?= $ln['id'] ?>"/>
                                <input class="btn-mini btn-primary" type="submit" value="ok"/>
                            </form>
                        </div>
                </td>
                <?
                // купил - общее количество
                $rez_vsego = $db->query("SELECT SQL_CALC_FOUND_ROWS order_items.id_photo FROM  orders JOIN  creative_ls.order_items ON
                orders.id = order_items.id_order && orders.id_user = ?i ORDER BY order_items.id_photo ASC ",
	                array($ln['id']), 'row'); // общее количество купленных фотографий с названиями
                $foto_zak = intval($db->query("SELECT FOUND_ROWS()",null, 'el')); // количество записей о купленных фотографиях в базе

                // кнопка с заказами - детально (удаленные альбомы пропускаются)
                ?>
                <td style="text-align: center">
                    <?
                    if ($foto_zak > 0)
                        {
                            ?>
                            <div class="btn-group">
                                <button class="btn btn-success dropdown-toggle" data-toggle="dropdown"><?=$foto_zak.' шт'?>
                                    <span class="caret"></span></button>
                                <?
                                $rez_fakt = $db->query("SELECT SQL_CALC_FOUND_ROWS albums.foto_folder, photos.id_album , photos.img , albums.nm AS anm , photos.nm AS pnm
	FROM  orders JOIN  creative_ls.order_items JOIN creative_ls.photos  JOIN creative_ls.albums ON
	orders.id = order_items.id_order && orders.id_user = ?i && photos.id = order_items.id_photo && photos.id_album = albums.id
	ORDER BY order_items.id_photo ASC ", array($ln['id']), 'assoc'); // общее количество купленных фотографий без удаленных фотографий
                                $udal = $foto_zak - intval($db->query("SELECT FOUND_ROWS()",null, 'el'));
                                ?>
                                <ul class="dropdown-menu pull-right"><?
                                    if ($rez_fakt)
                                        {
                                               ?>
                                            <li class="span11">
	                                            <?
	                                        foreach($rez_fakt as $ln_foto)
		                                        {
	                                        $source = ($_SERVER['DOCUMENT_ROOT'].$ln_foto['foto_folder'].$ln_foto['id_album'].'/'.$ln_foto['img']);
	                                        $sz = getimagesize($source);
	                                        if(intval($sz[0]) > intval($sz[1]))
		                                        $sz_string = 'width="160px"';
	                                        else
		                                        $sz_string = 'height="160px"';

                                                ?>
													    <li class="span2" style="margin-left: 10px; width: 126px; height: 240px;">

													     <a class="thumbnail" style="padding-left: 4px; padding-right: 4px; width: 120px;"
														  href="<?= $ln_foto['foto_folder'].$ln_foto['id_album'].'/'.$ln_foto['img']?>">

														 <img href="<?=$ln_foto['foto_folder'].$ln_foto['id_album'].'/'.$ln_foto['img']?>"
														 src="<?=$ln_foto['foto_folder'].$ln_foto['id_album'].'/'.$ln_foto['img']?>"
														 alt="<?= $ln_foto['pnm'] ?>" title="<?= $ln_foto['pnm'] ?>" <?=$sz_string?> />

                                            <h6 style="margin-top: 0; margin-bottom: 0;">Фото № <?=$ln_foto['pnm']?></h6>Альбом:<br> <?=$ln_foto['anm']?>
                                            </a>
                                            </li>
                                                <?
                                                }
                                                ?>
                                            </li>
                                        <?
                                        }
                                    if ($udal != 0)
                                        {
                                            ?>
                                            <li><a><b><?=$udal?> фотографии удаленны с сервера</b></a></li>
                                            <?
                                        }
                                    ?>
                                </ul>
                            </div>
                        <? }
                    else
                        {
                            echo 'нет';
                        }?>
                </td>
                <!-- кнопка удалить -->
                <td align="center" width="7%">
                    <form action="index.php?pg=<?= $pg ?>" method="post" style="margin-bottom: 0;">
                        <input class="btn btn-danger" type="hidden" name="delete_user" value="<?= $ln['id'] ?>"/>
                        <input class="btn-small btn-danger" type="submit" value="удалить" onclick="return confirmDelete();" />
                    </form>
                </td>
            </tr>
        <?
        }
    ?>
    </tbody>
</table>

<div style="clear: both; margin-top: 120px;"></div>
<?
paginator($record_count, $pg);
}
?>
