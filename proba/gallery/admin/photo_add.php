<?
//require_once("start.php"); подключаем БД
session_start();
if (!isset($_SESSION['admin'])){ header("Location: index.php"); exit; }
if (isset($_POST['t']))
{
	$targ_w = $targ_h = 190;
	$jpeg_quality = 90;

	$src = "../upload/{$_POST['t']}b.jpg";
	$img_r = imagecreatefromjpeg($src);
	$dst_r = ImageCreateTrueColor( $targ_w, $targ_h );

	imagecopyresampled($dst_r,$img_r,0,0,$_POST['x'],$_POST['y'],$targ_w,$targ_h,$_POST['w'],$_POST['h']);

	imagejpeg($dst_r,"../upload/{$_POST['t']}s.jpg",$jpeg_quality);
	header("Location:photos.php?ok=ok");
	//echo "<img src='../upload/{$_POST['t']}s.jpg'>";
	exit;
}
function resizeimg($filename, $smallimage, $w, $h) 
  { 
    $filename = $filename; 
    $smallimage = $smallimage;
    $ratio = $w/$h;
    $size_img = getimagesize($filename);
    if (($size_img[0]<$w) && ($size_img[1]<$h)) return true;
    $src_ratio=$size_img[0]/$size_img[1]; 
 
    if ($ratio<$src_ratio) 
    { 
      $h = $w/$src_ratio; 
    } 
    else
    { 
      $w = $h*$src_ratio; 
    } 
 
    $dest_img = imagecreatetruecolor($w, $h);   
    $white = imagecolorallocate($dest_img, 255, 255, 255);        
    $src_img = imagecreatefromjpeg($filename);                       
 
    imagecopyresampled($dest_img, $src_img, 0, 0, 0, 0, $w, $h, $size_img[0], $size_img[1]);                 
 
    imagejpeg($dest_img, $smallimage);                       
 
    imagedestroy($dest_img); 
    imagedestroy($src_img); 
    return true;          
  }
  $t=time();
  //$size_img[0], $size_img[1]
  $isize=getimagesize($_FILES["photo"]["tmp_name"]);
  $imgw=$isize[0];
  $imgh=$isize[1];
  if (($imgw>1000) || ($imgh > 800)){ resizeimg($_FILES["photo"]["tmp_name"], "../upload/{$t}b.jpg", 1000, 800); } else { move_uploaded_file($_FILES["photo"]["tmp_name"],"../upload/{$t}b.jpg"); }
  mysql_query("insert into photos (comment,big,small,cat) values ('{$_POST['comment']}','{$t}b.jpg','{$t}s.jpg','3')");
  $isize=getimagesize("../upload/{$t}b.jpg");
  $imgw=$isize[0];
  $imgh=$isize[1];
?>
<html>
	<head>

		<script src="../jquery14.js"></script>
		<script src="../js/jquery.Jcrop.js"></script>
		<link rel="stylesheet" href="../css/jquery.Jcrop.css" type="text/css" />
		
		<script language="Javascript">

			jQuery(window).load(function(){

				jQuery('#cropbox').Jcrop({
					onChange: showPreview,
					onSelect: showPreview,
					aspectRatio: 1
				});

			});

			// Our simple event handler, called from onChange and onSelect
			// event handlers, as per the Jcrop invocation above
			function showPreview(coords)
			{
				if (parseInt(coords.w) > 0)
				{
					updateCoords(coords);
					var rx = 190 / coords.w;
					var ry = 190 / coords.h;

					jQuery('#preview').css({
						width: Math.round(rx * <?=$imgw;?>) + 'px',
						height: Math.round(ry * <?=$imgh;?>) + 'px',
						marginLeft: '-' + Math.round(rx * coords.x) + 'px',
						marginTop: '-' + Math.round(ry * coords.y) + 'px'
					});
				}
			}
			function updateCoords(c)
			{
				$('#x').val(c.x);
				$('#y').val(c.y);
				$('#w').val(c.w);
				$('#h').val(c.h);
			};

			function checkCoords()
			{
				if (parseInt($('#w').val())) return true;
				alert('Please select a crop region then press submit.');
				return false;
			};

		</script>

	</head>

	<body>
<table><tr><td>
		<img src="../upload/<?=$t;?>b.jpg" id="cropbox" />
</td><td valign="middle">
<div style="width:190px;height:190px;overflow:hidden;">
			<img src="../upload/<?=$t;?>b.jpg" id="preview" />
		</div>
        </td></tr></table><br />
		<!-- This is the form that our event handler fills -->
		<form action="photo_add.php" method="post" onSubmit="return checkCoords();">
			<input type="hidden" id="x" name="x" />
			<input type="hidden" id="y" name="y" />
			<input type="hidden" id="w" name="w" />
			<input type="hidden" id="h" name="h" />
            <input type="hidden" id="t" name="t" value="<?=$t;?>" />
			<input type="submit" value="Crop Image" />
		</form>

	</body>

</html>