<?php
/**
 * ��������� �������� ��� ������
 *
 * @package    go\DB
 * @subpackage Storage
 * @author     ��������� ���� aka vasa_c
 */

namespace go\DB;

final class Storage
{

/*** STATIC: ***/

    /**
     * �������� ����������� ������ ���������
     *
     * @return \go\DB\Storage
     */
    public static function getInstance() {
        if (!self::$instance) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    /**
     * ���������� ����������� ������ ���������
     * 
     * @param mixed $instance
     *        ��������� ��������� ��� ��������� ��� ��� ����������
     * @return \go\DB\Storage
     */
    public static function setInstance($instance) {
        if ($instance instanceof self) {
            self::$instance = $instance;
        } elseif (is_array($instance)) {
            self::$instance = new self($instance);
        } else {
            $message = 'Argument 1 passed to Storage::setInstance must be '.
                'an instance of go\DB\DB or array, '.gettype($instance).' given';
            trigger_error($message, \E_USER_ERROR);
        }
        return self::$instance;
    }

    /**
     * ������ � ����������� ���� ������������ ���������
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
    public static function query($pattern, $data = null, $fetch = null, $prefix = null) {
        return self::getInstance()->__invoke($pattern, $data, $fetch, $prefix);
    }
    
/*** PUBLIC: ***/

    /**
     * ����������� ���������
     *
     * @throws \go\DB\Exceptions\StorageAssoc
     *         ������ ���������� ��� ����������
     * 
     * @param array $mparams [optional]
     *        ��������� ��� ���������� (�� ������� - ������ ���������)
     */
    public function __construct($mparams = null) {
        if ($mparams) {
            $this->fill($mparams);
        }
        return true;
    }

    /**
     * �������� ������ ���� �� �����
     *
     * @throws \go\DB\Exceptions\StorageNotFound
     *         ��� ����� ����
     *
     * @param string $name [optional]
     * @return \go\DB\DB
     */
    public function get($name = '') {
        if (!isset($this->dbs[$name])) {
            throw new Exceptions\StorageNotFound($name);
        }
        return $this->dbs[$name];
    }

    /**
     * ������� ������ ���� � ��������� � ���������
     *
     * @throws \go\DB\Exceptions\StorageEngaged
     *         ������ ��� ��� ������
     * @throws \go\DB\Exceptions\Config
     * @throws \go\DB\Exceptions\Connect
     *
     * @param array $params
     *        ��������� �����������
     * @param string $name [optional]
     *        ��� � ���������
     * @return \go\DB\DB
     *         ������ ��������� ����
     */
    public function create(array $params, $name = '') {
        $db = \go\DB\DB::create($params);
        $this->set($db, $name);
        return $db;
    }

    /**
     * �������� ���� � ���������
     *
     * @throws \go\DB\Exceptions\StorageEngaged
     *         ������ ��� ��� ������
     *
     * @param \go\DB\DB $db
     *        ������ ����
     * @param string $name
     *        ��� � ���������
     */
    public function set(DB $db, $name = '') {
        if (isset($this->dbs[$name])) {
            throw new Exceptions\StorageEngaged($name);
        }
        $this->dbs[$name] = $db;
        return true;
    }

    /**
     * ��������� ��������� ������������ ������
     *
     * @throws \go\DB\Exceptions\StorageAssoc
     *         ������ ���������� ��� ����������
     * @throws \go\DB\Exceptions\StorageEngaged
     *         ���� �� ��� ��� ������
     *
     * @param array $mparams
     *        ��������� ��� ������
     */
    public function fill(array $mparams) {
        $assocs = array();
        foreach ($mparams as $name => $params) {
            if (is_array($params)) {
                $this->create($params, $name);
            } elseif (isset($mparams[$params])) {
                $assocs[$name] = $params;
            } else {
                throw new Exceptions\StorageAssoc($params);
            }
        }
        foreach ($assocs as $name => $assoc) {
            $this->set($this->get($assoc), $name);
        }
        return true;
    }

    /**
     * ���������� �� ��� � ��������� ���� � ��������� ������
     *
     * @param string $name
     * @return bool
     */
    public function exists($name = '') {
        return isset($this->dbs[$name]);
    }

    /**
     * ����� ���������, ��� ������� - ������ � ����������� ���� ���������
     * 
     * @throws \go\DB\Exceptions\StorageDBCentral
     * @throws \go\DB\Exceptions\Connect
     * @throws \go\DB\Exceptions\Closed
     * @throws \go\DB\Exceptions\Templater
     * @throws \go\DB\Exceptions\Query
     * @throws \go\DB\Exceptions\Fetch
     *
     * @param string $pattern [optional]
     * @param array $data [optional]
     * @param string $fetch [optional]
     * @param string $prefix [optional]
     * @return mixed
     */
    public function __invoke($pattern, $data = null, $fetch = null, $prefix = null) {
        if (!isset($this->dbs[''])) {
            throw new Exceptions\StorageDBCentral('');
        }
        return $this->dbs['']->query($pattern, $data, $fetch, $prefix);
    }

    /**
     * @override magic method
     *
     * @example $db = $storage->dbname
     *
     * @throws \go\DB\Exceptions\StorageNotFound
     *
     * @param string $name
     * @return \go\DB\DB
     */
    public function __get($name) {
        return $this->get($name);
    }

    /**
     * @override magic method
     *
     * @example $storage->dbname = $db
     *
     * @throws \go\DB\Exceptions\StorageEngaged
     *
     * @param string $name
     * @param \go\DB\DB $value
     */
    public function __set($name, $value) {
        return $this->set($value, $name);
    }

    /**
     * @override magic method
     *
     * @example isset($storage->dbname)
     *
     * @param string $name
     * @return bool
     */
    public function __isset($name) {
        return $this->exists($name);
    }
    
/*** PRIVATE: ***/
    
/*** VARS: ***/

    /**
     * ����������� ���������
     * 
     * @var \go\DB\Storage
     */
    private static $instance;

    /**
     * �������� ����
     * 
     * @var array
     */
    private $dbs = array();
}