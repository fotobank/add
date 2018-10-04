<?php
/*
 * SZUserMgnt :: Smart User Mgnt System. Version 1.2
 * Copyright (C) 2002-2003 Andreas Norman. All rights reserved.
 * 
 * THIS SOFTWARE IS PROVIDED ``AS IS'' AND ANY EXPRESS OR IMPLIED
 * WARRANTIES, INCLUDING, BUT NOT LIMITED TO, THE IMPLIED WARRANTIES OF
 * MERCHANTABILITY AND FITNESS FOR A PARTICULAR PURPOSE ARE DISCLAIMED.
 * IN NO EVENT SHALL THE AUTHOR OR CONTRIBUTORS BE LIABLE FOR ANY DIRECT,
 * INDIRECT, INCIDENTAL, SPECIAL, EXEMPLARY, OR CONSEQUENTIAL DAMAGES
 * (INCLUDING, BUT NOT LIMITED TO, PROCUREMENT OF SUBSTITUTE GOODS OR
 * SERVICES; LOSS OF USE, DATA, OR PROFITS; OR BUSINESS INTERRUPTION)
 * HOWEVER CAUSED AND ON ANY THEORY OF LIABILITY, WHETHER IN CONTRACT,
 * STRICT LIABILITY, OR TORT (INCLUDING NEGLIGENCE OR OTHERWISE) ARISING
 * IN ANY WAY OUT OF THE USE OF THIS SOFTWARE, EVEN IF ADVISED OF THE
 * POSSIBILITY OF SUCH DAMAGE.
 * 
 * This software is FREE FOR NON-COMMERCIAL USE, provided the following 
 * conditions are met:
 * 
 * The user must assume the entire risk of using this program.
 * 
 * You are hereby granted a license to to use and distribute this 
 * program in its original unmodified form and in the original 
 * distribution package. You can make as many copies as you want, 
 * and distribute it via electronic means. There is no fee for
 * any of the above.
 * 
 * You are specifically prohibited from charging, or requesting
 * donations, for any such copies, however made; and from distributing
 * the software and/or documentation with other products (commercial or
 * otherwise) without prior written permission.
 * 
 * * * * * * * * * * * * * * * * * * * * *
 * Requirements: MySQLHandler.class.php  *
 *               SZMail.class.php        *
 * * * * * * * * * * * * * * * * * * * * *
 */

class SZUserMgnt {  

  var $sql;

  var $TABLES = array (
                  'sessions'    =>  'sessions',
                  'users'       =>  'users',
                  'user_levels' =>  'user_levels',
                  'szusermgnt'  =>  'szusermgnt'
  );

  var $EXPIRY = 2880;
  var $COOKIE_EXPIRY = 604800; // 7 days in seconds

  var $ERROR_MSG = '';
  var $MSG = '';
  var $PER_PAGE = 15;
  var $num_rows;
  var $classname;
  var $num_pages;
  
  var $USERNAME;
  var $USER_ID;
  var $LEVEL;
  var $SZMail;
  
  var $REALM = "Private Area";
  var $AUTH_MSG = "You must enter a valid login ID and password to access this resource\n";
  
  

  function SZUserMgnt($sql, $SZMail) {
    $this->sql = $sql;
    $this->SZMail = $SZMail;
  }
  
  function getPreferences() {
    return $this->sql->Select("SELECT * FROM ".$this->TABLES['szusermgnt']."");
  }
  
  function getSelectListLevels($level = false) {
    $data = $this->sql->Select("SELECT id, level, level_name FROM ".$this->TABLES['user_levels']."");
    $str = '<select name="level">';
    for ($i=0;$i < count($data);++$i) {
      if ($level && $data[$i]['id'] == $level) {
      	$str .= '<option value="'.$data[$i]['id'].'" selected>'.$data[$i]['level'].' - '.$data[$i]['level_name'].'</option>';
      } else {
      	$str .= '<option value="'.$data[$i]['id'].'">'.$data[$i]['level'].' - '.$data[$i]['level_name'].'</option>';
      }
    }
    $str .= '</select>';
    return $str;  
  }
  
  function setPreferences($pwd_remind_header, $pwd_remind_body, $new_account_header, $new_account_body, $mail_sender_name, $mail_sender_email) {
    $this->sql->Update("UPDATE ".$this->TABLES['szusermgnt']." SET pwd_remind_header = '".addslashes($pwd_remind_header)."', pwd_remind_body = '".addslashes($pwd_remind_body)."', new_account_header = '".addslashes($new_account_header)."', new_account_body = '".addslashes($new_account_body)."', mail_sender_name = '".addslashes($mail_sender_name)."', mail_sender_email = '".addslashes($mail_sender_email)."'");
    return true;
  }

