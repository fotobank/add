<?php

#############################################################################
#                                                                           #
# Cafe CounterIntelligence PHP Website Security Script 1.7                  #
# Copyright 2002, 2003 Mike Parniak                                         #
# www.cafecounterintelligence.com                                           #
#                                                                           #
# This program is free software; you can redistribute it and/or modify      #
# it under the terms of the GNU General Public License as published by      #
# the Free Software Foundation; either version 2 of the License, or         #
# (at your option) any later version.                                       #
#                                                                           #
# This program is distributed in the hope that it will be useful,           #
# but WITHOUT ANY WARRANTY; without even the implied warranty of            #
# MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the             #
# GNU General Public License for more details.                              #
#                                                                           #
# You should have received a copy of the GNU General Public License         #
# along with this program; if not, write to the Free Software               #
# Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA 02111-1307 USA   #
#                                                                           #
# Usage: require_once("ccisecurity.php"); at the start of website scripts.  #
#                                                                           #
#############################################################################

##################
#
# Configuration Section - Set these variables first (Or use default if you want)
#
##################

$usehtaccessbans = 1;			# 1 = modify .htaccess to ban IPs, 0 = don't ban IPs.
$filterGETvars = 1;				# 1 = sterilize HTML tags in GET variables, 0 = don't
$filterCOOKIEvars = 1;			# 1 = sterilize HTML tags in COOKIE variables, 0 = don't
$filterPOSTvars = 0;			# 1 = sterilize HTML tags in POST variables, 0 = don't
$extraPOSTprotection = 1;		# 1 = use the extra POST protection, 0 = don't
$extraGETprotection = 0;		# 1 = use the extra GET protection, 0 = don't (not recommended!)
$checkmultiPOST = 1;			# 1 = only allow maxmultiPOST number of successive POSTs, 0 = don't care
$maxmultiPOST = 4;				# Maximum number of POST operations in a row, if checkmultipost is on.
$zipcompress = 0;				# 1 = Compress pages using GZIP library (lower bandwidth, higher CPU), 0 = don't
$compresslevel = 9;				# Compression level for zipcompressing, from 1 (low) to 9 (maximum)
$cpuloadmonitor = 0;			# 1 = block access if over a certain system load, 0 = don't
$cpumaxload = 10.0;				# Maximum 5 minute system load average before blocking access
$ccisessionpath = "";			# if not blank, sets a directory path to store session files.

##### Encryption/Encoding Variables

$javababble = 0;				# 1 = Use Encoding/Encrypting (Must be on for any), 0 = Don't
$javaencrypt = 0;				# Do actual encrypting of HTML, not just escaping (warning: may slow display)
$preservehead = 0;				# 1 = Only encode/encrypt between BODY tags, 0 = encode/encrypt whole document

##################
#
# Check for in-script overrides
#
##################

if (isset($zipoverride)) {
  if (!isset($_REQUEST["zipoverride"])) {
    $zipcompress = $zipoverride;
    unset($zipoverride);
  }
}

if (isset($babbleoverride)) {
  if (!isset($_REQUEST["babbleoverride"])) {
    $javababble = $babbleoverride;
    unset($babbleoverride);
  }
}

##################
#
# Function: CCIJavaBabble
#
# Usage: Takes some HTML, url-encodes it (jumbles it) then returns the javascript needed to display it properly.
#
##################

function CCIJavaBabble($myoutput) {
  global $mycrypto, $myalpha2, $javaencrypt, $preservehead;
  $s = $myoutput;
  $s = ereg_replace("\n","",$s);

  if ($preservehead) {  
    eregi("(^.+<body[^>]*>)",$s,$chunks);
    $outputstring = $chunks[1];
    eregi_replace($headpart,"",$s);

    eregi("(</body[^>]*>.*)",$s,$chunks);
    $outputend = $chunks[1];
    eregi_replace($footpart,"",$s);
  } else {
    $outputstring = "";
    $outputend = "";
  }
  
  if ($javaencrypt) {
    $s = strtr($s,$myalpha2,$mycrypto);
    $s = rawurlencode($s);
    $outputstring .= "<script>var cc=unescape('$s'); ";
    $outputstring .= "var index = document.cookie.indexOf('" . md5($_SERVER["REMOTE_ADDR"] . $_SERVER["SERVER_ADDR"]) . "='); " .
      "var aa = '$myalpha2'; " .
      "if (index > -1) { " .
      "  index = document.cookie.indexOf('=', index) + 1; " .
      "  var endstr = document.cookie.indexOf(';', index); " .
      "  if (endstr == -1) endstr = document.cookie.length; " .
      "  var bb = unescape(document.cookie.substring(index, endstr)); " .
      "} " .
      "cc = cc.replace(/[$myalpha2]/g,function(str) { return aa.substr(bb.indexOf(str),1) }); document.write(cc);";
  } else {
    $outputstring .= "<script>document.write(unescape('" . rawurlencode($s) . "'));";
  }
  $outputstring .= "</script><noscript>You must enable Javascript in order to view this webpage.</noscript>" . $outputend;
       
  return $outputstring;
}

