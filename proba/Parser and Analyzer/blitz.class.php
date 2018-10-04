<?php
/***************************************************************************************
 * Blitz Multi-Byte HTML Analyzer & Parser 
 * Blitz is a PHP class written specifically for parsing and analyzing  HTML and XHTML 
 * with multi-byte character handling without compromising performance
 * 
 * Blitz HTML Parser & Analyzer Class provides functions to retrieve document encoding, Base url,    
 * Hyperlinks with their titles and text, Images with their ALT tags, Text in the document, 
 * Text in <title> or <h1> tag, contents of Meta tags.
 * 
 * Blitz HTML Parser & Analyzer can also find all keywords in the html docuemnt and the keyword density. 
 * Interestingly this class can also prepare array of weighted keywords, in which keywords can have 
 * different weights depending on their position, Like a keyword in <title> or <h1> or keywords in hyperlinks or Image ALT tag can have more weight 
 * that same keyword in normal text.
 * keyword weight for html = no. of occurrences X weight for one occurrences(single weight) 
 * 
 * We can easily define keyword weights for position in each tag and then we get Array of all keywords and their weights.
 * This is particularly helpful in indexing keywords in the html document for search engines.
 * Blitz HTML Parser & Analyzer can also fix syntax of incorrect HTML very fast.
 * 
 * Author: Sameer Shelavale
 * Email: sameer@possible.in
 * website: http://possible.in
 * License: GNU GPL, You should keep Package name, Class name, Author name, Email and website credits.
 * PHP Version: Tested on PHP 5.2.5 but should work on all versions PHP5+
 * Dependencies : php_mbstring  
 ****************************************************************************************/

class Blitz{
	var $mode = "single-byte";		// "single-byte" or "multi-byte"
	
	var $dom;						//variable for DOMDocuemnt object 
	var $stripedDom;				//stripped version of $dom used to find text in the html( tags like style, script etc will be stripped )
	var $baseUrl;					//To be implemented
	var $encoding;					//detected encoding of the docuemnt
	var $stopWords;
	
	var $stripTags;					// tags to be stripped for finding text content in the document 
	var $wordWeights;				//weights for each occurance of a word in tags(h1, title, links, metaTitle, metaKeywords, metaDescription, alt )
	var $defaultWeight = 1;			//default weight for any keyword
	var $minWordLength = 3;			//minimum length of a keyword
	var $maxWordLength = 25;		//maximum length of a keyword
	var $wordRegEx     = '\w'; // ending and trailing / and word lengths will be added in Strin2Words() function
										  //change this regex to allow more characters in the words
	
