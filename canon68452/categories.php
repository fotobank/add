<?
if(!isset($_SESSION['admin_logged']))
  die();

if(isset($_POST['go_add']))
{
  $nm = $_POST['nm'];
  $id = go\DB\query('insert into categories (nm) values (?string)', array($nm), 'id');
  $id_max = intval(go\DB\query('select `id_num` from categories order by id_num desc limit 1', null, 'el')) + 1;
  go\DB\query('update categories set id_num = ?i where id = ?i', array($id_max,$id));
}

if(isset($_POST['go_delete']))
{
	$id = $_POST['go_delete'];
	go\DB\query('update albums set id_category = 0 where id_category = ?i', array($id));
	go\DB\query('delete from categories where id_num = ?i', array($id));
}

if(isset($_POST['go_update']))
{
  $id = $_POST['go_update'];
  $categories = $_POST['categories'];
  $txt = $_POST['txt'];
  go\DB\query("update categories set txt = ?string where id_num = ?i", array($categories,$id));
}

if(isset($_POST['go_edit_name']))
{
	$id = $_POST['go_edit_name'];
  $nm = $_POST['nm'];
  if(empty($nm)) $nm = '-----';
  go\DB\query('update categories set nm = ?string where id_num = ?i', array($nm,$id));
}

if(isset($_POST['go_updown']))
{
  $id = $_POST['go_updown'];
  $id_cat = intval(go\DB\query('select id_num from categories where id_num = ?i', array($id), 'el'));
  if($id_cat > 0)
  {
    if(isset($_POST['up']))
    {
    	$rs = go\DB\query('select id_num from categories where id_num < ?i order by id_num desc limit 0, 1',array($id_cat), 'el');
    }
    else
    {
    	$rs = go\DB\query('select id_num from categories where id_num > ?i order by id_num asc limit 0, 1',array($id_cat), 'el');
    }
  	if($rs)
  	{
  	  $ln = $rs;
  	  $swap_id = intval($ln['id_num']);
  	}
  }
  if($id_cat > 0 && isset($swap_id) && $swap_id > 0)
  {
    go\DB\query('update categories set id_num = 0 where id_num = ?i', array($swap_id));
    go\DB\query('update categories set id_num = ?i where id_num = ?i', array($swap_id,$id_cat));
	go\DB\query('update categories set id_num = ?i where id_num = 0',array($id_cat));
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
   $rs = go\DB\query('select * from categories order by id asc', null, 'assoc');
if($rs)
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
	  foreach ($rs as $ln)
    {
    ?>
    <option value="<?=$ln['id_num']?>" <?=($current == $ln['id_num'] ? 'selected="selected"' : '')?>> <?=$ln['nm']?></option>
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
  $rs = go\DB\query('select * from categories where id_num = ?i', array($_SESSION['current_kontent']), 'assoc');
  if($rs)
  {
	foreach ($rs as $ln)
  {
  ?>
  <div class="controls" style="float: left;">
  <div class="input-append">  		  
	<form action="index.php" method="post">
	  <input id="appendedInputButton" style="height: 24px; padding-left: 10px; margin-left: 20px;" class="span3" type="text" name="nm" value="<?=$ln['nm']?>" />
	  <input class="btn btn-warning"  type="hidden" name="go_edit_name" value="<?=$ln['id_num']?>" />
	  <input class="btn btn-warning"  type="submit" value="Переименовать" />	  	  	  
   </form>
  </div>
  </div> 
  <form action="index.php" method="post" style="margin-left: 30px; float: left;">
		<div class="btn-toolbar" style="margin: 0px;">
		<div class="btn-group">
      		          <input type="hidden" name="go_updown" value="<?=$ln['id_num']?>" />
      		          <input class="btn btn-info" type="submit" name="up" value="влево" />
      		          <input class="btn btn-info" type="submit" name="down" value="вправо" />
		</div>
		</div>
  </form>
  <div>  
  <form action="index.php" method="post" >
	<input class="btn btn-danger" type="hidden" name="go_delete" value="<?=$ln['id_num']?>" />
	<input class="btn btn-danger" type="submit" value="Удалить раздел"  style="margin-left: 50px;" onclick="return confirmDelete();"/>
  </form> 
  </div> 		
  
  <form action="index.php" method="post" style="clear: both; margin: 0 0 120px 0" >
    <div>
  	 <textarea id="categories" name="categories" class="tinymce" rows="25" cols="1200" style="width: 1200px;" ><?=$ln['txt']?></textarea><br/>
  	 <input class="btn  btn-warning" type="hidden" name="go_update" value="<?=$ln['id_num']?>" />

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
		<input class="btn  btn-primary" type="hidden" name="go_update" value="<?=$ln['id_num']?>" />
		<input class="btn btn-warning" type="submit" value="Применить" name="save" style="margin-top: 10px; margin-bottom: 40px;">
       </div>
</form> 
</div> 
 <?
    }
  }
endif;
?>
</div>
