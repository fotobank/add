<?php
class Passport {
	var $API_KEY;
	var $API_PAS;
	var $i = 0;
	var $s_array = array(); 
	var $K_array = array(); 
	var $return_val; 
	var $num_count; 
	var $alp_count; 
	var $lwr_count; 
	
	function validate($API_KEY, $API_PAS, $urs_login, $urs_pass){
		$output = '';
		$con = mysql_connect('host','user','password'); // SQL Connect
		mysql_select_db('DB',$con);
		$API_KEY = $this->decrypt($API_KEY ,'cfmny47thriuy598yhiu');// key must match the login.php API you give out
		$API_PAS = $this->decrypt($API_PAS ,'rtuybg5e7wg6b3q9874vb');// key must match the login.php API you give out
		$sql = "SELECT * FROM `sites` WHERE `API_KEY` = '".$API_KEY."'";
		$query = mysql_query($sql, $con);
		$row = mysql_fetch_array($query);
		if($row['API_PAS'] == $API_PAS){
			$output .= 'true;';
		}else{
			$output .= 'false;';
		}
		$urs_login = $this->decrypt($urs_login, 'gfdkuyg5478iyhtre789654y8');// key must match the login.php API you give out
		$sql = "SELECT * FROM  `users` WHERE  `user` =  '".$urs_login."'";
		$query = mysql_query($sql, $con);
		$row = mysql_fetch_array($query);
		$urs_pass = $this->decrypt($urs_pass, 'dfjhj498y5tre786g87ey58h');
		if($urs_pass == $row['pass']){
			$output .= 'true;';
		}else{
			$output .= 'false;';
		}
		$output .= $row['id'].';';
		$output .= $urs_login.';';
		$output .= $urs_pass;
		return $output;
	}

	function allow_site($address){
		$con = mysql_connect('host','user','password'); // SQL Connect
		mysql_select_db('DB',$con);
		$API_KEY = genPrivateKey();
		$API_PASS = genPrivateKey();
		$sql = "INSERT INTO `sites` VALUES(null,'".$API_KEY."','".$API_PASS."','".$address."','')";
		mysql_query($sql, $con);
		return 'Account Created API KEY = '.$API_KEY.'<br /> API PAS = '.$API_PASS;
	}
	
	function create_acc($user, $pass, $email, $site){
		$con = mysql_connect('host','user','password'); // SQL Connect
		mysql_select_db('DB',$con);
		$sql = mysql_query("SELECT * FROM `users`",$con);
		while($row = mysql_fetch_array($sql)){
			if($row['id'] == $user){$switch = false;}
			if($row['email'] == $email){$switch = false;}
		}
		if($switch == true){
		$sql = "INSERT INTO `users` VALUES(null,'".$user."','".$pass."','".$email."','".$site."')";
		mysql_query($sql,$con);
		return true;
		}else{
		return false;
		}
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


//Returns plaintext given ciphertext and the private key used to make it 
//Isolates the public key and the cipherstream.  Calculates the shift key by preforming the SHA-1 hash on the private key, public key from the ciphertext and a static salt character.  Cipherstream is converted from hex to decimal format where the demical value of a character from the shift key is subtracted.  This in turn is converted to ASCII and glued to the other values thus providing the reconstructed plaintext. 
	function decrypt($cipher_in, $privateKey) { 
    $cipher_all = explode("/",$cipher_in); 
    $cipher = $cipher_all[0]; 
     
    $publicKey = $cipher_all[1]; 
    $shiftKey = sha1($privateKey."+".$publicKey); 
     
    $cipherStream = explode(":",$cipher); 
    $shift_array = str_split($shiftKey); 
     
    $counter = 0; 
    for($i=0;$i<sizeof($cipherStream);$i++) { 
        if($counter > 40) $counter = 0; 
        $cryptChar = hexdec($cipherStream[$i]) - ord($shift_array[$counter]); 
        $cryptChar -= floor($cryptChar/127) * 127; 
        $cipherText[$i] = chr($cryptChar); 
        $counter++; 
    } 
     
    $plaintext = implode("",$cipherText);     
    return $plaintext; 
 }
 
}
?>