	/***********************************************************************************
	 * Function HTMLBlitz 
	 * Description: This is constructor and just initializes variables to their default values 
	 ***********************************************************************************/
	function Blitz( $mode='multi-byte' ){
		global $_stopWords;
		
		$this->mode = $mode;
		$this->stopWords = array();
		if( $this->mode != 'multi-byte' ){
			$this->stopWords = $_stopWords;
		}else{
			//encode stopwords to base64 as they will be matched against base64 encoded multi-byte words from document 
			foreach($_stopWords As $w ){
				$this->stopWords[] = base64_encode($w);
			}
			
		}
		
		$this->dom = new DOMDocument();
		$this->strip = array( 'script'=>true, 'style'=>true, 'object'=>true, 'embed'=>true  );
		$this->wordWeights = array( 'h1'=>5, 'title'=>1, 'links'=>0, 'linkTitle'=>1, 'metaTitle'=>1, 'metaKeywords'=>1, 'metaDescription'=>1, 'alt'=>1  );
		$this->baseUrl = false;
		$this->stripedDom = false;
		
	}
	
	
	/***********************************************************************************
	 * Function LoadHTML()
	 * Description: This loads HTML as string and initializes DOMDocument object for it.
	 * Parameters:	$html - can be any string containing html
	 * 				$baseUrl - the url from where the html is retrieved (optional)
	 * 				$strp - array of tag names as keys to strip off to find text contents in document
	 * 				$weights - array of positions and weight of keywords in it
	 * 							supporeted positions are
	 * 							h1, title, links, linkTitle, metaTitle, metaKeywords, metaDescription, alt
	 * 							if weight is 0 for attributes(linkTitle, metaTitle, metaKeywords, metaDescription, alt) then keywords in that attribute will not be considered
	 * 							if weight is 0 for tags(h1, title, links) then keywords in them will not receive any extra weight and will be counted only once
	 * 							if weight is 1 or more for tags(h1, title, links) then keywords in them will receive additional weight 
	 * 
	 ***********************************************************************************/
	function LoadHTML(	$html, 
						$baseUrl=false, 
						$strp = array( 'script'=>true, 'style'=>true, 'object'=>true, 'embed'=>true  ),
						$weights = array( 'h1'=>1, 'title'=>1, 'links'=>0, 'linkTitle'=>1, 'metaTitle'=>1, 'metaKeywords'=>1, 'metaDescription'=>1, 'alt'=>1  )  
						){
		
		$this->stripTags = $strp;
		$this->baseUrl = false;
		$this->stripedDom = false;
		$this->wordWeights = $weights;
		
		//initial load
		$this->dom->loadHTML( $html );
		
		if( $this->mode == 'multi-byte' ){
			//check if encoding is specified in the document
			if( empty($this->dom->encoding) ){
				//if charset encoding in not specified in the document then detect it
				if (!empty($html)) {
					$this->encoding  = mb_detect_encoding($html);
		        }
			}else{
				$this->encoding = $this->dom->encoding;
			}
			
			mb_internal_encoding($this->encoding);
			
			//convert the html entities as per the detected encoding
			$mbHtml = mb_convert_encoding($html, 'HTML-ENTITIES', $this->encoding);
			
			//add a white space before block level elements to properly seperate words 
			$mbHtml = mb_eregi_replace('<(div|option|ul|li|table|tr|td|th|input|select|textarea|form)', ' <\\1', $mbHtml );
			
			//load the converted html
			
			$this->dom->loadHTML( $mbHtml );
		}else{
			//add a white space before block level elements to properly seperate words
			$sbHtml = preg_replace('/<(div|option|ul|li|table|tr|td|th|input|select|textarea|form)/i', " <\$1", $html );
			$this->dom->loadHTML( $sbHtml );
			$this->encoding = $this->dom->encoding;
		}
	}


	/***********************************************************************************
	 * Function Analyze()
	 * Description: returns array containing full analysis of html 
	 * 				the array keys are
	 * 				encoding 	- document encoding 
	 * 				doctype 	- array containing doctype info
	 * 				meta		- content of Meta tags in array
	 * 				title		- text in <title>
	 * 				links		- array of hyperlinks with each element having 'href','title','text' as keys
	 * 				images		- array of image urls with each image having 'src', 'alt' as keys
	 * 				text		- text content of the <body>
	 * 
	 *  			words		- an array of unique words in different parts of document
	 *  						  It has following keys
	 *  						h1		- sorted keyword density array of words in <h1> 	
	 *  						title	- sorted keyword density array of words in <title>
	 *  						a 		- sorted keyword density array of words in <a>
	 *  						a_title	- sorted keyword density array of words in title attribute of hyperlinks
	 *  						img_alt	- sorted keyword density array of words in image al attributes
	 *							density - sorted keyword density array of all words in the document
	 *							weights - sorted array of words and their weight						
	 *  							
	 ***********************************************************************************/	
	function Analyze(){
		$result = array();
		$result['encoding'] = $this->GetEncoding();
		$result['doctype'] = $this->GetDocType();
		$result['base'] = $this->GetBaseUrl();
		$result['meta'] = $this->GetMeta();
		$result['title'] = $this->GetPageTitle();
		$result['links'] = $this->GetLinks();
		$result['images'] = $this->GetImages();
		$result['text'] = $this->GetText();
		
		$result['words']['h1'] = $this->GetH1Words();
		$result['words']['title'] = $this->GetTitleWords();
		$result['words']['a'] = $this->GetLinkedWords();
		$result['words']['a_title'] = $this->GetLinkTitleWords();
		$result['words']['img_alt'] = $this->GetAltWords();
		
		$result['words']['weights'] = $this->GetWeightedWords();
		$result['words']['density'] = $this->GetWordDensity();
		
		return $result;
	}
	
	
	
	/***********************************************************************************
	 * Function GetEncoding()
	 * Description: returns the document encoding 
	 * 
	 ***********************************************************************************/	
	function GetEncoding(){
		return $this->encoding;
	}
	
	
	
