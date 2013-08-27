<?php
/**
 * Image uploader Class
 */
class ImageUploader{
   private $uploaded = false;
	public $name;
	public $type;
	public $size;
	public $tmp;
	public $error;
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
		$this->error = ($_FILES['image_file']['error'] != 0)?$_FILES['image_file']['error']:null;
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
	private function validate($maxFileSize, $minImageSize){
		if($this->type != 'image/jpeg' && $this->type != 'image/gif' && $this->type != 'image/png'){
			$this->message = 'Неразрешенный  формат файла!';
		   $this->uploaded = false;
			return false;
		}
		if($this->size > $maxFileSize){
			$this->message = 'Файл слишком большой!';
		   $this->uploaded = false;
			return false;
		}
		$size = getimagesize($this->tmp);
		if($size[0] < $minImageSize || $size[1] < $minImageSize){
			$this->message = 'Файл слишком маленький!';
		  $this->uploaded = false;
			return false;
		}
		else{
		   $this->uploaded = true;
			return true;
		}
	}

  private  function upload_dir($upload_dir, $mkdir = false) {
	 $status = true;

	 if (!is_dir($upload_dir)) {
		if ($mkdir) {
		  if (!mkdir($upload_dir)) {
			 $status = false;
		  } else {
			 if (!chmod($upload_dir, 0777)) $status = false;
		  }
		} else {
		  $status = false;
		}
	 }

	 // У вас есть каталог?
	 if (!is_dir($upload_dir)) {
		$this -> error .= '<li><strong>'.$upload_dir.'</strong> Не нашел папку с именем!</li>';
		$status = false;
	 }
	 // У вас есть права на запись в каталог?
	 if (is_dir($upload_dir) && !is_writable($upload_dir)) {
		$this -> error .= '<li><strong>'.$upload_dir.'</strong> В каталоге не существует разрешение на запись!</li>';
		$status = false;
	 }

	 if ($status) {
		$this->dir = $upload_dir;
		$this->uploaded = true;
		return true;
	 } else {
		$this -> error .= '<li><strong></strong> Нет или не могу создать папку для загрузки!</li>';
		$this->uploaded = false;
		return false;
	 }
  }

	/**
	 * Function to resieze image
	 *
	 * @return bool
	 */
	public function resize($maxThumbSize){
		list($oryginalWidth, $oryginalHeight) = getimagesize($this->tmp);
	      $mn = $oryginalWidth/230;
	      $oryginalWidth = (int)$_POST['w']*$mn;
	      $oryginalHeight = (int)$_POST['h']*$mn;
		if($oryginalWidth > $oryginalHeight){
			$thumbWidth = $maxThumbSize;
			$thumbHeight = intval($maxThumbSize*($oryginalHeight/$oryginalWidth));
		}
		else if($oryginalWidth < $oryginalHeight){
			$thumbWidth = intval($maxThumbSize*($oryginalWidth/$oryginalHeight));
			$thumbHeight = $maxThumbSize;
		}
		else{
			$thumbWidth = $maxThumbSize;
			$thumbHeight = $maxThumbSize;
		}

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
		imagecopyresampled($this->thumbImage,$sourceImage,0,0,(int)$_POST['x1']*$mn,(int)$_POST['y1']*$mn,$thumbWidth,$thumbHeight,$oryginalWidth,$oryginalHeight);
	}

  // загрузить результат отчета
  function result_report() {
	 if(isset($this -> error)) {
		echo '<ul>';
		echo $this -> error;
		echo '</ul>';
	 }
	 if ($this -> uploaded == true) {
		echo '<ul>';
		echo $this -> message;
		echo '</ul>';
	 }
  }

	/**
	 * Function to upload image
	 *
	 * @return bool
	 */
	public function upload($dir = '/tmp/', $maxThumbSize = 140, $report = false , $mkdir = false, $quality = 80, $maxFileSize = 15000000, $minImageSize = 10){
	   $this ->uploaded = true;
	   $this->upload_dir($dir, $mkdir);
	   $this->validate($maxFileSize,$minImageSize);
	   $this->resize($maxThumbSize);
		$fileExtension = explode('.',$this->name);
	//	$this->newThumbName = date("YmdHis").'_thumb.'.$fileExtension[1];
	   $this->newThumbName = 'imgNews-'.trim($_POST['newsId']).'.'.$fileExtension[1];
		if($this->type == 'image/gif'){
		  if(!imagegif($this->thumbImage, $dir.$this->newThumbName)) $this->uploaded = false;
		}
		else if($this->type == 'image/jpeg'){
		  if(!imagejpeg($this->thumbImage, $dir.$this->newThumbName, $quality)) $this->uploaded = false;
		}
		else{
		  if(!imagepng($this->thumbImage,$dir.$this->newThumbName)) $this->uploaded = false;
		}

		if($this->uploaded) $this->message = 'Файл успешно загружен!';
	   if($report) $this->result_report();
	}
}
?>
