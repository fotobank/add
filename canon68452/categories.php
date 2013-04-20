<?
if(!isset($_SESSION['admin_logged']))
  die();

if(isset($_POST['go_add']))
{
  $nm = mysql_escape_string($_POST['nm']);
  mysql_query('insert into categories (nm) values (\''.$nm.'\')');
}

if(isset($_POST['go_delete']))
{
	$id = intval($_POST['go_delete']);
	mysql_query('update albums set id_category = 0 where id_category = '.$id);
	mysql_query('delete from categories where id = '.$id);
}

if(isset($_POST['go_update']))
{
  $id = intval($_POST['go_update']);
  $categories = mysql_escape_string($_POST['categories']);
  $txt = mysql_escape_string($_POST['txt']);
  mysql_query("update categories set txt = '$categories' where id = $id");
}

if(isset($_POST['go_edit_name']))
{
	$id = intval($_POST['go_edit_name']);
  $nm = mysql_escape_string($_POST['nm']);
  if(empty($nm)) $nm = '-----';
  mysql_query('update categories set nm = \''.$nm.'\' where id = '.$id);
}

if(isset($_POST['go_updown']))
{
  $id = intval($_POST['go_updown']);
  $id_cat = intval(mysql_result(mysql_query('select id from categories where id = '.$id), 0));
  if($id_cat > 0)
  {
    if(isset($_POST['up']))
    {
    	$rs = mysql_query('select id from categories where id < '.$id_cat.' order by id desc limit 0, 1');
    }
    else
    {
    	$rs = mysql_query('select id from categories where id > '.$id_cat.' order by id asc limit 0, 1');
    }
  	if(mysql_num_rows($rs) > 0)
  	{
  	  $ln = mysql_fetch_assoc($rs);
  	  $swap_id = intval($ln['id']); 	  
  	}
  }
  if($id_cat > 0 && $swap_id > 0)
  {
    mysql_query('update categories set id = 0 where id = '.$swap_id);
    mysql_query('update categories set id = '.$swap_id.' where id = '.$id_cat);
	mysql_query('update categories set id = '.$id_cat.' where id = 0');
	$_SESSION['current_kontent'] = $swap_id;
  }
}


?>
<div style="margin-left: 20px;">
<form action="index.php" method="post" enctype="multipart/form-data">
  <input type="text" name="nm" value="" style="width: 200px;" />
  <input type="hidden" name="go_add" value="1" />
  <input type="submit" value="Добавить раздел" class="btn btn-success" />
</form>
<hr/>

<?
if(isset($_POST['chenge_kontent']))
   {
   $_SESSION['current_kontent'] = intval($_POST['id']);
   }
   $rs = mysql_query('select * from categories order by id asc');
if(mysql_num_rows($rs) > 0)
 {
  if(isset($_SESSION['current_kontent'])) {
   $current = intval($_SESSION['current_kontent']); }
  else {
   $current = 0; }
   ?>
  <div class="controls" style="float: left; height: 28px;">
  <div class="input-append">
   <form action="index.php" method="post">
   <select id="appendedInputButton" class="span3" name="id" style="height: 28px;">
   <?
  while($ln = mysql_fetch_assoc($rs))
    {
    ?>
    <option value="<?=$ln['id']?>" <?=($current == $ln['id'] ? 'selected="selected"' : '')?>> <?=$ln['nm']?></option>
    <?
    }
    ?>
    </select>
    <input class="btn btn-success" type="hidden" name="chenge_kontent" value="1"/>
    <input class="btn  btn-success" type="submit" value="Открыть" />
   </form>
  </div>
  </div>	
  <?
  }
  if(isset($_SESSION['current_kontent'])): 
  $rs = mysql_query('select * from categories where id = '.intval($_SESSION['current_kontent']));
  if(mysql_num_rows($rs) > 0)
  {
  while($ln = mysql_fetch_assoc($rs))
  {
  ?>
  <div class="controls" style="float: left;">
  <div class="input-append">  		  
	<form action="index.php" method="post">
	  <input id="appendedInputButton" style="height: 24px; padding-left: 10px; margin-left: 20px;" class="span3" type="text" name="nm" value="<?=$ln['nm']?>" />
	  <input class="btn btn-warning"  type="hidden" name="go_edit_name" value="<?=$ln['id']?>" />
	  <input class="btn btn-warning"  type="submit" value="Переименовать" />	  	  	  
   </form>
  </div>
  </div> 
  <form action="index.php" method="post" style="margin-left: 30px; float: left;">
		<div class="btn-toolbar" style="margin: 0px;">
		<div class="btn-group">
      		          <input type="hidden" name="go_updown" value="<?=$ln['id']?>" />
      		          <input class="btn btn-info" type="submit" name="up" value="влево" />
      		          <input class="btn btn-info" type="submit" name="down" value="вправо" />
		</div>
		</div>
  </form>
  <div>  
  <form action="index.php" method="post" >
	<input class="btn btn-danger" type="hidden" name="go_delete" value="<?=$ln['id']?>" />
	<input class="btn btn-danger" type="submit" value="Удалить раздел"  style="margin-left: 50px;" onclick="return confirmDelete();"/>
  </form> 
  </div> 		
  
  <form action="index.php" method="post" style="clear: both; margin: 0 0 120px 0" >
    <div>
  	 <textarea id="categories" name="categories" class="tinymce" rows="25" cols="1200" style="width: 1200px;" ><?=$ln['txt']?></textarea><br/>
  	 <input class="btn  btn-warning" type="hidden" name="go_update" value="<?=$ln['id']?>" />

		<a href="javascript:;" class="btn" onclick="$('#categories').tinymce().show();return false;">Show</a>
		<a href="javascript:;" class="btn" onclick="$('#categories').tinymce().hide();return false;">Hide</a>
		<a href="javascript:;" class="btn" onclick="$('#categories').tinymce().execCommand('Bold');return false;">Bold</a>
		<a href="javascript:;" class="btn" onclick="alert($('#categories').html());return false;">Get contents</a>
		<a href="javascript:;" class="btn" onclick="alert($('#categories').tinymce().selection.getContent());return false;">Get selected HTML</a>
		<a href="javascript:;" class="btn" onclick="alert($('#categories').tinymce().selection.getContent({format : 'text'}));return false;">Get selected text</a>
		<a href="javascript:;" class="btn" onclick="alert($('#categories').tinymce().selection.getNode().nodeName);return false;">Get selected element</a>
		<a href="javascript:;" class="btn" onclick="$('#categories').tinymce().execCommand('mceInsertContent',false,'<b>Hello world!!</b>');return false;">Insert HTML</a>
		<a href="javascript:;" class="btn" onclick="$('#categories').tinymce().execCommand('mceReplaceContent',false,'<b>{$selection}</b>');return false;">Replace selection</a>		
		<input type="reset" name="reset" class="btn"  value="Reset" />
		<br />
		<input class="btn  btn-primary" type="hidden" name="go_update" value="<?=$ln['id']?>" /> 	   
		<!-- <input class="btn btn-warning" type="submit" value="Применить" name="save" style="margin-top: 10px; margin-bottom: 40px;"> -->
       </div>
</form> 
</div> 
 <?
    }
  }
endif;
?>
</div>