	/***********************************************************************************
	 * 	Function GetDocType()
	 *  Description: returns the array containing DOCTYPE info
	 *  
	 ***********************************************************************************/
	function GetDocType(){
		$result['name'] = $this->dom->doctype->name;
		$result['publicId'] = $this->dom->doctype->publicId;
		$result['systemId'] = $this->dom->doctype->systemId;
		return $result;
	}
	
	

	/***********************************************************************************
	 * 	Function GetMeta()
	 *  Description: 	returns array of meta tags
	 *  				each element in the array relates to one meta tag 
	 *  				and has 'name', 'content', 'http-equiv' as array keys
	 *  
	 ***********************************************************************************/
	function GetMeta(){
		//get Meta tags
		$meta = array();
		$elementList = $this->dom->getElementsByTagName('meta');
		for( $i=0; $i < $elementList->length; $i++ ){
			//$node = $elementList->item($i)->attributes->getNamedItem('name')->value  ;
			$m = array();
			$m['name'] = $elementList->item($i)->attributes->getNamedItem('name')->value;
			$m['content'] = $elementList->item($i)->attributes->getNamedItem('content')->value;
			$m['http-equiv'] = $elementList->item($i)->attributes->getNamedItem('http-equiv')->value;
			$meta[$m['name']] = $m;
		}
		
		return $meta;
	}
	
	
	
	/***********************************************************************************
	 * Function GetPageTitle()
	 * Description: Returns Page title in the <title> tag
	 * 
	 ***********************************************************************************/
	function GetPageTitle(){
		//Get Page Title
		$elementList = $this->dom->getElementsByTagName('title');
		return  $elementList->item(0)->textContent;
	}
	
	
	
	/************************************************************************************
	 *	Function GetBaseUrl()
	 *	Description:	returns the base url for the document if specified in <base> tag 
	 *					else returns empty string 
	 *
	 ************************************************************************************/
	function GetBaseUrl(){
		//check Page Base url
		$base = '';
		$elementList = $this->dom->getElementsByTagName('base');
		for( $i=0; $i < $elementList->length; $i++ ){
			if( isset($elementList->item($i)->attributes->getNamedItem('href')->value) ){
				$base = $elementList->item($i)->attributes->getNamedItem('href')->value;
			}
		}
		return trim($base);
	}
	
	/************************************************************************************
	 *	Function GetLinks()
	 *	Description:	Returns array of all the hyperlinks in the html provided
	 *					Please note that this does not include hyperlinks in comments
	 *					Each element contains following keys
	 *					'href'  - the url ( this can be relative url or full url and needs validation)
	 *					'title' - titles for links( the title attribute )
	 *					'text'  - the linked text/phrase
	 * 
	 ************************************************************************************/
	function GetLinks(){
		//get page links
		$links = array();
		$elementList = $this->dom->getElementsByTagName('a');
		for( $i=0; $i < $elementList->length; $i++ ){
			//eliminate javascript calls in hyperlinks and hyperlinks with just #
			if( !preg_match( "/(javascript:|\A#\Z)/",$elementList->item($i)->attributes->getNamedItem('href')->value )){
				$links[$i]['href']	= $elementList->item($i)->attributes->getNamedItem('href')->value;  
				$links[$i]['title'] = $elementList->item($i)->attributes->getNamedItem('title')->value;
				$links[$i]['text']	= $elementList->item($i)->textContent;
			}
		}
		return $links;
	}
	
	
	/************************************************************************************
	 *	Function  GetImages()
	 *	Description:	Returns array of urls of Images in the document, all images and their alt tags
	 *					Each element of array contains following keys
	 *					'src' - image url
	 *					'alt' - description in alt tag if specified else empty string
	 * 
	 ************************************************************************************/
	function GetImages(){
		//get page images
		$images = array();
		$elementList = $this->dom->getElementsByTagName('img');
		for( $i=0; $i < $elementList->length; $i++ ){
			$images[$i]['src'] = $elementList->item($i)->attributes->getNamedItem('src')->value;  
			$images[$i]['alt'] = $elementList->item($i)->attributes->getNamedItem('alt')->value;
		}
		return $images;
	}
	
	
	
	/************************************************************************************
	 *	Function GetText()
	 *	Description:	Returns the text content within  <body> tag 
	 * 
	 ************************************************************************************/
	function GetText(){
		//Get Page Text
		if(!$this->stripedDom ){
			$this->StripTags();
		}
		$elementList = $this->stripedDom->getElementsByTagName('body');
		return $elementList->item(0)->nodeValue;
	}
	
	
	
