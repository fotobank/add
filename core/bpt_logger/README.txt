*** Use example ***

How it works? It's extremely simple! First of all, you have to include it with

require("logger.class.php");

then create it (setting log file name) with

$logger = new Logger('./logs/'.date("Y-m-d").'TestLog.log');

and now you can use it! Call this method to append log information

$logger->append(constant("LOG_INFO"),'Log information');

By default, log level is set to LOG_INFO. Setting log level determinate what information will be write into the log file. In this way, you can use append method to log every operation using different log level (the first method's parameter) but only the information having a log level minus or equal to the Logger's level will be registered. For example

$logger->setLogLevel(constant("LOG_DEBUG"));
$logger->append(constant("LOG_INFO"),'Log information');
$logger->append(constant("LOG_DEBUG"),'Debug log information');

In this case, only the first information will be logged. You can change logging's verbosity simply setting

$logger->setLogLevel($log_level);

where $log_level can assume these values

LOG_ERROR
LOG_WARNING
LOG_INFO
LOG_DEBUG

If you don't want to use custom log level you can call this method instead of append:

$logger->error($msg) //Append $msg with LOG_ERROR level
$logger->warning($msg) //Append $msg with LOG_WARNING level
$logger->info($msg) //Append $msg with LOG_INFO level
$logger->debug($msg) //Append $msg with LOG_DEBUG level