<?php
include ('../inc/i_resize.php');
require ('../inc/delete_dir.php');


// �������, �������������� ���������� ������ $dir
  function get_ftp_size($ftp_handle, $dir, $global_size = 0)
  {
    $file_list = ftp_rawlist($ftp_handle, $dir);
    if(!empty($file_list))
    {
      foreach($file_list as $file)
      {
        // ��������� ������ �� ���������� ��������
        list($acc,
             $bloks,
             $group,
             $user,
             $size, 
             $month, 
             $day, 
             $year, 
             $file) = preg_split("/[\s]+/", $file);
        //if($acc[0] != 'd' && $file == ".." && $file == ".")
        //{         
          // ���� ����� ���� ����, ������������ ���
          $global_size++;
       // }
      }
    }
  return $global_size;
} 


function hardFlush($pr) { 
?><img style="height: 30px; width: 6px; padding-left: 3px;" src="/img/ftp_ind.png"><? ;
$pr = intval($pr);	
if ($pr>1)
{
 $pr--;
 hardFlush($pr);
} 

			  
//echo ("����������:  ".$pr.'%');
    flush();
    ob_flush(); 

} 



// ������� ��� ������������ ��������� � �������� ����������:
function ftp_is_dir($folder)
    {    	 
	   $file_parts = explode('.',$folder);              //��������� ��� ����� � ��������� ��� � ������
	   $ext = strtolower(array_pop($file_parts));      //��������� �������� - ��� ����������
	   if($ext == 'jpg' || $ext == 'jpeg' || $ext == 'png' || $ext == 'gif' )   
      {         
          return 'true';
       } else
       {
          return 'false';
       }
    }
		
	
if(!isset($_SESSION['admin_logged']))
  die();

if(isset($_POST['go_add']))
{  
  if(isset($_FILES['preview']) && $_FILES['preview']['size'] != 0)
  {
  if($_FILES['preview']['size'] < 1024*15*1024)
  {
    $ext = strtolower(substr($_FILES['preview']['name'], 1 + strrpos($_FILES['preview']['name'], ".")));
    $nm = mysql_escape_string($_POST['nm']);
    $descr = mysql_escape_string($_POST['descr']);
	$foto_folder = mysql_escape_string($_POST['foto_folder']);	
    if(empty($nm)) $nm = '��� �����';
    mysql_query('insert into albums (nm) values (\''.$nm.'\')');
    if(mysql_errno() > 0)
    {
    	die('������ MySQL!'. mysql_error());
    }
    $id_album = mysql_insert_id();		  
    $img = 'id'.$id_album.'.'.$ext;
    $target_name = $_SERVER['DOCUMENT_ROOT'].'/images/'.$img;
	$file_load = $_SERVER['DOCUMENT_ROOT'].'/tmp/'.$img;
	
	if(move_uploaded_file($_FILES['preview']['tmp_name'], $file_load))	      
	   {
	   			
    $sharping = 1;
    $watermark = 0;
	$ip_marker = 0;
	
	if  (imageresize($target_name,$file_load,200,200,75,$watermark,$ip_marker,$sharping) == 'true')
		
	   {		           	     
          $id_category = intval(mysql_result(mysql_query('select id from categories order by id desc limit 0, 1'), 0));
          mysql_query("update albums set id_category = '1', img = '$img', order_field = '$id_album', descr = '$descr', foto_folder = '$foto_folder'  where id = '$id_album'");	  	   	   	        	  
	      mkdir ('../'.$foto_folder.$id_album, 0777, true) or die($php_errormsg);  
          unlink($file_load);		  
        }
	  else 
	    {
	       mysql_query('delete from albums where id = '.$id_album);
    	   die('��� ��������� ����������� ������ JPG, PNG ��� GIF ������� ������ �� ����� 15Mb.');
		   unlink($file_load);
	    }
	   }
	  else 
	   {
	       mysql_query('delete from albums where id = '.$id_album);
	       die('�� ���� ��������� ���� � ����� "tmp"');
		   unlink($file_load);
	   }
    }
      else
    {
    	   die('������ ����� ��������� 15 ��������');
		   unlink($file_load);
    }
   } 
   //   else
 // {
   //         die('����� ����!');
	//		unlink($file_load);
 // }
}


