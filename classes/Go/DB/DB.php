<?php
/**
 * goDB2: ���������� ��� ������ � ������������ ������ ������ �� PHP
 *
 * @package go\DB
 * @link    https://github.com/vasa-c/go-db source
 * @link    https://github.com/vasa-c/go-db/wiki documentation
 * @version 2.0.2 beta
 * @author  ��������� ���� aka vasa_c (http://blgo.ru/)
 * @license MIT (http://www.opensource.org/licenses/mit-license.php)
 * @uses    PHP >= 5.3
 * @uses    ��� ������� �������� ���� ����������
 */

namespace go\DB;

const VERSION = '2.0.2 beta';

abstract class DB
{

/*** STATIC: ***/

    /**
     * ������� ������ ��� ������� � ����
     *
     * @throws \go\DB\Exceptions\Config
     *         �������� ���������������� ���������
     * @throws \go\DB\Exceptions\Connect
     *         ������ �����������
     *
     * @param array $params
     *        ��������� ����������� � ����
     * @param string $adapter [optional]
     *        ������� ���� (���� �� ������ � $params)
     * @return \go\DB\DB
     *         ������ ��� ������� � ����
     */
    final public static function create(array $params, $adapter = NULL) {
        $adapter = isset($params['_adapter']) ? $params['_adapter'] : $adapter;
        $adapter = \strtolower($adapter);
        $classname = __NAMESPACE__.'\\Adapters\\'.$adapter;
        if (!\class_exists($classname, true)) {
            throw new Exceptions\UnknownAdapter($adapter);
        }
        $params['_adapter'] = $adapter;
        return (new $classname($params));
    }

    /**
     * �������� ������ ��������� ���������
     *
     * @return array
     */
    final public static function getAvailableAdapters() {
        if (!self::$availableAdapters) {
            $A = array();
            foreach (\glob(__DIR__.'/Adapters/*.php') as $filename) {
                if (\preg_match('~([a-z0-9]*)\.php$~s', $filename, $matches)) {
                    $A[] = $matches[1];
                }
            }
            self::$availableAdapters = $A;
        }
        return self::$availableAdapters;
    }

/*** PUBLIC: ***/

    /**
     * ��������� ������ � ���� ������
     *
     * @throws \go\DB\Exceptions\Connect
     *         ������ ��� ���������� �����������
     * @throws \go\DB\Exceptions\Closed
     *         ����������� �������
     * @throws \go\DB\Exceptions\Templater
     *         ������ ������������� �������
     * @throws \go\DB\Exceptions\Query
     *         ������ � �������
     * @throws \go\DB\Exceptions\Fetch
     *         ������ ��� ������� ����������
     *
     * @param string $pattern
     *        ������ �������
     * @param array $data [optional]
     *        �������� ������ ��� �������
     * @param string $fetch [optional]
     *        ������ ������������� ����������
     * @param string $prefix [optional]
     *        ������� ������ ��� ������� ����������� �������
     * @return \go\DB\Result
     *         ��������� � �������� �������
     */
    final public function query($pattern, $data = NULL, $fetch = NULL, $prefix = NULL) {
        $query = $this->makeQuery($pattern, $data, $prefix);
        return $this->plainQuery($query, $fetch);
    }

    /**
     * ���������� "�������" �������
     *
     * @throws \go\DB\Exceptions\Connect
     * @throws \go\DB\Exceptions\Closed
     * @throws \go\DB\Exceptions\Query
     * @throws \go\DB\Exceptions\Fetch
     *
     * @param string $query
     *        SQL-������
     * @param string $fetch [optional]
     *        ������ ������������� ����������
     * @return \go\DB\Result
     *         ��������� � �������� �������
     */
    final public function plainQuery($query, $fetch = NULL) {
        $this->forcedConnect();
        $implementation = $this->connector->getImplementation();
        $connection     = $this->connector->getConnection();
        $duration       = \microtime(true);
        $cursor         = $implementation->query($connection, $query);
        $duration       = \microtime(true) - $duration;
        if (!$cursor) {
            $errorInfo  = $implementation->getErrorInfo($connection);
            $errorCode  = $implementation->getErrorCode($connection);
            throw new Exceptions\Query($query, $errorInfo, $errorCode);
        }
        $this->debugLog($query, $duration, NULL);
        $fetcher = $this->createFetcher($cursor);
        if (is_null($fetch)) {
            return $fetcher;
        }
        return $fetcher->fetch($fetch);
    }

