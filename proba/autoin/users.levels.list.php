<?php
require('inc/header.inc.php');
require('inc/admin.auth.inc.php');
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">

<html>
<head>
	<title></title>
 <LINK REL="StyleSheet" HREF="inc/admin.css" type="text/css">
</head>
<body>

<table class="listlines" cellspacing="0" cellpadding="0">
  <tr>
    <td class="listlines">
      <table width="100%" cellspacing="1" cellpadding="0">
        <tr>
          <td class="mainheader" colspan="4"><a href="users.levels.new.php"><img src="images/icons/add.gif" align="absmiddle" alt="" border="0" align="absmiddle"></a>&nbsp;&nbsp;User Levels</td>
        </tr>
        <?=$SZUserMgnt->getLevelList()?>
        <tr>
          <td colspan="4" class="listfooter">
            <a href="users.list.php">Administration</a> | <a href="users.levels.list.php">Security Levels</a> | <a href="settings.php">Settings</a>
          </td>
        </tr>
        <tr>
          <td colspan="9" class="listheader" align="center"><a href="http://www.seduction747.com/SZUserMgnt" target="_blank">Powered by SZUserMgnt 1.2</a></td>
        </tr>
      </table>
    </td>
  </tr>
</table>
</body>
</html>