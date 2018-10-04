<?php

  // Include the class source.
  require_once 'private_sessions.class.php';

  // Create an object.
  $ps = new private_sessions();

  // Store session data in MySQL database.
  $ps->save_to_db = true;

  // MySQL access parameters.
  $ps->db_host = 'localhost';
  $ps->db_uname = 'root';
  $ps->db_passwd = '';
  $ps->db_name = 'test';

  // The name of the table used to save session data.
  $ps->save_table = 'mysessions';

  // Optionally create the table if not created.
  $ps->install_table();

  // Set up session handlers.
  $ps->set_handler();

  // That's all! Proceed to use sessions normally.
  session_start();
  echo $_SESSION['foo'] = 'Hi there!';

?>