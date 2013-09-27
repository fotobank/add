<?
if (!isset($_SESSION['admin_logged'])) die();

define('RECORDS_PER_PAGE', 25);


  include('ipgeobase/geo.php');
  $geo = new Geo();
  // этот метод позволяет получить все данные по ip в виде массива.
  // массив имеет ключи 'inetnum', 'country', 'city', 'region', 'district', 'lat', 'lng'
  $city = $geo->get_value('city');
  $ip = $geo->ip;

if (isset($_POST['update_balans']))
    {
        $id = $_POST['update_balans'];
        $balans = $_POST['balans'];
        go\DB\query('update users set balans = ?scalar where id = ?i', array($balans, $id));
    }

if (isset($_POST['update_level']))
	{
		$id = $_POST['update_level'];
		$level = intval($_POST['level']);
		go\DB\query('update users set level = ?i where id = ?i', array($level, $id));
	}

if (isset($_POST['checkbox']))
	{
		$id = $_POST['checkbox'];
		$block = $_POST['block'];
		$block = ($block == 0) ? 1 : 0;
		go\DB\query('update users set block = ?i where id = ?i', array($block, $id));
	}

if (isset($_POST['delete_user']))
    {
        $id = $_POST['delete_user'];
	    go\DB\query('delete from users where id = ?i',array($id));
    }

$pg = isset($_GET['pg']) ? intval($_GET['pg']) : 1;
if ($pg < 1)
	{
		$pg = 1;
	}
$start = ($pg - 1) * RECORDS_PER_PAGE;

