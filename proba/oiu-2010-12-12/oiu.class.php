<?php
/*****************************************************
*** Oziams' Image Uploader v1.0 - 13 December 2010 ***
******************************************************
Requirements: PHP >= 4.0.3 with GD extensions

*******************
*** BASIC USAGE ***
*******************
// Set upload dir where images will be stored, 
// this can be ABSOLUTE or RELATIVE path, MUST have trailing forward slash.
define("UPLOAD_DIR","./uploaded_images/"); 

define("SOURCE", $_FILES["image"]["tmp_name"]); # Get temp source
define("FILENAME", strtolower($_FILES["image"]["name"])); # Get image filename

require_once("oiu.class.php"); # Path to oiu.class.php file

  // Set variables below for main image re-sizing and/or thumbnail creation
  $img_width  = 400; # Image width in pixels, set to 0 for NO re-sizing
  $img_height = 0;   # Image height, set to 0 for proportional height

  $th_width   = 100; # Thumbnail width, set to 0 for NO thumbnail creation
  $th_height  = 0;   # Thumbnail height, set to 0 for proportional height

  $oiu->CreateImage($img_width, $img_height, $th_width, $th_height);

*****************************
*** BSD License Agreement ***
*****************************
Author: Dwayne Rothe - oziam@live.com.au
Copyright (c)2010-2011, Dwayne Rothe - All rights reserved.

Redistribution and use in source and binary forms, with or without modification, 
are permitted provided that the following conditions are met:

1.) Redistributions of source code must retain the above copyright notice, 
this list of conditions and the following disclaimer.

2.) Redistributions in binary form must reproduce the above copyright notice, 
this list of conditions and the following disclaimer in the documentation 
and/or other materials provided with the distribution.

THIS SOFTWARE IS PROVIDED BY THE COPYRIGHT HOLDERS AND CONTRIBUTORS "AS IS" AND ANY 
EXPRESS OR IMPLIED WARRANTIES, INCLUDING, BUT NOT LIMITED TO, THE IMPLIED WARRANTIES 
OF MERCHANTABILITY AND FITNESS FOR A PARTICULAR PURPOSE ARE DISCLAIMED. IN NO EVENT 
SHALL THE COPYRIGHT HOLDER OR CONTRIBUTORS BE LIABLE FOR ANY DIRECT, INDIRECT, INCIDENTAL, 
SPECIAL, EXEMPLARY, OR CONSEQUENTIAL DAMAGES (INCLUDING, BUT NOT LIMITED TO, PROCUREMENT 
OF SUBSTITUTE GOODS OR SERVICES; LOSS OF USE, DATA, OR PROFITS; OR BUSINESS INTERRUPTION) 
HOWEVER CAUSED AND ON ANY THEORY OF LIABILITY, WHETHER IN CONTRACT, STRICT LIABILITY, OR 
TORT (INCLUDING NEGLIGENCE OR OTHERWISE) ARISING IN ANY WAY OUT OF THE USE OF THIS SOFTWARE, 
EVEN IF ADVISED OF THE POSSIBILITY OF SUCH DAMAGE.
*****************************************************************************************/
if(!defined("UPLOAD_DIR")){ define("UPLOAD_DIR", "./uploaded_images/");
}
class ImageUpload{

	protected $UPLOAD_DIR = UPLOAD_DIR;
	protected $SOURCE     = SOURCE;
	protected $FILENAME   = FILENAME;

	public function CreateImage($img_W, $img_H, $th_W, $th_H){
	
	  $this->stretch = 0; # If you want smaller images to stretch to re-size set to 1 

		// Check to see if upload directory exists and create it if necessary
		if(!is_dir($this->UPLOAD_DIR)){ 
      mkdir($this->UPLOAD_DIR); chmod($this->UPLOAD_DIR, 0777);
    }
		
		// Upload original image or return false if error
		if((move_uploaded_file($this->SOURCE, $this->UPLOAD_DIR.$this->FILENAME)) === false){
     trigger_error('Could not upload to '.$this->UPLOAD_DIR, E_USER_WARNING);
     return(false);
		}
		
		// We need to get the image type
		// 1 = GIF, 2 = JPG,JPEG, 3 = PNG
		$type = getimagesize($this->UPLOAD_DIR.$this->FILENAME);
		
		switch($type[2]){
			case '1':
			$icf  = "imagecreatefromgif";
			$img  = "imagegif";
			$qlty = "80"; # Set quality %
			break;
			case '2':
			$icf  = "imagecreatefromjpeg";
			$img  = "imagejpeg";
			$qlty = "80"; # Set quality %
			break;
			case '3':
			$icf  = "imagecreatefrompng";
			$img  = "imagepng";
			$qlty = "9"; # DONOT CHANGE
			break;
		}
		
		// Check for loaded GD extensions
		if(!function_exists($icf)){ 
		 @unlink($this->UPLOAD_DIR.$this->FILENAME);
		 trigger_error('GD extensions are not loaded!', E_USER_WARNING);
     return(false);
		}
		
		// Get image original width and height
		list($org_W, $org_H) = getimagesize($this->UPLOAD_DIR.$this->FILENAME);
		
		if($this->stretch == 0){
		
      if($org_W < $img_W){ $img_W = $org_W;
      }
      if($img_H > 0 && $org_H < $img_H){ $img_H = $org_H;
		  }
		  elseif($img_H == 0){
       $proportion = ($org_H/$org_W);
       $img_H = ($img_W*$proportion);
      }
		}
		else{
		
      if($img_H == 0){
		   $proportion = ($org_H/$org_W);
       $img_H = ($img_W*$proportion);
      }
		}
		
		$src = $icf($this->UPLOAD_DIR.$this->FILENAME);
		
	  // Re-size main image if required
	  if($img_W > 0){
		$img_tmp = imagecreatetruecolor($img_W, $img_H);
		imagecopyresampled($img_tmp, $src, 0, 0, 0, 0, $img_W, $img_H, $org_W, $org_H);
		$img($img_tmp, $this->UPLOAD_DIR.$this->FILENAME, $qlty);
		imagedestroy($img_tmp); # free image from memory
		}
		
		// Create thumbnail image if required
		if($th_W > 0){
		
      if($th_H == 0){
       $proportion = ($org_H/$org_W);
       $th_H = ($th_W*$proportion);
      }
    $th_tmp = imagecreatetruecolor($th_W, $th_H);
    imagecopyresampled($th_tmp, $src, 0, 0, 0, 0, $th_W, $th_H, $org_W, $org_H);
    $img($th_tmp, $this->UPLOAD_DIR.'th_'.$this->FILENAME, $qlty);
    imagedestroy($th_tmp); # free image from memory
		}
	}
}
$oiu = new ImageUpload(); # Instantiate class