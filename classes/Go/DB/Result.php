<?php
/**
 * ��������� ��������, ������������ � ���� ���������� �������
 *
 * @example $result = $db->query($pattern, $data);
 * ������ $result ������������� � ���� ���������� ���������� �������.
 * ��������, ��� mysql-�������� ��� ����� ���� mysqli_result-������.
 *
 * @package go\DB
 * @author  ��������� ���� aka vasa_c
 */

namespace go\DB;

interface Result extends \IteratorAggregate
{
    /**
     * ��������� ��������� � ������������ � ��������
     *
     * @throws \go\DB\Exceptions\Fetch
     *         ������ ��� �������
     *
     * @param string $fetch
     *        ������ �������
     * @return mixed
     *         ��������� � �������� �������
     */
    public function fetch($fetch);

    /**
     * �������� ���������
     */
    public function free();

    /**
     * ������ ������������� ��������
     *
     * @throws \go\DB\Exceptions\UnexpectedFetch
     *
     * @param string $param [optional]
     *        ����, ������������ � �������� �������
     *        �� ������� - ���������� ������
     * @return array
     */
    public function assoc($param = null);

    /**
     * ������ ���������� ��������
     *
     * @throws \go\DB\Exceptions\UnexpectedFetch
     *
     * @param int $param [optional]
     *        ����� ����, ������������� � �������� �������
     *        �� ������� - ���������� ������
     * @return array
     */
    public function numerics($param = null);

    /**
     * ������ ��������
     *
     * @throws \go\DB\Exceptions\UnexpectedFetch
     *
     * @param string $param [optional]
     *        ����, ������������ � �������� �������
     *        �� ������� - ���������� ������
     * @return array
     */
    public function objects($param = null);

    /**
     * ������ ��������
     *
     * @throws \go\DB\Exceptions\UnexpectedFetch
     *
     * @return array
     */
    public function col($param = null);

    /**
     * ������ ���������� (������ ���� - ��� ���������, ������ - ��������)
     *
     * @throws \go\DB\Exceptions\UnexpectedFetch
     *
     * @return array
     */
    public function vars($param = null);

    /**
     * �������� �� assoc
     *
     * @throws \go\DB\Exceptions\UnexpectedFetch
     *
     * @param string $param [optional]
     * @return Iterator
     */
    public function iassoc($param = null);

    /**
     * �������� �� numerics
     *
     * @throws \go\DB\Exceptions\UnexpectedFetch
     *
     * @param int $param [optional]
     * @return Iterator
     */
    public function inumerics($param = null);

    /**
     * �������� �� objects
     *
     * @throws \go\DB\Exceptions\UnexpectedFetch
     *
     * @param string $param [optional]
     * @return Iterator
     */
    public function iobjects($param = null);

    /**
     * �������� �� vars
     *
     * @throws \go\DB\Exceptions\UnexpectedFetch
     *
     * @return Iterator
     */
    public function ivars($param = null);

    /**
     * �������� �� col
     *
     * @throws \go\DB\Exceptions\UnexpectedFetch
     *
     * @return Iterator
     */
    public function icol($param = null);

    /**
     * ������������� ������ �� ����� ������ (��� ������ - NULL)
     *
     * @throws \go\DB\Exceptions\UnexpectedFetch
     *
     * @return array
     */
    public function row($param = null);

    /**
     * ���������� ������ �� ����� ������ (��� ������ - NULL)
     *
     * @throws \go\DB\Exceptions\UnexpectedFetch
     *
     * @return array
     */
    public function numeric($param = null);

    /**
     * ���� ������ � ���� ������� (��� ������ - NULL)
     *
     * @throws \go\DB\Exceptions\UnexpectedFetch
     *
     * @return object
     */
    public function object($param = null);

    /**
     * ���� �������� �� ������ (��� ������ - NULL)
     *
     * @throws \go\DB\Exceptions\UnexpectedFetch
     *
     * @return string
     */
    public function el($param = null);

    /**
     * ���� �������� �� ������ � ���� bool (��� ������ - NULL)
     *
     * @throws \go\DB\Exceptions\UnexpectedFetch
     *
     * @return bool
     */
    public function bool($param = null);

    /**
     * ���������� ����� � ����������
     *
     * @throws \go\DB\Exceptions\UnexpectedFetch
     *
     * @return int
     */
    public function num($param = null);

    /**
     * ��������� AUTO_INCREMENT
     *
     * @return int
     */
    public function id($param = null);

    /**
     * ���������� ���������� �������� �����
     * 
     * @return int
     */
    public function ar($param = null);

    /**
     * ���������� ���������� ����������
     *
     * @return mixed
     */
    public function cursor($param = null);
}