  function setStatus($ID, $status) {
    $this->sql->Update("UPDATE ".$this->TABLES['users']." SET active = $status WHERE id = $ID");
    return true;
  }
  
  function getUsersAmount() {
    $rows = $this->sql->Select("SELECT COUNT(*) as num FROM ".$this->TABLES['users']."");
    return $rows[0]["num"];
  }
  
  function getUser($ID) {
    return $this->sql->Select("SELECT * FROM ".$this->TABLES['users']." WHERE id = $ID");
  }
  
  function getUserList($page = false) {
    $sql_text = "SELECT l.level_name, u.id, u.register_date, u.last_logged_in, u.username, u.email, u.active FROM ".$this->TABLES['users']." u, ".$this->TABLES['user_levels']." l WHERE l.id = u.level ORDER BY u.username";
    if (!$page) {  
      $page = 1;  
    } 

    $page_start = ($this->PER_PAGE * $page) - $this->PER_PAGE;  
    $num_pages = $this->getNumPages($this->getUsersAmount());
    if (($page > $num_pages) || ($page < 0)) {  
      $page = 1;
    }
    
    $sql_text = $sql_text . " LIMIT ".$page_start.", ".$this->PER_PAGE."";
    $data = $this->sql->Select($sql_text);
    $i=0;
    $len = count($data);

    $str ='<tr>'."\n";

    if ($page > 1)  { 
      $str .= '   <td class="icon_darkbg"><a href="?page='.($page - 1).'"><img src="images/icons/prev.gif" align="absmiddle" alt="" border="0"></a></td>'."\n";
    } else {
      $str .= '   <td class="icon_darkbg"><img src="images/icons/prev_na.gif" align="absmiddle" alt="" border="0"></td>'."\n";        
    }
    if ($page != $num_pages) {
      $str .= '   <td class="icon_darkbg"><a href="?page='.($page + 1).'"><img src="images/icons/next.gif" align="absmiddle" alt="" border="0"></a></td>'."\n";
    } else {
      $str .= '   <td class="icon_darkbg"><img src="images/icons/next_na.gif" align="absmiddle" alt="" border="0"></td>'."\n";
    }

    $str .='
          <td class="listheader">Username</td>
          <td class="listheader">Email</td>
          <td class="listheader">Register Date</td>
          <td class="listheader">Last Logged In</td>
          <td class="listheader">Security Level</td>
          <td class="listheader" colspan="3"></td>
        </tr>
    ';
    for ($i=0; $i< $len; $i++) {
      if ($this->classname == 'lightbg') {
        $this->classname = 'darkbg';
      } else {
        $this->classname = 'lightbg';
      }
      $str .='
        <tr>';
          if ($data[$i]['id'] != 1) {
            $str .='<td class="icon_'.$this->classname.'"><a href="users.delete.php?ID='.$data[$i]['id'].'"><img src="images/icons/remove.gif" align="absmiddle" alt="" border="0"></a></td>';
          } else {
            $str .='<td class="icon_'.$this->classname.'"></td>';
          }
          $str .='
          <td class="icon_'.$this->classname.'"><a href="users.edit.php?ID='.$data[$i]['id'].'"><img src="images/icons/edit.gif" align="absmiddle" alt="" border="0"></a></td>
          <td class="'.$this->classname.'">'.$data[$i]['username'].'</td>
          <td class="'.$this->classname.'"><a href="mailto:'.$data[$i]['email'].'">'.$data[$i]['email'].'</a></td>
          <td class="'.$this->classname.'">'.$this->FormatDate("Y-m-d H:i", $data[$i]['register_date']).'</td>
          <td class="'.$this->classname.'">'.$this->FormatDate("Y-m-d H:i", $data[$i]['last_logged_in']).'</td>
          <td class="'.$this->classname.'">'.$data[$i]['level_name'].'</td>
          <td class="icon_'.$this->classname.'"><a href="users.password_edit.php?ID='.$data[$i]['id'].'"><img src="images/icons/password_change.gif" alt="" width="19" height="19" border="0"></a></td>
          ';
          if ($data[$i]['id'] != 1) {
            if ($data[$i]['active'] == 1) { 
              $str .='<td class="icon_'.$this->classname.'"><a href="users.activate.php?ID='.$data[$i]['id'].'&status=0"><img src="images/icons/active.gif" align="absmiddle" alt="" border="0"></a></td>';
            } else {
              $str .='<td class="icon_'.$this->classname.'"><a href="users.activate.php?ID='.$data[$i]['id'].'&status=1"><img src="images/icons/inactive.gif" align="absmiddle" alt="" border="0"></a></td>';
            }
          } else {
            $str .='<td class="icon_'.$this->classname.'"></td>';
          }
     $str .='
        </tr>
      ';
    }
    return $str;
  }