if(isset($_POST['go_delete']))
{
	$id = intval($_POST['go_delete']);	    
    $album_folder = mysql_result(mysql_query('select order_field from albums where id = ' .$id), 0);
	$foto_folder = mysql_result(mysql_query('select foto_folder from albums where id = ' .$id), 0);		   
	deleteDir ($_SERVER['DOCUMENT_ROOT'].$foto_folder.$album_folder);
	mysql_query('delete from photos where id_album = '.$id);	
	$album_foto = mysql_result(mysql_query('select img from albums where id = ' .$id), 0);
	@unlink("../images/$album_foto");		
	mysql_query('delete from albums where id = '.$id);
}

if(isset($_POST['go_edit_name']))
{
	$id = intval($_POST['go_edit_name']);
  $nm = mysql_escape_string($_POST['nm']);
  if(empty($nm)) $nm = '-----';
  mysql_query('update albums set nm = \''.$nm.'\' where id = '.$id);
}

if(isset($_POST['go_edit_descr']))
{
	$id = intval($_POST['go_edit_descr']);
  $descr = mysql_escape_string($_POST['descr']);
  mysql_query('update albums set descr = \''.$descr.'\' where id = '.$id);
}

if(isset($_POST['go_edit_nastr']))
{  
  
  $watermark = (int)isset($_REQUEST['watermark']);
  $ip_marker = (int)isset($_REQUEST['ip_marker']);
  $sharping = (int)isset($_REQUEST['sharping']);
 
  $quality = mysql_escape_string($_POST['quality']);   
  $id = intval($_POST['go_edit_nastr']);
  $price = floatval($_POST['price']);
  $id_category = intval($_POST['id_category']);
  $pass = mysql_escape_string($_POST['pass']);
  $ftp_folder = mysql_escape_string($_POST['ftp_folder']); 
  $foto_folder = mysql_escape_string($_POST['foto_folder']);
  mysql_query('update albums set price = \''.$price.'\', id_category = '.$id_category.', pass = \''.$pass.'\',quality = \''.$quality.'\'
  , ftp_folder = \''.$ftp_folder.'\', foto_folder = \''.$foto_folder.'\', watermark = \''.$watermark.'\',
  ip_marker = \''.$ip_marker.'\', sharping = \''.$sharping.'\' where id = '.$id);
  mysql_query('update photos set price = \''.$price.'\' where id_album = '.$id);
}
 
