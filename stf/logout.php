 <?
   session_start();
   if (isset($_SESSION['user'])) {
   // ������� ������� "user"
      unset($_SESSION['user']);
   }
   if (isset($_SERVER['HTTP_REFERER'])) {
      header ("location: ".$_SERVER['HTTP_REFERER']);
   }else {
      header ("location: index.php");
   }
?> 