  function http_authenticate() {
    if (!isset($_SERVER['PHP_AUTH_USER']) || ($_POST['SeenBefore'] == 1 && $_POST['OldAuth'] == $_SERVER['PHP_AUTH_USER'])) {
      header('WWW-Authenticate: Basic realm="'.$this->REALM.'"');
      header('HTTP/1.0 401 Unauthorized');
      echo $this->AUTH_MSG;
      exit;
    } else {
      echo 'http_authenticate is notsupported!';
    }
  }

  function login($username, $password, $rememberMe) {
    if (!$username || !$password) {
      $this->appendError("You forgot to write user name and/or password");
    } else {
      if ($data = $this->sql->Select("SELECT u.username, u.id, l.level FROM ".$this->TABLES['users']." u, ".$this->TABLES['user_levels']." l WHERE u.level = l.id AND u.username = '".strtolower($username)."' AND u.password = '".md5(strtolower($password))."' AND u.active = 1")) {
        $this->USERNAME = $data[0]['username'];
        $this->USER_ID = $data[0]['id'];
        $this->LEVEL = $data[0]['level'];
        $this->setSessionVariables($rememberMe);
        $this->sql->Update("UPDATE ".$this->TABLES['users']." SET last_logged_in = NOW()+1 WHERE id = ".$this->USER_ID."");
        return true;
      } else {
        $this->appendError("Wrong user name and/or password!");
        return false;
      }
    }
  }
  
  function removeSessionData() {
    $this->sql->Delete("DELETE FROM ".$this->TABLES['sessions']." WHERE user_id = ".$this->USER_ID);
  }
  
  function setSessionVariables($rememberMe) {
    if ($rememberMe) {
      setcookie ("usernamecookie", md5(strtolower($this->USERNAME)),time()+$this->COOKIE_EXPIRY);
    }
    session_start();
    $_SESSION["SESS_username"] = $this->USERNAME;
    $_SESSION["SESS_user_id"] = $this->USER_ID;
    $_SESSION["SESS_level"] = $this->LEVEL;
    $PHPSESSID=session_id();  
    $this->removeSessionData();
    $this->sql->Insert("INSERT INTO sessions (sesskey, expiry, user_id) VALUES ('".session_id()."', ".(time() + $this->EXPIRY).", ".$this->USER_ID.")");
  }
  
  function isCorrectPassword($username, $password) {
    if ($this->sql->Select("SELECT COUNT(*) FROM ".$this->TABLES['users']." WHERE username = '".strtolower($username)."' AND  password = '".md5(strtolower($password))."'")) {
      $this->appendError("Wrong user name and/or password!");
      return true;
    } else {
      return false;
    }
  }
  
  function addUser($username, $email, $password, $confirm_password, $generate_password, $level) {
    if ($generate_password) {
      $password = $this->generatePassword(6);
    } else {
      if (!$this->isValidPassword($password, $confirm_password)) {
        return false;
      }
    }
    if ($this->isValidUserName($username) && $this->isValidEmail($email)) {
      if ($user_id = $this->sql->Insert("INSERT INTO ".$this->TABLES['users']." (username, email, password, register_date, level) VALUES ('".$username."', '".$email."', '".md5(strtolower($password))."', NOW()+1, $level)")) {
        $prefs = $this->getPreferences();
        $body = str_replace('[PASSWORD]', $password, $prefs[0]['new_account_body']);
        $body = str_replace('[USERNAME]', $username, $body);
        $this->SZMail->write($prefs[0]['new_account_header'], $body, $prefs[0]['mail_sender_name'], $prefs[0]['mail_sender_email'], $email, 3, 0, 0, 0);
        $this->SZMail->send();
        return $user_id;
      } else {
        $this->appendError("SQL: Failed to create user!");
        return false;
      }
    } else {
      $this->appendError("Failed to create user!");
      return false;
    }
  }
  
  function removeUser($user_id) {
    $this->sql->Delete("DELETE FROM ".$this->TABLES['users']." WHERE id = $user_id");
    return true;
  }
  
  function updateUser($user_id, $username, $email, $level) {
    $this->sql->Update("UPDATE ".$this->TABLES['users']." SET username = '".$username."', email = '".strtolower($email)."', level = $level WHERE id = $user_id");
    return true;
  }
  