	/************************************************************************************
	 *	Function GetWords()
	 *	Description:	returns array of unique words in the <body> tag of html with the number of occurances
	 *					in short it returns the array of keywords sorted by density 
	 *					each element is array with 'keyword' and 'count' as keys
	 *  				This is a wrapper for _GetWords() to get clean list of words 
	 ************************************************************************************/
	function GetWords(){
		$words = $this->_GetWords();
		$finalWords = array();
		foreach( $words As $w=>$c ){
			if( $this->mode != 'multi-byte' ){
				//save to array
				$finalWords[] = array('word'=>$w, 'count'=>$c) ;
			}else{
				//decode base64 encoded multi-byte words and save to array
				$finalWords[] = array('word'=>base64_decode( $w ), 'count'=>$c) ;
			}
		}
		return $finalWords;
	}
	
	
	/************************************************************************************
	 *	Function _GetWords()
	 *	Description:	returns array of unique words in the <body> tag of html with the number of occurances
	 *					it returns the array of keywords sorted by density 
	 *					each element key is keyword(base64 encoded for multi-byte) 
	 *					and value is the density or number of occurances
	 *  
	 ************************************************************************************/
	protected function _GetWords(){
		
		//Get words in document
		//$words =  array_count_values( array_diff(array_walk(str_word_count($text, 1), 'lowercase') , $this->stopWords )) ;
		$words =  array_count_values( array_diff( $this->String2Words($this->GetText()) , $this->stopWords )) ;
		arsort( $words );
		reset( $words );
		
		return $words;
	}
	
	
	
	/*************************************************************************************
	 * 	Function GetH1Words()
	 * 	Description:	Get array of unique keywords in H1 with their density
	 * 					in short it returns the array of keyword density in <h1> tag
	 *					each element is array with 'keyword' and 'count' as keys  
	 * 					This is a wrapper for _GetH1Words to get clean list of words 
	 *************************************************************************************/
	function GetH1Words(){
		$words = $this->_GetH1Words();
		//construct final array of words with their densities
		$finalWords = array();
		foreach( $words As $w=>$c ){
			if( $this->mode != 'multi-byte' ){
				//save to array
				$finalWords[] = array('word'=>$w, 'count'=>$c) ;
			}else{
				//decode base64 encoded multi-byte words and save to array
				$finalWords[] = array('word'=>base64_decode( $w ), 'count'=>$c) ;
			}
		}
		return $finalWords;
	}
	
	
	/*************************************************************************************
	 * 	Function _GetH1Words()
	 * 	Description:	Get array of unique keywords in H1 with their density
	 * 					in short it returns the array of keyword density in <h1> tag
	 *					each element key is keyword(base64 encoded for multi-byte) 
	 *					and value is the density or number of occurances
	 * 
	 *************************************************************************************/
	protected function _GetH1Words(){
		//Get Text in H1
		$elementList = $this->dom->getElementsByTagName('h1');
		$h1Text = $elementList->item(0)->textContent;
		//Get words 
		$h1Words =  array_count_values( array_diff( $this->String2Words($h1Text) , $this->stopWords )) ;
		arsort( $h1Words );
		reset( $h1Words );
		
		return $h1Words;
	}
	
	
	
	/*************************************************************************************
	 * 	Function GetTitleWords()
	 * 	Description:	Get array of unique keywords in Title with their density
	 * 					in short it returns the array of keyword density in <title> tag
	 *					each element is array with 'keyword' and 'count' as keys
	 *  				This is a wrapper for _GetTitleWords() to get clean list of words	 
	 *************************************************************************************/
	function GetTitleWords(){
		
		$words = $this->_GetTitleWords();
		//construct final array of words with their densities
		$finalWords = array();
		foreach( $words As $w=>$c ){
			if( $this->mode != 'multi-byte' ){
				//save to array
				$finalWords[] = array('word'=>$w, 'count'=>$c) ;
			}else{
				//decode base64 encoded multi-byte words and save to array
				$finalWords[] = array('word'=>base64_decode( $w ), 'count'=>$c) ;
			}
		}
		return $finalWords;
	}
	
	
	/*************************************************************************************
	 * 	Function _GetTitleWords()
	 * 	Description:	Get array of unique keywords in Title with their density
	 * 					in short it returns the array of keyword density in <title> tag
	 *					each element key is keyword(base64 encoded for multi-byte) 
	 *					and value is the density or number of occurances
	 *************************************************************************************/
	function _GetTitleWords(){
		
		//Get words in page Title
		$titleWords =  array_count_values( array_diff( $this->String2Words($this->GetPageTitle()) , $this->stopWords )) ;
		arsort( $titleWords );
		reset( $titleWords );
		
		return $titleWords;
	}
	
	
	
