<?PHP
/*
Oziams' Image Uploader example with basic error checking, you can use to upload 
images as is or optionally re-size images and/or create thumbnails if required. 
Image filename will be as original in lowercase, thumbnails will have the same 
name as original with prefix "th_". Supports GIF,JPG or PNG images only.

This is just a basic example of how it could be used, of course you could
add more security checks and also display the image or thumb after upload if desired.
*/
$msg = null;

if(isset($_FILES['image'])){

// Set upload dir where images will be stored, 
// this can be ABSOLUTE or RELATIVE path, MUST have trailing forward slash.
define("UPLOAD_DIR","./uploaded_images/");

// Lets check to see if we are uploading an image file else print error $msg
$type = $_FILES["image"]["type"];
$ext  = pathinfo($_FILES["image"]["name"], PATHINFO_EXTENSION);

if(($type == "image/gif" && $ext == 'gif') || 
   ($type == "image/jpeg" && $ext == 'jpg') || 
   ($type == "image/pjpeg" && $ext == 'jpg') || 
   ($type == "image/x-png" && $ext == 'png')){

  define("SOURCE", $_FILES["image"]["tmp_name"]);
  define("FILENAME", strtolower($_FILES["image"]["name"]));
  
  require_once("oiu.class.php"); # Path to oiu.class.php file
  
  // If image name doesn't already exist continue, else print error $msg
  if(!is_file(UPLOAD_DIR.FILENAME)){

  // Set variables below for main image re-sizing and/or thumbnail creation
  $img_width  = 400; # Image width in pixels, set to 0 for NO re-sizing
  $img_height = 0;   # Image height, set to 0 for proportional height

  $th_width   = 100; # Thumbnail width, set to 0 for NO thumbnail creation
  $th_height  = 0;   # Thumbnail height, set to 0 for proportional height

  if($oiu->CreateImage($img_width, $img_height, $th_width, $th_height) === false){
   $msg = 'Upload error';
  }
  else{ $msg = 'Uploaded <b>'.FILENAME.'</b> successfully';}
  }
  else{ $msg = 'Upload error: <b>'.FILENAME.'</b> already exists!';}
}
else{ $msg = 'Upload error: Invalid Image type';}
}

print <<<HTML
<html>
<head>
<title>Oziams' Image Uploader Example</title>
</head>
<body>
<form name="myForm" method="POST" enctype="multipart/form-data" action="example.php">
<table width="400" border="0" cellspacing="2" cellpadding="0">
<tr><td>
<table style="font:normal 9pt tahoma,arial" width="100%" border="0" cellspacing="0" cellpadding="0">
<tr><td><font size=3>Oziams' Image Uploader Example</font></td></tr>
<tr><td><br><font color=red>$msg</font></td></tr>
<tr><td><br>
<input name="image" type="file" value="Choose...">&nbsp;<input name="upload" type="submit" value="Upload">
</td></tr>
</table>
</td></tr></table>
</form>
</body>
</html>
HTML;
exit;
?>