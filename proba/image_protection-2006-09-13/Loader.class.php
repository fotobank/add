<?php
/*
+-------------------------------------------------+
+                                                 +
+    Loader.class.php ver. 1.0 by László Zsidi    +
+     examples and support on http://gifs.hu      +
+                                                 +
+    This class can be used and distributed       +
+    free of charge, but cannot be modified       +
+        without permission of author.            +
+                                                 +
+-------------------------------------------------+
*/
/*
:::::::::::::::::::::::::::::::::::::::::::::::::
::                                             ::
::             H O W  T O  U S E ?             ::
::                                             ::
::                                             ::
::                                             ::
::   require('Loader.class.php');              ::
::                                             ::
::   $protect = new Loader(                    ::
::    	$_SERVER['HTTP_REFERER'],              ::
::    	$_SERVER['QUERY_STRING'],              ::
::    	String password,                       ::
::    	String watermark text,                 ::
::    	Watermark switch true->on false->off,  ::
::    	String font,                           ::
::    	Int fontsize,                          ::
::    	Hex fontcolor,                         ::
::    	Hex shadowcolor,                       ::
::      String Error action                    ::
::        'jump=>protected.php'                ::
::        Redirect into specified site         ::
::	  'show=>protected/protected.gif'      ::
::        Display a specified image            ::
::     );                                      ::
::                                             ::
:::::::::::::::::::::::::::::::::::::::::::::::::
*/
class Loader {
	/*
	:::::::::::::::::::::::::::::::::::::::::::::::
	::                                           ::
	::             Class variables               ::
	::                                           ::
	:::::::::::::::::::::::::::::::::::::::::::::::
	*/
	var $dir = "";
	/*
	:::::::::::::::::::::::::::::::::::::::::::::::
	::                                           ::
	::            Class constructor              ::
	::                                           ::
	:::::::::::::::::::::::::::::::::::::::::::::::
	*/
	function Loader( $referer, $query, $pws, $cpr, $sw, $font, $font_size, $rgbtext, $rgbtsdw, $process )
	{
        $this->set_http_header();
		if( $referer )
		{
        	$decrypted = explode( "=", $query );
    		$sw ? $this->watermark( $this->md5_decrypt($decrypted[0], $pws ) . "/" . $decrypted[1] , $cpr, $font, $font_size, $rgbtext, $rgbtsdw, 0, 5, 30, 2, 2) : $this->show( $this->md5_decrypt( $decrypted[0], $pws ) . "/" . $decrypted[1] );
        }
        else
        {
        	$processor = explode("=>", $process);
        	if($processor[0] == "show")
        	{
				header( "Content-type: image/" . substr( $processor[1], strlen( $processor[1] ) - 4, 4 ) == "jpeg" ? "jpeg" : substr( $processor[1], strlen( $processor[1] ) - 3, 3 ) );
				readfile( $processor[0] );
			}
			else if($processor[0] == "jump")
			{
				header( "Location: " . $processor[1] );
			}
        }
	}
	/*
	:::::::::::::::::::::::::::::::::::::::::::::::
	::                                           ::
	::     Set http header and disable cache.    ::
	::                                           ::
	:::::::::::::::::::::::::::::::::::::::::::::::
	*/
	function set_http_header()
	{
		header( "Expires: -1" );
		header( "Last-Modified: " . gmdate( "D, d M Y H:i:s" ) . " GMT" );
		header( "Cache-Control: no-cache, must-revalidate" );
		header( "Pragma: no-cache" );
		return ( 0 );
	}
	/*
	:::::::::::::::::::::::::::::::::::::::::::::::
	::                                           ::
	::            Show without watermark         ::
	::                                           ::
	:::::::::::::::::::::::::::::::::::::::::::::::
	*/
    function show( $img )
    {
		header( "Content-type: image/" . substr( $img, strlen( $img ) - 4, 4 ) == "jpeg" ? "jpeg" : substr( $img, strlen( $img ) - 3, 3 ) );
    	readfile( $img );
    }
	/*
	:::::::::::::::::::::::::::::::::::::::::::::::
	::                                           ::
	::             Show with watermark           ::
	::                                           ::
	:::::::::::::::::::::::::::::::::::::::::::::::
	*/
	function watermark( $img, $cpr, $font, $font_size, $rgbtext, $rgbtsdw, $hotspot, $txp, $typ, $sxp, $syp )
	{
		strtolower( substr( $img, strlen( $img ) - 4, 4 ) ) == "jpeg" ? $suffx = "jpeg" : $suffx = strtolower( substr( $img, strlen( $img ) - 3, 3 ) );
		switch( $suffx )
		{
			case "jpg":
				$image = imageCreateFromJpeg( $img );
				break;
			case "jpeg":
				$image = imageCreateFromJpeg( $img );
				break;
			break;
			case "gif":
				$image = imageCreateFromGif( $img );
				break;
			break;
			case "png":
				$image = imageCreateFromPng( $img );
				break;
		}
    	if( $hotspot != 0 )
    	{
      		$ix = imagesx( $image );
      		$iy = imagesy( $image );
      		$tsw = strlen( $text ) * $font_size / imagefontwidth( $font ) * 3;
      		$tsh = $font_size / imagefontheight( $font );
      		switch ( $hotspot )
      		{
        		case 1:
         			$txp = $txp; $typ = $tsh * $tsh + imagefontheight( $font ) * 2 + $typ;
        			break;
        		case 2:
         			$txp = floor( ( $ix - $tsw ) / 2 ); $typ = $tsh * $tsh + imagefontheight( $font ) * 2 + $typ;
        			break;
        		case 3:
         			$txp = $ix - $tsw - $txp; $typ = $tsh * $tsh + imagefontheight( $font ) * 2 + $typ;
        			break;
        		case 4:
         			$txp = $txp; $typ = floor( ( $iy - $tsh ) / 2 );
        			break;
        		case 5:
         			$txp = floor( ( $ix - $tsw ) / 2 ); $typ = floor( ( $iy - $tsh ) / 2 );
        			break;
        		case 6:
         			$txp = $ix - $tsw - $txp; $typ = floor( ( $iy - $tsh ) / 2 );
        			break;
        		case 7:
         			$txp = $txp; $typ = $iy - $tsh - $typ;
        			break;
        		case 8:
         			$txp = floor( ( $ix - $tsw ) / 2 ); $typ = $iy - $tsh - $typ;
        			break;
        		case 9:
         			$txp = $ix - $tsw - $txp; $typ = $iy - $tsh - $typ;
        			break;
      		}
    	}
  		ImageTTFText( $image, $font_size, 0, $txp + $sxp, $typ + $syp, imagecolorallocate( $image, HexDec( $rgbtsdw ) & 0xff, ( HexDec( $rgbtsdw ) >> 8 ) & 0xff, ( HexDec( $rgbtsdw ) >> 16 ) & 0xff ), $font, $cpr );
  		ImageTTFText( $image, $font_size, 0, $txp, $typ, imagecolorallocate( $image, HexDec( $rgbtext ) & 0xff, ( HexDec( $rgbtext ) >> 8 ) & 0xff, ( HexDec( $rgbtext ) >> 16 ) & 0xff ), $font, $cpr );
		switch( $suffx )
		{
			case "jpg":
  				header( "Content-type: image/jpg" );
  				imageJpeg( $image );
  				imageDestroy( $image );
				break;
			case "jpeg":
  				header( "Content-type: image/jpg" );
  				imageJpeg( $image );
  				imageDestroy( $image );
				break;
			break;
			case "gif":
  				header( "Content-type: image/gif" );
  				imageGif( $image );
  				imageDestroy( $image );
				break;
			break;
			case "png":
  				header( "Content-type: image/png" );
  				imagePng( $image );
  				imageDestroy( $image );
				break;
		}
	}
	/*
	:::::::::::::::::::::::::::::::::::::::::::::::
	::                                           ::
	::                MD5 decrypt                ::
	::                                           ::
	:::::::::::::::::::::::::::::::::::::::::::::::
	*/
	function md5_decrypt( $enc_text, $password, $iv_len = 16 )
	{
    	$enc_text = base64_decode( $enc_text );
    	$n = strlen( $enc_text );
    	$i = $iv_len;
    	$plain_text = '';
    	$iv = substr( $password ^ substr( $enc_text, 0, $iv_len ), 0, 512 );
    	while ( $i < $n )
    	{
        	$block = substr( $enc_text, $i, 16 );
        	$plain_text .= $block ^ pack( 'H*', md5( $iv ) );
        	$iv = substr( $block . $iv, 0, 512 ) ^ $password;
        	$i += 16;
    	}
    	return preg_replace( '/\\x13\\x00*$/', '', $plain_text );
	}
}
?>