##################
#
# Function: CCIClearSession
#
# Format: CCIClearSession()
# Returns: Nothing
#
# Usage: Clears all the data out of the session record other than data used for this script
#
##################

function CCIClearSession() {
  $getvariables = array_keys($_SESSION);
  $count = 0;
  while($count < count($getvariables)) {
    if (substr($getvariables[$count],0,7) != "ccisec-") {
      session_unregister($getvariables[$count]); 
      if (ini_get('register_globals')) unset($$getvariables[$count]);
    }
    $count++;
  }
}

##################
#
# Function: CCIBanIP
#
# Format: CCIBanIP(IPAddress)
# Returns: Nothing
#
# Usage: Will open and add a deny line to the .htaccess file in the same directory to deny all
#        accessing by a given IP address.
#
##################

function CCIBanIP($banip) {
  $filelocation = ".htaccess";
  $limitend = "# End of CCI Security Section\n";
  $newline = "deny from $banip\n";
  if (file_exists($filelocation)) {
    $mybans = file($filelocation);
    $lastline = "";
    if (in_array($newline,$mybans)) exit();
    if (in_array($limitend,$mybans)) {      
      $i = count($mybans)-1;
      while ($mybans[$i] != $limitend) {
        $lastline = array_pop($mybans) . $lastline;
        $i--;
      }
      $lastline = array_pop($mybans) . $lastline;
      $lastline = array_pop($mybans) . $lastline;
      $lastline = array_pop($mybans) . $lastline;
      array_push($mybans,$newline,$lastline);
    } else {
      array_push($mybans,"\n\n# CCI Security Script\n","<Limit GET POST>\n","order allow,deny\n",$newline,"allow from all\n","</Limit>\n",$limitend);
    }
  } else {
    $mybans = array("# CCI Security Script\n","<Limit GET POST>\n","order allow,deny\n",$newline,"allow from all\n","</Limit>\n",$limitend);
  }  
  $myfile = fopen($filelocation,"w");
  fwrite($myfile,implode($mybans,""));
  fclose($myfile);
    
}

##################
#
# Function: CCIFloodCheck
#
# Format: CCIFloodCheck("identifier",interval,threshold)
# Returns: 1 if requested without minimum interval, a threshold number of times.  0 if not.
#
# Usage: For functions that require flood control pass a unique identifier, the minimum number of
#        seconds that should be waited between repeats of the function, and a number of times that
#        function can be called too quickly before it sets off the flood trapping.
#
##################

function CCIFloodCheck($identifier,$interval,$threshold=1) {
  $myresult = 0;
  if (isset($_SESSION["ccisec-" . $identifier])) {
    if ($_SESSION["ccisec-" . $identifier] > (time()-$interval)) {
      if ($threshold<2) {
        $myresult = 1;
      } else {
        if (!isset($_SESSION["ccisec-" . $identifier . "-counter"])) {
          $_SESSION["ccisec-" . $identifier . "-counter"] = 1;
        } else {
          $_SESSION["ccisec-" . $identifier . "-counter"]++;
          if ($_SESSION["ccisec-" . $identifier . "-counter"] >= $threshold) {
            $myresult = 1;
          }
        }
      }
    }
    $_SESSION["ccisec-" . $identifier] = time();
  }
  return $myresult; 
}

################################################################################

srand(time());
if (eregi("ccisecurity\.php",$_SERVER["SCRIPT_NAME"])) exit();

if ($ccisessionpath != "") session_save_path($ccisessionpath);
session_name(md5($_SERVER["REMOTE_ADDR"] . $_SERVER["HTTP_HOST"] . "CCI"));

ini_set("session.use_only_cookies","1");
ini_set("session.use_trans_sid","0");

