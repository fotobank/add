<?

/**
 * Class md5_encrypt
 */

class md5_encrypt_
{
	     private $plain_text;
       private $password;
       private $iv_len;


	function __construct($plain_text, $password, $iv_len = 16)
	{
    	   $this->plain_text = $plain_text;
         $this->password = $password;
         $this->iv_len = $iv_len;
	}

	function get_rnd_iv($iv_len)
	{
    	$iv = '';
    	while ($iv_len-- > 0)
    	{
        	$iv .= chr(mt_rand() & 0xff);
    	}
    	return $iv;
	}

	function ret()
	{
         $this->plain_text .= "\x13";
         $n = strlen($this->plain_text);
         if ($n % 16) $this->plain_text .= str_repeat("\0", 16 - ($n % 16));
         $i = 0;
         $enc_text = $this->get_rnd_iv($this->iv_len);
         $iv = substr($this->password ^ $enc_text, 0, 512);
         while ($i < $n)
         {
                $block = substr($this->plain_text, $i, 16) ^ pack('H*', md5($iv));
                $enc_text .= $block;
                $iv = substr($block . $iv, 0, 512) ^ $this->password;
                $i += 16;
         }
         return  base64_encode($enc_text);
	}
}

/*
:::::::::::::::::::::::::::::::::::::::::::::::::
::                                             ::
::             H O W  T O  U S E ?             ::
::                                             ::
::                                             ::
::  The keys are the images holder directory   ::
::   which created by multichars {A-Za-z0-9}   ::
::    and the html <span> style attribute      ::
::  <span stlye = "display:block; background:  ::
::       url(loader.php?' . $encrypted .       ::
::    '=' . $images[$_GET['thumb']] . ');">    ::
::                                             ::
::                                             ::
::                                             ::
::              Simple example:                ::
::                                             ::
:: Create a md5 encrypted string and construct ::
::   a <span> element inside a <img> element   ::
::                                             ::
::                                             ::
::                                             ::
:::::::::::::::::::::::::::::::::::::::::::::::::

PHP code:

$dir = "myimageholderdirectory1245678";
$psw = "mypasswordforencrypt/decrypt";
$md5_encrypt = new md5_encrypt($dir, $psw);
$encrypted = $md5_encrypt->ret();
$size = getImageSize($dir . "/image.gif");

HTML code:

<span style="display:block; background:url(loader.php?' . $encrypted . '=image.gif);">
 <img src="security/protector.gif" alt=""  width=' . $size[0] . ' height=' . $size[1] . '>
</span>

The protector.gif is a transparent gif and them size
resized by <img> with & height attributes.

Generated example html code:

<html>
 <span style="display:block;
 	background:url(loader.php?RgY9sjDqJVvJ+KNvqDrMNpm/L2/LLESuXtH7bsrbdrDnbk18/Y7t1rEJjDaAhyfD=circle.gif);">
 		<img src="security/protector.gif" alt="" width=198 height=114>
 </span>
</html>

:::::::::::::::::::::::::::::::::::::::::::::::::
::                                             ::
::        Call the loader.php as image         ::
::                                             ::
::                                             ::
::                                             ::
::           P R O T E C T I O N S :           ::
::                                             ::
:: -Disable disk file cache                    ::
:: -Disable 'right click,save as image...'     ::
:: -Disable images save by total web mirror    ::
:: -Disable view image by direct loader url    ::
:: -Set watermark on the images                ::
::                                             ::
:::::::::::::::::::::::::::::::::::::::::::::::::
*/

$dir = "/images2/733";
$psw = "Protected_Site_Sec";

$md5_encrypt = new md5_encrypt_($dir, $psw, 16);
$dir = "./../..".$dir;
$encrypted = $md5_encrypt->ret();

if($dh = opendir($dir))
{
	while ($file = readdir($dh))
	{
		if (($file != ".") && ($file != ".."))
		{
			$images[] = substr(trim($file), 2, -4);
		}
	}
	closedir($dh);
}

$k = $_GET['thumb'] + 1;
$h = $_GET['thumb'] - 1;

if($k == count($images)) $k = 0;
if($h < 0) $h=count($images)-1;

  $size = getimagesize($dir.'/'.(isset($_GET['thumb'])?'id'.$images[$_GET['thumb']].'.jpg':'id'.$images[0].'.jpg'));
	$html = '
	<html>
	 <head>
	  <style type="text/css">
	   a {font-family: Arial, Sans-serif, Verdana; font-size:11px; color:black; text-decoration:none;}
	   a:hover {text-decoration:underline;}
	  </style>
	 </head>
	<p>
	 <table align=center>
	  <tr>
	       <td align=center>
	        <div style="background:url(/loader.php?'.$encrypted.'||'.$images[$_GET['thumb']].');">
	             <div style="width: '.$size[0].'px; height: '.$size[1].'px;"></div>
	        </div>
	            <a class="modern"
                 href="#'.$images[$_GET['thumb']].'"
                 style="display:block; position: absolute; float: right;
                 background:url(/loader.php?'.$encrypted.'||'.(isset($_GET['thumb'])?$images[$_GET['thumb']]:$images[0]).');">
	                   <img id="'.$images[$_GET['thumb']].'" src="/security/protector.gif" alt="" width='.$size[0].' height='.$size[1].'>
	            </a>
	       </td>
	  </tr>
	  <tr>
	   <td align=center><b><a href=?thumb='.$h.'>Previous image</a> | <a href="?thumb='.$k.'">Next image</a></b>
	   </td>
	  </tr>
	 </table>
	</p>
	</html>';
echo $html;
?>