  function setPassword($user_id, $new_password, $confirm_password, $generate_password) { 
    if ($generate_password) { 
      $new_password = $this->generatePassword(6); 
    } else { 
      if (!$this->isValidPassword($new_password, $confirm_password)) { 
        return false; 
      } 
    } 
    if ($this->sql->Update("UPDATE ".$this->TABLES['users']." SET password = '".md5(strtolower($new_password))."' WHERE id = $user_id")) { 
      $user = $this->getUser($user_id); 
      $prefs = $this->getPreferences(); 
      $body = str_replace('[PASSWORD]', $new_password, $prefs[0]['pwd_remind_body']); 
      $body = str_replace('[USERNAME]', $user[0]['username'], $body); 
      $this->SZMail->write($prefs[0]['pwd_remind_header'], $body, $prefs[0]['mail_sender_name'], $prefs[0]['mail_sender_email'], $user[0]['email'], 3, 0, 0, 0); 
      $this->SZMail->send(); 
      return true; 
    } else { 
      $this->appendError("Unable to change password!"); 
      return false; 
    } 
  } 
  
  function updatePassword($user_id, $old_password, $new_password, $confirm_password) {
    if ($this->isCorrectPassword($username, $old_password)) {
      if ($this->isValidPassword($new_password, $confirm_password)) {
        if ($this->sql->Update("UPDATE ".$this->TABLES['users']." SET password = '".md5(strtolower($new_password))."' WHERE id = $user_id")) {
          return true;
        } else {
          $this->appendError("Unable to change password!");
          return false;
        }
      } else {
        return false;
      }
    } else {
      return false;
    }
  }
  
  function isValidEmail($email) {
  	if (!eregi("^([a-zA-Z0-9\._\-]+)@([a-zA-Z0-9\._\-]+)\\.([a-zA-Z]+)$", $email)) {
  		$this->appendError("Invalid email address!");
  		return false;
  	} else {
  		return true;
  	}
  }
  
  function isValidPassword($password, $confirm_password) {
  	if (strlen($password) < 6) {
  		$this->appendError("Password must be 6 characters or more!");
  		return false;
  	} else {
      if ($password != $confirm_password) {
        $this->appendError("Password mismatch!");
        return false;
      } else {
        return true;
      }
    }
  }  
  
  function isValidUserName($username) {
  	if (strrpos($username,' ') > 0) {
  		$this->appendError("No spaces are permitted in your username!");
  		return false;
  	} else {
    	if (strspn($username,"abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ") == 0) {
    		$this->appendError("The username must contain letters!");
    		return false;
    	} else {
      	if (strspn($username,"abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789-_")!= strlen($username)) {
      		$this->appendError("Illigal characters in username!");
      		return false;
      	} else {
        	if (strlen($username) < 3) {
        		$this->appendError("Username must contain 3 characters or more!");
        		return false;
        	} else {
          	if (strlen($username) > 12) {
          		$this->appendError("Username must contain less than 12 characters!");
          		return false;
          	} else {
            	if (eregi("^((root)|(bin)|(daemon)|(adm)|(lp)|(sync)|(shutdown)|(halt)|(mail)|(news)|(uucp)|(operator)|(games)|(mysql)|(httpd)|(nobody)|(dummy)|(webmaster)|(admin)|(administrator)|(funkymusic)|(www)|(shell)|(ftp)|(irc)|(ns)|(download))$",$username)) {
            		$this->appendError("Username reserved");
            		return false;
            	} else {
                if ($this->sql->Select("SELECT id FROM ".$this->TABLES['users']." WHERE username = '".$username."'")) {
                  $this->appendError("Username already exists");
                  return false;
                } else {
                  return true;
                }
              }
            }
          }
        }
      }
    }
  }
  
  function generatePassword($limit=6) { 
    for($i=0; $i<$limit; $i++) { 
      $pass[$i] = rand(0,1) ? chr(rand(48,57)) : chr(rand(65,90));
    } 
    shuffle($pass); 
    return implode("",$pass); 
  } 
  
  function clearExpiredSessions() {
    $this->sql->Delete("DELETE FROM ".$this->TABLES['sessions']." WHERE expiry < '".time()."'");
  }

  function updateSessionData($PHPSESSID) {
    $this->clearExpiredSessions();
    $this->sql->Update("UPDATE ".$this->TABLES['sessions']." SET expiry = '".(time() + $this->EXPIRY)."' WHERE sesskey = '".$PHPSESSID."'");
  }
  
