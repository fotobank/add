<?
/*
**	glogin
**
**	Sends Login information in secure way. The username and password 
**	has an randomic name, and the password value is encripted and it is imposible
**	to deencript.
**
**	The username do have a way back (deencription) and the algorithm is a basic encript 
**	method. this algorith is not strong back gives more work to some one that wants
**	to spy us.
**
**	It is *almost* imposible to brake this sLogin and get the password value. The
**	username is easy to have. But username without password is not useful.
**
**	Also this sLogin prevent to login sending the same encripted password as most of
**	login system will do, they prevent to not hide the password, but sending that encripted
**	value you can login. sLogin encript the password with MD5 + "randomic key".  
**
*/

class gLogin {

    var $fields;
    var $method;
    var $fValues; /* form sended values*/

    
    function gLogin($method = 'post') {
        @session_start(); /* creating a session */
        switch( strtolower($method) ) {
            case 'get':
                $this->fValues = &$_GET;
                $this->method = 'get';
                break;
            default:
                $this->fValues = &$_POST;
                $this->method = 'post';
                break;
        }
    }

	function getValue($val) {
		return $this->deencript( $this->fValues[ $_SESSION['sLogin'][$val]['safe'] ] ) ;
	}
	
	/*
	**	ugly *encriptation* (it is not encriptation at all... but is something ;-) )
	*/
	function deencript($val) {
		$word = "";
		$val = strrev($val);

		for($i=0; $i < strlen($val)/2; $i++) {
			$nro = substr($val, $i*2,2);
			$rep = hexdec($nro);
			if ($rep == 0) continue;
			$word .= chr($rep); 
		}
		$word = strrev($word);
		return $word;
	}
	
	function isFormSubmited() {
		$v = true;

		if ( !isset($_SESSION['sLogin']) || !is_array($_SESSION['sLogin'])) return false;
		
		foreach ($_SESSION['sLogin'] as $field => $values)  {
			$v = $v && isset( $this->fValues[ $values['safe'] ] );
		
		}
		return  $v ;
	}
	
	function match($field, $value) {
		$value = md5( $value . $_SESSION['sLoginC']['magic'] );
		return $this->fValues[ $_SESSION['sLogin'][$field]['safe'] ] === $value;
	}
	
	
    function safeSend($inputName, $safeAsPassword=false) {
        /*
         *  the security is in the $safeFieldName, which is a hidden input which for every query
         *  it has a new name assigned to an real input.
         *  Also there is a encrypt method the Password and the normal. The normal has a 
         *  way back (restore the original value). The password is almost inposible to restore
         *  back, it implements MD5 of Password and a secret key that change for every request.
         */
        $safeFieldName = md5( $inputName . time() . microtime() ); 
        $this->fields[$inputName]['safe'] = $safeFieldName;
        $this->fields[$inputName]['password'] = $safeAsPassword === true;
        $_SESSION['sLogin'][$inputName] = $this->fields[$inputName]; /* Remember ;-) */
    }    

    function Js() {
        $_SESSION['sLoginC']['magic'] = md5( session_id() . time() . microtime() );
		
		$input = "";
		$js_action = "";
        foreach ($this->fields as $field => $values)  {
            $input .= "<input type = hidden id = '".$values['safe']."' name = '".$values['safe']."'>\r\n";        
        	$js_action .= "\tsLogin_Safe('$field', '".$values['safe']."',".($values['password']===true ? 'true' : 'false').");\r\n";   
		}
        
		
		
        $r =  ' 
<script><!--
var magicCode = "'.$_SESSION['sLoginC']['magic'].'";
function sLogin_Send() {
'.$js_action.'
	return true;
}

function sLogin_Safe(field, hidden, password ) {
	f = document.getElementById(field);
	if ( f == null) {
		alert("sLogin could not find the field " + field);
		return false;
	}
	h = document.getElementById(hidden);
	if (password) {
		safe = hex_md5( f.value + magicCode);
	} else {
		safe = reverse(binl2hex( str2binl(reverse(f.value)) )) ;
	}

	h.value = safe;
	f.value = "";
}

function reverse(str) {
	var nstring;
	nstring="";
	for(i= str.length-1; i >= 0; i--)  {
		nstring += str[i];
	}
	return nstring;
}        

//--></script>';
        return $r.$input;
    }
    
    function onsubmit() {
        return 'return sLogin_Send()';
    }


    
}
?>