	/*************************************************************************************
	 * 	Function GetLinkedWords()
	 * 	Description:	Get array of unique keywords in Hyperlinks with their density
	 * 					in short it returns the array of keyword density in <a> tag
	 * 					Note that this does not include the words in link title(title attribute)
	 *					each element is array with 'keyword' and 'count' as keys
	 *  				This is a wrapper for _GetLinkedWords() to get clean list of words	 
	 *************************************************************************************/
	function GetLinkedWords(){
		
		$words = $this->_GetLinkedWords();
		//construct final array of words with their densities
		$finalWords = array();
		foreach( $words As $w=>$c ){
			if( $this->mode != 'multi-byte' ){
				//save to array
				$finalWords[] = array('word'=>$w, 'count'=>$c) ;
			}else{
				//decode base64 encoded multi-byte words and save to array
				$finalWords[] = array('word'=>base64_decode( $w ), 'count'=>$c) ;
			}
		}
		return $finalWords;
	}
	
	
	/*************************************************************************************
	 * 	Function _GetLinkedWords()
	 * 	Description:	Get array of unique keywords in Hyperlinks with their density
	 * 					in short it returns the array of keyword density in <a> tag
	 * 					Note that this does not include the words in link title(title attribute)
	 *					each element key is keyword(base64 encoded for multi-byte) 
	 *					and value is the density or number of occurances
	 *************************************************************************************/
	function _GetLinkedWords(){
		
		$elementList = $this->dom->getElementsByTagName('a');
		$linkTexts = '';
		for( $i=0; $i < $elementList->length; $i++ ){
			$linkTexts .= $elementList->item($i)->textContent. ' ';  
		}
		return  array_count_values( array_diff( $this->String2Words($linkTexts) , $this->stopWords )) ;

	}
	
	
	
	/*************************************************************************************
	 * 	Function GetLinkTitleWords()
	 * 	Description:	Get array of unique keywords in Hyperlinks Titles(title attribute) with their density
	 * 					in short it returns the array of keyword density in 'title' attribute of <a> tag
	 *					each element is array with 'keyword' and 'count' as keys
	 *  				This is a wrapper for _GetLinkTitleWords() to get clean list of words
	 *************************************************************************************/
	function GetLinkTitleWords(){
		
		$words = $this->_GetLinkTitleWords();
		//construct final array of words with their densities
		$finalWords = array();
		foreach( $words As $w=>$c ){
			if( $this->mode != 'multi-byte' ){
				//save to array
				$finalWords[] = array('word'=>$w, 'count'=>$c) ;
			}else{
				//decode base64 encoded multi-byte words and save to array
				$finalWords[] = array('word'=>base64_decode( $w ), 'count'=>$c) ;
			}
		}
		return $finalWords;
	}
	
	
	
	/*************************************************************************************
	 * 	Function _GetLinkTitleWords()
	 * 	Description:	Get array of unique keywords in Hyperlinks Titles(title attribute) with their density
	 * 					in short it returns the array of keyword density in 'title' attribute of <a> tag
	 *					each element key is keyword(base64 encoded for multi-byte) 
	 *					and value is the density or number of occurances
	 *************************************************************************************/
	function _GetLinkTitleWords(){
		
		$elementList = $this->dom->getElementsByTagName('a');
		$linkTitleTexts = '';
		for( $i=0; $i < $elementList->length; $i++ ){
			$linkTitleTexts .= $elementList->item($i)->attributes->getNamedItem('title')->value. ' ';  
		}
		return  array_count_values( array_diff( $this->String2Words($linkTitleTexts) , $this->stopWords )) ;
	}
	
	
	
