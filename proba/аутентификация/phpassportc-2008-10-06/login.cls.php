<?php
class Passport {
	var $i = 0;
	var $s_array = array(); 
	var $K_array = array(); 
	var $return_val; 
	var $num_count; 
	var $alp_count; 
	var $lwr_count; 
	
	function login($urs_login, $urs_pass, $apikey, $apipas){
	global $_SESSION;
		$address = 'http://www.barkersmedia.co.uk/passport/login.php';// Web address to class handler
		$urs_login = $this->encrypt($urs_login, 'gfdkuyg5478iyhtre789654y8'); // Must match Servers Key
		$urs_pass = $this->encrypt($urs_pass, 'dfjhj498y5tre786g87ey58h'); // Must match Servers Key
		$send = 'key='.$this->encrypt($apikey,'cfmny47thriuy598yhiu').'&keypas='.$this->encrypt($apipas,'rtuybg5e7wg6b3q9874vb').'&user='.$urs_login.'&pass='.$urs_pass.'';
		$check = $this->do_post_request($address, $send);
		$check = split(';',$check);
		if($check[0] == 'false'){die('<strong>Barkers Media : Error : </strong> This Site has not been allowed to use this API');}
		if($check[1] == 'false'){die('<strong>Barkers Media : Error : </strong> Username &/or Password are Incorrect');}
		$_SESSION['userid'] = $check[2]; // Gives Site userID 
		$_SESSION['user'] = $check[3]; //  Gives Site Secured Username
		return true;
	}
	
//Generates SHA-1 private key : SHA-1 hash is preformed twice on 300 to 400 bits of /dev/urandom entropy that has been salted with the UNIX epoch twice. 
//Multiple levels of salt combined with a random amount of entropy gathered from /dev/urandom (Source: electrical system noise), determined by the Mersenne Twister algorithm, prevents the use of rainbow tables, statistical analysis and renders brute force attacks computationally infeasible. 
function genPrivateKey() { 
    $entropy = shell_exec('head -c '.mt_rand(300,400).' < /dev/urandom'); 
    $salt = mktime(); 
    $privateKey = sha1(sha1($salt.$entropy).$salt); 
    return $privateKey; 
} 


//Generates unique MD5 public key : MD5 hash is performed on a Mersenne Twister generated number + the plaintext + the UNIX epoch. 
//Salting with the UNIX epoch & a Mersenne Twister derived number allows idendical plaintext to produce unique ciphertext.  It also protects against various brute force methods. 
function genPublicKey($text) { 
    $salt = mktime(); 
    $rand = mt_rand(); 
    $publicKey = md5($rand.$text.$salt); 
    return $publicKey; 
} 


//Returns ciphertext given plaintext and the private key 
//SHA-1 hash is performed on the private key, a uniquely generated public key and a static salt character producing the "Shift Key".  The decimal value of each character of plaintext is then added to the decimal value of the next sequential character of the "Shift Key", repeating when needed.  Some simple math is applied to simplify the output, which is converted to hex.  The public key is appended to the cipherstream thus producing the ciphertext. 
function encrypt($text, $privateKey) { 
    $publicKey = $this->genPublicKey($text); 
    $shiftKey = sha1($privateKey."+".$publicKey); 
     
    $text_array = str_split($text); 
    $shift_array = str_split($shiftKey); 
     
    $counter = 0; 
    for($i=0;$i<sizeof($text_array);$i++) { 
        if($counter > 40) $counter = 0; 
        $cryptChar = ord($text_array[$i]) + ord($shift_array[$counter]); 
        $cryptChar -= floor($cryptChar/127) * 127; 
        $cipherStream[$i] = dechex($cryptChar); 
        $counter++; 
    } 
     
    $cipher = implode(":",$cipherStream)."/".$publicKey; 
    return $cipher; 
} 

function do_post_request($url, $data, $optional_headers = null)   
{   
 $params = array('http' => array(   
              'method' => 'POST',   
              'content' => $data  
           ));   
 if ($optional_headers !== null) {   
    $params['http']['header'] = $optional_headers;   
 }   
 $ctx = stream_context_create($params);   
 $fp = @fopen($url, 'rb', false, $ctx);   
 if (!$fp) {   
    throw new Exception("Problem with $url, $php_errormsg");   
 }   
 $response = @stream_get_contents($fp);   
 if ($response === false) {   
    throw new Exception("Problem reading data from $url, $php_errormsg");   
 }   
 return $response;   
}    

}
?>