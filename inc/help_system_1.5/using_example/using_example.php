<?php
$mobj->write_hf = 0;
require_once '../lib_help_system.php';
$help = new Help_System('help_config.php');
echo '
'.$help->get_main_href().'Example of main help</a>
<p />
Example of context help #1:
'.$help->get_context_href('h1').'
<br />
Example of context help #2:
'.$help->get_context_href('h2');
?>