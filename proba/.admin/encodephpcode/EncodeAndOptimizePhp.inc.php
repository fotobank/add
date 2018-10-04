<?php

/**
 * Class to encode and optimize any php code
 * Later on you can decode it as it was
 *
 * @author Rochak Chauhan
 *
 * Note: If you have any html tags inside echo / print/ die .....
 *		 then make sure that you enclose the echo /print/dir statements with " and not '
 */

class EncodeAndOptimizePhp {
	private $encodedFileContents = '';

	/**
	 * Function to convert string into hexadecimal
	 *
	 * @access private
	 * @param $content - string
	 *
	 * @return string - string in hexadecimal
	 */
	private function convertToHex($contents) {
		$outputStr="";

		$contents = str_replace('$', ' $',$contents);
		$wordArray = explode(' ', $contents);
		
		for($i=0; $i<count($wordArray); $i++) {
			if( trim($wordArray[$i]) != '') {

				if($wordArray[$i][0] == '$') {
					$outputStr .= $wordArray[$i];
				}
				else {
					for($count=0; $count<strlen($wordArray[$i]); $count++) {
						$outputStr .= '\x'.dechex(ord($wordArray[$i][$count]));
					}
				}
			}
			$outputStr .= '\x20';
		}
		return $outputStr;
	}

	/**
	 * Function to encrypt everything betwen echo statement in hexadecimal
	 *
	 * @access private
	 * @param $fileContents - string
	 *
	 * @return string
	 */
	 private function encodePhpCode($fileContents) {
		 $matches = Array();
		 
		 if (preg_match("/.*echo[\s]+\"(.*)\"/", $fileContents, $matches) || preg_match("/.*echo[\s]+\'(.*)\'/", $fileContents, $matches) || preg_match("/.*print+\(\"(.*)\"\)/",$fileContents,$matches) || preg_match("/.*print+\(\'(.*)\'\)/",$fileContents,$matches) || preg_match("/.*die+\(\"(.*)\"\)/",$fileContents,$matches) || preg_match("/.*die+\(\'(.*)\'\)/",$fileContents,$matches)) {
			 $newFileContents = $this->convertToHex($matches[1]);				
			 return str_replace($matches[1], $newFileContents, $fileContents);
		 }
		 else {
			 return $fileContents;		 
		 }
	 }

	 /**
	  * Function to encode a php file
	  *
	  *
 	  * @access public
	  * @param $fileName string - full path of the php file
	  *
	  * @return boolean true is encoded file is created successfully , false otherwise
	  */
	  public function encodePhpFile($fileName) {
		if(file_exists($fileName)) {
			  if($this->optimizePhpFile($fileName)) {
				  $fileContentsArray = explode("\r\n",$this->optimizedFileContents);
				  for($i=0; $i<count($fileContentsArray); $i++) {
					  $this->encodedFileContents .= $this->encodePhpCode($fileContentsArray[$i])."\r\n";
				  }
			  }
			  else{ 
				  trigger_error("Failed to optimize file on Line:".__LINE__, E_USER_ERROR);
				  exit;
			  }
		  }
		  else {
			 trigger_error("Invalid file name. File does not exist.", E_USER_ERROR);
			 exit;
		  }
		$this->createEncodedFile($fileName);
	  }

	/**
	 * Function to create the encoded php file
	 *
	 *
	 * @access private
	 * @param $fileName string - fill path of the original php file
	 *
	 * @return boolean 
	 */
	private function createEncodedFile($fileName) {
		$fileNameExtention = end(explode(".", trim($fileName)));

		$encodedFilePath =  str_replace($fileNameExtention, "encoded.php", $fileName);
		
		$fpEncode = fopen($encodedFilePath, 'w');
		$phpCodeToBeWritten = $this->removeComments(trim($this->encodedFileContents));

		if( $fpEncode ) {
			fwrite($fpEncode, $phpCodeToBeWritten) or die("<b>ERROR: </b> Failed to write contents in the new encoded file.");
		}
		else {
			trigger_error("Failed to open file for writing.", E_USER_ERROR);
			exit;
		}
	}
	
	/**
	 * Function to optimize php file
	 *
	 *
	 * @access private
	 * @param $fileName string
	 *
	 * @return boolean - true on success
	 */
	private function optimizePhpFile($fileName) {
		$charPos = 0;
		if(!file_exists($fileName)) {
			trigger_error("Invalid file name. File does not exist.", E_USER_ERROR);
			exit;
		}
		else {
			$fileContentsArray = file($fileName);
			for($i=0; $i<count($fileContentsArray); $i++) {
				
				if(trim($fileContentsArray[$i]) == '') {
					$this->arrayOfChanges[] = 'emptyLine';
				}
				else{
					$whiteSpaces = '';
					for($j=0; $j<strlen($fileContentsArray[$i]); $j++) {
						if(ord($fileContentsArray[$i][$j]) != 9 || ord($fileContentsArray[$i][$j]) != 32) {
							break;
						}
						else {
							$whiteSpaces .= $fileContentsArray[$i][$j];
						}
					}
					$this->optimizedFileContents .= " ".trim($fileContentsArray[$i])."\r\n";
				}
			}						
		}
		return true;
	}

	/** 
	 * Function to remove all multiline comments from the phpcode
	 *
	 * @param $phpCode string
	 *
	 * @return string
	 */
	 private function removeComments($phpCode) {

		$returnCode = str_replace('/*', '$|$|$/*', $phpCode);
		$returnCode = str_replace('*/', '*/|$|', $returnCode);


		$tempArray = explode('$|$|$', $returnCode);

		$return = '<?php';
		foreach($tempArray as $temp) {
			$arr = explode("|$|", $temp);
			if(trim($arr[0][0]) == '/') {
				$return .= $arr[1];				
			}
		}
		return $return;
	}
}
?>