<?php

error_reporting(E_ALL);

include("gLogin.php");

$login = new gLogin('post');



/*
**	This must come first, before the safeSend function
**	call
*/



if ($login->isFormSubmited()) {
        /*
         * This is only an example, replace it by ur original
         * table value.
         */

	$db = mysql_connect('localhost','root','');

	mysql_select_db('db');

	

	$sql = mysql_query("select * from username where usrName = '".$login->getValue( 'uname' )."'",$db) or die(mysql_error($db));

	if (mysql_num_rows($sql) == 0) {

		/* User doesn't exist */ 

		$m = "User Doesn't exist";

	} else {

		$row = mysql_fetch_array($sql);

		if ( !$login->match('pword', $row['usrPass']) ) {

			$m = "Passwods missmatch";

		} else {

			/*
			**	User login!, do something here for do the login
			*/

			$m = "welcome";

		}

	}

}

$login->safeSend('uname');

$login->safeSend('pword', true);







?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">

<html xmlns="http://www.w3.org/1999/xhtml" >

<head profile="http://gmpg.org/xfn/11">

    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />

    <title>Test</title>

    <script type="text/javascript" src="md5.js"></script>


</head>

<body>

    <?

		if (isset($m)) echo '<script>alert("'.$m.'");</script>';

	?>
<center><h1>Testing Cesar D. Rodas gLogin</h1>
</center>
    <div id = 'mbody'>

        <div  id = 'loginbox' class='loginbox'>

            <form action = "glogin.test.php" onsubmit="<?=$login->onsubmit()?>" method ="post">

            <?=$login->Js();?>

            <table cellspacing=6>

                <tr> 

                    <td>Username<br /><input type='text' id = 'uname' /></td>

                </tr>

                <tr>

                    <td>Password<br /><input type='password' id = 'pword' /></td>

                </tr>

                <tr>

                    <td colspan=2 align=center><input type=submit value='Login'></td>

                </tr>


            </table>

            </form

        ></div>

    </div>

</body>