<?php

  // Include class definition
  require_once('smart_counter.class.php');

  $sc = new smart_counter();
  $sc->inc_interval = 1200; // 20 minutes

  // Update counter values with in-class autoconnection enabled
  $sc->db_server = 'localhost';
  $sc->db_username = 'root'; // the user must have permissions to create tables
  $sc->db_password = '';
  $sc->db_name = 'smart_counter'; // should exist
  $sc->db_main_table = 'sc_main'; // will be created automatically
  $sc->db_users_table = 'sc_users'; // will be created automatically
  $sc->update_counter();

/*
  Following code can be used if you want to connect the db by your own...

  $link_id = mysql_connect('localhost', 'root', '') or die(mysql_error());
  mysql_select_db('smart_counter') or die(mysql_error());

  $sc->db_name = 'smart_counter';
  $sc->db_main_table = 'sc_main';
  $sc->db_users_table = 'sc_users';
  $sc->db_link = $link_id;
  $sc->update_counter(FALSE);
*/

  echo sprintf('Total visits: %d<br />', $sc->get_total_visits());
  echo sprintf('Visits on this page: %d<br />', $sc->get_page_visits());
  echo sprintf('Today visits: %d<br />', $sc->get_today_visits());
  echo sprintf('Online users: %d<br /><br />', $sc->get_active_visits(300));

  $lv = $sc->get_latest_visitors();
  foreach ($lv as $ip=>$info)
  {
    echo $ip . ' ';
    echo $info['host'] . ' ';
    echo date('F j, Y [H:i:s]', $info['time']) . ' ';
    echo $info['location'] . '<br /><br />';
  }

?>