<?
if (!isset($_SESSION['admin_logged'])) die();

define('RECORDS_PER_PAGE', 10);

if (isset($_POST['update_balans']))
    {
        $id = intval($_POST['update_balans']);
        $balans = floatval($_POST['balans']);
        mysql_query("update users set balans = '$balans' where id = $id");
    }

if (isset($_POST['delete_user']))
    {
        $id = intval($_POST['delete_user']);
        mysql_query("delete from users where id = $id");
    }

$pg = isset($_GET['pg']) ? intval($_GET['pg']) : 1;
if ($pg < 1)
	{
		$pg = 1;
	}
$start = ($pg - 1) * RECORDS_PER_PAGE;

$rs = mysql_query('SELECT  SQL_CALC_FOUND_ROWS u.* FROM  users u order by id desc limit '.$start.', '.RECORDS_PER_PAGE);
if (mysql_num_rows($rs) > 0)
{
$record_count = intval(mysql_result(mysql_query('SELECT  FOUND_ROWS() as cnt'), 0));
?>

<table class="table table-striped table-bordered table-condensed span12">

    <tr class="success">
        <td><b>ID</b></td>
        <td><b>Логин</b></td>
        <td><b>Имя</b></td>
        <td><b>E-mail</b></td>
	     <td><b>Skype</b></td>
	     <td><b>Телефон</b></td>
	     <td><b>Ip</b></td>
        <td><b>Регистр.</b></td>
        <td><b>Подтв.рег.</b></td>
        <td><b>Баланс</b></td>
        <td><b>Заказы</b></td>
        <td><b>Удалить</b></td>
    </tr>

    <tbody>
    <?
    while ($ln = mysql_fetch_assoc($rs))
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
		             <a class="map"  href="/canon68452/map.php"><?=$ln['ip']?></a>
	             </td>
                <td width="12%" style="text-align: left; vertical-align: middle"><?=date('H:i d.m.Y', $ln['timestamp'])?></td>
                <? if ($ln['status'] == 1)
                    {
                        $podtw = 'да';
                    }
                else
                    {
                        $podtw = 'нет';
                    } ?>
                <td style="text-align: center; vertical-align: middle"><?=$podtw?></td>
                <td style="text-align: center">
                    <div class="controls">
                        <div class="input-append">
                            <form action="index.php?pg=<?= $pg ?>" method="post" style="margin-bottom: 0; margin-top: 10px;">
                                <label for="appendedInputButton"></label><input id="appendedInputButton" style="height: 18px; padding-top: 2px; padding-bottom: 3px; width: 80px;" class="span1" type="text" name="balans" value="<?= $ln['balans'] ?>"/>
                                <input class="btn btn-primary" type="hidden" name="update_balans" value="<?= $ln['id'] ?>"/>
                                <input class="btn-small btn-primary" type="submit" value="применить"/>
                            </form>
                        </div>
                    </div>
                </td>
                <?
                // купил - общее количество
                $rez_vsego = mysql_query("SELECT SQL_CALC_FOUND_ROWS order_items.id_photo FROM  orders JOIN  creative_ls.order_items ON  orders.id = order_items.id_order && orders.id_user = ".$ln['id']." ORDER BY order_items.id_photo ASC "); // общее количество купленных фотографий с названиями
                $foto_zak = mysql_result(mysql_query("SELECT FOUND_ROWS()"), 0); // количество записей о купленных фотографиях в базе

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
                                $rez_fakt = mysql_query("SELECT SQL_CALC_FOUND_ROWS albums.foto_folder, photos.id_album , photos.img , albums.nm AS anm , photos.nm AS pnm
	FROM  orders JOIN  creative_ls.order_items JOIN creative_ls.photos  JOIN creative_ls.albums ON
	orders.id = order_items.id_order && orders.id_user = ".$ln['id']." && photos.id = order_items.id_photo && photos.id_album = albums.id
	ORDER BY order_items.id_photo ASC "); // общее количество купленных фотографий без удаленных фотографий
                                $udal = $foto_zak - mysql_result(mysql_query("SELECT FOUND_ROWS()"), 0);
                                ?>
                                <ul class="dropdown-menu pull-right"><?
                                    if (mysql_num_rows($rez_fakt) > 0)
                                        {
                                                ?>
                                            <li class="span11">
                                                <?
                                            while ($ln_foto = mysql_fetch_assoc($rez_fakt))
                                                {
                                                ?>
                                                    <li class="span2" style="margin-left: 10px; width: 126px; height: 240px;">
                                                        <a class="thumbnail" style="padding-left: 4px; padding-right: 4px; width: 120px;" href="<?= $ln_foto['foto_folder'].$ln_foto['id_album'].'/'.$ln_foto['img']?>">
                                                            <img href="<?=$ln_foto['foto_folder'].$ln_foto['id_album'].'/'.$ln_foto['img']?>" src="<?=$ln_foto['foto_folder'].$ln_foto['id_album'].'/'.$ln_foto['img']?>" alt="<?= $ln_foto['pnm'] ?>" title="<?= $ln_foto['pnm'] ?>" <?=$sz_string?> />
                                                            <h6 style="margin-top: 0; margin-bottom: 0;">Фото
                                                                № <?=$ln_foto['pnm']?></h6>
                                                            Альбом:<br> <?=$ln_foto['anm']?>
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
