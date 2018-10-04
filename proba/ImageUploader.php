<?php
/**
 * Image uploader Class
 * 
 * @author Leszek Albrzykowski
 * @copyright 2007, Leszek Albrzykowski
 * @licence GPL
 */
class ImageUploader{
	public $name;
	public $type;
	public $size;
	public $tmp;
	public $error;
	public $fullImage;
	public $thumbImage;
	public $message;
	public $newFullName;
	public $newThumbName;
	/**
	 * Function to initialize variables
	 *
	 * @return bool
	 */
	public function __construct(){
		global $_FILES;
		$this->error = $_FILES['image_file']['error'];
		if($this->error != 0){
			$this->message = $this->error;
			$this->message;
			return false;
		}
		else{
			$this->name = $_FILES['image_file']['name'];
			$this->type = $_FILES['image_file']['type'];
			$this->size = $_FILES['image_file']['size'];
			$this->tmp = $_FILES['image_file']['tmp_name'];
			return true;
		}
	}
	/**
	 * Function to Check the uploaded file
	 *
	 * @return bool
	 */
	public function validate($maxFileSize,$minImageSize){
		if($this->type != 'image/jpeg' && $this->type != 'image/gif' && $this->type != 'image/png'){
			$this->message = 'Bad file format.';
			return false;
		}
		if($this->size > $maxFileSize){
			$this->message = 'The file is to big.';
			return false;
		}
		$size = getimagesize($this->tmp);
		if($size[0] < $minImageSize || $size[1] < $minImageSize){
			$this->message = 'The fie dimensions are to small.';
			return false;
		}
		else{
			return true;
		}
	}
	/**
	 * Function to resieze image
	 *
	 * @return bool
	 */
	public function resize($maxFullSize, $maxThumbSize){
		list($oryginalWidth, $oryginalHeight) = getimagesize($this->tmp);
		if($oryginalWidth > $oryginalHeight){
			$fullWidth = $maxFullSize;
			$fullHeight = intval($maxFullSize*($oryginalHeight/$oryginalWidth));
			$thumbWidth = $maxThumbSize;
			$thumbHeight = intval($maxThumbSize*($oryginalHeight/$oryginalWidth));
		}
		else if($oryginalWidth < $oryginalHeight){
			$fullWidth = intval($maxFullSize*($oryginalWidth/$oryginalHeight));
			$fullHeight = $maxFullSize;
			$thumbWidth = intval($maxThumbSize*($oryginalWidth/$oryginalHeight));
			$thumbHeight = $maxThumbSize;
		}
		else{
			$fullWidth = $maxFullSize;
			$fullHeight = $maxFullSize;
			$thumbWidth = $maxThumbSize;
			$thumbHeight = $maxThumbSize;
		}
		$this->fullImage = imagecreatetruecolor($fullWidth,$fullHeight);
		$this->thumbImage = imagecreatetruecolor($thumbWidth, $thumbHeight);
		if($this->type == 'image/gif'){
			$sourceImage = imagecreatefromgif($this->tmp);
		}
		else if($this->type == 'image/jpeg'){
			$sourceImage = imagecreatefromjpeg($this->tmp);
		}
		else{
			$sourceImage = imagecreatefrompng($this->tmp);
		}
		imagecopyresampled($this->fullImage,$sourceImage,0,0,0,0,$fullWidth,$fullHeight,$oryginalWidth,$oryginalHeight);
		imagecopyresampled($this->thumbImage,$sourceImage,0,0,0,0,$thumbWidth,$thumbHeight,$oryginalWidth,$oryginalHeight);
		
	}
	/**
	 * Function to upload image
	 *
	 * @return bool
	 */
	public function upload($dir,$quality){
		$fileExtension = explode('.',$this->name);
		$this->newFullName = date("YmdHis").'.'.$fileExtension[1];
		$this->newThumbName = date("YmdHis").'thumb.'.$fileExtension[1];
		if($this->type == 'image/gif'){
			imagegif($this->fullImage, $dir.$this->newFullName);
			imagegif($this->thumbImage, $dir.$this->newThumbName);
		}
		else if($this->type == 'image/jpeg'){
			imagejpeg($this->fullImage, $dir.$this->newFullName, $quality);
			imagejpeg($this->thumbImage, $dir.$this->newThumbName, $quality);
		}
		else{
			imagepng($this->fullImage,$dir.$this->newFullName);
			imagepng($this->thumbImage,$dir.$this->newThumbName);
		}
		$this->message = 'The file has been uploaded.';
	}
}
?>
