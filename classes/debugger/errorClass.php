<?php
       require_once (__DIR__.'/../../inc/func.php');
       require_once (__DIR__.'/../../classes/autoload.php');
       autoload::getInstance();
       /*if (check_Session::getInstance()->has('Debug_HC')) {
               $Debug_HackerConsole_Main = Debug_HackerConsole_Main::getInstance(true);
       }*/
       /**
        * CLASS debugger_errorClass
        *
        *
        */
       class debugger_errorClass {


              /**
               * @var array mailOptions
               */
              private $mailOptions = array(
                     'mail_Period'  => 5, // Minimal period for sending an error message (in minutes)
                     'from_Addr'    => "webmaster@aleks.od.ua",
                     'from_Name'    => "Ошибки в скриптах",
                     'to_Addr'      => "aleksjurii@gmail.com",
                     'log_Max_Size' => 250 //// Max size of a log before it will sended and cleared (in kb)
              );
              /**
               * private (string) sAssertion
               * Check if error comes from an essertion or not, if yes, will conatin the filename of the evaluated script
               */
              private $sAssertion = NULL;
              /**
               * private (string) sLang
               * localization string
               */
              private $sLang = 'EN';

              /**
               * private (int) iNbLines
               * Количество сторок до и после ошибки
               */
              private $iNbLines = 5;

              /**
               * private (array) aOptions
               * Options array
               */
              private $aOptions = array(
                     'REALTIME'  => true,
                     'LOGFILE'   => true,
                     'ERROR'     => true,
                     'EXCEPTION' => true,
                     'ERROUTPUT' => false // вывод fafal error (системная переменная)
              );

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
               * Текущий файл уникальный идентификатор
               */
              private $sCurId = '';

              /**
               * @var null
               * XML LOG Object (simplexml object)
               */
              private $sxmlNew = NULL;
              /**
               * private (object) XML_DOC
               * XML LOG Object (DOMDocument object)
               */
              private $XML_DOC = NULL;
              /**
               * private (object) XML_ROOT
               * XML LOG root Object (DOMDocument object)
               */
              private $XML_ROOT = NULL;
              /**
               * private (object) oCurrentNode
               * Current node Object (DOMDocument object)
               */
              private $currentNode = NULL;

              /**
               * private (array) aCanBeSet
               * class properties that can be set via debugger_errorClass::__set()
               */
              private $aCanBeSet = array(
                     'mail_Period'  => "mailOptions['mail_Period']",
                     'from_Addr'    => "mailOptions['from_Addr']",
                     'from_Name'    => "mailOptions['from_Name']",
                     'to_Addr'      => "mailOptions['to_Addr']",
                     'log_Max_Size' => "mailOptions['log_Max_Size']",
                     'LINES'        => "iNbLines",
                     'REALTIME'     => "aOptions['REALTIME']",
                     'LOGFILE'      => "aOptions['LOGFILE']",
                     'ERROUTPUT'    => "aOptions['ERROUTPUT']",
                     'HTML'         => "sTemplateHTML",
                     'CSS'          => "sTemplateCSS",
                     'HTMLLOG'      => "sTemplateHTMLLOG",
                     'CSSLOG'       => "sTemplateCSSLOG",
                     'ERROR'        => "aOptions['ERROR']",
                     'EXCEPTION'    => "aOptions['EXCEPTION']",
                     'log_File'     => "sFile"
              );

              /**
               *  автовключение вывода при наличии ошибки
               */
              public $isError = 0;

              /**
               * private (object) XML_TYPES
               * XML DOMDocument object with the list of error types and their translation
               */
              private $XML_TYPES = NULL;

              /**
               * @var bool
               * переключение вывода с экрана на mail
               */
              private $printMail = false;

              /**
               * @var bool
               * вывод  лога на email
               */
              private $logMail = false;

              /**
               * @var null
               * имя лог файла
               */
              private $sFile = NULL;

              /**
               * private (object) XML_ERRORS
               * XML DOMDocument object with the list of errors and their translation
               */
              private $XML_ERRORS = NULL;

              /**
               * private (array) aIndex
               * replacement array for the templates
               */
              private $aIndex = array(
                     0   => array(
                            '{DATE_START_TITRE}',
                            '{DATE_START_VALUE}'
                     ),
                     1   => array(
                            '{DATE_NEW_TITRE}',
                            '{DATE_NEW_VALUE}'
                     ),
                     2   => array(
                            '{KOLL_TITRE}',
                            '{KOLL_VALUE}'
                     ),
                     3   => array(
                            '{TYPE_TITRE}',
                            '{TYPE_VALUE}'
                     ),
                     4   => array(
                            '{MSG_TITRE}',
                            '{MSG_VALUE}'
                     ),
                     5   => array(
                            '{FILE_TITRE}',
                            '{FILE_VALUE}'
                     ),
                     6   => array(
                            '{LINE_TITRE}',
                            '{LINE_VALUE}'
                     ),
                     7   => array(
                            '{MEM_TITRE}',
                            '{MEM_VALUE}'
                     ),
                     8   => array(
                            '{TRANS_TITRE}',
                            '{TRANS_VALUE}'
                     ),
                     9   => array(
                            '{SUGG_TITRE}',
                            '{SUGG_VALUE}'
                     ),
                     10  => array(
                            '{CONTEXT_TITRE}',
                            '{CONTEXT_VALUE}'
                     ),
                     11  => array(
                            '{SOURCE_TITRE}',
                            '{SOURCE_VALUE}'
                     ),
                     100 => '{TOTAL_STATS}',
                     101 => '{PHP_VERSION}'
              );

              static private $instance = NULL;


              /**
               * function Singleton
               * Создание объекта в единственном экземпляре
               *
               * @param string $sLang
               *
               * @return null|debugger_errorClass
               */
              static function getInstance($sLang = 'EN') {

                     if (self::$instance == NULL) {
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
              public function __construct($sLang) {

                     error_reporting(0);
                     $aLnDir = scandir(__DIR__.'/xml');
                     if (in_array($sLang, $aLnDir)) {
                            $this->sLang = $sLang;
                     }
                     $this->XML_ERRORS = new DOMDocument('1.0', 'utf-8');
                     $this->XML_ERRORS->load(__DIR__.'/xml/'.$this->sLang.'/errors.xml');
                     $this->XML_TYPES = new DOMDocument('1.0', 'utf-8');
                     $this->XML_TYPES->load(__DIR__.'/xml/'.$this->sLang.'/types.xml');
                     $this->XML_DOC  = new DOMDocument ('1.0', 'utf-8');
                     $root           = $this->XML_DOC->createElement("ROOT");
                     $this->XML_ROOT = $this->XML_DOC->appendChild($root);
                     if (!is_dir($_SERVER['DOCUMENT_ROOT'].'/logs')) {
                            mkdir($_SERVER['DOCUMENT_ROOT'].'/logs', 0744);
                     }
                     $this->sCurId = date('Ymd').'_'.uniqid();
                     if ($this->sFile === NULL) {
                            $this->sFile = $_SERVER['DOCUMENT_ROOT'].'/logs/'.$this->sCurId.'_error_log.xml';
                     }
                     set_error_handler(array($this, 'myErrorHandler'));
                     set_exception_handler(array($this, 'myExceptionHandler'));
                     register_shutdown_function(array($this, 'captureShutdown'));
                     $this->sxmlNew = simplexml_import_dom($this->XML_DOC);
              }



              /**
               * Функция перехвата фатальных ошибок
               * UNCATCHABLE ERRORS
               */
              public function captureShutdown() {

                     $error = error_get_last();
                     ;
                     if ($error) {
                            $message  = '';
                            $sErrFile = '';
                            $iErrLine = '';
                            foreach ($error as $key => $value) {
                                   if ($key == 'file') $sErrFile = $value;
                                   if ($key == 'line') $iErrLine = $value;
                                   if ($key == 'message') $message = $value;
                                   if ($key == 'type') $message = $value;
                            }
                            $sVars    = debugger_SHOWCONTEXT::notify();
                            $aTempArr = array('TRANSLATION' => 'Остановка скрипта из-за фатальной ошибки', 'SUGGESTION' => 'Проверьте скрипт на ошибки');
                            $errType  = 'Fatal Error';
                            $this->setCssLog('default_log');
                            $this->setCss('default');
                            // включить вывод всех ошибок при Fatal Error
                            $this->aOptions['ERROUTPUT'] = true;
                            $this->buildLog($errType, $message, $sErrFile, $iErrLine, $aTempArr, $sVars);
                     }
                     if ($this->aOptions['ERROUTPUT'] === true) {
                            $this->saveToFile();
                     }

                     return true;
              }


              /**
               * public function checkCode ()
               * use the assert () function to get the errors in a given string, or a given file
               *
               * @Param (string) sString : the string with the PHP code to evaluate, or the file to evaluate. Usually, it will come from a file via file_get_contents () for example
               * @Return : false if given parameter is not a string.
               */
              public function checkCode($sCode) {

                     if (file_exists($sCode)) {
                            $sString          = file_get_contents($sCode);
                            $this->sAssertion = $sCode;
                     } elseif (!is_string($sCode)) {
                            return false;
                     } else {
                            $sString = $sCode;
                     }
                     $sString = str_replace(array('<?php', '<?', '?>'), '', $sString);
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
              public function myAssertHandler($file, $line, $code) {

                     return true;
              }


              /**
               * private function checkErrorMessage ()
               * try to find the correct trsnalation and suggestion from a given error message
               *
               * @Param (string) sMsg : the PHP error message
               * @Return (array) aTempArr : array with the translation and the suggestion found
               */
              private function checkErrorMessage($sMsg) {

                     $iLength     = strlen($sMsg);
                     $xpath       = new DOMXPath($this->XML_ERRORS);
                     $sQueryLabel = '//error/label';
                     $oLabelLists = $xpath->query($sQueryLabel);
                     $aMsg        = explode(' ', $sMsg);
                     foreach ($oLabelLists as $oLabel) {
                            $aLabel = explode(' ', $oLabel->nodeValue);
                            $aDiff  = array_diff($aLabel, $aMsg);
                            if (empty ($aDiff)) {
                                   $aTempArr['TRANSLATION'] = iconv('utf-8', 'windows-1251', $oLabel->nextSibling->nextSibling->nodeValue);
                                   $aTempArr['SUGGESTION']  = iconv('utf-8', 'windows-1251', $oLabel->nextSibling->nextSibling->nextSibling->nextSibling->nodeValue);

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
              private function checkTypeTrans($cErrno) {

                     $xpath       = new DOMXPath($this->XML_TYPES);
                     $sQueryLevel = '//type/level';
                     $oLevelList  = $xpath->query($sQueryLevel);
                     foreach ($oLevelList as $oLevel) {
                            if (constant($oLevel->nodeValue) === $cErrno) {
                                   return $oLevel->nextSibling->nextSibling->nodeValue;
                            }
                     }
              }


              /**
               * public function myExceptionHandler ()
               * the exception handler : builds the XML error log
               *
               * @Param (object) e : the Exception object
               */
              public function myExceptionHandler($e) {

                     $sErrStr  = $e->getMessage();
                     $iErrLine = $e->getLine();
                     $sType    = 'Exception '.$e->getCode();
                     if (is_null($this->sAssertion)) {
                            $sErrFile = $e->getFile();
                     } else {
                            $sErrFile         = $this->sAssertion;
                            $this->sAssertion = NULL;
                     }
                     $aTempArr = array('TRANSLATION' => '', 'SUGGESTION' => '');
                     $this->setCssLog('default_log');
                     $this->setCss('default');
                     $this->aOptions['ERROUTPUT'] = true;
                     $sVars                       = debugger_SHOWCONTEXT::notify();
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
              public function myErrorHandler($cErrno, $sErrStr, $sErrFile, $iErrLine, $mVars) {

                     $aTempArr = $this->checkErrorMessage($sErrStr);
                     $sType    = $this->checkTypeTrans($cErrno);
                     if (!is_null($this->sAssertion)) {
                            $sErrFile         = $this->sAssertion;
                            $this->sAssertion = NULL;
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
              private function buildLog($sType, $sErrStr, $sErrFile, $iErrLine, $aTempArr, $sVars) {

                     // не создавать если пришли со страницы '/error.php'
                     if (isset($_SERVER['PHP_SELF']) && $_SERVER['PHP_SELF'] != '/error.php') {
                            $iErrLine--;
                            if ($iErrLine < 0) {
                                   $iErrLine = 0;
                            }
                            $koll      = 1;
                            $dateStart = date('d-m-Y H:i:s');
                            if (file_exists($this->sFile) and filesize($this->sFile) != 0) {

                                   $html = file_get_html($this->sFile);
                                   $errors = $html->find('ERROR[id]');

                                   foreach ($errors as $error) {
                                          if ($error->getElementByTagName("PHP_MESSAGE")->innertext == iconv("WINDOWS-1251", "UTF-8", $sErrStr)) {
                                                 $koll      = $error->getElementByTagName("KOLL")->innertext + 1;
                                                 $dateStart = $error->getElementByTagName(("DATE_START"))->innertext;
                                   //       dump_d('1: '.$koll." ".$dateStart);
                                          break;
                                          }
                                   //       dump_d('2: '.iconv("WINDOWS-1251", "UTF-8", $sErrStr));
                                   //       dump_d('3: '.$error);
                                   }

                                    /*$sxml = simplexml_load_file($this->sFile);
                                    foreach ($sxml->ERROR as $error) {
                                    if ($error->PHP_MESSAGE == iconv("WINDOWS-1251", "UTF-8", $sErrStr)) {
                                    $koll      = intval($error->KOLL) + 1;
                                    $dateStart = ((string)$error->DATE_START);
                                    break;
                                    }
                             }*/
                                    }
                            unset($sxml);
                            $oNewLog = $this->XML_DOC->createElement('ERROR');
                            $iNewId  = $this->XML_ROOT->getElementsByTagName('ERROR')->length + 1;
                            $oNewLog = $this->XML_ROOT->appendChild($oNewLog);
                            $oNewLog->setAttribute('id', $iNewId);
                            $aElem[] = $this->XML_DOC->createElement('DATE_START', $dateStart);
                            $aElem[] = $this->XML_DOC->createElement('DATE_NEW', date('d-m-Y H:i:s'));
                            $aElem[] = $this->XML_DOC->createElement('KOLL', $koll);
                            $aElem[] = $this->XML_DOC->createElement('TYPE', $sType);
                            // $sErrStr = utf8_encode($sErrStr);
                            $aElem[]     = $this->XML_DOC->createElement('PHP_MESSAGE', iconv("WINDOWS-1251", "UTF-8", $sErrStr));
                            $aElem[]     = $this->XML_DOC->createElement('FILE', $sErrFile);
                            $aElem[]     = $this->XML_DOC->createElement('LINE', $iErrLine + 1);
                            $aElem[]     = $this->XML_DOC->createElement('MEMORY', function_exists('memory_get_usage') ? @memory_get_usage() : 'n/a');
                            $aElem[]     = $this->XML_DOC->createElement('TRANSLATION', iconv("WINDOWS-1251", "UTF-8", $aTempArr['TRANSLATION']));
                            $aElem[]     = $this->XML_DOC->createElement('SUGGESTION', iconv("WINDOWS-1251", "UTF-8", $aTempArr['SUGGESTION']));
                            $aElem[]     = $this->XML_DOC->createElement('CONTEXT', $sVars);
                            $oSource     = $this->XML_DOC->createElement('SOURCE');
                            $aSourceElem = array();
                            $numLine     = $iErrLine + 1 - $this->iNbLines;
                            foreach ($this->getLine($sErrFile, $iErrLine) as $iLine => $sLine) {
                                   // $sLine = utf8_encode($sLine);
                                   if ($iLine === $iErrLine) {
                                          $aSourceElem[] = $this->XML_DOC->createElement('SOURCE_LINE_ERROR',
                                                 $numLine.') '.trim(iconv("WINDOWS-1251", "UTF-8", ' /** ЛИНИЯ ОШИБКИ => */ '.$sLine)));

                                   } else {
                                          $aSourceElem[] =
                                                 $this->XML_DOC->createElement('SOURCE_LINE', $numLine.') '.trim(iconv("WINDOWS-1251", "UTF-8", $sLine)));
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
                            // превью и лог для fatal error
                            // если fatal error
                            if ($this->aOptions['ERROUTPUT'] === true) {
                                   //	и если включен показ
                                   if (true === $this->aOptions['REALTIME']) {
                                          $this->showAll();
                                   }
                            }
                     }
              }


              /**
               *  Sending mail
               */
              function sendMail() {

                     // письма только для aleks.od.ua
                     //					if ($_SERVER['HTTP_HOST'] == stristr(mb_substr(get_domain(), 0, -1), "al")) {
                     if (file_exists($this->sFile)) {
                            $dateTime = '';
                            $sxml = @simplexml_load_file($this->sFile);
                            foreach($sxml->xpath("//ERROR/DATE_MAIL") as $dates) {
                                   if(strtotime((string)$dates) >= strtotime($dateTime)) {
                                          $dateTime = (string)$dates;
                                   }
                            }
                            if (strtotime($dateTime) < strtotime("-".$this->mailOptions['mail_Period']." minutes") or $dateTime === '') {
                                   //  включить вывод на email
                                   $this->printMail = true;
                                   $styleErr        = file_get_contents(__DIR__.'/../../classes/debugger/css/default.dat');
                                   $mail_mes        = $styleErr."<u><b>Error:</b></u><br><span style='color: #900000; font-size: 12px; font-weight: bold;'>
																											 <b>\$_SERVER_NAME</b> = ".$_SERVER['SERVER_NAME']."</span>".$this->showAll();
                                   $mail            = new Mail_sender;
                                   $mail->from_Addr = $this->mailOptions['from_Addr'];
                                   $mail->from_Name = $this->mailOptions['from_Name'];
                                   $mail->to        = $this->mailOptions['to_Addr'];
                                   $mail->subj      = "Произошла ошибка: ";
                                   $mail->body_type = 'text/html';
                                   $mail->body      = $mail_mes;
                                   $mail->priority  = 1;
                                   $mail->prepare_letter();
                                   $mail->send_letter();
                                   unset($mail);
                            }
                            unset($sxml);
                            unset($mail);
                     }
              }
       //}


              /**
               * public function showAll ()
               * show the whole current xml log
               * показать весь текущий XML log
               */
              public function showAll() {

                     if ($this->logMail) {
                            // Отправка log файла
                            $xml = new DOMDocument('1.0', 'utf-8');
                            if (file_exists($this->sFile) and filesize($this->sFile) != 0) {
                                   $xml->load($this->sFile);
                            }
                     } else {
                            $xml = $this->XML_DOC;
                     }
                     $xpath  = new DOMXPath($xml);
                     $sQuery = '//ERROR';
                     if ($xpath->query($sQuery)->length > 0) {
                            $oNodeLists = $xpath->query($sQuery);
                            $err        = '';
                            foreach ($oNodeLists as $oNodeList) {
                                   $this->currentNode = $oNodeList;
                                   $err .= $this->printMe();
                            }
                            if ($this->printMail) {
                                   return ($err);
                            } else {
                                   echo ($err);
                            }
                     }
              }


              /**
               * public function showLog ()
               * show the whole current log in a table, with stats (best used after debugger_errorClass::loadXML())
               * показать весь текущий журнал в таблице, со статистикой (лучше всего использовать после debugger_errorClass :: LoadXml ())
               *
               * @Return (string) sHtml : the generated HTML
               */
              public function showLog() {

                     $sBaseHtml      = file_get_contents(__DIR__.'/templates/'.$this->sTemplateHTMLLOG.'.dat');
                     $iStartPos      = strpos($sBaseHtml, '<!-- LINES HERE -->');
                     $sHtml          = substr($sBaseHtml, 0, $iStartPos);
                     $iEndPos        = strpos($sBaseHtml, '<!-- STATS -->');
                     $iLength        = strlen($sBaseHtml);
                     $sTempHtml      = substr($sBaseHtml, $iStartPos, -($iLength - $iEndPos));
                     $sTempHtmlTotal = '';
                     $xpath          = new DOMXPath($this->XML_DOC);
                     $sQuery         = '//ERROR';
                     $oNodeLists     = $xpath->query($sQuery);
                     foreach ($oNodeLists as $oNodeList) {
                            $this->currentNode = $oNodeList;
                            $sTempHtmlTotal .= $this->printMeLog($sTempHtml);
                     }
                     $sHtml .= $sTempHtmlTotal;
                     $sQuery     = '//ERROR/TYPE';
                     $oNodeLists = $xpath->query($sQuery);
                     $sCountType = '';
                     $aTypes     = array();
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
                     $sHtml    = str_replace($this->aIndex[100], $sCountType, $sHtml);
                     $sHtml    = str_replace($this->aIndex[101], $sVersion, $sHtml);

                     return $sHtml;
              }



              /**
               * private function printMe ()
               * display a caught error
               *
               * @Return (string) sHtml : the generated HTML
               */
              private function printMe() {

                     $sHtml     = file_get_contents(__DIR__.'/templates/'.$this->sTemplateHTML.'.dat');
                     $nodeLists = $this->currentNode->childNodes;
                     $iId       = $this->currentNode->getAttribute('id');
                     for ($n = 0; $n < $nodeLists->length; $n++) {
                            if ($nodeLists->item($n)->nodeType == 1) {
                                   $sName = $nodeLists->item($n)->nodeName;
                                   if ($sName === 'SOURCE') {
                                          $sourceNodeList = $nodeLists->item($n)->childNodes;
                                          $sValeur        = '';
                                          for ($j = 0; $j < $sourceNodeList->length; $j++) {
                                                 $sValeur .= str_replace(array('<?php', '?>', '<?'), '', $sourceNodeList->item($j)->nodeValue);
                                                 $sValeur .= "\r\n";
                                          }
                                          $sValeur = highlight_string('<?php '."\r\n".$sValeur.'?>', true);
                                   } elseif ($sName === 'CONTEXT') {
                                          $php_INFO    = debugger_SHOWCONTEXT::php_INFO();
                                          $content     = $nodeLists->item($n)->nodeValue;
                                          $contentData = $content.$php_INFO;
                                          $contentTeg  = $contentData;
                                          $sValeur     = $contentTeg;
                                   } else {
                                          $sValeur = $nodeLists->item($n)->nodeValue;
                                   }
                                   $sId          = uniqid().'_'.$iId;
                                   $sValeur      = iconv("UTF-8", "windows-1251", $sValeur);
                                   $aReplacement = array($sName, $sValeur);
                                   $sHtml        = str_replace($this->aIndex[$n], $aReplacement, $sHtml);
                                   $sHtml        = str_replace('{ID}', $sId, $sHtml);
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
              private function printMeLog($sHtml) {

                     $nodeList = $this->currentNode->childNodes;
                     for ($i = 0; $i < $nodeList->length; $i++) {
                            if ($nodeList->item($i)->nodeName === 'SOURCE') {
                                   $sourceNodeList = $nodeList->item($i)->childNodes;
                                   $sValeur        = '';
                                   for ($j = 0; $j < $sourceNodeList->length; $j++) {
                                          $sValeur .= str_replace(array('<?php', '?>', '<?'), '', $sourceNodeList->item($j)->nodeValue);
                                          $sValeur .= "\r\n";
                                   }
                                   $sValeur = highlight_string('<?php '."\r\n".$sValeur.'?>', true);
                            } else {
                                   $sValeur = $nodeList->item($i)->nodeValue;
                            }
                            $sValeur = iconv("UTF-8", "windows-1251", $sValeur);
                            $sValeur = str_replace("&nbsp;&nbsp;&nbsp;", "", $sValeur);
                            $sHtml   = str_replace($this->aIndex[$i][1], $sValeur, $sHtml);
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
              private function getLine($sErrFile, $iErrLine) {

                     $aSource = array();
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
              public function loadXML($sFile = NULL) {

                     if ($sFile === NULL) {
                            $xml = $this->sFile;
                     } else {
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
              public function saveToFile() {

                     /** не записывать если пришли со страницы '/error.php' */
                     if (true === $this->aOptions['LOGFILE'] && isset($_SERVER['PHP_SELF']) && $_SERVER['PHP_SELF'] != '/error.php') {
                            if (!file_exists($this->sFile) or filesize($this->sFile) == 0) {
                                   //	записать если присутствует тег 'DATE'
                                   if ($this->sxmlNew->ERROR->count() > 0) {
                                          $this->sxmlNew->asXML($this->sFile);
                                   }
                                   $this->sendMail();
                                   if ($this->printMail) {
                                          foreach ($this->sxmlNew->xpath("//ERROR") as $errorNew) {
                                                 $errorNew->addChild('DATE_MAIL', date('d-m-Y H:i:s'));
                                          }
                                          $this->printMail = false;
                                   }
                                   $this->_saveLOG($this->sxmlNew->saveXML());
                                   return true;
                            }
                            $sxml = file_get_html($this->sFile);
                            $sxmlNew = str_get_html($this->XML_DOC->saveXML());
                            foreach ($sxmlNew->find("ERROR[id]") as $errorNew) {
                                   /** $saveVar - переменная trigger записи новой ошибки */
                                    $saveVar = NULL;
                                   dump_d(count($sxml->find("ERROR[id]")));
                            foreach ($sxml->find("ERROR[id]") as $errorFile) {
                            dump_d($errorFile);
                            if ($errorFile->getElementByTagName("FILE")->innertext == $errorNew->getElementByTagName("FILE")->innertext and
                                  $errorFile->getElementByTagName("LINE")->innertext == $errorNew->getElementByTagName("LINE")->innertext) {

                                   $errorFile->outertext = $errorNew->outertext;
                                   $errorFile->getElementByTagName("DATE_MAIL")->outertext = $errorNew->getElementByTagName("DATE_MAIL")->outertext;
                                    }
                                           $saveVar = true;
                                           $this->sendMail();
                                           if ($this->printMail) {
                                                  $errorFile->getElementByTagName("DATE_MAIL")->innertext = date('d-m-Y H:i:s');
                                           }
                                            $this->_saveLOG($sxml->save());


                                    if ($saveVar == NULL) {
                                           /** записать если запись ошибки в файле не найдена */
                                            $idNew     = count($sxml->find("ERROR[id]")) + 1;
                                            $errorSave = $sxml->appendChild('ERROR');
                                            $errorSave->setAttribute('ID', $idNew);
                                            $errorSave->outertext = $errorNew->outertext;
                                            $this->sendMail();
                                            if ($this->printMail) {
                                                   $errorSave->appendChild("DATE_MAIL");
                                                   $errorSave->getElementByTagName("DATE_MAIL")->innertext = date('d-m-Y H:i:s');
                                            } else {
                                                   $errorSave->appendChild("DATE_MAIL");
                                                   $errorSave->getElementByTagName("DATE_MAIL")->innertext = iconv("WINDOWS-1251", "UTF-8", "Файл не отправлен");
                                            }
                                           $this->_saveLOG($sxml->save());
                                    }
                            }





                               /** Конвертируем XML-файл в объект */
                           /* $sxml = simplexml_load_file($this->sFile);
                            foreach ($this->sxmlNew->xpath("//ERROR") as $errorNew) {*/
                                   /** $saveVar - переменная trigger записи новой ошибки */
                                  /* $saveVar = NULL;
                                   foreach ($sxml->xpath("//ERROR") as $errorFile) {
                                          if ((string)$errorFile->FILE == (string)$errorNew->FILE and (int)$errorFile->LINE == (int)$errorNew->LINE) {
                                                 foreach ($errorFile as $teg => $child) {
                                                        if ($teg != "SOURCE" && $teg != "DATE_MAIL") {
                                                               $errorFile->$teg = $errorNew->$teg;
                                                        }
                                                 }
                                                 $saveVar = true;
                                                 $this->sendMail();
                                                 if ($this->printMail) {
                                                        $errorFile->DATE_MAIL = date('d-m-Y H:i:s');
                                                 }
                                                 $sxml->asXML($this->sFile);
                                          }
                                   }
                                   if ($saveVar == NULL) {*/
                                          /** записать если запись ошибки в файле не найдена */
                                         /* $idNew     = count($sxml->ERROR) + 1;
                                          $errorSave = $sxml->addChild('ERROR');
                                          $errorSave->addAttribute('ID', $idNew);
                                          foreach ($errorNew as $teg => $childData) {
                                                 if ($teg == "SOURCE") {
                                                        if (!$sourse = $errorSave->SOURCE) {
                                                               $sourse = $errorSave->addChild("SOURCE");
                                                        }
                                                        foreach ($childData as $teg => $SOURCE_LINE) {
                                                               $sourse->addChild($teg, $SOURCE_LINE);
                                                        }
                                                 } else {
                                                        $errorSave->addChild($teg, $childData);
                                                 }
                                          }
                                          $this->sendMail();
                                          if ($this->printMail) {
                                                 $errorSave->addChild('DATE_MAIL', date('d-m-Y H:i:s'));
                                          } else {
                                                 $errorSave->addChild('DATE_MAIL', iconv("WINDOWS-1251", "UTF-8", "Файл не отправлен"));
                                          }
                                          $this->_saveLOG($sxml);
                                   }*/
                            }
                            $this->printMail = false;
                            unset($errorFile);
                           /* unset($child);
                            unset($teg);
                            unset($errorNew);
                            unset($saveVar);
                            $this->glearMail();
                                    $sxml->clear();
                                    unset($sxml);
                                    $sxmlNew->clear();
                                    unset($sxmlNew);*/

                         }
                     }



              /**
               * запись и разделение лога
               * @param        $xmlLOG - xml объект
               */
              private function _saveLOG($xmlLOG) {

                     if (!$xml = fopen($this->sFile, "w")) {
                            trigger_error("Не могу открыть файл ($this->sFile)", E_USER_WARNING);
                            exit;
                     }
                     // запись - файл существует и доступен для записи.
                     if (is_writable($this->sFile)) {
                            flock($xml, LOCK_EX); //БЛОКИРОВКА ФАЙЛА
                            $xmlLOG = str_replace("> <","><", $xmlLOG);
                            $xmlLOG = explode("><", $xmlLOG);
                            $xmlLOG = join(">\n<", $xmlLOG);
                            if (fwrite($xml, $xmlLOG) === false) {
                                   trigger_error("Не могу произвести запись в файл ($this->sFile)", E_USER_WARNING);
                                   exit;
                            }
                            flock($xml, LOCK_UN); //СНЯТИЕ БЛОКИРОВКИ
                            fclose($xml);
                     } else {
                            echo "Файл $this->sFile недоступен для записи";
                     }
              }


              /**
               *  проверка log файла на max размер, очистка и отправка
               */
              private function glearMail() {

                     if (filesize($this->sFile) > ($this->mailOptions['log_Max_Size'] * 1024)) {
                            //  включить вывод на email
                            $this->printMail = true;
                            // включить вывод лога на email
                            $this->logMail = true;
                            $styleErr      = file_get_contents(__DIR__.'/../../classes/debugger/css/default.dat');
                            $mail_mes      = $styleErr."<html><body><h1>Report of errors log</h1><br>".$this->showAll()."<br>";
                            $mail_mes     .= '<p>This letter was created and a log on server was cleared at '.date('Y-m-d').'.<br>
																					    This message was sent automatically by robot, please don\'t reply!</p></body></html>';
                            $mail            = new Mail_sender;
                            $mail->from_Addr = $this->mailOptions['from_Addr'];
                            $mail->from_Name = $this->mailOptions['from_Name'];
                            $mail->to        = $this->mailOptions['to_Addr'];
                            $mail->subj      = 'Report of errors log';
                            $mail->body_type = 'text/html';
                            $mail->body      = $mail_mes;
                            $mail->priority  = 2;
                            $mail->prepare_letter();
                            $mail->send_letter();
                            $this->logMail   = false;
                            $this->printMail = false;
                            $dateMail        = $this->XML_DOC->createElement('DATE_MAIL', date('d-m-Y H:i:s'));
                            $node            = $this->XML_DOC->importNode($dateMail, true); //выбираем корневой узел
                            $this->XML_ROOT->appendChild($node); //добавляем дочерний к корневому
                            unlink($this->sFile);
                            unset($mail);

                     }
              }


              /**
               * public function __destruct ()
               * destructor
               * will save the log to a file if the LOGFILE option is set to true
               */
              public function __destruct() {

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
              public function __set($sProp, $mVal) {

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
                                          set_error_handler(array($this, 'myErrorHandler'));
                                   } else {
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
                                          set_exception_handler(array($this, 'myExceptionHandler'));
                                   } else {
                                          restore_exception_handler();
                                   }

                                   return true;
                                   break;
                            default:
                                   return false;
                     }
              }



              /**
               * стили CSS
               */
              public function setCss($mVal) {

                     if (file_exists(__DIR__.'/css/'.$mVal.'.dat')) {
                            $this->sTemplateCSS = $mVal;
                            readfile(__DIR__.'/css/'.$mVal.'.dat');
                     }
              }


              /**
               * стили CSSLOG
               */
              public function setCssLog($mVal) {

                     if (file_exists(__DIR__.'/css/'.$mVal.'.dat')) {
                            $this->sTemplateCSSLOG = $mVal;
                            readfile(__DIR__.'/css/'.$mVal.'.dat');
                     }
              }


              /**
               * @return mixed
               *  вывод ошибок
               */
              public function showRealtime() {

                     return $this->aOptions['REALTIME'];
              }


              /**
               * public function __get ()
               * allows some properties to be get
               *
               * @Param (string) sProp : name of the property
               * @Return (boolean) false if failed, value of the property if succeeded
               */
              public function __get($sProp) {

                     if (false === array_key_exists($sProp, $this->aCanBeSet)) {
                            return false;
                     }
                     $sRealProp = $this->aCanBeSet[$sProp];

                     return $this->$sRealProp;
              }
       }

?>