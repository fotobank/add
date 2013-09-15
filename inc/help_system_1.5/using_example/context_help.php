<?php
require_once '../lib_help_system.php';
$o_help = new Help_System($cfg_name);
$help = $o_help->get_context_content($context_help_id, '');
echo '
<script language="javascript">
  self.focus();
</script>

<b>'.$help->header.'</b><hr size="1" />'.$help->body;
?>