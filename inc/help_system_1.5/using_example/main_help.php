<?php
require_once '../lib_help_system.php';
$o_help = new Help_System($cfg_name);
echo '
<script language="javascript">
  self.focus();
</script>

<h1>Help System</h1>
<table align="center" border="1" width="98%">
<tr>
<td valign="top" nowrap="nowrap" width="150">
'.$o_help->get_sections($main_help_id).'
</td>
<td valign="top">
'.$o_help->get_content($main_help_id).'
</td>
</tr>
</table>
';
?>
