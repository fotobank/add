<?php
/**
 * Image uploader Class
 */
class ImageUploader {


       private $uploaded = false;
       public $name;
       public $type;
       public $size;
       public $tmp;
       public $error;
       public $thumbImage;
       public $message;
       public $newFullName;
       public $newThumbName; // ��� ��������� �����
       public $upload_dir; // ����� ��� ��������
       public $width_load; // ������ ������ �������� ��� ������
       public $maxThumbSize; // ������ �������� ��������
       public $report = true; // ����� ������
       public $mkdir = false; // ������� ����� (��� ����������)
       public $quality = 80; // �������� ��������
       public $maxFileSize = 15000000; // max ��� ��������
       public $minImageSize = 10; // min ��� ��������
       /**
        * Function to initialize variables
        *
        * @param $data
        */
       public function __construct($data) {

              global $_FILES;
              $this->error = ($_FILES['image_file']['error'] != 0) ? $_FILES['image_file']['error'] : NULL;
              if ($this->error != 0) {
                     $this->message = $this->error;
                     $this->message;

                     return false;
              } else {
                     $this->name = $_FILES['image_file']['name'];
                     $this->type = $_FILES['image_file']['type'];
                     $this->size = $_FILES['image_file']['size'];
                     $this->tmp  = $_FILES['image_file']['tmp_name'];
                     $this->newThumbName = $data["newThumbName"];
                     $this->upload_dir   = $data["upload_dir"];
                     $this->width_load   = $data["width_load"];
                     $this->maxThumbSize = $data["maxThumbSize"];

                     return true;
              }
       }


       /**
        * Function to Check the uploaded file
        *
        * @return bool
        */
       private function validate() {

              if ($this->type != 'image/jpeg' && $this->type != 'image/gif' && $this->type != 'image/png') {
                     $this->message  = '�������������  ������ �����!';
                     $this->uploaded = false;

                     return false;
              }
              if ($this->size > $this->maxFileSize) {
                     $this->message  = '���� ������� �������!';
                     $this->uploaded = false;

                     return false;
              }
              $size = getimagesize($this->tmp);
              if ($size[0] < $this->minImageSize || $size[1] < $this->minImageSize) {
                     $this->message  = '���� ������� ���������!';
                     $this->uploaded = false;

                     return false;
              } else {
                     $this->uploaded = true;

                     return true;
              }
       }


       /**
        * @return bool
        */
       private function upload_dir() {

              $this->uploaded = true;
              if (!is_dir($this->upload_dir)) {
                     if ($this->mkdir) {
                            if (!mkdir($this->upload_dir)) {
                                   $this->uploaded = false;
                            } else {
                                   if (!chmod($this->upload_dir, 0777)) $this->uploaded = false;
                            }
                     } else {
                            $this->uploaded = false;
                     }
              }
              // � ��� ���� �������?
              if (!is_dir($this->upload_dir)) {
                     $this->error .= '<li><strong>'.$this->upload_dir.'</strong> �� ����� ����� � ������!</li>';
                     $this->uploaded = false;
              }
              // � ��� ���� ����� �� ������ � �������?
              if (is_dir($this->upload_dir) && !is_writable($this->upload_dir)) {
                     $this->error .= '<li><strong>'.$this->upload_dir.'</strong> � �������� �� ���������� ���������� �� ������!</li>';
                     $this->uploaded = false;
              }
              if (!$this->uploaded) {
                     $this->error .= '<li><strong></strong> ��� ��� �� ���� ������� ����� ��� ��������!</li>';

                     return false;
              } else {
                     return true;
              }
       }



       /**
        * Function to resieze image
        *
        * @return bool
        */
       public function resize() {

              list($oryginalWidth, $oryginalHeight) = getimagesize($this->tmp);
              $mn             = $oryginalWidth / $this->width_load;
              $oryginalWidth  = (int)$_POST['w'] * $mn;
              $oryginalHeight = (int)$_POST['h'] * $mn;
              if ($oryginalWidth > $oryginalHeight) {
                     $thumbWidth  = $this->maxThumbSize;
                     $thumbHeight = intval($this->maxThumbSize * ($oryginalHeight / $oryginalWidth));
              } else if ($oryginalWidth < $oryginalHeight) {
                     $thumbWidth  = intval($this->maxThumbSize * ($oryginalWidth / $oryginalHeight));
                     $thumbHeight = $this->maxThumbSize;
              } else {
                     $thumbWidth  = $this->maxThumbSize;
                     $thumbHeight = $this->maxThumbSize;
              }
              $this->thumbImage = imagecreatetruecolor($thumbWidth, $thumbHeight);
              if ($this->type == 'image/gif') {
                     $sourceImage = imagecreatefromgif($this->tmp);
              } else if ($this->type == 'image/jpeg') {
                     $sourceImage = imagecreatefromjpeg($this->tmp);
              } else {
                     $sourceImage = imagecreatefrompng($this->tmp);
              }
              if (imagecopyresampled($this->thumbImage, $sourceImage, 0, 0, (int)$_POST['x1'] * $mn, (int)$_POST['y1'] * $mn,
                     $thumbWidth, $thumbHeight, $oryginalWidth, $oryginalHeight)
              ) {
                     $this->uploaded = true;

                     return true;
              } else {
                     $this->uploaded = false;

                     return false;
              }
       }



       // ��������� ��������� ������
       function result_report() {

              if (isset($this->error)) {
                     echo '<ul>';
                     echo $this->error;
                     echo '</ul>';
              }
              if ($this->uploaded == true) {
                     echo '<ul>';
                     echo $this->message;
                     echo '</ul>';
              }
       }


       /**
        * Function to upload image
        *
        * @return bool
        */
       public function upload() {

              $this->uploaded = true;
              $this->upload_dir();
              $this->validate();
              $this->resize();
              if ($this->type == 'image/gif') {
                     if (!imagegif($this->thumbImage, $this->upload_dir.$this->newThumbName)) $this->uploaded = false;
              } else if ($this->type == 'image/jpeg') {
                     if (!imagejpeg($this->thumbImage, $this->upload_dir.$this->newThumbName, $this->quality)) $this->uploaded = false;
              } else {
                     if (!imagepng($this->thumbImage, $this->upload_dir.$this->newThumbName)) $this->uploaded = false;
              }
              if ($this->uploaded) $this->message = '���� ������� ��������!';
              if ($this->report) $this->result_report();
       }

}
?>