$rs = go\DB\query('SELECT  SQL_CALC_FOUND_ROWS u.* FROM  users u order by id desc limit ?i, ?i', array($start,RECORDS_PER_PAGE), 'assoc');
if ($rs)
{
$record_count = intval(go\DB\query('SELECT FOUND_ROWS() as cnt',null, 'el'));
?>

<table class="table table-striped table-bordered table-condensed table-hover">

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
						<?
						$geo->setIp($ln['ip']);
						?>
						<a data-toggle="modal" class="ip" href="#ipModal"  data-m1="<?=$ln['ip']?>"
						 data-city="<?=$geo->get_value('city')?>" data-district="<?=$geo->get_value('district')?>" data-country="<?=$geo->get_value('country')?>"
						 data-lng="<?=$geo->get_value('lng')?>" data-lat="<?=$geo->get_value('lat')?>"
						 data-placement="top" data-original-title="<?=$geo->get_value('city')?>"><?=$ln['ip']?>
						</a>
	             </td>
                <td style="text-align: left; vertical-align: middle"><?=date('H:i d.m.Y', $ln['timestamp'])?></td>
                <td style="text-align: center; vertical-align: middle"><?=($ln['status'] == 1) ? 'да' : 'нет';?></td>
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
					            <input class="btn-mini btn-primary" type="submit" value="ok" style=" border-radius: 0 4px 4px 0;"/>
				            </form>
			            </div>
	            </td>
	            <?
	            $action = go\DB\query("SELECT time_event , ip FROM actions WHERE id_user =?i ORDER BY time_event DESC LIMIT 1",array($ln['id']),'row');
			 if($action)
				  {
	            ?>
	            <td style="text-align: center; vertical-align: middle">
					  <?
					  $geo->setIp($action['ip']);
					  ?>
					  <a data-toggle="modal" class="ip" href="#ipModal"  data-m1="<?=$action['ip']?>"
						data-city="<?=$geo->get_value('city')?>" data-district="<?=$geo->get_value('district')?>" data-country="<?=$geo->get_value('country')?>"
						data-lng="<?=$geo->get_value('lng')?>" data-lat="<?=$geo->get_value('lat')?>"
						data-placement="top" data-original-title="<?=$geo->get_value('city')?>"><?=$action['ip']?>
					  </a>
					</td>
	            <td style="text-align: left; vertical-align: middle"><?= russData($action['time_event'])?></td>
				  <?
              }
				  else
					 {
						?>
						<td style="text-align: center; vertical-align: middle">
						<a class="ip" href="#ipModal"  data-m1="0" >------</a></td>
						<td style="text-align: left; vertical-align: middle">------</td>
					 <?
					 }
				  ?>
	            <td style="text-align: center; vertical-align: middle">
		            <?
					  $rs = go\DB\query('SELECT `id_subs`, `time_subs` FROM `subs_user_on` WHERE `id_user` =?i',array($ln['id']),'assoc');
		            if($rs)
			            {
				            ?>
				            <div class="btn-group">
						            <ul class="dropdown-menu pull-right">
							            <li class="span8"> </li>
							            <?
							            $key = 0;
							            foreach ($rs as $data)
								            {
									            $subs = go\DB\query('SELECT * FROM `subs` WHERE `id` =?i',array($data['id_subs']),'row');
									            ?>
									            <li class="span2" style="clear: both;margin-left: 10px;">
											         <b>Акция № <?=$data['id_subs']?> подписка:  <?=$data['time_subs']?></b><br>
										            <b>Название акции:</b> <?=$subs['nm']?><br>
										            <b>Время проведения:</b> с <?=$subs['time_in']?> до <?=$subs['time_out']?><br>
											         <b>Время выполнения для одноразовой акции:</b> <?=$subs['time_act']?><br>
										            <b>Повторять через каждые</b> <?=$subs['time']?> часов <br>
										            <b>Событие альбома для выполнения условия: <?=$subs['id_album_event']?></b><br>
											         <b>Событие usera для выполнения условия: <?=$subs['id_user_event']?></b><br>
												      <b>Режим:</b> <?=$subs['mode']?><br>
													   <b>Описание:</b> <?=$subs['spec']?><br>
														<b>Первый количественный аргумент акции a1:</b> <?=$subs['a1']?><br>
										            <b>Второй количественный аргумент акции a2:</b> <?=$subs['a2']?><br>
										            <b>Третий количественный аргумент акции a3:</b> <?=$subs['a3']?><br>
										            <b>Описание зависимостей аргументов a1, a2, a3 в программе:</b> <?=$subs['txt']?><br>
												      <b>Привязка к компонентам сайта: <?=$subs['var']?></b><br>
														<b>Условие выполнения:</b> <?=$subs['order']?><br>
										            <b>Статус выполнения:</b> <?=$subs['status']?><br><br>
									            </li>
								            <?
									            $key++;
								            }
							            ?>
						            </ul>
					            <button class="btn btn-success dropdown-toggle" data-toggle="dropdown">
						            <?=$key?> шт
						            <span class="caret"></span>
					            </button>
				            </div>
			            <?
			            }
		            ?>

	            </td>

                <td style="text-align: center">
                        <div class="input-append">
                            <form action="index.php?pg=<?= $pg ?>" method="post" style="margin-bottom: 0; margin-top: 10px;">
                                <label for="appendedInputButton"></label><input id="appendedInputButton" style="height: 16px; padding-top: 2px;
                                 padding-bottom: 3px; width: 60px;" class="span1" type="text" name="balans" value="<?= $ln['balans'] ?>"/>
                                <input class="btn btn-primary" type="hidden" name="update_balans" value="<?= $ln['id'] ?>"/>
                                <input class="btn-mini btn-primary" type="submit" value="ok" style=" border-radius: 0 4px 4px 0;"/>
                            </form>
                        </div>
                </td>
                <?
                // купил - общее количество
                $rez_vsego = go\DB\query("SELECT SQL_CALC_FOUND_ROWS order_items.id_photo FROM  orders JOIN  creative_ls.order_items ON
                orders.id = order_items.id_order && orders.id_user = ?i ORDER BY order_items.id_photo ASC ",
	                array($ln['id']), 'row'); // общее количество купленных фотографий с названиями
                $foto_zak = intval(go\DB\query("SELECT FOUND_ROWS()",null, 'el')); // количество записей о купленных фотографиях в базе

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
                                $rez_fakt = go\DB\query("SELECT SQL_CALC_FOUND_ROWS albums.foto_folder, photos.id_album , photos.img , albums.nm AS anm , photos.nm AS pnm
	FROM  orders JOIN  creative_ls.order_items JOIN creative_ls.photos  JOIN creative_ls.albums ON
	orders.id = order_items.id_order && orders.id_user = ?i && photos.id = order_items.id_photo && photos.id_album = albums.id
	ORDER BY order_items.id_photo ASC ", array($ln['id']), 'assoc'); // общее количество купленных фотографий без удаленных фотографий
                                $udal = $foto_zak - intval(go\DB\query("SELECT FOUND_ROWS()",null, 'el'));
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

  <div class="modal hide fade in animated fadeInDown"  id="ipModal" tabindex="-1" role="dialog" aria-labelledby="ipModalLabel" aria-hidden="true"
	data-width="630" data-height="415" aria-hidden="false">
  <div class="modal-header" style="background: rgba(229,229,229,0.53)" >
	 <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
	 <h3 id="h3Sity">город </h3>
  </div>
  <div class="modal-body" style="height: 450px;">
	 <div id="map" style="width: 600px; height: 400px;"></div>
 </div>
  <div class="modal-footer">
	 <a href="#" class="btn" data-dismiss="modal">Закрыть</a>
  </div>
  </div>



<!--  <div id="map" style="width: 600px; height: 400px;"></div>-->

  <script src="http://api-maps.yandex.ru/2.0-stable/?load=package.standard&lang=ru-RU" type="text/javascript"></script>
  <script type="text/javascript">
$(".ip").click(function () {
		var city = $(this).data('city');
  $('#h3Sity').empty().append('город '+city);
		var district = $(this).data('district');
		var country = $(this).data('country');
		var lng = $(this).data('lng');
		var lat = $(this).data('lat');
  console.log('city= '+city,'\ndistrict= '+district);

	 ymaps.ready(init);
	 var myMap;
	 function init(){
		$('#map').empty();
		myMap = new ymaps.Map ("map", {
		  center:  [lat, lng],
		  zoom: 14
		});

		var myPlacemark = new ymaps.Placemark(
		 [lat, lng],
		 { iconContent: 'Страна: '+country+'<br>Город: '+ city +'<br>Фед.округ: '+district },
		 { preset: 'twirl#whiteStretchyIcon' } // Иконка будет белой и растянется под iconContent
		);

		myMap.geoObjects.add(myPlacemark);
		myMap.controls
		  // Кнопка изменения масштаба.
		 .add('zoomControl', { left: 5, top: 5 })
		  // Список типов карты
		 .add('typeSelector')
		  // Стандартный набор кнопок
		 .add('mapTools', { left: 35, top: 5 });
	 }
	 });
  </script>

  <div style="clear: both; margin-top: 120px;"></div>
<?
paginator($record_count, $pg);
}
?>