    /**
     * ����� �������, ��� ������� - ������������� �� query()
     *
     * ��������� ��� ������� ���������:
     * @example $db->query('SELECT * FROM `table`');
     * @example $db('SELECT * FROM `table`');
     *
     * @throws \go\DB\Exceptions\Connect
     * @throws \go\DB\Exceptions\Closed
     * @throws \go\DB\Exceptions\Templater
     * @throws \go\DB\Exceptions\Query
     * @throws \go\DB\Exceptions\Fetch
     *
     * @param string $pattern
     * @param array $data [optional]
     * @param string $fetch [optional]
     * @param string $prefix [optional]
     * @return \go\DB\Result
     */
    final public function __invoke($pattern, $data = NULL, $fetch = NULL, $prefix = NULL) {
        return $this->query($pattern, $data, $fetch, $prefix);
    }

    /**
     * ����������� �� ���������� ����������
     *
     * @return bool
     */
    final public function isConnected() {
        if ($this->hardClosed) {
            return false;
        }
        return $this->connector->isConnected();
    }

    /**
     * ������� �� ����������
     *
     * @return bool
     */
    final public function isClosed() {
        return $this->hardClosed;
    }


    /**
     * ������������� ���������� ����������, ���� ��� ��� �� �����������
     *
     * @throws \go\DB\Exceptions\Connect
     *         ������ �����������
     * @throws \go\DB\Exceptions\Closed
     *         ����������� ������� "�������" �������
     */
    final public function forcedConnect() {
        if ($this->hardClosed) {
            throw new Exceptions\Closed();
        }
        if ($this->connected) {
            return false;
        }
        $res = $this->connector->connect();
        $this->connected = true;
        return $res;
    }

    /**
     * ������� ����������
     *
     * @param bool $soft [optional]
     *        "������" ��������: � ������������ ��������������
	  *
	  * @return bool
	  */
  final public function close($soft = false) { // @todo close
        if ($this->hardClosed) {
            return false;
        }
        $result = false;
        if ($this->connected) {
            $result = $this->connector->close();
            $this->connected = false;
        }
        $this->hardClosed = !$soft;
        return $result;
    }

    /**
     * ���������� ������� ������
     *
     * @param string $prefix
	  * @return bool
	  */
  final public function setPrefix($prefix) {
        $this->prefix = $prefix;
        return true;
    }

    /**
     * �������� ������� ������
     *
     * @return string
     */
    final public function getPrefix() {
        return $this->prefix;
    }

    /**
     * ���������� ���������� ���������� ����������
     *
     * @param bool $callback
     *        ���������� (true - �����������)
	  * @return bool
	  */
  final public function setDebug($callback = true) { // @todo cli
        if ($callback === true) {
            if (php_sapi_name() == 'cli') {
                $callback = new Helpers\Debuggers\OutConsole();
            } else {
                $callback = new Helpers\Debuggers\OutHtml();
            }
        }
        $this->debugCallback = $callback;
        return true;
    }

    /**
     * �������� ���������� ���������� ����������
     *
     * @return callback
     */
    final public function getDebug() {
        return $this->debugCallback;
    }

    /**
     * ��������� �������� ���������� ����������
     */
    final public function disableDebug() {
        $this->debugCallback = NULL;
        return true;
    }

    /**
     * �������� ���������� ���������� ����������� � ����
     *
     * @throws \go\DB\Exceptions\Connect
     * @throws \go\DB\Exceptions\Closed
     *
     * @param bool $connect
     *        ������������, ���� �� ����������
     * @return mixed
     *         �������������� ���������� ��� FALSE ���� ��� �� �������
     */
    final public function getImplementationConnection($connect = true) {
        if ($connect && (!$this->connector->isConnected())) {
            $this->forcedConnect();
        }
        return $this->connector->getConnection();
    }

    /**
     * ������������ ������ �� ��������� ������� � ������
     *
     * @throws \go\DB\Exceptions\Templater
     *
     * @param string $pattern
     * @param array $data
     * @param string $prefix
     * @return string
     */
    public function makeQuery($pattern, $data, $prefix = NULL) {
        $this->forcedConnect();
        if (is_null($prefix)) {
            $prefix = $this->prefix;
        }
        $templater = $this->createTemplater($pattern, $data, $prefix);
        $templater->parse();
        return $templater->getQuery();
    }

/*** PROTECTED: ***/

    /**
     * ������� ����������� - ����� �� �������
     *
     * @param array $params
     *        ���������������� ��������� ����
     */
    protected function __construct($params) {
        $this->separateParams($params);
        $this->connector = $this->createConnector();
        if (!$this->paramsSys['lazy']) {
            $this->connector->connect();
            $this->connected = true;
        }
        $this->setPrefix($this->paramsSys['prefix']);
        $this->setDebug($this->paramsSys['debug']);
    }

