<?php
/*
Library for processing of errors and events. V2.7. Copyright (C) 2004 - 2010 Richter
Additional information: http://wpdom.com, richter@wpdom.com
*/

class Error_Processor {
  var $EP_tmpl_err_item		= '[ERR_MSG]';		// Error messages template: one item of list of a messages
  var $EP_log_fullname		= 'errors.log';		// Path and filename of error log
  var $EP_mail_period		= 5;			// Minimal period for sending an error message (in minutes)
  var $EP_from_addr;
  var $EP_from_name;
  var $EP_to_addr;
  var $EP_log_max_size		= 500;			// Max size of a log before it will sended and cleared (in kb)

  var $event_log_fullname	= 'events.log';		// Path and filename of event log

  // Processes an error
  // $actions - String with actions: '' - adding in error list of errors,
  // 'w' - additionally writes an error message to screen, 'a' - additionally
  // writes list of all messages to screen, 'd' - additionally cleans errors
  // stack, 's' - additionally stop an execution,  'l' - additionally writes to
  // log, 'm' - additionally sends by E-mail (values can be combined, for instance: 'ws')
  // $err_file, $err_line - filename and line in it with error (typically constants
  // __FILE__ and __LINE__)
  function err_proc($err_msg, $actions = '', $err_file = '', $err_line = '')
  {
    $this->log_send(0);

    // Adding in list of errors
    $this->err_list[] = $err_msg;

    // Writing log
    if (substr_count($actions, 'l')) {
      @touch($this->EP_log_fullname);
      @chmod($this->EP_log_fullname, 0777);
      error_log(str_replace(array("\n", "\r"), ' ', $err_msg)."\t".$_SERVER[REQUEST_URI]."\t".date('r')."\t".Get_IP()."\n", 3, $this->EP_log_fullname);
    }

    // Sending mail
    if (substr_count($actions, 'm')) {
      // Check, that messages not send too often
      $log_file = $this->EP_log_fullname;
      $dump = @file($log_file);
      for ($I=count($dump)-1; $I>0; $I--) {
        $str = explode("\t", $dump[count($dump)-1]);
        if (strtotime($str[2]) > strtotime("-".$this->EP_mail_period." minutes")) {
          $too_often = TRUE;
          break;
        }
      }
      if (!$too_often) {
        $mail_mes = "
	Error: $err_msg\n\n
	File: $err_file\n
	Line: $err_line\n
	Date/time: ".date('r')."\n
	\$SERVER_NAME = ".$_SERVER[SERVER_NAME]."\n
	\$REQUEST_URI: ".$_SERVER[REQUEST_URI]."\n
	\$REMOTE_ADDR: ".$_SERVER[REMOTE_ADDR]."\n
	\$HTTP_USER_AGENT: ".$_SERVER[HTTP_USER_AGENT]."\n
	\$HTTP_REFERER: ".$_SERVER[HTTP_REFERER]."\n
	\$REQUEST_METHOD: ".$_SERVER[REQUEST_METHOD]."\n
	\$HTTP_ACCEPT_LANGUAGE: ".$_SERVER[HTTP_ACCEPT_LANGUAGE]."\n
  	Cookie:\n";
        foreach ($_COOKIE as $I => $val) {
          $mail_mes .= $I.'='.$val."\n";
        }
        $mail_mes .= "
    	Variables (GET):\n
        ";
        while (list($I,$val) = each($_GET)) {
          $mail_mes .= " $I=$val\n";
        }
        $mail_mes .= "
    	Variables (POST):\n
        ";
        while (list($I,$val) = each($_POST)) {
          $mail_mes .= " $I=$val\n";
        }
        $mail			= new Mail_sender;
        $mail->from_addr	= $this->EP_from_addr;
        $mail->from_name	= $this->EP_from_name;
        $mail->to		= $this->EP_to_addr;
        $mail->subj		= "Error occurred: $err_msg";
        $mail->body		= $mail_mes;
        $mail->priority		= 1;
        $mail->prepare_letter();
        $mail->send_letter();
      }
    }
    if (substr_count($actions,'w')) echo $err_msg;
    if (substr_count($actions,'a')) echo $this->err_write();
    if (substr_count($actions,'d')) unset($this->err_list);
    if (substr_count($actions,'s')) die();
  }

  // Return HTML-block with list of an error messages
  function err_write()
  {
    if (is_array($this->err_list))
      foreach ($this->err_list as $err_msg) {
        $messages .= str_replace('[ERR_MSG]',$err_msg,$this->EP_tmpl_err_item);
      }
    if ($messages != '') return $messages;
    else return FALSE;
  }

  // Sends a log to administrator by e-mail and clears a log
  // $type: 0 - errors, 1 - events
  function log_send($type = 0)
  {
    if ($type == 0) {
      $title = 'Report of errors log';
      $log_file = $this->EP_log_fullname;
    } else {
      $title = 'Report of events log';
      $log_file = $this->event_log_fullname;
    }

    $dump = @file($log_file);
    if ($dump && filesize($log_file)>$this->EP_log_max_size*1024) {
      $mail_mes = '
	<html><body>
	<h1>'.$title.'</h1>
      ';
      $dump = array_reverse($dump, FALSE);
      foreach ($dump as $val)
        $mail_mes .= trim($val).'<br>';
      $mail_mes .= '
	<p>
	This letter was created and a log on server was cleared at '.date('Y-m-d').'.
	<br>
	This message was sent automatically by robot, please don\'t reply!
	</p>
	</body></html>
      ';
      $mail		= new Mail_sender;
      $mail->from_addr	= $this->EP_from_addr;
      $mail->from_name	= $this->EP_from_name;
      $mail->to		= $this->EP_to_addr;
      $mail->subj	= $title;
      $mail->body_type	= 'text/html';
      $mail->body	= $mail_mes;
      $mail->priority	= 3;
      $mail->prepare_letter();
      $mail->send_letter();
      unlink($log_file);
    }
  }

  // Log an event into log
  function log_event($message, $user_id)
  {
    @touch($this->event_log_fullname);
    @chmod($this->event_log_fullname, 0777);
    error_log(str_replace(array("\n", "\r"), ' ', $message)."\t".$_SERVER[REQUEST_URI]."\t$user_id\t".date('r')."\t".Get_IP()."\n", 3, $this->event_log_fullname);

    $this->log_send(1);
  }
}
?>