  function rememberMe() {
    if (isset($_COOKIE["usernamecookie"]) && $data = $this->sql->Select("SELECT * FROM ".$this->TABLES['users']." WHERE MD5(LCASE(username)) = '".$_COOKIE["usernamecookie"]."'")) {
      $this->USERNAME = $data[0]['username'];
      $this->USER_ID = $data[0]['id'];
      $this->LEVEL = $data[0]['level'];
      $this->setSessionVariables(true);
      return true;
    } else {
      $this->appendError('Cannot remember you..');
      return false;
    }
  }

  function logout($PHPSESSID) {
    $this->sql->Delete("DELETE FROM ".$this->TABLES['sessions']." WHERE sesskey = '".$PHPSESSID."'");
    session_destroy();
    $_SESSION = array();
    session_unset();
    setcookie("usernamecookie", "",time()+$this->COOKIE_EXPIRY);
    $this->appendMsg("You have been logged out!");
    return true;
  }
  
  function getLevelInfo($ID) {
    return $this->sql->Select("SELECT * FROM ".$this->TABLES['user_levels']." WHERE id = $ID");
  }
  
  function addLevel($level, $level_name) {
    if (!empty($level) && $level>0 && !empty($level_name)) {
      if ($this->sql->Insert("INSERT INTO ".$this->TABLES['user_levels']." (level, level_name) VALUES (".$level.", '".addslashes($level_name)."')")) {
        return true;
      } else {
        return false;
      }
    } else {
      return false;
    }
  }
  
  function updateLevel($ID, $level, $level_name) {
    if (!empty($level) && $level>0 && !empty($level_name)) {
      $this->sql->Update("UPDATE ".$this->TABLES['user_levels']." SET level_name = '".addslashes($level_name)."', level = ".$level." WHERE id = $ID");
      return true;
    } else {
      $this-> appendError("You need to enter a valid level and name!");
      return false;
    }
  }
  
  function removeLevel($ID) {
    $this->sql->Delete("DELETE FROM ".$this->TABLES['user_levels']." WHERE id = $ID");
    return true;
  }
  
  function getLevelList() {
    $data = $this->sql->Select("SELECT id, level, level_name FROM ".$this->TABLES['user_levels']." ORDER BY level ASC");
    $len = count($data);
    if ($len < 1) {
      $str = '
        <tr>
          <td class="lightbg" colspan="3">No levels found...</td>
        </tr>
      ';
    } else {
      $str ='
          <tr>
            <td class="icon_darkbg" colspan="2"></td>
            <td class="listheader">Level</td>
            <td class="listheader">Name</td>
          </tr>
      ';
    }
    for ($i=0; $i< $len; $i++) {
      if ($this->classname == 'lightbg') {
        $this->classname = 'darkbg';
      } else {
        $this->classname = 'lightbg';
      }
      $str .='
        <tr>
          <td class="icon_'.$this->classname.'"><a href="users.levels.remove.php?ID='.$data[$i]['id'].'"><img src="images/icons/remove.gif" align="absmiddle" alt="" border="0"></a></td>
          <td class="icon_'.$this->classname.'"><a href="users.levels.edit.php?ID='.$data[$i]['id'].'"><img src="images/icons/edit.gif" align="absmiddle" alt="" border="0"></a></td>
          <td class="'.$this->classname.'">'.$data[$i]['level'].'</td>
          <td class="'.$this->classname.'">'.$data[$i]['level_name'].'</td>
        </tr>
      ';
    }
    return $str;
  }

  function appendError($error_msg) {
    $this->ERROR_MSG .= $error_msg."<br>\n";
  }
  
  function appendMsg($msg) {
    $this->MSG .= $msg."<br>\n";
  }

  function getNumPages($num_rows) {
    if ($num_rows <= $this->PER_PAGE) {
      $num_pages = 1;  
    } else if (($num_rows % $this->PER_PAGE) == 0) {
      $num_pages = ($num_rows / $this->PER_PAGE);
    } else {  
      $num_pages = ($num_rows / $this->PER_PAGE) + 1;
    }  
    $num_pages = (int) $num_pages;
    return $num_pages;
  }
  
  function FormatDate($format, $time) {
    if (strlen($time) < 4) {
      return 'N/A';
    }
    $year=substr($time,0,4);
    $month=substr($time,4,2);
    $day=substr($time,6,2);
    $hour=substr($time,8,2);
    $minute=substr($time,10,2);
    $seconds=substr($time,12,2);
    $month = (strlen($month) > 1) ? $month*1 : $month;
    $day = (strlen($day) > 1) ? $day*1 : $day;
    return date($format, mktime($hour,$minute,$seconds,$month,$day,$year));
  }
}
?>