	/*************************************************************************************
	 * 	Function GetAltWords()
	 * 	Description:	Get array of unique keywords in image ALT attribute with their density
	 * 					in short it returns the array of keyword density in 'alt' attribute of <img> tag
	 *					each element is array with 'keyword' and 'count' as keys
	 *  				This is a wrapper for _GetAltWords() to get clean list of words
	 *************************************************************************************/
	function GetAltWords(){
		
		$words = $this->_GetAltWords();
		//construct final array of words with their densities
		$finalWords = array();
		foreach( $words As $w=>$c ){
			if( $this->mode != 'multi-byte' ){
				//save to array
				$finalWords[] = array('word'=>$w, 'count'=>$c) ;
			}else{
				//decode base64 encoded multi-byte words and save to array
				$finalWords[] = array('word'=>base64_decode( $w ), 'count'=>$c) ;
			}
		}
		return $finalWords;
	}
	
	
	
	/*************************************************************************************
	 * 	Function _GetAltWords()
	 * 	Description:	Get array of unique keywords in image ALT attribute with their density
	 * 					in short it returns the array of keyword density in 'alt' attribute of <img> tag
	 *					each element key is keyword(base64 encoded for multi-byte) 
	 *					and value is the density or number of occurances
	 *************************************************************************************/
	function _GetAltWords(){
		
		$elementList = $this->dom->getElementsByTagName('img');
		$altTexts = '';
		for( $i=0; $i < $elementList->length; $i++ ){
			$altTexts .= $elementList->item($i)->attributes->getNamedItem('alt')->value. ' ';  
		}
		return  array_count_values( array_diff( $this->String2Words($altTexts) , $this->stopWords )) ;
	}
	
	
	
	/************************************************************************************
	 *	Function GetWeightedWords()
	 *	Description:	returns array of unique words in the html with the weight(importance) of it
	 *					Keyword weights can be used for searching multiple articles and keywords may receive different 
	 *					weights depending on its position in HTML. for example. Keywords in <title> or 
	 *					<h1> tags should receive higher weight.	Likewise wach keyword position can have different weight
	 *					each element has 'word' and 'weight' keys. 'weight' is the weight of keyword depending on its position in html
	 *  Parameters:		$weights - array specifying each position as key and its weight as value
	 *  
	 ************************************************************************************/
	function GetWeightedWords( $weights = false){

		if(!$weights ){
			$weights = $this->wordWeights;
		}
		
		$words = $this->_GetWords();
		
		//add weight of words in title
		if( $weights['title'] > 0 ){
			$titleWords = $this->_GetTitleWords();
			foreach( $titleWords As $word => $count ){
				$words[$word] += ($count * $weights['title']);
			}
		}
		
		//add weight of words in h1
		if( $weights['h1'] > 0 ){
			$h1Words = $this->_GetH1Words();
			foreach( $h1Words As $word => $count ){
				$words[$word] += ($count * $weights['h1']);
			}
		}
		
		//add weight of words in links
		if( $weights['link'] > 0 ){
			$linkedWords = $this->_GetLinkedWords();
			foreach( $linkedWords As $word => $count ){
				$words[$word] += ($count * $weights['link']);
			}
		}
		
		//add weight of words in link titles
		if( $weights['linkTitle'] > 0 ){
			$linkTitleWords = $this->_GetLinkTitleWords();
			foreach( $linkTitleWords As $word => $count ){
				$words[$word] += ($count * $weights['linkTitle']);
			}
		}
		
		//add weight of words in ALT tags of images
		if( $weights['alt'] > 0 ){
			$altWords = $this->_GetAltWords();
			foreach( $altWords As $word => $count ){
				$words[$word] += ($count * $weights['alt']);
			}
		}

		//add meta keywords
		$metas = $this->GetMeta();
		
		foreach( $metas As $meta ){
			
			if( $meta['name'] == 'title' ){
				if( $weights['metaTitle'] > 0 ){
					$metaTitleWords = array_count_values( array_diff( $this->String2Words( $meta['content'] ), $this->stopWords ));
					foreach( $metaTitleWords As $word => $count ){
						$words[$word] += ($count * $weights['metaTitle']);
					}
				}
			}elseif($meta['name'] == 'keywords'){
				if( $weights['metaKeywords'] > 0 ){
					$metaKeyWords = array_count_values( array_diff( $this->String2Words( $meta['content'] ), $this->stopWords));
					foreach( $metaKeyWords As $word => $count ){
						$words[$word] += ($count * $weights['metaKeywords']);
					}
				}
			}elseif($meta['name'] == 'description'){
				if( $weights['metaDescription'] > 0 ){
					$metaDescWords = array_count_values( array_diff( $this->String2Words( $meta['content'] ), $this->stopWords));
					foreach( $metaDescWords As $word => $count ){
						$words[$word] += ($count * $weights['metaDescription']);
					}
				}
			}
		}
		
		arsort( $words );
		reset( $words );
		
		//construct final array of words with their densities
		$finalWords = array();
		foreach( $words As $w=>$c ){
			if( $this->mode != 'multi-byte' ){
				//save to array
				$finalWords[] = array('word'=>$w, 'weight'=>$c) ;
			}else{
				//decode base64 encoded multi-byte words and save to array
				$finalWords[] = array('word'=>base64_decode( $w ), 'weight'=>$c) ;
			}
		}
		return $finalWords;
		
	}
	
	
	
