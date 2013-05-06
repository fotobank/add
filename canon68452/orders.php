<?
    if(!isset($_SESSION['admin_logged']))
    die();
    define('RECORDS_PER_PAGE', 20);
    if(isset($_POST['delete_order']))
    {
	$id = $_POST['delete_order'];
	$db->query("delete from orders where id = ?i", array($id));
	$db->query("delete from order_items where id_order = ?i", array($id));
	$db->query("delete from download_photo where id_order = ?i", array($id));
    }

$pg = isset($_GET['pg']) ? intval($_GET['pg']) : 1;
if ($pg < 1)
	{
		$pg = 1;
	}
$start = ($pg - 1) * RECORDS_PER_PAGE;


    $rs = $db->query('select SQL_CALC_FOUND_ROWS r.*, u.login, u.us_name
                     from orders r, users u
                    where u.id = r.id_user
                    order by id desc limit ?i, ?i', array($start,RECORDS_PER_PAGE), 'assoc');
	?>	
    <div class="tabbable tabs-left">
    <ul class="nav nav-tabs">								
  	<?				
    if($rs)
    {
	$record_count = intval($db->query('SELECT FOUND_ROWS() as cnt',null, 'el'));
	$n=1;
foreach ($rs as $ln)
    {
	if ($n==1)
	{
	$akt = 'active';
	} else {
	$akt = '';	
	}
  	?>		
    <li class="<?=$akt?>"><a data-toggle="tab" href="<?='#'.$n?>">Заказ № <?=$ln['id']?></a></li>
    <?
    $n++;
    }
    }
    ?>
    </ul>
    <?
    $rs = $db->query('select SQL_CALC_FOUND_ROWS r.*, u.login, u.us_name
                     from orders r, users u
                    where u.id = r.id_user
	                 order by id desc limit ?i, ?i', array($start,RECORDS_PER_PAGE), 'assoc');
    ?><div class="tab-content"><?
    if($rs)
    {  
    $n=1;
 foreach ($rs as $ln)
    {
    if ($n==1)
	{
	$akt = 'active';
	} else {
	$akt = '';	
	}
  	?>
    <div id="<?=$n?>" class="tab-pane <?=$akt?>">		
	<table class="table table-striped table-bordered table-condensed span8">
	<thead>
  	<tr>
	<th>ID</th>
	<th>ID пользователя</th>
	<th>Логин пользователя</th>		
	<th>Имя</th>
	<th>Дата</th>
	<th>Действия</th>
  	</tr>
	</thead>
	<tbody>	
    <tr>		
    <td><b><?=$ln['id']?></b></td>
    <td><?=$ln['id_user']?></td>
    <td><?=$ln['login']?></td>	   
	<td><?=$ln['us_name']?></td>
	<td><?=date('H:i d.m.Y', $ln['dt'])?></td>
    <td align="center" width="7%">
    <form action="index.php?pg=<?=$pg?>" method="post" style="margin-bottom: 0px; margin-top: 0px;">
    <input class="btn btn-danger" type="hidden" name="delete_order" value="<?=$ln['id']?>" />
    <input class="btn-samall btn-danger" type="submit" value="Удалить" onclick="return confirmDelete();" />
    </form>
    </td>
  	</tr>		
	<?								 		 									   
	$tmp = $db->query('select o.*, p.img, a.nm AS anm, p.nm AS pnm, p.price, p.id_album, a.foto_folder
  		                from download_photo o, photos p, albums a
  		                where p.id = o.id_photo and p.id_album = a.id and o.id_order = ?i', array($ln['id']),'assoc');
		
	$sum = 0;
	$kol = 0;
	   foreach ($tmp as $tmp2)
  	{	
  	$sum+= $tmp2['price'];
	$kol++;
	$source = ($_SERVER['DOCUMENT_ROOT'].$tmp2['foto_folder'].$tmp2['id_album'].'/'.$tmp2['img']);			
    $sz = getimagesize($source);
								
	if(intval($sz[0]) > intval($sz[1]))
    $sz_string = 'width="60px"';
    else
    $sz_string = 'height="60px"';			
  	?>
  	<tr>	
  	<td colspan="1">			  						
    <img alt="<?=$tmp2['pnm']?>" src="<?=$tmp2['foto_folder'].$tmp2['id_album'].'/'.$tmp2['img']?>" alt="<?=$tmp2['pnm']?>" title="<?=$tmp2['pnm']?>" <?=$sz_string?> /></td>
	<td align="center"> фотография № <a href="<?=$tmp2['foto_folder'].$tmp2['id_album'].'/'.$tmp2['img']?>"><?=$tmp2['pnm']?></a></td>
	<td align="center"> альбом: <?=$tmp2['anm']?></td>                            			    	   
	<td>Скачано: <?=$tmp2['downloads']?></td>
	<td><?=$tmp2['price']?> грн.</td>
    <td><br/></td>		   
  	</tr>
  	<?
  	}
	$sum = $sum.' грн.';
	if ($kol == 0)
	{
		$db->query('select SQL_CALC_FOUND_ROWS o.id_order
  		                from order_items o
  		                where o.id_order = ?i', array($ln['id']),'assoc');
	$kol = $db->query("SELECT FOUND_ROWS()",null, 'el');
	$sum = 'фотографии удаленны из базы';
	}
  	?>	  	
    <tr>
	<td style="border-top: 3px dotted #f00;"><br/></td>
	<td style="border-top: 3px dotted #f00;"><b>ВСЕГО:</b><br/></td>
	<td style="border-top: 3px dotted #f00;"><b><?=$kol?> шт.</b><br/></td>
	<td style="border-top: 3px dotted #f00;"><b>ИТОГО:</b></td>
    <td style="border-top: 3px dotted #f00;"><b><?=$sum?></b></td>
    <td style="border-top: 3px dotted #f00;"><br/></td>
  	</tr> 	
	</tbody>
	</table>
	</div>
	<? $n++?>	 			
	<?
  	}
  	?>
	<div style="clear:both"> </div>
   <?
paginator($record_count, $pg);
    }	
    ?>
    </div>
    </div>
