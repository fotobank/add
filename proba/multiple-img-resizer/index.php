<?php
/**
* @ Faizan Ahmed John courtesy to Jarrod Oberto
* @ website My Site: www.asktoknow.net
* Multiple Image Resizer
* @author Faizan Ahmed John
* @copyright 2011
* @version 1.0
* @access public
* @License GPL
*/

	set_time_limit(0);
	// *** Include the class
	require_once("resize-class.php");

	/* Set the image path and the size you required */

	define(imagesDir ,"thumbnails"); 	/* All images will be resized retaining the Aspect Ratio */
	define(resizedDir,imagesDir."/resized_images"); 							/* Set Desired Image dir : Optional */
	define(img_width,"150");   													/* Set Desired Image Width : Keeping in mind the Aspect Ratio */
	define(img_height,"250");  													/* Set Desired Image Height : Keeping in mind the Aspect Ratio */


	//echo '<pre>';
	resizeProductImagesRecursive(imagesDir);
	echo "<span style='font-weight:bold; font-size:15px;color:green;'>Done...<br />All images Resized.</span><br /> Please check the Directory: <span style='font-weight:bold; font-size:20px;color:#245ddb;'>".resizedDir."</span>";

function resizeProductImagesRecursive($directory, $filter=FALSE)
{
		$total_images = 0;
		// if the path has a slash at the end we remove it here
		if(substr($directory,-1) == '/')
		{
			$directory = substr($directory,0,-1);
		}
		// if the path is not valid or is not a directory ...
		if(!file_exists($directory) || !is_dir($directory))
		{
			// ... we return false and exit the function
			return FALSE;
	
		// ... else if the path is readable
		}elseif(is_readable($directory))
		{
	
			// initialize directory tree variable
			$directory_tree = array();
	
			// we open the directory
			$directory_list = opendir($directory);
	
			// and scan through the items inside
			while (FALSE !== ($file = readdir($directory_list)))
			{
				// if the filepointer is not the current directory
				// or the parent directory
				if($file != '.' && $file != '..')
				{
					// we build the new path to scan
					$path = $directory.'/'.$file;
	
					// if the path is readable
					if(is_readable($path))
					{
						// we split the new path by directories
						$subdirectories = explode('/',$path);
	
						// if the new path is a directory
						if(is_dir($path))
						{
							resizeProductImagesRecursive($path, $filter);
	
						// if the new path is a file
						}elseif(is_file($path))
						{
							// get the file extension by taking everything after the last dot
						   $nameExt = explode('.',end($subdirectories));
							$extension = end($nameExt);
							$currentWorkingDir = $subdirectories;
							unset( $currentWorkingDir[count($currentWorkingDir)-1] );
					//		$currentWorkingDir = implode('/',$currentWorkingDir);
							// if there is no filter set or the filter is set and matches
							if($filter === FALSE || $filter == $extension)
							{
									if( strpos($path,'.svn' ) || strpos($path,'.db' ) ||  strpos($path,'list' ) ||  strpos($path,'thumnails' ))continue;
									/*echo 'Path:'.$path;
									echo '<br>';
									echo 'Working Directory:'.$currentWorkingDir;
									echo '<br>';
									echo 'name:'.end($subdirectories);
									echo '<br>';
									echo 'extension:'.$extension;
									echo '<br>';
									echo 'size:'.filesize($path);
									echo '<br>';
									echo 'kind:'.'File';
									echo '<br>';*/
									$total_images += 1; 
									/*RESIZE IMAGE USING CLASS*/
									//Get the file extension
									$fileName = end($subdirectories);
									$currentFileName = explode('.', $fileName );
									$currentFileName[0] = $currentFileName[0].'_'.img_width;
									$currentFileName = implode('.',$currentFileName);
									//echo '<hr>';
									
									if(!is_dir(resizedDir))
									{
										mkdir(resizedDir, 0777, TRUE);
									}
																	
									//Initialise / load image
									$resizeObj = new resize($path);
									
									//Resize image (options: exact, portrait, landscape, auto, crop)
									$resizeObj -> resizeImage(img_width, img_height, 'auto');
									//Save image
									$resizeObj -> saveImage( resizedDir."/".$fileName , img_width);								
							}
						}
					}
				}
			}
			// close the directory
			closedir($directory_list);
	
			// return file list
			//echo $total_images;
			return $directory_tree;
	
		// if the path is not readable ...
		}else{
			// ... we return false
			return FALSE;
		}
}
// ------------------------------------------------------------
?>
