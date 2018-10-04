<?php
  /*
   |--------------------------------------------------------------------------
   | Image Resize Class
   |--------------------------------------------------------------------------
   | #########################################################################
   | Author  : Deepak B Pillai
   | eMail   : pillai.deepakb@gmail.com
   | Project : AccurateResizer
   | Version : 1.0
   | #########################################################################
   | #########################################################################
   | 'AccurateResizer' is used to resize image as per the input we given(width, height).
   | Usage: include the calss in your page (include('resize_new.php');)
   | And call 'new thumbnail($UploadedPath,150,105,"TS");' like this
   | $UploadedPath means the full path of the image
   | 150 means the width and 105 means the height of the image
   | And the final input 'TS', which helps you to save the processed image as a new one
   | (if your input image name is a.jpg then it will process the image and save it like a_ts.jpg)
   | and later you can use the original mage(a.jpg)
   | if no input is given in the area of 'TS' then the code will rewrite the same image. 
   | #########################################################################
   */
class image
{
	 public function getExtension($str)
	 {
		 $i = strrpos($str,".");
		 if (!$i) { return ""; }
		 $l = strlen($str) - $i;
		 $extt = substr($str,$i+1,$l);
		 return $extt;
	 }
	public function getfile($path)
	{
		$fle = explode("/", $path);
		$endl = end($fle);
		unset($fle);
		return $endl;
	}
		
	public function getUplodePath($uPath)
	{
		$UaPath = explode('/', $uPath);
		for($i=0; $i<=(count($UaPath)-2); $i++)
		{
			$npath.=$UaPath[$i]."/";
		}
		unset($UaPath);
		return $npath;
	}	
	public function addExt($name, $seed)
	{
		if($seed == "P"){
			$seed="P";
		}else if($seed == "T"){
			$seed="tn";
		}else if($seed == "SL"){
			$seed="sl";
		}else if($seed == "TS"){
			$seed="ts";
		}else if($seed == "S"){
			$seed="S";
		}
		else
		{
			$seed = "";
		}

		$nameArray = array();
		$nameRev = array();
		$nameArray = explode('.', $name);
		$nameRev = array_reverse($nameArray);
		if($seed != "")
		{
			$nameRev[1] = $nameRev[1]."_".$seed;
		}
		else
		{
			//Do nothing
		}
		$nameAgnRev = array_reverse($nameRev);
		for($j=0; $j<=(count($nameAgnRev)-2); $j++)
		{
			$newName.= $nameAgnRev[$j].".";
		}
		unset($nameAgnRev);
		$newName = $newName.$nameRev[0];
		return $newName;
	}

}


class thumbnail extends image
{
	function __construct($UploadedPath,$width,$height,$mode)
	{
		if($UploadedPath != "" && $width != "" && $height !="" && $mode != "")
		{
			$filename = stripslashes(parent::getfile($UploadedPath));
			$extension = parent::getExtension($filename);
			$extension = strtolower($extension);

			if($extension=="jpg" || $extension=="jpeg" )
			{
				$src = imagecreatefromjpeg($UploadedPath);
			}
			else if($extension=="png")
			{
				$src = imagecreatefrompng($UploadedPath);
			}
			else 
			{
				$src = imagecreatefromgif($UploadedPath);
			}


				$newwidth = $width;
				$newheight = $height;
				$tmp=imagecreatetruecolor($newwidth,$newheight);
				
				$filename = parent::getUplodePath($UploadedPath).parent::addExt($filename,$mode);

				list($width_s,$height_s)=getimagesize($UploadedPath);

				imagecopyresampled($tmp,$src,0,0,0,0,$newwidth,$newheight,$width_s,$height_s);

				if($extension=="jpg" || $extension=="jpeg" )
				{
					imagejpeg($tmp,$filename, 100);
				}
				else if($extension=="png")
				{
					 imagePNG($tmp, $filename, 9);
				}
				else 
				{
					imageGIF($tmp, $filename, 100);
				}
			
			imagedestroy($src);
			imagedestroy($tmp);
			unset($newwidth);
			unset($newheight);
			unset($width_s);
			unset($height_s);
			unset($filename);
			unset($extension);
			unset($mode);
			unset($mode);
			unset($UploadedPath);
		}
		else
		{
			echo "Insufficient Input!";
		}
	}

}
?>