if(isset($_POST['go_ftp_upload']))
{
	//600x450
	$id = intval($_POST['go_ftp_upload']);
	
  $rs = mysql_query('select * from albums where id = '.$id);
  if(mysql_num_rows($rs) > 0)
  {
  	   //�������� ������ �� ������� � ��������� FTP-�������
  	    $album_data = mysql_fetch_assoc($rs);
        $ftp_host = get_param('ftp_host');
        $ftp_user = get_param('ftp_user');
        $ftp_pass = get_param('ftp_pass');
        // mysql_set_charset("utf8");
     if($ftp_host && $ftp_user && $ftp_pass)
     {
    	//���� � ����� ������������ ���� - ������� ���
    	if(strstr($ftp_host, ':'))
    	{
    		$ftp_port = substr($ftp_host, strpos($ftp_host, ':') + 1);
    		$ftp_host = substr($ftp_host, 0, strpos($ftp_host, ':'));
    	}
    	else
    	{
    		$ftp_port = 21;
    	}
    	   //�����������
    	$ftp = ftp_connect($ftp_host, $ftp_port);
      if(!$ftp)
    	    die('�������� ����� ��� ���� ftp �������!');
              //���������
      if(!ftp_login($ftp, $ftp_user, $ftp_pass))
      {
      	    ftp_close($ftp);
            die('�������� ����� ��� ������ ��� FTP �������!');
      }
	  
	  if (ftp_chdir($ftp, $album_data['ftp_folder']))
	        {
          ftp_chdir($ftp, $album_data['ftp_folder']);	
	        }	  
	  
            //�������� ������ ������ � �����
       $file_list = ftp_nlist($ftp, $album_data['ftp_folder']);				  
			
		//var_dump($file_list);
		//echo '����� ftp: <br><pre>', print_r($file_list,1), '</pre>';	
			
	  if ( $file_list === FALSE )
           {  
		      ftp_close($ftp);
              die ('���������� �� ����������! <br>');	          			  
           }
           
		    //var_dump($file_list);
			//echo '����� ftp: <br><pre>', print_r($file_list,1), '</pre>';	 
		   
		    // ���� ���������� �� ����� ����? FTP ���� ���������������� ����� ������ ������	
	   if ( !count($file_list) )		
	           // if ( !count($file_list) || ftp_size( $ftp, $file_list[0] ) == -1 )
           {
                   echo '������ ��������� ������ ������!';
                   echo '<br> ����� FTP - File List: <br><pre>', print_r($file_list,1), '</pre>';
				   ftp_close($ftp);			 
                   die('��� �������� �� FTP ����� : " '.$album_data['ftp_folder']. ' " - ������!');
           }                 		 			 			
    	  $local_dir = $_SERVER['DOCUMENT_ROOT'].'/tmp/';
			 
		    // ���������� ������ � ����� 	 
          $pload = 100 / (get_ftp_size ($ftp, $album_data['ftp_folder']));
          $pr = 0;
		 			 			 
    	  //���������� �����, ���������� � ������������ �� ������
      foreach($file_list as $key => $remote_file)
    	{
          // �����
        $pr=$pr+$pload;
        if ($pr>=1)
             {		
        hardFlush($pr);
        $pr = $pr-intval($pr);	
             }
		
    		//���
// $remote_file = iconv('utf-8', 'cp1251', $remote_file);
     		$f_name = substr($remote_file, strrpos($remote_file, '/') + 1);		   	
	   if (ftp_is_dir($f_name) == 'true')   // �������� �� ���������� � �� �������:                  
		{
			//��������� ����
      		$local_file = $local_dir.$f_name;
			//���� �� FTP
//$remote_file = $album_data['ftp_folder'].$remote_file;
       if(!ftp_get($ftp, $local_file, $remote_file, FTP_BINARY)) 
      	    {	
			  ftp_close($ftp);
      		  die('�� ���� ��������� ����: '.$remote_file.' -> '.$local_file);     		           
      	    }
		      		  
          //������� ������ � ��
          $nm = substr($f_name, 0, strrpos($f_name, '.'));				  		  		 		  
          mysql_query('insert into photos (id_album, nm) values ('.intval($album_data['id']).', \''.$nm.'\')');
          $id_photo = mysql_insert_id();
          $tmp_name = 'id'.$id_photo.'.jpg';		  
		  $foto_folder = $album_data['foto_folder'];
		  $album_folder = $album_data['id'];
		  //$watermark = $album_data['watermark'];
		  $watermark = 0;
		  //$ip_marker = $album_data['ip_marker'];
		  $ip_marker = 0;
		  $sharping = $album_data['sharping'];	
          $target_name = $_SERVER['DOCUMENT_ROOT'].$foto_folder.$album_folder.'/'.$tmp_name;		  		  		 
		  $quality = $album_data['quality'];	
      if  (imageresize($target_name,$local_file,600,450,$quality,$watermark,$ip_marker,$sharping) == 'true')
        {        
          unlink($local_file);		  
		  mysql_query("update photos set img = '$tmp_name', price = '".$album_data['price']."', ftp_path = '$remote_file' where id = '$id_photo'");
	    }
     else
	    {
		  unlink($local_file);
		  mysql_query('delete from photos where id = '.$id_photo);
	      echo ('���� �� FTP'.$remote_file.' - �����!'); ?><br><?php;         
	    }	  
	  }
//   else
//	  {
//		  echo ($remote_file.'  - ��� ����� ��� ���������������� ����!');
         // unlink($local_file);
//	  }
//   }
    }
    	  ftp_close($ftp);		  
	      echo "<center><b>�������� ������ ���������!</b></center>";
  }
 }
}


if(isset($_POST['go_updown']))
{
  $swap_id = 0;
  $id = intval($_POST['go_updown']);
  $current_order = intval(mysql_result(mysql_query('select order_field from albums where id = '.$id), 0));
  if($current_order > 0)
  {
    if(isset($_POST['up']))
    {
    	$rs = mysql_query('select id, order_field from albums where order_field < '.$current_order.' order by order_field desc limit 0, 1');
    }
    else
    {
    	$rs = mysql_query('select id, order_field from albums where order_field > '.$current_order.' order by order_field asc limit 0, 1');
    }
  	if(mysql_num_rows($rs) > 0)
  	{
  	  $ln = mysql_fetch_assoc($rs);
  	  $swap_id = intval($ln['id']);
  	  $swap_order = intval($ln['order_field']);
  	}
  }
  if($current_order > 0 && $swap_id > 0)
  {
    mysql_query('update albums set order_field = '.$current_order.' where id = '.$swap_id);
    mysql_query('update albums set order_field = '.$swap_order.' where id = '.$id);
  }
}
?>
<div class="row">
<div class="span5 offset0">
<form action="index.php" method="post" enctype="multipart/form-data">
<table border="0">
  <tr>
    <td>������:</td>
    <td>
