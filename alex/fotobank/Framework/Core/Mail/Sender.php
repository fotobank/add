<?php
       /*
       Library for work with mail. V1.4. Copyright (C) 2003 - 2008 Richter
       Additional information: http://wpdom.com
       */

namespace Framework\Core\Mail;

       class Sender {

              public $from_addr;  // Sender address
              public $from_name;  // Sender name
              public $to = [];    // Address of a recipient or array of these addresses
              public $headers;
              public $body;    // Main message
              public $body_type;  // Main message encoding (text/plain or text/html)
              public $priority;
              // Letter priority; Строка или массив, которые будут вставлены в конец отправляемых заголовков письма.
              public $mime;
              public $subj;


              public function __construct() {

                     $this->from_addr = '';
                     $this->from_name = '';
                     $this->to        = '';
                     $this->body      = '';
                     $this->body_type = 'text/plain';
                     $this->headers   = Array();
                     $this->subj      = '';
                     $this->priority  = 3;
              }


              // Attachs some content
              public function attach_content($file_name, $file_content, $encoding_type = 'application/octet-stream', $in_letter_id = false): void {

                     $this->headers[] = array(
                            'name'    => $file_name,
                            'content' => $file_content,
                            'encode'  => $encoding_type,
                            'cid'     => $in_letter_id
                     );
              }


              // Builds a part of letter
              public function build_part($header): string {

                     $cnt      = $header['content'];
                     $cnt      = chunk_split(base64_encode($cnt));
                     $encoding = 'base64';
                     $charset = '';
                     if ($header['encode'] === 'text/html' || $header['encode'] === 'text/plain') {
                            $charset = '; charset="windows-1251\r\n"';
                     }

                     return 'Content-Type: '.$header['encode'].
                            ($header['name'] ? '; name = "'.$header['name'].'"' : '')."$charset\nContent-Transfer-Encoding: $encoding".($header['cid'] ?
                                   "\nContent-ID: <".$header['cid'].'>' : '')."\n\n$cnt\n";
              }

              // Attachs a file (Use it for make attachment)
              // $in_letter_id: ID in body of letter or FALSE
              public function attach_file($filename, $filename_in_letter, $enc_type, $in_letter_id = false): void {

                     if ($filename_in_letter === '') {
                            $filename_in_letter = $filename;
                     }
                     $fp   = fopen($filename, 'rb');
                     $data = fread($fp, filesize($filename));
                     fclose($fp);
                     $this->attach_content($filename_in_letter, $data, $enc_type, $in_letter_id);
              }


              // Prepare letter
              public function prepare_letter(): void {

                     $mime = '';
                     // В некоторых случаях, когда есть несколько адресов
                     if (is_array($this->from_addr)) {
                            $this->from_addr = $this->from_addr[0];
                     }
                     if (!empty($this->from_addr)) {
                            if ($this->from_name !== '') {
                                   $from = $this->from_name.' <'.$this->from_addr.'>';
                            } else {
                                   $from = $this->from_addr;
                            }
                            $from .= "From: $from\nReply-To: $from\n";
                            $mime .= $from;
                     }
                     $mime .= 'X-Priority: '.$this->priority."\nMIME-Version: 1.0\n";
                     if (count($this->headers) > 0) {  // Multipart letter
                            // Главное тело как часть письма
                            $this->attach_content('', $this->body, $this->body_type);
                            // Сборка частей
                            $boundary  = 'b'.md5(uniqid(time(), true)); // граница
                            $multipart = "Content-Type: multipart/mixed; boundary =$boundary\n\nThis is a MIME encoded letter\n\n--$boundary";
                            for ($I = count($this->headers) - 1; $I >= 0; $I--) {
                                   $multipart .= "\n".$this->build_part($this->headers[$I])."--$boundary"; // Вставка части письма
                            }
                            $multipart .= "--\n";
                            $mime      .= $multipart;
                     } elseif ($this->body !== '') {  // Простое письмо
                            /**
                             * @todo Закодировать тело письма в base64
                             */
                            $this->body = chunk_split(base64_encode($this->body));
                            $mime       .= 'Content-Type: '.$this->body_type."; charset=\"windows-1251\"\nContent-Transfer-Encoding: base64".PHP_EOL.$this->body;
                     }
                     if (!is_array($this->to)) {
                            $this->to = array($this->to);
                     }
                     $this->mime = $mime;
              }

              // Sends letter
              public function send_letter(): bool {

                     foreach ($this->to as $to) {
                            // если хоть одно письмо не отправлено выходим
                            if(!mail($to, $this->subj, '', $this->mime)){
                                   return false;
                            }
                     }
                     return true;
              }
       }