	/************************************************************************************
	 *	Function GetWordDensity()
	 *	Description:	returns array of unique words in the html with the word density
	 *					This unlike GetWords() can also include words in meta tags, alt and title attributes
	 *					each element has 'word' and 'count' keys
	 *  Parameters:		$weights - array specifying each position as key and value as 0 or 1
	 *  					value 0 means dont count words in that particular position
	 *  					value 1 or nonzero means count words in that particular position or tag in html
	 *  				The advantage is we can use same weight array as for GetEWeightedWords 
	 *  
	 ************************************************************************************/
	function GetWordDensity( $weights= false ){

		if(!$weights ){
			$weights = $this->wordWeights;
		}
		if(!$this->stripedDom ){
			$this->StripTags();
		}
		
		$words = $this->_GetWords();
		
		//add words in title
		if( $weights['title'] > 0 ){
			$titleWords = $this->_GetTitleWords();
			foreach( $titleWords As $word => $count ){
				$words[$word] += 1;
			}
		}
		
		//add weight of words in link titles
		if( $weights['linkTitle'] > 0 ){
			$linkTitleWords = $this->_GetLinkTitleWords();
			foreach( $linkTitleWords As $word => $count ){
				$words[$word] += 1;
			}
		}
		
		//add weight of words in ALT tags of images
		if( $weights['alt'] > 0 ){
			$altWords = $this->_GetAltWords();
			foreach( $altWords As $word => $count ){
				$words[$word] += 1;
			}
		}

		//add meta keywords
		$metas = $this->GetMeta();
		
		foreach( $metas As $meta ){

			if( $meta['name'] == 'title' ){
				if( $weights['metaTitle'] > 0 ){
					$metaTitleWords = array_count_values( array_diff( $this->String2Words( $meta['content'] ), $this->stopWords ));
					foreach( $metaTitleWords As $word => $count ){
						$words[$word] += 1;
					}
				}
			}elseif($meta['name'] == 'keywords'){
				if( $weights['metaKeywords'] > 0 ){
					$metaKeyWords = array_count_values( array_diff( $this->String2Words( $meta['content'] ), $this->stopWords));
					foreach( $metaKeyWords As $word => $count ){
						$words[$word] += 1;
					}
				}
			}elseif($meta['name'] == 'description'){
				if( $weights['metaDescription'] > 0 ){
					$metaDescWords = array_count_values( array_diff( $this->String2Words( $meta['content'] ), $this->stopWords));
					foreach( $metaDescWords As $word => $count ){
						$words[$word] += 1;
					}
				}
			}
		}
		
		arsort( $words );
		reset( $words );
		
		//construct final array of words with their densities
		$finalWords = array();
		foreach( $words As $w=>$c ){
			if( $this->mode != 'multi-byte' ){
				//save to array
				$finalWords[] = array('word'=>$w, 'count'=>$c) ;
			}else{
				//decode base64 encoded multi-byte words and save to array
				$finalWords[] = array('word'=>base64_decode( $w ), 'count'=>$c) ;
			}
		}
		return $finalWords;
	}
	
	

