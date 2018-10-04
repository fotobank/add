<?

require("backend.php");

if ($authlib->conf_flush() == 2) echo " accounts flushed";

else echo "flushing was unsuccessful";

?>