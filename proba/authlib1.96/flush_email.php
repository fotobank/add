<?

require("backend.php");

if ($authlib->email_flush() == 2) echo " accounts flushed";

else echo "flushing was unsuccessful";

?>