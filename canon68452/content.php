<?
if(!isset($_SESSION['admin_logged']))
  die();

if(isset($_POST['go_update']))
{
  $id = intval($_POST['go_update']);
  $content = mysql_escape_string($_POST['content']);
  $namecont = mysql_escape_string($_POST['namecont']);
  mysql_query("update content set txt = '$content' where id = $id");
}

if(isset($_POST['chenge_kontent']))
   {
   $_SESSION['current_kontent'] = intval($_POST['id']);
   }
   $rs = mysql_query('select * from content order by id asc');
if(mysql_num_rows($rs) > 0)
 {
  if(isset($_SESSION['current_kontent'])) {
   $current = intval($_SESSION['current_kontent']); }
  else {
   $current = 0; }
   ?>
<div style="margin-left: 20px;">   
<div class="controls">
<div class="input-append">
  <form action="index.php" method="post">
   <select id="appendedInputButton" class="span3" name="id" style="height: 28px;">
   <?
 while($ln = mysql_fetch_assoc($rs))
   {
   ?>
   <option value="<?=$ln['id']?>" <?=($current == $ln['id'] ? 'selected="selected"' : '')?>> <?=$ln['namecont']?></option>
   <?
   }
   ?>
  </select>
   <input class="btn btn-success" type="hidden" name="chenge_kontent" value="1"/>
   <input class="btn  btn-success" type="submit" value="�������" />
  </form>
</div>
</div>	
<?
}
if(isset($_SESSION['current_kontent'])): 
   $rs = mysql_query('select * from content where id = '.intval($_SESSION['current_kontent']));
if(mysql_num_rows($rs) > 0)
{
  while($ln = mysql_fetch_assoc($rs))
  	{
?>
 <form action="index.php" method="post">
    <div>
  	 <textarea id="content" name="content" class="tinymce" rows="25" cols="1200" style="float: left; width: 1200px;" ><?=$ln['txt']?></textarea><br style="clear:both;"/>		
    <script>
          CKEDITOR.replace( 'content', {
    toolbar: 'Basic',
    uiColor: '#9AB8F3',
	extraPlugins: 'stylesheetparser',
	
	filebrowserBrowseUrl : '/ckfinder/ckfinder.html',
	filebrowserImageBrowseUrl : '/ckfinder/ckfinder.html?type=Images',
	filebrowserFlashBrowseUrl : '/ckfinder/ckfinder.html?type=Flash',
	filebrowserUploadUrl : '/ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Files',
	filebrowserImageUploadUrl : '/ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Images',
	filebrowserFlashUploadUrl : '/ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Flash',
	filebrowserWindowWidth : '1000',
 	filebrowserWindowHeight : '700',
	filebrowserImageUploadUrl : 
	   '/ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Images&currentFolder=/images/'
	
});
    </script>
        <a href="javascript:;" class="btn" onclick="tinyMCE.get('content').show();return false;">Show</a>
		<a href="javascript:;" class="btn" onclick="tinyMCE.get('content').hide();return false;">Hide</a>
		<a href="javascript:;" class="btn" onclick="tinyMCE.get('content').execCommand('Bold');return false;">Bold</a>
		<a href="javascript:;" class="btn" onclick="alert(tinyMCE.get('content').getContent());return false;">Get contents</a>
		<a href="javascript:;" class="btn" onclick="alert(tinyMCE.get('content').selection.getContent());return false;">Get selected HTML</a>
		<a href="javascript:;" class="btn" onclick="alert(tinyMCE.get('content').selection.getContent({format : 'text'}));return false;">Get selected text</a>
		<a href="javascript:;" class="btn" onclick="alert(tinyMCE.get('content').selection.getNode().nodeName);return false;">Get selected element</a>
		<a href="javascript:;" class="btn" onclick="tinyMCE.execCommand('mceInsertContent',false,'<b>Hello world!!</b>');return false;">Insert HTML</a>
		<a href="javascript:;" class="btn" onclick="tinyMCE.execCommand('mceReplaceContent',false,'<b>{$selection}</b>');return false;">Replace selection</a>
		
		<input type="reset" name="reset" class="btn"  value="Reset" />
		<br />
		<input class="btn  btn-warning" type="hidden" name="go_update" value="<?=$ln['id']?>" /> 
		<!-- <input class="btn btn-warning" type="submit" value="���������" name="save" style="margin-top: 10px; margin-bottom: 40px;"> -->
      </div>
</form> 
 <?
    }
  }
endif;


if(isset($_POST['chenge_kontent2']))
   {
   $_SESSION['current_kontent2'] = intval($_POST['id']);
   }
   $rs2 = mysql_query('select * from content order by id asc');
  if(mysql_num_rows($rs2) > 0)
{
  if(isset($_SESSION['current_kontent2'])) {
   $current = intval($_SESSION['current_kontent2']); }
  else {
   $current = 0; }
   ?>
<div class="controls" style="clear: both; margin-top: 100px;"
<div class="input-append">
  <form id="myForm1" action="index.php" method="post">
   <select id="appendedInputButton" class="span3" name="id" style="height: 28px;"  onChange="$('#myForm1').trigger('submit');">
   <?
 while($ln = mysql_fetch_assoc($rs2))
   {
   ?>
   <option value="<?=$ln['id']?>" <?=($current == $ln['id'] ? 'selected="selected"' : '')?>> <?=$ln['namecont']?></option>
   <?
   }
   ?>
  </select>
   <input class="btn btn-success" type="hidden" name="chenge_kontent2" value="1"/>
   <!--<input class="btn  btn-success" type="submit" value="�������" class="sub1"/>-->
  </form>
</div>
</div>	
<?
}
if(isset($_SESSION['current_kontent2'])): 
   $rs2 = mysql_query('select * from content where id = '.intval($_SESSION['current_kontent2']));
if(mysql_num_rows($rs2) > 0)
{
  while($ln = mysql_fetch_assoc($rs2))
  	{
?>
 <form method="post" action="index.php" style="margin-left: 20px;">
  	 <textarea rows="25" cols="1200" name="content" style="font-size: 14px; width: 1200px;"><?=$ln['txt']?></textarea><br/>
  	 <input class="btn  btn-warning" type="hidden" name="go_update" value="<?=$ln['id']?>" />
  	 <input class="btn  btn-warning" type="submit" value="���������" />
 </form>  
 <?
    }
  }
endif;
?>
</div>