if (($zipcompress) && (eregi("gzip",$_SERVER["HTTP_ACCEPT_ENCODING"]))) {
  ini_set("zlib.output_compression","On");
  ini_set("zlib.output_compression_level",$compresslevel);
  ob_start("ob_gzhandler"); 
}
if ($javababble) {
  if ($javaencrypt) {
    $myalpha = array_merge(range("a","z"),range("A","Z"),range("0","9"));
    $myalpha2 = implode("",$myalpha);
    shuffle($myalpha);
    $mycrypto = implode("",$myalpha);
    setcookie(md5($_SERVER["REMOTE_ADDR"] . $_SERVER["SERVER_ADDR"]),$mycrypto);
    unset($myalpha);
  }
  ob_start("cciJavaBabble");
}

if (substr_count($_SERVER["SERVER_NAME"],".")>1) {
  $cookiedomain = eregi_replace("^[^\.]+\.",".",$_SERVER["SERVER_NAME"]);
} else $cookiedomain = "." . $_SERVER["SERVER_NAME"];

$ip = $_SERVER["REMOTE_ADDR"];
$mykeyname = md5($_SERVER["REMOTE_ADDR"] . $_SERVER["HTTP_HOST"] . $_SERVER["DOCUMENT_ROOT"] . "CCI");
$myposthashname = md5($_SERVER["REMOTE_ADDR"] . $_SERVER["HTTP_HOST"] . $_SERVER["PATH"] . "CCI");

$myhash = md5($_SERVER["REMOTE_ADDR"] . $_SERVER["HTTP_USER_AGENT"] . 
						$_SERVER["HTTP_HOST"] . $_SERVER["DOCUMENT_ROOT"] . 
						$_SERVER["SERVER_SOFTWARE"] . $_SERVER["PATH"] . "X");
											
$mysession = md5($_SERVER["REMOTE_ADDR"] . $_SERVER["HTTP_HOST"]);						
session_id($mysession);
session_start();

if (!isset($_SESSION["ccisec-errors"])) $_SESSION["ccisec-errors"] = 0;
if ($_SESSION["ccisec-errors"]>=10) {
  CCIBanIP($ip);
  exit();
}

if ($_SESSION["ccisec-myhash"] != $myhash) {		
  $_SESSION["ccisec-myhash"] = $myhash;
  $_SESSION["ccisec-errors"]++;
  session_write_close();
  Header("Location: http://" . $_SERVER["HTTP_HOST"] . $_SERVER["REQUEST_URI"]);
  exit();
}

if ((!isset($_COOKIE[$mykeyname])) || ($_COOKIE[$mykeyname] != $myhash)) {
  
  if (!isset($_SESSION["ccisec-nocookie"])) {
    $_SESSION["ccisec-nocookie"] = 1;
  } else {
    $_SESSION["ccisec-nocookie"]++;
  }
  
  if (($usehtaccessbans) && ($_SESSION["ccisec-nocookie"]>10)) CCIBanIP($ip);
    
  setcookie($mykeyname,$myhash,0,"/",$cookiedomain);
       
  if ($_SESSION["ccisec-nocookie"]>2) {
    echo "<b><h1>Access Denied</h1><br><br>You must enable cookies in order to access this website.  Please do so before returning, as continued attempts to access without cookies may result in a banning of this ip ($ip).</b>";
    session_write_close();
	exit();
  } 
  if ($extraGETprotection) {
    $_SESSION["ccisec-hash"] = md5(uniqid(time()));
    setcookie($myposthashname,$_SESSION["ccisec-hash"],0,"/",$cookiedomain);  
  } 
  CCIClearSession();  
  session_write_close();
  Header("Location: http://" . $_SERVER["HTTP_HOST"] . $_SERVER["REQUEST_URI"]);
  exit();
} else $_SESSION["ccisec-nocookie"] = 0;

if (($usehtaccessbans) && ($_SESSION["ccisec-fastaccesses"]>40)) CCIBanIP($ip);

if ($_SESSION["ccisec-fastaccesses"]>10) {
  if ((time()-60) < $_SESSION["ccisec-lastaccess"]) {
    echo "<b><h1>Access Denied</h1><br><br>There have been too many rapid requests from this IP address ($ip).  You must now wait a full 60 seconds before accessing this site again.</b>";
    $_SESSION["ccisec-fastaccesses"]++;
    $_SESSION["ccisec-lastaccess"]=time();
    exit();
  }
}

