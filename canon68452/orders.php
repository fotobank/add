<?
    if(!isset($_SESSION['admin_logged']))
    die();
    define('RECORDS_PER_PAGE', 10);
    if(isset($_POST['delete_order']))
    {
	$id = intval($_POST['delete_order']);
	mysql_query("delete from orders where id = '$id'");
	mysql_query("delete from order_items where id_order = '$id'");
	mysql_query("delete from download_photo where id_order = '$id'");
    }
    $pg = intval($_GET['pg']);
    if($pg < 1) $pg = 1;
    $start = ($pg - 1) * RECORDS_PER_PAGE;
    $rs = mysql_query('select SQL_CALC_FOUND_ROWS r.*, u.login, u.us_name
                     from orders r, users u
                    where u.id = r.id_user
                    order by id desc limit '.$start.', '.RECORDS_PER_PAGE);
	?>	
    <div class="tabbable tabs-left">
    <ul class="nav nav-tabs">								
  	<?				
    if(mysql_num_rows($rs) > 0)
    {
	$record_count = intval(mysql_result(mysql_query('select FOUND_ROWS() as cnt'), 0));
	$n=1;
    while($ln = mysql_fetch_assoc($rs))
    {
	if ($n==1)
	{
	$akt = 'active';
	} else {
	$akt = '';	
	}
  	?>		
    <li class="<?=$akt?>"><a data-toggle="tab" href="<?='#'.$n?>">����� � <?=$ln['id']?></a></li>
    <?
    $n++;
    }
    }
    ?>
    </ul>
    <?
    $rs = mysql_query('select SQL_CALC_FOUND_ROWS r.*, u.login, u.us_name
                     from orders r, users u
                    where u.id = r.id_user
                    order by id desc limit '.$start.', '.RECORDS_PER_PAGE);
    ?><div class="tab-content"><?
    if(mysql_num_rows($rs) > 0)
    {  
    $n=1;
    while($ln = mysql_fetch_assoc($rs))
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
	<th>ID ������������</th>
	<th>����� ������������</th>		
	<th>���</th>
	<th>����</th>
	<th>��������</th>
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
    <input class="btn-samall btn-danger" type="submit" value="�������" />
    </form>
    </td>
  	</tr>		
	<?								 		 									   
	$tmp = mysql_query('select o.*, p.img, a.nm AS anm, p.nm AS pnm, p.price, p.id_album, a.foto_folder
  		                from download_photo o, photos p, albums a
  		                where p.id = o.id_photo and p.id_album = a.id and o.id_order = '.$ln['id']);
		
	$sum = 0;
	$kol = 0;
  	while($tmp2 = mysql_fetch_assoc($tmp))
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
	<td align="center"> ���������� � <a href="<?=$tmp2['foto_folder'].$tmp2['id_album'].'/'.$tmp2['img']?>"><?=$tmp2['pnm']?></a></td>
	<td align="center"> ������: <?=$tmp2['anm']?></td>                            			    	   
	<td>�������: <?=$tmp2['downloads']?></td>
	<td><?=$tmp2['price']?> ���.</td>
    <td><br/></td>		   
  	</tr>
  	<?
  	}
	$sum = $sum.' ���.';
	if ($kol == 0)
	{
	mysql_query('select SQL_CALC_FOUND_ROWS o.id_order
  		                from order_items o
  		                where o.id_order = '.$ln['id']);
	$kol = mysql_result(mysql_query("SELECT FOUND_ROWS()"), 0);
	$sum = '���������� �������� �� ����';
	}
  	?>	  	
    <tr>
	<td style="border-top: 3px dotted #f00;"><br/></td>
	<td style="border-top: 3px dotted #f00;"><b>�����:</b><br/></td>
	<td style="border-top: 3px dotted #f00;"><b><?=$kol?> ��.</b><br/></td>
	<td style="border-top: 3px dotted #f00;"><b>�����:</b></td>
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
	<div style="clear:both">
	��������: &nbsp;&nbsp;
	<?
	$page_count = ceil($record_count / RECORDS_PER_PAGE);
	for($i = 1; $i <= $page_count; $i++)
	{
		?>
		<a href="index.php?pg=<?=$i?>"><?=$i?></a>&nbsp;
		<?
	}
	?>
    </div>
    <?
    }	
    ?>
    </div>
    </div>