<div class="controls">
<div class="input-append">	
	<input id="appendedInputButton" class="span3" type="file" name="preview" style="width: 203px; margin-bottom: 5px;" />
</div>
</div>	
	</td>	
  </tr>
  <tr>
    <td>��������:</td>
    <td><input type="text" name="nm" value="" style="width: 203px; margin-bottom: 5px;" /></td>
  </tr>
  <tr>
    <td>����� ���������:</td>   
	<td><input type="text" name="foto_folder" value="/images2/" style="width: 203px; margin-bottom: 5px;"  /></td>
  </tr>
  <tr>
    <td>��������:</td>
    <td><textarea style="width: 400px; height: 100px;" name="descr"></textarea></td> 
  </tr>
  <tr>
    <td align="center" colspan="2">
      <input class="btn  btn-success" type="hidden" name="go_add" value="1" />
      <input class="btn  btn-success" type="submit" value="��������"  />
    </td>
  </tr>
  </table>
</form>
</div>
<div class="span5 offset1">
<div>1. ������� ���� ��� ��������� � IP ������� ����������� �� ������� � ������ <b>���������.</b></div>
<div>2. ������ "��������" ��������� ������� <b>��� �������</b> � FTP.</div>
<div>3.��� ����� <b>/��� �����/</b> �����������.</div> 
<div>4.����� ���������� <b>����� � ���������</b> ��� ����������� ������� ����������� ������� ������� ����� �� �������!</div>
</div>
</div>
<hr/>