    /**
     * ����������
     */
    public final function __destruct() {
        $this->connector->close();
        $this->connector->removeLink();
        $this->connector = NULL;
    }

    /**
     * ���������� ������������ �������
     */
    public function __clone() {
        $this->connector->addLink($this->connected);
    }

    /**
     * ������� ������ ����������� � ����
     *
     * @return \go\DB\Helpers\Connector
     */
    protected function createConnector() {
        return (new Helpers\Connector($this->paramsSys['adapter'], $this->paramsDB));
    }

    /**
     * ������� ������������ �������
     *
     * @param string $pattern
     * @param array $data
     * @param string $prefix
     * @return \go\DB\Helpers\Templater
     */
    protected function createTemplater($pattern, $data, $prefix) {
        return (new Helpers\Templater($this->connector, $pattern, $data, $prefix));
    }

    /**
     * ������� ������ ������������� ����������
     *
     * @param mixed $cursor
     * @return \go\DB\Result
     */
    protected function createFetcher($cursor) {
        return (new Helpers\Fetcher($this->connector, $cursor));
    }

    /**
     * ������ � ���������� ���������� �� ��������� � �����������
     *
     * @throws \go\DB\Exceptions\ConfigSys
     *
     * @param array $params
     */
    protected function separateParams($params) {
        $this->paramsDB  = array();
        $this->paramsSys = \go\DB\Helpers\Config::get('configsys');
        foreach ($params as $name => $value) {
            if ((!empty($name)) && ($name[0] == '_')) {
                $name = substr($name, 1);
                if (!\array_key_exists($name, $this->paramsSys)) {
                    throw new Exceptions\ConfigSys('Unknown system param "'.$name.'"');
                }
                $this->paramsSys[$name] = $value;
            } else {
                $this->paramsDB[$name] = $value;
            }
        }
        return true;
    }

    /**
     * �������� ������� � ��������
     *
     * @param string $query
     * @param float $duration
     * @param mixed $info
     */
    protected function debugLog($query, $duration, $info) {
        if ($this->debugCallback) {
            \call_user_func($this->debugCallback, $query, $duration, $info);
        }
        return true;
    }

/*** VARS: ***/

    /**
     * ��� ������ ��������� ���������
     *
     * @var array
     */
    private static $availableAdapters;

    /**
     * ������-�����������
     *
     * @var \go\DB\Helpers\Connector
     */
    protected $connector;

    /**
     * ��������� ���������
     *
     * @var array
     */
    protected $paramsSys;

    /**
     * ��������� ����������� � ����
     *
     * @var array
     */
    protected $paramsDB;

    /**
     * ������� ������� ��� ������
     *
     * @var string
     */
    protected $prefix;

    /**
     * �������� ��������
     *
     * @var callback
     */
    protected $debugCallback;

    /**
     * ����������� �� ����������� ��� ������� ������� ����
     *
     * @var bool
     */
    protected $connected = false;

    /**
     * ������� �� ����������� ������ �������
     *
     * @var bool
     */
    protected $hardClosed = false;
}

/**
 * ������� ������ ��� ������� � ����
 * (����� DB::create)
 *
 * @throws \go\DB\Exceptions\Config
 * @throws \go\DB\Exceptions\Connect
 *
 * @param array $params
 *        ��������� ����������� � ����
 * @param string $adapter [optional]
 *        ������� ���� (���� �� ������ � $params)
 * @return \go\DB\DB
 *         ������ ��� ������� � ����
 */
function create(array $params, $adapter = NULL) {
    return DB::create($params, $adapter);
}

/**
 * ������ � ����������� ���� ������������ ���������
 * (����� Storage::query)
 *
 * @throws \go\DB\Exceptions\StorageDBCentral
 *         ��� ����������� ����
 * @throws \go\DB\Exceptions\Connect
 * @throws \go\DB\Exceptions\Closed
 * @throws \go\DB\Exceptions\Templater
 * @throws \go\DB\Exceptions\Query
 * @throws \go\DB\Exceptions\Fetch
 *
 * @param string $pattern
 * @param array $data [optional]
 * @param string $fetch [optional]
 * @param string $prefix [optional]
 */
function query($pattern, $data = NULL, $fetch = NULL, $prefix = NULL) {
    return Storage::getInstance()->query($pattern, $data, $fetch, $prefix);
}