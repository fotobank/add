<?php
/* Class name : Upload Images
* Inherited from :
* Created by : Saadi Ali (email : alito181@gmail.com)
* Created On : 9-September-2013
* Description : Class upload images with a thumbnail .

*
* How to use :
*
*  - $upload = new upload(
                        $field,  // Field images
                        $folder_img, // upload folder
                        array("JPG",'GIF','PNG'), // Allowed images Extensions
                        false, //  upload images only
                        $folder_thum, // Folder thumbnails
                        200, // width Thumbnail
                        150, // height Thumbnail
                        );
*
*  - $upload->error();  // Error checking
*  - $upload->error_ext();  // Check the image extension
*  - $upload->new_name();  //  Creation of a new name
*  - $upload->image_info(); // image Information Ex: print_r($upload->image_info())
*  - $new->up(); //  upload  if (true) Thumbnail will be loaded
*/


class upload {


  	var $folder_img;
  	var $folder_thum;
    var $new_name;

    var $error;
    var $name;
  	var $type;
  	var $size ;
  	var $tmp;

  	var $w;
  	var $h;
  	var $only;

    // -------------------
    var $extensions	=array();
   //-----------------------
  	function __construct($field,$folder_img,$exts=array(),$only=false,$them=false,$them_w=false,$them_h=false){
  		$info				=$_FILES[$field];
  		$this->name			=$info['name'];
  		$this->type			=$this->type($info['name']);
  		$this->size			=$info['size'];
  		$this->tmp			=$info['tmp_name'];
  		$this->error		=$info['error'];
  		$this->h			=$them_h;
  		$this->w			=$them_w;
  		$this->only	=$only;
  		$this->extensions($exts);
  		$this->local_images($folder_img);
  		$this->folder_thum($them);
  	}

  /*  */
  	function type($file){
 		return strtoupper(end(explode(".",$file)));
  	}

  /*  */
  	function image_info(){
  		$arr['name']	=$this->name;
  		$arr['type']	=$this->type;
  		$arr['size']	=$this->size;
  	   	return $arr;
  	}

    /*  */
  	function local_images($dir){
  		$this->folder_img=$dir;
  	}

    /*  */
  	function folder_thum($dir){
  		$this->folder_thum=$dir;
  	}

    /*  */
  	function error(){
  		return $this->error;
  	}

    /*  */
  	function extensions($exts){
  		if(count($exts)>0):

				$exts=implode("|",$exts);
				$exts=strtoupper($exts);
				foreach(explode("|",$exts) as $ext)
					{
						$this->extensions[]=$ext;
					}

		else:

				$this->extensions= array('gif','png','jpg','jpeg');

      endif;
  	}

    /*  */
  	function chack_type(){
  		if($this->only and !@getimagesize($this->tmp))return false;
  		if(in_array($this->type,$this->extensions))
			return true;
		else 
			return false;
  	}

    /*  */
  	function error_ext(){
  		if($this->chack_type())
  			return false;
		else
			return true;
  	}

    /*  */
  	function file_name($file){
  		$ext=explode(".",$file);
  		$type=end($ext);
  		unset($ext[count($ext)-1]);
  		$this->name=implode(".",$ext);
  	}

    /*  */
  	function new_name(){
  		$this->new_name=true;
  		$this->file_name($this->name);
  		$this->name=md5(sha1($this->name)).time().".".$this->type;
  	}

    /*  */
  	function name(){
  		return $this->name;
  	}

    /*  */
  	function up($Sm=false){
  		if($this->chack_type())
	  		{
	  		if(move_uploaded_file($this->tmp,$this->folder_img."/".$this->name))
  				{
	  			if($this->folder_thum!="" and $Sm==true)$this->thumbnails();
	  				return true;
  				}
			else
				return false;
				
			}
		else
			return false;
			
  	}

    /*  */
  	function thumbnails(){
  		$them=imagecreatetruecolor($this->w,$this->h);
	  	$image_p=$this->save_images();
  		$image_p_x=imagesx($image_p);
  		$image_p_y=imagesy($image_p);
  		imagecopyresampled($them,$image_p,0,0,0,0,$this->w,$this->h,$image_p_x,$image_p_y);
		$this->save_thumbnails($them);
  	}

    /*  */
  	function save_images(){
  		switch(strtolower($this->type))
  		 	{
  		 	case	'jpeg':
            	return 	imagecreatefromjpeg($this->folder_img."/".$this->name);
                break;
  		 	case	'jpg':
            	return 	imagecreatefromjpeg($this->folder_img."/".$this->name);
                break;
  			case	'gif':
            	return 	imagecreatefromgif($this->folder_img."/".$this->name);
                break;
  			case	'png':
            	return 	imagecreatefrompng($this->folder_img."/".$this->name);
                break;
  			}	
  	}

    /*  */
  	function save_thumbnails($img){
  		switch(strtolower($this->type))
  		 	{
  		 	case'jpeg':
                  return imagejpeg($img,$this->folder_thum."/".$this->name);
                  break;
  		 	case'jpg':
                  return imagejpeg($img,$this->folder_thum."/".$this->name);
                  break;
  			case'gif':
                  return imagegif($img,$this->folder_thum."/".$this->name);
                  break;
  			case'png':
                  return imagepng($img,$this->folder_thum."/".$this->name);
                  break;
  			}	
  	}

  }
  
?>