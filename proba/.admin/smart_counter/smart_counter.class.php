<?php

// ----------------------------------------------------------------------------
Этот класс может быть использована для подсчета количества посетителю сайта с помощью таблицы базы данных MySQL. Он может отслеживать общее посетителей сайта, посетители данной страницы, посетители в текущий день и активных посетителей (доступ в последние 5 минут). посещений пользователей одного и того же IP-адреса регистрируются только после окончания определенного периода времени (по умолчанию 20 минут). visitis статистика хранится в двух таблицах базы данных MySQL с настраиваемыми именами. Класс также может создавать эти таблицы, если они еще не существуют.
// Requirements: PHP 4, MySQL
//
// ----------------------------------------------------------------------------


class smart_counter
{

  var $db_server;
  var $db_username;
  var $db_password;
  var $db_name;
  var $db_main_table;
  var $db_users_table;
  var $db_link;
  var $current_page;
  var $ip_addr;
  var $inc_interval;
  var $inc_total;

  function smart_counter()
  {
    $this->db_server = 'localhost';
    $this->db_username = 'root';
    $this->db_password = '';
    $this->db_name = 'smart_counter';
    $this->db_main_table = 'sc_main';
    $this->db_users_table = 'sc_users';
    $this->current_page = realpath(basename($_SERVER['PHP_SELF']));
    $this->current_page = str_replace('\\', '/', $this->current_page);
    $this->ip_addr = $_SERVER['REMOTE_ADDR'];
    $this->inc_interval = 1200;
    $this->inc_total = TRUE;
  }

  function update_counter($auto_connect = TRUE)
  {
    if ($auto_connect)
    {
      $this->db_link = mysql_connect($this->db_server, $this->db_username,
        $this->db_password) or die(mysql_error());
      mysql_select_db($this->db_name, $this->db_link) or die(mysql_error());
    }
    $this->install_tables();
    $this->update_users();
    if ($this->inc_total)
    {
      $this->inc_page_hits(TRUE);
    }
    $this->inc_page_hits(FALSE);
  }

  function get_total_visits()
  {
    $result = mysql_query("SELECT sc_count FROM $this->db_main_table
      WHERE sc_name = 'total'", $this->db_link) or die(mysql_error());
    return mysql_result($result, 0, 0);
  }

  function get_page_visits()
  {
    $result = mysql_query("SELECT sc_count FROM $this->db_main_table
      WHERE sc_name = '$this->current_page'", $this->db_link)
      or die(mysql_error());
    return mysql_result($result, 0, 0);
  }

  function get_today_visits()
  {
    list($month, $day, $year) = explode('|', date('m|d|Y'));
    $day_start = mktime(0, 0, 0, $month, $day, $year);
    $result = mysql_query("SELECT COUNT(*) FROM $this->db_users_table
      WHERE sc_time >= $day_start", $this->db_link) or die(mysql_error());
    return mysql_result($result, 0, 0);
  }

  function get_active_visits($interval = 300)
  {
    $count_from = time() - $interval;
    $result = mysql_query("SELECT COUNT(*) FROM $this->db_users_table
      WHERE sc_time >= $count_from", $this->db_link) or die(mysql_error());
    return mysql_result($result, 0, 0);
  }

  function get_latest_visitors()
  {
    $result = mysql_query("SELECT sc_ip, sc_time, sc_location
      FROM $this->db_users_table ORDER BY sc_time DESC", $this->db_link)
      or die(mysql_error());
    $visitors = array();
    while ($row = mysql_fetch_assoc($result))
    {
      $ip = $row['sc_ip'];
      $visitors[$ip]['host'] = gethostbyaddr($ip);
      $visitors[$ip]['time'] = $row['sc_time'];
      $visitors[$ip]['location'] = $row['sc_location'];
    }
    return $visitors;
  }

  function install_tables()
  {
    $found_main = $found_users = FALSE;
    $result = mysql_query('SHOW TABLES', $this->db_link) or die(mysql_error());
    while ($row = mysql_fetch_array($result))
    {
      if (strtoupper($this->db_main_table) == strtoupper($row[0]))
      {
        $found_main = TRUE;
      }
      elseif (strtoupper($this->db_users_table) == strtoupper($row[0]))
      {
        $found_users = TRUE;
      }
      if ($found_main && $found_users)
      {
        break;
      }
    }
    if (!$found_main)
    {
      mysql_query("CREATE TABLE $this->db_main_table(
        sc_name VARCHAR(255) NOT NULL,
        sc_count INT UNSIGNED NOT NULL DEFAULT 0,
        PRIMARY KEY(sc_name)
      )", $this->db_link) or die(mysql_error());
    }
    if (!$found_users)
    {
      mysql_query("CREATE TABLE $this->db_users_table(
        sc_ip CHAR(16) NOT NULL,
        sc_time INT UNSIGNED NOT NULL,
        sc_location VARCHAR(255) NOT NULL DEFAULT '',
        PRIMARY KEY(sc_ip)
      )", $this->db_link) or die(mysql_error());
    }
  }

  function update_users()
  {
    $now = time();
    $day_start = $now - 86400;
    mysql_query("DELETE FROM $this->db_users_table WHERE sc_time < $day_start",
      $this->db_link) or die(mysql_error());
    $current_page = $this->current_page;
    $current_page = addslashes($current_page);
    $result = mysql_query("SELECT sc_time FROM $this->db_users_table
      WHERE sc_ip = '$this->ip_addr'", $this->db_link) or die(mysql_error());
    if (!mysql_num_rows($result))
    {
      mysql_query("INSERT INTO $this->db_users_table (sc_ip, sc_time, sc_location)
        VALUES ('$this->ip_addr', $now, '$current_page')", $this->db_link)
        or die(mysql_error());
      $this->inc_total = TRUE;
    }
    else
    {
      $last_time = mysql_result($result, 0, 0);
      $this->inc_total = (($now - $last_time) > $this->inc_interval);
      mysql_query("UPDATE $this->db_users_table SET sc_time = $now,
        sc_location = '$current_page' WHERE sc_ip = '$this->ip_addr'",
        $this->db_link) or die(mysql_error());
    }
  }

  function inc_page_hits($is_total)
  {
    $page = ($is_total ? 'total' : $this->current_page);
    $page = addslashes($page);
    $result = mysql_query("SELECT sc_count FROM $this->db_main_table
      WHERE sc_name = '$page'", $this->db_link) or die(mysql_error());
    if (!mysql_num_rows($result))
    {
      mysql_query("INSERT INTO $this->db_main_table(sc_name, sc_count)
        VALUES('$page', 1)", $this->db_link) or die(mysql_error());
    }
    else
    {
      $new_count = mysql_result($result, 0, 0) + 1;
      mysql_query("UPDATE $this->db_main_table SET sc_count = $new_count
        WHERE sc_name='$page'", $this->db_link) or die(mysql_error());
    }
  }

}

?>