if (!isset($_SESSION["ccisec-lastaccess"])) {
  $_SESSION["ccisec-lastaccess"]=time();
} else {
  if ((time()-2) < $_SESSION["ccisec-lastaccess"]) {
    if (!isset($_SESSION["ccisec-fastaccesses"])) $_SESSION["ccisec-fastaccesses"] = 0;
    $_SESSION["ccisec-fastaccesses"]++;
  } else {
    $_SESSION["ccisec-fastaccesses"] = 0;
  }
  $_SESSION["ccisec-lastaccess"]=time();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {

  if ($checkmultiPOST) {
    if (($_SESSION["ccisec-lastoperation"] == "POST") && ($_SESSION["ccisec-opcount"] >= $maxmultiPOST)) {
      echo "<b><h1>Access Denied</h1><br><br>You may not make multiple POST operations in sequence - please return to the website and try again.</b>";
      $_SESSION["ccisec-errors"]++;
      exit(); 
    }
  }     

  if ($extraPOSTprotection) {
    if ((!isset($_COOKIE[$myposthashname])) || ($_COOKIE[$myposthashname] != $_SESSION["ccisec-hash"])) {
      echo "<b><h1>Access Denied</h1><br><br>Your browser did not send the correct security data needed to complete a POST operation.  Make sure that you have cookies enabled and then try again, or contact the administration if you feel you are receiving this message in error.</b>";
      $_SESSION["ccisec-errors"]++;
      exit();
    }
  }
} else if (($extraGETprotection) && ($_SERVER["REQUEST_METHOD"] == "GET")) {
  if ((!isset($_COOKIE[$myposthashname])) || ($_COOKIE[$myposthashname] != $_SESSION["ccisec-hash"])) {
    echo "<b><h1>Access Denied</h1><br><br>Your browser did not send the correct security data needed to complete a GET operation.  Make sure that you have cookies enabled and then try again, or contact the administration if you feel you are receiving this message in error.</b>";
    $_SESSION["ccisec-errors"]++;
    exit();
  }
} else if ($_SERVER["REQUEST_METHOD"] != "GET") {
  exit();
}

if (($extraPOSTprotection) || ($extraGETprotection)) {
  srand(time());
  $_SESSION["ccisec-hash"] = md5(uniqid(time()));
  setcookie($myposthashname,$_SESSION["ccisec-hash"],0,"/",$cookiedomain);
}

if ($_SESSION["ccisec-lastoperation"] == $_SERVER["REQUEST_METHOD"]) {
  if (!isset($_SESSION["ccisec-opcount"])) {
    $_SESSION["ccisec-opcount"] = 1;
  } else {
    $_SESSION["ccisec-opcount"]++;
  }
} else $_SESSION["ccisec-lastoperation"] = $_SERVER["REQUEST_METHOD"];

# Make special characters safe in any GET based cgi variables.

if ($filterGETvars) {
  $getvariables = array_keys($_GET);
  $count = 0;
  while($count < count($getvariables)) {
    $_GET[$getvariables[$count]] = htmlspecialchars($_GET[$getvariables[$count]]);
    if (ini_get('register_globals')) $$getvariables[$count] = $_GET[$getvariables[$count]];
    $count++;
  }
}

if ($filterPOSTvars) {
  $getvariables = array_keys($_POST);
  $count = 0;
  while($count < count($getvariables)) {
    $_POST[$getvariables[$count]] = htmlspecialchars($_POST[$getvariables[$count]]);
    if (ini_get('register_globals')) $$getvariables[$count] = $_POST[$getvariables[$count]];
    $count++;
  }
}

if ($filterCOOKIEvars) {
  $getvariables = array_keys($_COOKIE);
  $count = 0;
  while($count < count($getvariables)) {
    $_COOKIE[$getvariables[$count]] = htmlspecialchars($_COOKIE[$getvariables[$count]]);
    if (ini_get('register_globals')) $$getvariables[$count] = $_COOKIE[$getvariables[$count]];
    $count++;
  }
}

if ($cpuloadmonitor) {
  $myshelldata = shell_exec("uptime");
  $myshelldata = eregi_replace(".*average.*: ","",$myshelldata);
  $myshelldata = eregi_replace(", .*","",$myshelldata);
  if ($myshelldata >= $cpumaxload) {
    echo "<b><h1>Access Denied</h1><br><br>The server is currently too busy to serve your request.  We apologize for the inconvenience.</b>";  
    exit();
  }
  unset($myshelldata);
}

unset($count);
unset($getvariables);
unset($ip);
unset($cookiedomain);
unset($mykeyname);
unset($myposthashname);
unset($myhash);
unset($mysession);

$_SESSION["ccisec-errors"] = 0;
if (connection_aborted()) exit();

?>