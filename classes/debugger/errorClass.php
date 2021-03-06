<?php

       use Framework\Core\Mail\Sender;

       require_once __DIR__.'/../../alex/fotobank/Framework/Boot/config.php';
       /*if (check_Session::getInstance()->has('Debug_HC')) {
               $Debug_HackerConsole_Main = Debug_HackerConsole_Main::getInstance(true);
       }*/

       /**
        * CLASS debugger_errorClass
        *
        *
        */
       class debugger_errorClass
       {

              /**
               * @var array mailOptions
               */
              private $mailOptions = ['mail_Period' => 5, // Minimal period for sending an error message (in minutes)
                                      'from_Addr'   => "webmaster@aleks.od.ua", 'from_Name' => "������ � ��������",
                                      'to_Addr'     => "aleksjurii@gmail.com", 'log_Max_Size' => 250
                                      //// Max size of a log before it will sended and cleared (in kb)
              ];
              /**
               * private (string) sAssertion
               * Check if error comes from an essertion or not, if yes, will conatin the filename of the evaluated
               * script
               */
              private $sAssertion = null;
              /**
               * private (string) sLang
               * localization string
               */
              private $sLang = 'EN';
              /**
               * private (int) iNbLines
               * ���������� ������ �� � ����� ������
               */
              private $iNbLines = 5;
              /**
               * private (array) aOptions
               * Options array
               */
              private $aOptions = ['REALTIME'  => true, 'LOGFILE' => true, 'ERROR' => true, 'EXCEPTION' => true,
                                   'ERROUTPUT' => false // ����� fafal error (��������� ����������)
              ];
              /**
               * private (string) sTemplateHTML
               * HTML template file for the realtime log
               */
              private $sTemplateHTML = 'default';
              /**
               * private (string) sTemplateCSS
               * CSS template file for the realtime log
               */
              private $sTemplateCSS = 'default';
              /**
               * private (string) sTemplateHTMLLOG
               * HTML template file for the whole log file
               */
              private $sTemplateHTMLLOG = 'default_log';
              /**
               * private (string) sTemplateCSSLOG
               * CSS template file for the whole log file
               */
              private $sTemplateCSSLOG = 'default_log';
              /**
               * private (string) sCurId
               * ������� ���� ���������� �������������
               */
              private $sCurId = '';
              /**
               * @var null
               * XML LOG Object (simplexml object)
               */
              private $sxmlNew = null;
              /**
               * private (object) XML_DOC
               * XML LOG Object (DOMDocument object)
               */
              private $XML_DOC = null;
              /**
               * private (object) XML_ROOT
               * XML LOG root Object (DOMDocument object)
               */
              private $XML_ROOT = null;
              /**
               * private (object) oCurrentNode
               * Current node Object (DOMDocument object)
               */
              private $currentNode = null;
              /**
               * private (array) aCanBeSet
               * class properties that can be set via debugger_errorClass::__set()
               */
              private $aCanBeSet = ['mail_Period'  => "mailOptions['mail_Period']",
                                    'from_Addr'    => "mailOptions['from_Addr']",
                                    'from_Name'    => "mailOptions['from_Name']", 'to_Addr' => "mailOptions['to_Addr']",
                                    'log_Max_Size' => "mailOptions['log_Max_Size']", 'LINES' => "iNbLines",
                                    'REALTIME'     => "aOptions['REALTIME']", 'LOGFILE' => "aOptions['LOGFILE']",
                                    'ERROUTPUT'    => "aOptions['ERROUTPUT']", 'HTML' => "sTemplateHTML",
                                    'CSS'          => "sTemplateCSS", 'HTMLLOG' => "sTemplateHTMLLOG",
                                    'CSSLOG'       => "sTemplateCSSLOG", 'ERROR' => "aOptions['ERROR']",
                                    'EXCEPTION'    => "aOptions['EXCEPTION']", 'log_File' => "sFile"];
              /**
               *  ������������� ������ ��� ������� ������
               */
              public $isError = 0;
              /**
               * private (object) XML_TYPES
               * XML DOMDocument object with the list of error types and their translation
               */
              private $XML_TYPES = null;
              /**
               * @var bool
               * ������������ ������ � ������ �� mail
               */
              private $printMail = false;
              /**
               * @var bool
               * �����  ���� �� email
               */
              private $logMail = false;
              /**
               * @var null
               * ��� ��� �����
               */
              private $sFile = null;
              /**
               * private (object) XML_ERRORS
               * XML DOMDocument object with the list of errors and their translation
               */
              private $XML_ERRORS = null;
              /**
               * private (array) aIndex
               * replacement array for the templates
               */
              private $aIndex = [0   => ['{DATE_START_TITRE}', '{DATE_START_VALUE}'],
                                 1   => ['{DATE_NEW_TITRE}', '{DATE_NEW_VALUE}'], 2 => ['{KOLL_TITRE}', '{KOLL_VALUE}'],
                                 3   => ['{TYPE_TITRE}', '{TYPE_VALUE}'], 4 => ['{MSG_TITRE}', '{MSG_VALUE}'],
                                 5   => ['{FILE_TITRE}', '{FILE_VALUE}'], 6 => ['{LINE_TITRE}', '{LINE_VALUE}'],
                                 7   => ['{MEM_TITRE}', '{MEM_VALUE}'], 8 => ['{TRANS_TITRE}', '{TRANS_VALUE}'],
                                 9   => ['{SUGG_TITRE}', '{SUGG_VALUE}'], 10 => ['{CONTEXT_TITRE}', '{CONTEXT_VALUE}'],
                                 11  => ['{SOURCE_TITRE}', '{SOURCE_VALUE}'], 100 => '{TOTAL_STATS}',
                                 101 => '{PHP_VERSION}'];
              static private $instance = null;

              /**
               * function Singleton
               * �������� ������� � ������������ ����������
               *
               * @param string $sLang
               *
               * @return null|debugger_errorClass
               */
              static function getInstance($sLang = 'EN')
              {
                     if (self::$instance == null) {
                            self::$instance = new debugger_errorClass($sLang);
                     }
                     return self::$instance;
              }

              /**
               * public function __construct ()
               * contsructor
               * sets the error_reporting to 0
               * gets the localization dir
               * import all the xml files
               * set the error handler
               *
               * @Param (string) sLang : the localization used
               */
              public function __construct($sLang)
              {
                     $aLnDir = scandir(__DIR__.'/xml');
                     if (in_array($sLang, $aLnDir)) {
                            $this->sLang = $sLang;
                     }
                     $this->XML_ERRORS = new DOMDocument('1.0', 'utf-8');
                     $this->XML_ERRORS->load(__DIR__.'/xml/'.$this->sLang.'/errors.xml');
                     $this->XML_TYPES = new DOMDocument('1.0', 'utf-8');
                     $this->XML_TYPES->load(__DIR__.'/xml/'.$this->sLang.'/types.xml');
                     $this->XML_DOC = new DOMDocument ('1.0', 'utf-8');
                     $root = $this->XML_DOC->createElement("ROOT");
                     $this->XML_ROOT = $this->XML_DOC->appendChild($root);
                     if (!is_dir($_SERVER['DOCUMENT_ROOT'].'/logs')) {
                            if (!mkdir($concurrentDirectory = $_SERVER['DOCUMENT_ROOT'].'/logs', 0744) &&
                                   !is_dir($concurrentDirectory)) {
                                   throw new \RuntimeException(sprintf('Directory "%s" was not created',
                                          $concurrentDirectory));
                            }
                     }
                     $this->sCurId = date('Ymd').'_'.uniqid('', true);
                     if ($this->sFile === null) {
                            $this->sFile = $_SERVER['DOCUMENT_ROOT'].'/logs/'.$this->sCurId.'_error_log.xml';
                     }
                     set_error_handler([$this, 'myErrorHandler']);
                     set_exception_handler([$this, 'myExceptionHandler']);
                     register_shutdown_function([$this, 'captureShutdown']);
              }

              /**
               * ������� ��������� ��������� ������
               * UNCATCHABLE ERRORS
               */
              public function captureShutdown()
              {
                     $error = error_get_last();
                     if ($error) {
                            $message = '';
                            $sErrFile = '';
                            $iErrLine = '';
                            foreach ($error as $key => $value) {
                                   switch ($key) {
                                          case 'file':
                                                 $sErrFile = $value;
                                                 break;
                                          case 'line':
                                                 $iErrLine = $value;
                                                 break;
                                          case 'message':
                                                 $message = $value;
                                                 break;
                                          case 'type':
                                                 $message = $value;
                                                 break;
                                   };
                            }
                            $sVars = debugger_SHOWCONTEXT::notify();
                            $aTempArr = ['TRANSLATION' => '��������� ������� ��-�� ��������� ������',
                                         'SUGGESTION'  => '��������� ������ �� ������'];
                            $errType = 'Fatal Error';
                            $this->setCssLog('default_log');
                            $this->setCss('default');
                            // �������� ����� ���� ������ ��� Fatal Error
                            $this->aOptions['ERROUTPUT'] = true;
                            $this->buildLog($errType, $message, $sErrFile, $iErrLine, $aTempArr, $sVars);
                            if ($this->aOptions['ERROUTPUT'] === true) $this->saveToFile();
                     }
                     if (true === $this->aOptions['REALTIME']) {
                            $cpuLoad = $this->getServerCPULoad();
                            ?>
						 <div class="center">
							 <div class="centered"
							      style="margin: -70px -600px; position: absolute; z-index: 10;">
								 <span class="label label-success"><?= "RAM: ".chpu_Bytes(memory_get_usage()) ?> </span>
                                    <? if ($cpuLoad) echo "<span class='label label-success'>CPU: ".($cpuLoad * 100).
                                           "% </span>";
                                           //    $dir = $_SERVER['DOCUMENT_ROOT']; $sizeDir = getFilesSize($dir); $sizeDir = chpu_Bytes($sizeDir);
                                    ?>
								 <!--                        <span class="label label-success">-->
                                 <?//= "SIZE: ".$sizeDir ?><!-- </span>-->
							 </div>
						 </div>
                            <?
                     }
                     return true;
              }

              function getServerCPULoad()
              {
                     //��������� ����������� ������ ����������� ����������
                     if (is_readable('/proc/stat')) {
                            //������ ������ �����
                            $file_first = file("/proc/stat");
                            //���������� �������� ��������� (������� ����)
                            $tmp_first = explode(" ", $file_first[0]);
                            $cpu_user_first = $tmp_first[2];
                            $cpu_nice_first = $tmp_first[3];
                            $cpu_sys_first = $tmp_first[4];
                            $cpu_idle_first = $tmp_first[5];
                            $cpu_io_first = $tmp_first[6];
                            sleep(2);//���������� �� ������� ������
                            //������ ������ �����
                            $file_second = file("/proc/stat");
                            $tmp_second = explode(" ", $file_second[0]);
                            $cpu_user_second = $tmp_second[2];
                            $cpu_nice_second = $tmp_second[3];
                            $cpu_sys_second = $tmp_second[4];
                            $cpu_idle_second = $tmp_second[5];
                            $cpu_io_second = $tmp_second[6];
                            //���������� ������� ��������������� ������������� �������
                            $diff_used = ($cpu_user_second - $cpu_user_first) + ($cpu_nice_second - $cpu_nice_first) +
                                   ($cpu_sys_second - $cpu_sys_first) + ($cpu_io_second - $cpu_io_first);
                            //���������� ������� ������ ������������� �������
                            $diff_total = ($cpu_user_second - $cpu_user_first) + ($cpu_nice_second - $cpu_nice_first) +
                                   ($cpu_sys_second - $cpu_sys_first) + ($cpu_io_second - $cpu_io_first) +
                                   ($cpu_idle_second - $cpu_idle_first);
                            //   ����������� �������� cpu
                            $cpu = round($diff_used / $diff_total, 2);
                            return $cpu;
                     }
                     return null;
              }

              /**
               * public function checkCode ()
               * use the assert () function to get the errors in a given string, or a given file
               *
               * @Param (string) sString : the string with the PHP code to evaluate, or the file to evaluate. Usually,
               *        it will come from a file via file_get_contents () for example
               * @Return : false if given parameter is not a string.
               */
              public function checkCode($sCode)
              {
                     if (file_exists($sCode)) {
                            $sString = file_get_contents($sCode);
                            $this->sAssertion = $sCode;
                     }
					 elseif (!is_string($sCode)) {
                            return false;
                     }
                     else {
                            $sString = $sCode;
                     }
                     $sString = str_replace(['<?php', '<?', '?>'], '', $sString);
                     assert_options(ASSERT_ACTIVE, 1);
                     assert_options(ASSERT_WARNING, 0);
                     assert_options(ASSERT_QUIET_EVAL, 1);
                     // assert_options (ASSERT_CALLBACK, array ($this, 'myAssertHandler')); //Waiting a bit to improve this part
                     assert($sString);
                     assert_options(ASSERT_ACTIVE, 0);
              }

              /**
               * public function myAssertHandler ()
               * activate the assertion. Right now, does nothing...and is not used.
               *
               * @Param (string) file : the file from which comes the code
               * @Param (int) line : the error line
               * @Param (string) code : the error code
               * @Return : true
               */
              public function myAssertHandler($file, $line, $code)
              {
                     return true;
              }

              /**
               * private function checkErrorMessage ()
               * try to find the correct trsnalation and suggestion from a given error message
               *
               * @Param (string) sMsg : the PHP error message
               * @Return (array) aTempArr : array with the translation and the suggestion found
               */
              private function checkErrorMessage($sMsg)
              {
                     $xpath = new DOMXPath($this->XML_ERRORS);
                     $oLabelLists = $xpath->query('//error/label');
                     $aMsg = explode(' ', $sMsg);
                     foreach ($oLabelLists as $oLabel) {
                            $aLabel = explode(' ', $oLabel->nodeValue);
                            $aDiff = array_diff($aLabel, $aMsg);
                            if (empty ($aDiff)) {
                                   $aTempArr['TRANSLATION'] =
                                          iconv('utf-8', 'windows-1251', $oLabel->nextSibling->nextSibling->nodeValue);
                                   $aTempArr['SUGGESTION'] = iconv('utf-8', 'windows-1251',
                                          $oLabel->nextSibling->nextSibling->nextSibling->nextSibling->nodeValue);
                                   return $aTempArr;
                            }
                     }
                     return false;
              }

              /**
               * private function checkTypeTrans ()
               * try to find the error type translation
               *
               * @Param (int) cErrno : the PHP constant error type code
               * @Return (string) nodeValue : the translated error type
               */
              private function checkTypeTrans($cErrno)
              {
                     $xpath = new DOMXPath($this->XML_TYPES);
                     $oLevelList = $xpath->query('//type/level');
                     foreach ($oLevelList as $oLevel) {
                            if (constant($oLevel->nodeValue) === $cErrno) {
                                   return $oLevel->nextSibling->nextSibling->nodeValue;
                            }
                     }
                     return false;
              }

              /**
               * public function myExceptionHandler ()
               * the exception handler : builds the XML error log
               *
               * @Param (object) e : the Exception object
               */
              public function myExceptionHandler($e)
              {
                     $sErrStr = $e->getMessage();
                     $iErrLine = $e->getLine();
                     $sType = 'Exception '.$e->getCode();
                     if (is_null($this->sAssertion)) {
                            $sErrFile = $e->getFile();
                     }
                     else {
                            $sErrFile = $this->sAssertion;
                            $this->sAssertion = null;
                     }
                     $aTempArr = ['TRANSLATION' => '', 'SUGGESTION' => ''];
                     $this->setCssLog('default_log');
                     $this->setCss('default');
                     $this->aOptions['ERROUTPUT'] = true;
                     $sVars = debugger_SHOWCONTEXT::notify();
                     $this->buildLog($sType, $sErrStr, $sErrFile, $iErrLine, $aTempArr, $sVars);
              }

              /**
               * public function myErrorHandler ()
               * the error handler : builds the XML error log
               *
               * @Param (int) cErrno : the PHP constant error type code
               * @Param (string) sErrStr : the PHP error message
               * @Param (string) sErrFile : the file in which the error has been detected
               * @Param (int) iErrLine : the line of the error
               * @Param (array) mVars : the context
               */
              public function myErrorHandler($cErrno, $sErrStr, $sErrFile, $iErrLine, $mVars)
              {
                     $aTempArr = $this->checkErrorMessage($sErrStr);
                     $sType = $this->checkTypeTrans($cErrno);
                     if (!is_null($this->sAssertion)) {
                            $sErrFile = $this->sAssertion;
                            $this->sAssertion = null;
                     }
                     $sVars = debugger_SHOWCONTEXT::notify();
                     $this->buildLog($sType, $sErrStr, $sErrFile, $iErrLine, $aTempArr, $sVars);
              }

              /**
               * private function buildLog ()
               * the error handler : builds the XML error log
               *
               * @Param (string) sType : The type of error/exception
               * @Param (string) sErrStr : the PHP error message
               * @Param (string) sErrFile : the file in which the error has been detected
               * @Param (int) iErrLine : the line of the error
               * @Param (string) sVars : the context
               */
              private function buildLog($sType, $sErrStr, $sErrFile, $iErrLine, $aTempArr, $sVars)
              {
                     // �� ��������� ���� ������ �� �������� '/error.php'
                     if (isset($_SERVER['PHP_SELF']) && $_SERVER['PHP_SELF'] != '/error.php') {
                            $this->get_koll_dateStart($sErrStr, $sErrFile, $iErrLine, $koll, $dateStart, $iNewId);
                            $oNewLog = $this->XML_DOC->createElement('ERROR');
                            $oNewLog = $this->XML_ROOT->appendChild($oNewLog);
                            $oNewLog->setAttribute('id', $iNewId);
                            $aElem[] = $this->XML_DOC->createElement('DATE_START', $dateStart);
                            $aElem[] = $this->XML_DOC->createElement('DATE_NEW', date('d-m-Y H:i:s'));
                            $aElem[] = $this->XML_DOC->createElement('KOLL', $koll);
                            $aElem[] = $this->XML_DOC->createElement('TYPE', $sType);
                            // $sErrStr = utf8_encode($sErrStr);
                            $aElem[] = $this->XML_DOC->createElement('PHP_MESSAGE',
                                   iconv("WINDOWS-1251", "UTF-8", $sErrStr));
                            $aElem[] = $this->XML_DOC->createElement('FILE', $sErrFile);
                            $aElem[] = $this->XML_DOC->createElement('LINE', $iErrLine);
                            $iMem = function_exists('memory_get_usage') ?
                                   iconv("WINDOWS-1251", "UTF-8", chpu_Bytes(@memory_get_usage())) : 'n/a';
                            $aElem[] = $this->XML_DOC->createElement('MEMORY', $iMem);
                            $aElem[] = $this->XML_DOC->createElement('TRANSLATION',
                                   iconv("WINDOWS-1251", "UTF-8", $aTempArr['TRANSLATION']));
                            $aElem[] = $this->XML_DOC->createElement('SUGGESTION',
                                   iconv("WINDOWS-1251", "UTF-8", $aTempArr['SUGGESTION']));
                            $aElem[] = $this->XML_DOC->createElement('CONTEXT', $sVars);
                            $oSource = $this->XML_DOC->createElement('SOURCE');
                            $aSourceElem = [];
                            $iErrLine--;
                            if ($iErrLine < 0) {
                                   $iErrLine = 0;
                            }
                            $numLine = $iErrLine - $this->iNbLines;
                            foreach ($this->getLine($sErrFile, $iErrLine) as $iLine => $sLine) {
                                   // $sLine = utf8_encode($sLine);
                                   if ($iLine === $iErrLine) {
                                          $aSourceElem[] = $this->XML_DOC->createElement('SOURCE_LINE_ERROR',
                                                 $numLine.') '.trim(iconv("WINDOWS-1251", "UTF-8",
                                                        ' /** ����� ������ => */ '.htmlspecialchars($sLine))));
                                   }
                                   else {
                                          $aSourceElem[] = $this->XML_DOC->createElement('SOURCE_LINE', $numLine.') '.
                                                 trim(iconv("WINDOWS-1251", "UTF-8", htmlspecialchars($sLine))));
                                   }
                                   $numLine++;
                            }
                            unset($numLine);
                            foreach ($aSourceElem as $oSourceElem) {
                                   $oSource->appendChild($oSourceElem);
                            }
                            foreach ($aElem as $child) {
                                   $oNewLog->appendChild($child);
                            }
                            $oNewLog->appendChild($oSource);
                            $this->currentNode = $oNewLog;
                            $this->isError++;
                            // ������ � ��� ��� fatal error
                            // ���� fatal error
                            if ($this->aOptions['ERROUTPUT'] === true) {
                                   //	� ���� ������� �����
                                   if (true === $this->aOptions['REALTIME']) {
                                          $this->showAll();
                                   }
                            }
                     }
              }

              /**
               * ���������� ������ ��� ������������ ERROR id ,���� ������ ������ � �������� ���-�� ���������� �������
               *
               * @param $sErrStr
               * @param $sErrFile
               * @param $iErrLine
               * @param $iNewId
               * @param $koll
               * @param $dateStart
               */
              private function get_koll_dateStart($sErrStr, $sErrFile, $iErrLine, &$koll, &$dateStart, &$iNewId)
              {
                     $koll = 1;
                     $dateStart = date('d-m-Y H:i:s');
                     $iNewId = $this->XML_ROOT->getElementsByTagName('ERROR')->length + 1;
                     if (file_exists($this->sFile) and filesize($this->sFile) != 0) {
                            $sxml = file_get_html($this->sFile);
                            foreach ($sxml->find('ERROR[id]') as $error) {
                                   if (is_object($error->find("PHP_MESSAGE", 0))) {
                                          if ($error->find("PHP_MESSAGE", 0)->innertext ==
                                                 iconv("WINDOWS-1251", "UTF-8", $sErrStr) &&
                                                 $error->find("FILE", 0)->innertext == $sErrFile &&
                                                 $error->find("LINE", 0)->innertext == ($iErrLine)) {
                                                 $koll = $error->find("KOLL", 0)->innertext + 1;
                                                 $dateStart = $error->find("DATE_START", 0)->innertext;
                                                 $iNewId = $error->id;
                                                 break;
                                          }
                                   }
                            }
                            $sxml->clear();
                            unset($sxml);
                     }
              }

              /**
               *  Sending mail
               */
              function sendMail()
              {
                     // ������ ������ ��� aleks.od.ua
                     //					if ($_SERVER['HTTP_HOST'] == stristr(mb_substr(get_domain(), 0, -1), "al")) {
                     if (file_exists($this->sFile)) {
                            $dateTime = '';
                            $sxml = file_get_html($this->sFile);
                            foreach ($sxml->find('DATE_MAIL') as $key) {
                                   $dates = $key->innertext;
                                   if (strtotime($dates) >= strtotime($dateTime)) {
                                          $dateTime = $dates;
                                   }
                            }
                            $sxml->clear();
                            unset($sxml);
                            if (strtotime($dateTime) < strtotime("-".$this->mailOptions['mail_Period']." minutes") or
                                   $dateTime === '') {
                                   //  �������� ����� �� email
                                   $this->printMail = true;
                                   $styleErr = file_get_contents(__DIR__.'/../../classes/debugger/css/default.dat');
                                   $mail_mes = $styleErr."<u><b>Error:</b></u><br><span style='color: #900000; font-size: 12px; font-weight: bold;'>
																											 <b>\$_SERVER_NAME</b> = ".
                                          $_SERVER['SERVER_NAME']."</span>".$this->showAll();
                                   $mail = new Sender();
                                   $mail->from_Addr = $this->mailOptions['from_Addr'];
                                   $mail->from_Name = $this->mailOptions['from_Name'];
                                   $mail->to = $this->mailOptions['to_Addr'];
                                   $mail->subj = "��������� ������: ";
                                   $mail->body_type = 'text/html';
                                   $mail->body = $mail_mes;
                                   $mail->priority = 1;
                                   $mail->prepare_letter();
                                   $mail->send_letter();
                                   unset($mail);
                            }
                     }
              }


              //}

              /**
               * public function showAll ()
               * show the whole current xml log
               * �������� ���� ������� XML log
               */
              public function showAll()
              {
                     if ($this->logMail) {
                            // �������� log �����
                            $xml = new DOMDocument('1.0', 'utf-8');
                            if (file_exists($this->sFile) and filesize($this->sFile) != 0) {
                                   $xml->load($this->sFile);
                            }
                     }
                     else {
                            $xml = $this->XML_DOC;
                     }
                     $xpath = new DOMXPath($xml);
                     $sQuery = '//ERROR';
                     if ($xpath->query($sQuery)->length > 0) {
                            $oNodeLists = $xpath->query($sQuery);
                            $err = '';
                            foreach ($oNodeLists as $oNodeList) {
                                   $this->currentNode = $oNodeList;
                                   $err .= $this->printMe();
                            }
                            if ($this->printMail) {
                                   return ($err);
                            }
                            else {
                                   echo($err);
                            }
                     }
              }


              /*  public function __toString() {
                       return $this->showAll();
                }*/
              /**
               * public function showLog ()
               * show the whole current log in a table, with stats (best used after debugger_errorClass::loadXML())
               * �������� ���� ������� ������ � �������, �� ����������� (����� ����� ������������ �����
               * debugger_errorClass :: LoadXml ())
               *
               * @Return (string) sHtml : the generated HTML
               */
              public function showLog()
              {
                     $sBaseHtml = file_get_contents(__DIR__.'/templates/'.$this->sTemplateHTMLLOG.'.dat');
                     $iStartPos = strpos($sBaseHtml, '<!-- LINES HERE -->');
                     $sHtml = substr($sBaseHtml, 0, $iStartPos);
                     $iEndPos = strpos($sBaseHtml, '<!-- STATS -->');
                     $iLength = strlen($sBaseHtml);
                     $sTempHtml = substr($sBaseHtml, $iStartPos, -($iLength - $iEndPos));
                     $sTempHtmlTotal = '';
                     $xpath = new DOMXPath($this->XML_DOC);
                     $oNodeLists = $xpath->query('//ERROR');
                     foreach ($oNodeLists as $oNodeList) {
                            $this->currentNode = $oNodeList;
                            $sTempHtmlTotal .= $this->printMeLog($sTempHtml);
                     }
                     $sHtml .= $sTempHtmlTotal;
                     $oNodeLists = $xpath->query('//ERROR/TYPE');
                     $sCountType = '';
                     $aTypes = [];
                     if ($oNodeLists->length > 0) {
                            foreach ($oNodeLists as $oNodeList) {
                                   $aTypes[] = $oNodeList->nodeValue;
                            }
                            $sHtml .= substr($sBaseHtml, $iEndPos, ($iLength - 1));
                            $aCountType = array_count_values($aTypes);
                            foreach ($aCountType as $kType => $vType) {
                                   $sCountType .= $kType.' : '.$vType.'<br />';
                            }
                     }
                     $sVersion = @phpversion();
                     $sHtml = str_replace($this->aIndex[100], $sCountType, $sHtml);
                     $sHtml = str_replace($this->aIndex[101], $sVersion, $sHtml);
                     return $sHtml;
              }

              /**
               * private function printMe ()
               * display a caught error
               *
               * @Return (string) sHtml : the generated HTML
               */
              private function printMe()
              {
                     $sHtml = file_get_contents(__DIR__.'/templates/'.$this->sTemplateHTML.'.dat');
                     $nodeLists = $this->currentNode->childNodes;
                     $iId = $this->currentNode->getAttribute('id');
                     for ($n = 0; $n < $nodeLists->length; $n++) {
                            if ($nodeLists->item($n)->nodeType == 1) {
                                   $sName = $nodeLists->item($n)->nodeName;
                                   if ($sName === 'SOURCE') {
                                          $sourceNodeList = $nodeLists->item($n)->childNodes;
                                          $sValeur = '';
                                          for ($j = 0; $j < $sourceNodeList->length; $j++) {
                                                 $sValeur .= str_replace(['<?php', '?>', '<?'], '',
                                                        $sourceNodeList->item($j)->nodeValue);
                                                 $sValeur .= "\n";
                                          }
                                          $sValeur = preg_replace("/  +/", " ", $sValeur);
                                          $sValeur = highlight_string('<?php '."\n".$sValeur.'?>', true);
                                   }
								   elseif ($sName === 'CONTEXT') {
                                          $php_INFO = debugger_SHOWCONTEXT::php_INFO();
                                          $content = $nodeLists->item($n)->nodeValue;
                                          $contentData = $content.$php_INFO;
                                          $contentTeg = $contentData;
                                          $sValeur = $contentTeg;
                                   }
                                   else {
                                          $sValeur = $nodeLists->item($n)->nodeValue;
                                   }
                                   $sId = uniqid().'_'.$iId;
                                   $sValeur = iconv("UTF-8", "windows-1251", $sValeur);
                                   $aReplacement = [$sName, $sValeur];
                                   $sHtml = str_replace($this->aIndex[$n], $aReplacement, $sHtml);
                                   $sHtml = str_replace('{ID}', $sId, $sHtml);
                            }
                     }
                     return $sHtml;
              }

              /**
               * private function printMeLog ()
               * display a caught error, used by debugger_errorClass::showLog()
               *
               * @Return (string) sHtml : the generated HTML
               */
              private function printMeLog($sHtml)
              {
                     $nodeList = $this->currentNode->childNodes;
                     for ($i = 0; $i < $nodeList->length; $i++) {
                            if ($nodeList->item($i)->nodeName === 'SOURCE') {
                                   $sourceNodeList = $nodeList->item($i)->childNodes;
                                   $sValeur = '';
                                   for ($j = 0; $j < $sourceNodeList->length; $j++) {
                                          $sValeur .= str_replace(['<?php', '?>', '<?'], '',
                                                 $sourceNodeList->item($j)->nodeValue);
                                          $sValeur .= "\r\n";
                                   }
                                   $sValeur = highlight_string('<?php '."\r\n".$sValeur.'?>', true);
                            }
                            else {
                                   $sValeur = $nodeList->item($i)->nodeValue;
                            }
                            $sValeur = iconv("UTF-8", "windows-1251", $sValeur);
                            $sValeur = preg_replace("/  +/", " ", $sValeur);
                            $sHtml = str_replace($this->aIndex[$i][1], $sValeur, $sHtml);
                     }
                     return $sHtml;
              }

              /**
               * private function getLine ()
               * method to get the lines around the detected error
               *
               * @Param (string) sErrFile : the file in which the error has been detected
               * @Param (int) iErrLine : the line of the error
               * @Return (array) aSource : array with each line
               */
              private function getLine($sErrFile, $iErrLine)
              {
                     $aSource = [];
                     if (file_exists($sErrFile)) {
                            $aLines = file($sErrFile);
                            for ($i = $iErrLine - $this->iNbLines; $i <= $iErrLine + $this->iNbLines; $i++) {
                                   if (isset ($aLines[$i])) $aSource[$i] = $aLines[$i];
                            }
                     }
                     return $aSource;
              }

              /**
               * public function loadXML ()
               * loads an external error log
               *
               * @Param (string) sFile : the error log file to be loaded
               */
              public function loadXML($sFile = null)
              {
                     if ($sFile === null) {
                            $xml = $this->sFile;
                     }
                     else {
                            $xml = $_SERVER['DOCUMENT_ROOT'].'/logs/'.$sFile;
                     }
                     if (!file_exists($xml)) {
                            return false;
                     }
                     $this->XML_DOC->load($xml);
              }

              /**
               * public function saveToFile ()
               * save the current log to a given file
               *
               * @Param (string) sFile : name of the log file
               */
              public function saveToFile()
              {
                     /** �� ���������� ���� ������ �� �������� '/error.php' */
                     if (true === $this->aOptions['LOGFILE'] && isset($_SERVER['PHP_SELF']) &&
                            $_SERVER['PHP_SELF'] != '/error.php') {
                            $sxmlNew = str_get_html($this->XML_DOC->saveXML());
                            // �������� ���������� �� ��� ����
                            if ($this->saveNewLog($sxmlNew)) {
                                   $sxml = file_get_html($this->sFile);
                                   foreach ($sxmlNew->find("ERROR[id]") as $errorNew) {
                                          $saveNew = true; // true - ����� ������
                                          $this->sendMail();
                                          if ($this->printMail) {
                                                 $errorNew->addChild($errorNew, "DATE_MAIL", date('d-m-Y H:i:s'));
                                          }
                                          foreach ($sxml->find("ERROR[id]") as $errorFile) {
                                                 if ($errorFile->find("FILE", 0)->innertext ===
                                                        $errorNew->find("FILE", 0)->innertext and
                                                        $errorFile->find("LINE", 0)->innertext ===
                                                        $errorNew->find("LINE", 0)->innertext and
                                                        $errorFile->find("PHP_MESSAGE", 0)->innertext ===
                                                        $errorNew->find("PHP_MESSAGE", 0)->innertext) {
                                                        if (count($errorNew->find("DATE_MAIL", 0)) === 0) {
                                                               $dateMail = $errorFile->find("DATE_MAIL", 0)->innertext;
                                                               $errorNew->addChild($errorNew, "DATE_MAIL", $dateMail);
                                                        }
                                                        $errorFile->outertext = $errorNew->outertext;
                                                        $saveNew = false; // ������ ������� � ���������
                                                        $this->_saveLOG($sxml->save());
                                                        break;
                                                 }
                                          }
                                          if ($saveNew === true) { // ���� ������ �����
                                                 $errorNew->id = $this->idTagErr();
                                                 $errorNew->addChild($errorNew, "DATE_MAIL", date('d-m-Y H:i:s'));
                                                 $root = $sxml->find("ROOT", 0);
                                                 $root->innertext = $root->innertext.$errorNew->outertext;
                                                 $this->_saveLOG($sxml->save());
                                          }
                                   }
                                   $this->printMail = false;
                                   unset($errorFile);
                                   unset($errorNew);
                                   unset($saveNew);
                                   $sxml->clear();
                                   unset($sxml);
                            }
                            $this->glearMail();
                            $sxmlNew->clear();
                            unset($sxmlNew);
                     }
              }

              /**
               * ���������� ������� � ����� log
               *
               * @return int id=$idNew ����� �������� id
               */
              private function idTagErr()
              {
                     $idxml = file_get_html($this->sFile);
                     $idNew = count($idxml->find("ERROR[id]")) + 1;
                     $idxml->clear();
                     unset($idxml);
                     return $idNew;
              }

              /**
               * @param $sxmlNew
               * ������ ������ ����
               *
               * @return mixed
               */
              private function saveNewLog($sxmlNew)
              {
                     if (!file_exists($this->sFile) or filesize($this->sFile) == 0) {
                            if (count($sxmlNew->find("ERROR[id]")) > 0) {
                                   $this->_saveLOG($sxmlNew->save());
                            }
                            $this->sendMail();
                            if ($this->printMail) {
                                   foreach ($sxmlNew->find("ERROR[id]") as $errorNew) {
                                          $errorNew->addChild($errorNew, "DATE_MAIL", date('d-m-Y H:i:s'));
                                   }
                                   $this->printMail = false;
                            }
                            $this->_saveLOG($sxmlNew->save());
                            return false;
                     }
                     return true;
              }

              /**
               * ������ � ���������� ����
               *
               * @param        $xmlLOG - xml ������
               */
              private function _saveLOG($xmlLOG)
              {
                     if (!$xml = fopen($this->sFile, "w")) {
                            trigger_error("�� ���� ������� ���� ($this->sFile)", E_USER_WARNING);
                            exit;
                     }
                     // ������ - ���� ���������� � �������� ��� ������.
                     if (is_writable($this->sFile)) {
                            flock($xml, LOCK_EX); //���������� �����
                            $xmlLOG = str_replace("> <", "><", $xmlLOG);
                            $xmlLOG = explode("><", $xmlLOG);
                            $xmlLOG = join(">\n<", $xmlLOG);
                            if (fwrite($xml, $xmlLOG) === false) {
                                   trigger_error("�� ���� ���������� ������ � ���� ($this->sFile)", E_USER_WARNING);
                                   exit;
                            }
                            flock($xml, LOCK_UN); //������ ����������
                            fclose($xml);
                     }
                     else {
                            echo "���� $this->sFile ���������� ��� ������";
                     }
              }

              /**
               *  �������� log ����� �� max ������, ������� � ��������
               */
              private function glearMail()
              {
                     if (filesize($this->sFile) > ($this->mailOptions['log_Max_Size'] * 1024)) {
                            //  �������� ����� �� email
                            $this->printMail = true;
                            // �������� ����� ���� �� email
                            $this->logMail = true;
                            $styleErr = file_get_contents(__DIR__.'/../../classes/debugger/css/default.dat');
                            $mail_mes =
                                   $styleErr."<html><body><h1>Report of errors log</h1><br>".$this->showAll()."<br>";
                            $mail_mes .= '<p>This letter was created and a log on server was cleared at '.date('Y-m-d').'.<br>
																					    This message was sent automatically by robot, please don\'t reply!</p></body></html>';
                            $mail = new Sender();
                            $mail->from_Addr = $this->mailOptions['from_Addr'];
                            $mail->from_Name = $this->mailOptions['from_Name'];
                            $mail->to = $this->mailOptions['to_Addr'];
                            $mail->subj = 'Report of errors log';
                            $mail->body_type = 'text/html';
                            $mail->body = $mail_mes;
                            $mail->priority = 2;
                            $mail->prepare_letter();
                            $mail->send_letter();
                            $this->logMail = false;
                            $this->printMail = false;
                            $dateMail = $this->XML_DOC->createElement('DATE_MAIL', date('d-m-Y H:i:s'));
                            $node = $this->XML_DOC->importNode($dateMail, true); //�������� �������� ����
                            $this->XML_ROOT->appendChild($node); //��������� �������� � ���������
                            unlink($this->sFile);
                            unset($mail);
                     }
              }

              /**
               * public function __destruct ()
               * destructor
               * will save the log to a file if the LOGFILE option is set to true
               */
              public function __destruct()
              {
                     $this->saveToFile();
              }

              /**
               * public function __set ()
               * allows some properties to be set
               *
               * @Param (string) sProp : name of the property
               * @Param (mixed) mVal : the value to be given to the property
               * @Return (boolean) false if failed, true if succeeded
               */
              public function __set($sProp, $mVal)
              {
                     if (false === array_key_exists($sProp, $this->aCanBeSet)) {
                            return false;
                     }
                     switch ($sProp) {
                            case 'log_File' :
                                   if (!is_string($mVal)) {
                                          return false;
                                   }
                                   $this->sFile = $_SERVER['DOCUMENT_ROOT'].'/logs/'.$mVal;
                                   return true;
                                   break;
                            case 'mail_Period' :
                                   if (!is_int($mVal)) {
                                          return false;
                                   }
                                   $this->mailOptions['mail_Period'] = $mVal;
                                   return true;
                                   break;
                            case 'from_Addr' :
                                   if (!is_string($mVal)) {
                                          return false;
                                   }
                                   $this->mailOptions['from_Addr'] = $mVal;
                                   return true;
                                   break;
                            case 'from_Name' :
                                   if (!is_string($mVal)) {
                                          return false;
                                   }
                                   $this->mailOptions['from_Name'] = $mVal;
                                   return true;
                                   break;
                            case 'to_Addr' :
                                   if (!is_string($mVal)) {
                                          return false;
                                   }
                                   $this->mailOptions['to_Addr'] = $mVal;
                                   return true;
                                   break;
                            case 'log_Max_Size' :
                                   if (!is_int($mVal)) {
                                          return false;
                                   }
                                   $this->mailOptions['log_Max_Size'] = $mVal;
                                   return true;
                                   break;
                            case 'LINES' :
                                   if (!is_int($mVal)) {
                                          return false;
                                   }
                                   $this->iNbLines = $mVal;
                                   return true;
                                   break;
                            case 'HTML' :
                                   if (!file_exists(__DIR__.'/templates/'.$mVal.'.dat')) {
                                          return false;
                                   }
                                   $this->sTemplateHTML = $mVal;
                                   return true;
                                   break;
                            case 'HTMLLOG' :
                                   if (!file_exists(__DIR__.'/templates/'.$mVal.'.dat')) {
                                          return false;
                                   }
                                   $this->sTemplateHTMLLOG = $mVal;
                                   return true;
                                   break;
                            case 'CSS' :
                                   if (!file_exists(__DIR__.'/css/'.$mVal.'.dat')) {
                                          return false;
                                   }
                                   $this->sTemplateCSS = $mVal;
                                   readfile(__DIR__.'/css/'.$mVal.'.dat');
                                   return true;
                                   break;
                            case 'CSSLOG' :
                                   if (!file_exists(__DIR__.'/css/'.$mVal.'.dat')) {
                                          return false;
                                   }
                                   $this->sTemplateCSSLOG = $mVal;
                                   readfile(__DIR__.'/css/'.$mVal.'.dat');
                                   return true;
                                   break;
                            case 'REALTIME' :
                                   if (!is_bool($mVal)) {
                                          return false;
                                   }
                                   $this->aOptions['REALTIME'] = $mVal;
                                   return true;
                                   break;
                            case 'LOGFILE' :
                                   if (!is_bool($mVal)) {
                                          return false;
                                   }
                                   $this->aOptions['LOGFILE'] = $mVal;
                                   return true;
                                   break;
                            case 'ERROUTPUT' :
                                   if (!is_bool($mVal)) {
                                          return false;
                                   }
                                   $this->aOptions['ERROUTPUT'] = $mVal;
                                   return true;
                                   break;
                            case 'ERROR' :
                                   if (!is_bool($mVal)) {
                                          return false;
                                   }
                                   $this->aOptions['ERROR'] = $mVal;
                                   if (true === $mVal) {
                                          set_error_handler([$this, 'myErrorHandler']);
                                   }
                                   else {
                                          restore_error_handler();
                                   }
                                   return true;
                                   break;
                            case 'EXCEPTION' :
                                   if (!is_bool($mVal)) {
                                          return false;
                                   }
                                   $this->aOptions['EXCEPTION'] = $mVal;
                                   if (true === $mVal) {
                                          set_exception_handler([$this, 'myExceptionHandler']);
                                   }
                                   else {
                                          restore_exception_handler();
                                   }
                                   return true;
                                   break;
                            default:
                                   return false;
                     }
              }

              /**
               * ����� CSS
               */
              public function setCss($mVal)
              {
                     if (file_exists(__DIR__.'/css/'.$mVal.'.dat')) {
                            $this->sTemplateCSS = $mVal;
                            readfile(__DIR__.'/css/'.$mVal.'.dat');
                     }
              }

              /**
               * ����� CSSLOG
               */
              public function setCssLog($mVal)
              {
                     if (file_exists(__DIR__.'/css/'.$mVal.'.dat')) {
                            $this->sTemplateCSSLOG = $mVal;
                            readfile(__DIR__.'/css/'.$mVal.'.dat');
                     }
              }

              /**
               * @return mixed
               *  ����� ������
               */
              public function showRealtime()
              {
                     return $this->aOptions['REALTIME'];
              }

              /**
               * public function __get ()
               * allows some properties to be get
               *
               * @Param (string) sProp : name of the property
               * @Return (boolean) false if failed, value of the property if succeeded
               */
              public function __get($sProp)
              {
                     if (false === array_key_exists($sProp, $this->aCanBeSet)) {
                            return false;
                     }
                     $sRealProp = $this->aCanBeSet[$sProp];
                     return $this->$sRealProp;
              }
       }

?>
