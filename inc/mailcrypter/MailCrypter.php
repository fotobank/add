<?php

//	MailCrypter class
//	Written by: Pablo Gazmuri on July 23, 2002
//	This class writes scrambled mailto: links,
//	keeping email addresses invisible to email
//	harvesting programs.
//	NOTE: Only tested in IE and Netscape 6


class MailCrypter{

	var $links;
	
	
	//this function adds a link and returns the scrambled link text
	function addMailTo($address, $addlAttributes = ""){
		$new = "";
		
		$this->links[] = $address;
		
		for($i=0;$i<strlen($address);$i++){
			$new .= chr(ord(substr($address, $i, 1)) - 1);
		}
		
		return "<a id=\"link".(count($this->links)-1)."\" href=\"mailto:$new\" $addlAttributes >$new</a>";
	}
	
	
	//this function echos the javascript code to descramble the links
	function writeScript(){
	
	echo "\n\n<script language=\"JavaScript\">
		<!--hide from older browsers\n";
		
	
		
	echo "
		function ConvLink(link){
			var temp='';
			var i;
			for(i =0;i<link.href.length;i++){
				if (i>6){
					temp = temp + String.fromCharCode(link.href.charCodeAt(i)+1);
				}else{
					temp = temp + link.href.charAt(i);
				}
			}
			link.href = temp
			link.innerHTML = temp.substring(7);
				
		}\n";
		
		for($i=0; $i<count($this->links);$i++){ echo "
		ConvLink(document.getElementById('link$i'));\n";}
		
		echo "-->\n</script>";
	
	
	
	}
	

}

?>