<?
$rs = mysql_query('select * from albums order by order_field asc');
if(mysql_num_rows($rs) > 0)
{
	while($ln = mysql_fetch_assoc($rs))
	{	   
		?>		                				
		<div style="border-bottom: 0 SOLID #000;">
		  <table border="0">
		    <tr>		      
		      <td valign="top">			 
		        <table border="3" >
		         <tr>				 
				  <td align="center" style="height: 120px;">
		            <img src="/images/<?=$ln['img']?>" alt="-" width="100px" height="100px" />	
<div class="controls">
<div class="input-append">					
      		        <form action="index.php" method="post" style="margin: 5px;">
      		          <input id="appendedInputButton" type="text" name="nm" value="<?=$ln['nm']?>" style="height: 17px;"/>
      		          <input class="btn btn-primary" type="hidden" name="go_edit_name" value="<?=$ln['id']?>" />
      		          <input class="btn-small btn-primary" type="submit" value="���������" />
      		        </form>
</div>
</div>					
      		      </td>				 				                           				  
      		      <td rowspan="3" align="center">
      		        <form action="index.php" method="post" style="margin: 0px;">
      		          <textarea  rows="12" cols="35" name="descr" style="width: 346px; height: 210px;"><?=$ln['descr']?></textarea><br/>
      		          <input class="btn btn-primary" type="hidden" name="go_edit_descr" value="<?=$ln['id']?>" />
      		          <input class="btn-small btn-primary" type="submit" value="���������" style="margin-bottom: 10px;">
      		        </form>					
      		      </td>					
      		      <td rowspan="3">
				   <table border="0" >
				     <tr>
					 <td>	
      		       <form action="index.php" method="post" style="margin: 5px;">
      		        <table border="0" >					 					  						   
      		            <tr>
      		              
<td><div class="input-prepend">
<span class="add-on" style="padding-bottom: 0px; padding-top: 0px;">���� �� ���� (��.):</span>
<input id="prependedInput" class="span2" type="text" NAME="price" VALUE="<?=$ln['price']?>" style="margin-bottom: 0px; width: 152px;"/>

</div></td>     		              	
						  <td style="padding-left: 25px; padding-right: 7px; padding-bottom: 8px;"><input type='CHECKBOX' NAME='watermark' VALUE='yes' <?if ($ln['watermark']) { echo 'checked="checked"'; }?> /></td>			
						  <td style="padding-bottom: 3px;">������� ����</td>
      		            </tr>
						<tr>
<td><div class="input-prepend">
							 
							 
<span class="add-on" style="padding-bottom: 0px; padding-top: 0px;">�������� .jpg (%):</span>
<input id="prependedInput" class="span2" type="text" NAME="quality" VALUE="<?=$ln['quality']?>" style="margin-bottom: 0px; width: 154px;"/>
</div></td> 
						     <td style="padding-left: 25px; padding-right: 7px; padding-bottom: 8px;"><input type='CHECKBOX' NAME='ip_marker' VALUE='yes' <?if ($ln['ip_marker']) { echo 'checked="checked"'; }?> /></td>						  
						     <td style="padding-bottom: 3px;">IP �������.</td>
						</tr>
      		            <tr>
<td><div class="input-prepend">
<span class="add-on">���������:</span>																												
            		        
            		          <select id="prependedInput" class="span2" name="id_category" style="margin-bottom: 0px; width: 211px;">
            		            <?
                                  $tmp = mysql_query('select * from categories order by id desc');
                                  while($tmp2 = mysql_fetch_assoc($tmp))
                                     {
                          	    ?>
                          	       <option value="<?=$tmp2['id']?>" <?=($tmp2['id'] == $ln['id_category'] ? 'selected="selected"' : '')?>><?=$tmp2['nm']?></option>
                          	    <?
                                     }
            		            ?>
            		          </select>
</div></td> 							  
						             		       
      		            </tr>
      		            <tr>
<td><div class="input-prepend">
<span class="add-on" style="padding-bottom: 0px; padding-top: 0px;">������ �� ������:</span>
<input id="prependedInput" class="span2" type="text" NAME="pass" VALUE="<?=$ln['pass']?>" style="margin-bottom: 0px; width: 152px;"/>													
</div></td> 
      		            </tr>
						<tr>
<td><div class="input-prepend">
<span class="add-on" style="padding-bottom: 0px; padding-top: 0px;">����� ���������:</span>
<input id="prependedInput" class="span2" type="text" NAME="foto_folder" VALUE="<?=$ln['foto_folder']?>" style="margin-bottom: 0px;"/>
</div></td> 																																		
						</tr>
      		            <tr>
<td><div class="input-prepend">
<span class="add-on" style="padding-bottom: 0px; padding-top: 0px;">����� uploada FTP:</span>
<input id="prependedInput" class="span2" type="text" NAME="ftp_folder" VALUE="<?=$ln['ftp_folder']?>" style="margin-bottom: 0px; width: 147px;"/>						  
</div></td> 	
		<td style="padding-left: 25px; padding-right: 7px; padding-bottom: 8px;"><input type='CHECKBOX' NAME='sharping' VALUE='yes' <?if ($ln['sharping']) { echo 'checked="checked"'; }?> /></td>
		<td style="padding-bottom: 3px;">�������� ��������</td>  			 
                        </tr>						
      		            <tr>
      		                <td colspan="2" align="center">
        		              <input class="btn btn-primary"  type="hidden" name="go_edit_nastr" value="<?=$ln['id']?>" />
        		              <input class="btn-small btn-primary"  type="submit" value="���������" />
        		            </td>														
      		            </tr>												  						  
        	         </table>					 
   		            </form>			     					
					</td>															
					</tr>										
					<tr>					  
					   <td align="center">				   
					      <form action="index.php" method="post" style="margin-bottom: 0px;">
  		                   <input class="btn btn-success"  type="hidden" name="go_ftp_upload" value="<?=$ln['id']?>" />
  		                   <input class="btn-small btn-success"  type="submit" value="�������� � FTP" /><br/> 						  
      		               </form> 		
      		           </td>					  					   
					</tr>					
				  </table>
				</td>
				<tr>
		            <td align="center" style="height: 40px;">
					����� �������: "..<?=$ln['foto_folder']?><?=$ln['order_field']?>"
      		        <form action="index.php" method="post"  style="margin: 0px;">
      		          <input class="btn btn-primary"  type="hidden" name="go_delete" value="<?=$ln['id']?>" />					
      		          <input class="btn-small btn-danger dropdown-toggle"  type="submit" value="�������  ������" />						  
      		        </form>										
      		        </td>                  					
      		       </tr>     		         		    																
      		    <tr>
		            <td align="center" style="height: 30px;">
					
      		         <form action="index.php" method="post" style="margin: 0px;">
		<div class="btn-toolbar">
		<div class="btn-group">
      		          <input type="hidden" name="go_updown" value="<?=$ln['id']?>" />
      		          <input class="btn-small btn-info" type="submit" name="up" value="�������" />
      		          <input class="btn-small btn-info" type="submit" name="down" value="��������" />
		</div>
		</div>
      		         </form>
					 
      		        </td>
      		    </tr>
		        </table>
		      </td>
		    </tr>
		  </table>
		</div>
		<?		
	}
}
?>
