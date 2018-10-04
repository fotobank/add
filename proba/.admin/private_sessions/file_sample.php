<?php

  // Include the class source.
  require_once 'private_sessions.class.php';

  // Create an object.
  $ps = new private_sessions();

  // Store session data in disk files.
  $ps->save_to_db = false;

  // The path of the directory used to save session data. No trailing slashes.
  $ps->save_path = realpath('.') . '/ps_sess_tmp';

  // Set up session handlers.
  $ps->set_handler();

  // That's all! Proceed to use sessions normally.
  session_start();
  echo $_SESSION['foo'] = 'Hi there!';

?>