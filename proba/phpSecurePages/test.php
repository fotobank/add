<?PHP
        $cfgProgDir = 'phpSecurePages/';
        include($cfgProgDir . "secure.php");
?>

<HTML><HEAD>
<TITLE>Test 1</TITLE>
</HEAD>

<BODY style="font-family:arial;font-size:16px;">
<h1>TEST PAGE 1</h1>
<P>This is phpSecurePages test page 1.</P>



<P><FONT COLOR="Gray">Go to test page 1</FONT><BR>
<A HREF="test2.php">Go to test page 2</A><BR>
<A HREF="test3.php">Go to test page 3</A></P>
<P><A HREF="logout.php">LogOut</A></P>

<P><TABLE>
<tr><td colspan=2><u>Variables available to your scripts on this page</u></td></tr>
<TR><TD>login:      </TD><TD><?PHP echo $login ?>    </TD></TR>
<TR bgcolor="#c2c2c2"><TD>password:   </TD><TD><?PHP echo $password ?> </TD></TR>
<TR><TD>user level: </TD><TD><?PHP echo $userLevel ?></TD></TR>
<TR bgcolor="#c2c2c2"><TD>ID:         </TD><TD><?PHP echo $ID ?>       </TD></TR>
</TABLE></P>
</BODY></HTML>