	/************************************************************************************
	 * function StripTags() 
	 * This function Removes tags not required  for text processing
	 * The tags are script, style, object, embed 
	 * 
	 ************************************************************************************/
	function StripTags( $stripTags = false ){
		if(!$stripTags ){
			$stripTags = $this->stripTags;
		}
		
		$this->stripedDom = $this->dom;
		
		// remove the scripts, styles, object and embed tags
		$toRemove = array();

		//find <script> tags to remove and add them to the array of nodes to remove
		if( $stripTags['script'] ){
			$elementList = $this->stripedDom->getElementsByTagName('script');
			for( $i=0; $i < $elementList->length; $i++ ){
				$node = $elementList->item($i);
				$toRemove[] = $node;
			}
		}
				
		//find <style> tags to remove and add them to the array of nodes to remove
		if( $stripTags['style'] ){
			$elementList = $this->stripedDom->getElementsByTagName('style');
			for( $i=0; $i < $elementList->length; $i++ ){
				$node = $elementList->item($i);
				$toRemove[] = $node;
			}
		}
			
		//find <embed> tags to remove and add them to the array of nodes to remove
		if( $stripTags['embed'] ){
			$elementList = $this->stripedDom->getElementsByTagName('embed');
			for( $i=0; $i < $elementList->length; $i++ ){
				$node = $elementList->item($i);
				$toRemove[] = $node;
			}	
		}
		
		//find <object> tags to remove and add them to the array of nodes to remove
		if( $stripTags['script'] ){
			$elementList = $this->stripedDom->getElementsByTagName('object');
			for( $i=0; $i < $elementList->length; $i++ ){
				$node = $elementList->item($i);
				$toRemove[] = $node;
			}
		}
		
		// remove the nodes
		foreach( $toRemove As $n ){
			$n->parentNode->removeChild( $n);
		} 
		
		//save the processed data in $dom
		$this->stripedDom->saveHTML();
		
	}
	
	
	
	/************************************************************************************
	 *	Function String2Words()
	 *	Description:	This returns an array of words in the passed string
	 *					Please note that the returned words can contain duplicates
	 *					for multi-byte version the words are base64 encoded as they are to be 
	 *					used as array keys in word density related functions 
	 * 
	 ************************************************************************************/
	function String2Words( $str, $minLength = false, $maxLength = false ){
		if( !$minLength ){
			$minLength = $this->minWordLength;
		}
		if( !$maxLength ){
			$maxLength = $this->maxWordLength;
		}
		if( $this->mode != "multi-byte" ){
			preg_match_all('/'.$this->wordRegEx .'{'.$minLength.','.$maxLength.'}/', strtolower($str), $words);
			return $words[0];
		}else{
			//multi-byte version to get words
			mb_regex_encoding($this->encoding);
			
			$allWords= mb_split('\W+', mb_strtolower($str));
			
			$words = array();
			foreach( $allWords As $k => $w ){
				$len = mb_strlen($w);
				if($len >= $minLength && $len <= $maxLength)
					$words[] =  base64_encode($w);
			}
			
			return $words;
		}
	}

	
	
	/************************************************************************************
	 * 	Funciton FixHTML( )
	 * 	Description:	This function corrects HTML with incorrect syntax e.g. unclosed tags etc.
	 * 					This can be useful where we need to cut input html without causing 
	 * 					unclosed tags etc.
	 *	Parameters:		$htmlStr - string containing html/xhtml
	 *					$autoAddWrappers - if true it will automatically add <html><head><body> etc. tags
	 *						and will make it a full valid html document
	 *						if false it will just correcy whatever input is given
	 ************************************************************************************/
	function FixHTML( $htmlStr, $autoAddWrappers=false ){
		$doc = new DOMDocument();
		$doc->loadHTML($htmlStr);
		if(!$autoAddWrappers){
			$elementList = $this->dom->getElementsByTagName('body');
			return $this->DOMinnerHTML($elementList->item(0)) ;
		}
		return $doc->saveHTML(); /* and our script tags will still be <script></script> */
		
	}
	
	
	
	/************************************************************************************
	 * Function DOMinnerHTML()
	 * Description:		returns innerHTML for any DOMElement object
	 * Parameters:		$domElement  - an object of DOMElement class
	 * 
	 ************************************************************************************/
	function DOMinnerHTML($domElement)
	{
	    $innerHTML = "";
	    $children = $domElement->childNodes;
	    $tmp_dom = new DOMDocument();
	    foreach ($children as $child)
	    {
	        $tmp_dom->appendChild($tmp_dom->importNode($child, true));
	        
	    }
	    $innerHTML = trim($tmp_dom->saveHTML());
	    return $innerHTML;
	}
	
}

?>