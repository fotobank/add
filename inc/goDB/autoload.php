<?php
/**
 * ������������ ������� � goDB
 *
 * @example
 * <code>
 * require_once('/path/to/goDB/autoload.php');
 * spl_autoload_register('\go\DB\autoload');
 * </code>
 *
 * @package go\DB
 * @author  ��������� ���� aka vasa_c (http://blgo.ru/)
 */

namespace go\DB;

/**
 * ��������� ����� �� �����
 * 
 * @param string $classname
 *        ��� ���������� ������
 * @return bool
 *         ��� �� �������� ����� (FALSE - ����� �� ������ ��� �� ��������� � go\DB)
 */
function autoload($classname) {
    if (\strpos($classname, __NAMESPACE__) !== 0) {
        return false;
    }
    $localname = \substr($classname, \strlen(__NAMESPACE__));
    $filename  = __DIR__.\str_replace('\\', '/', $localname.'.php');
    if (!\file_exists($filename)) {
        return false;
    }
    require_once($filename);
    return \class_exists($classname, false);
}

/**
 * ���������������� ������������� ��� goDB
 */
function autoloadRegister() {
    \spl_autoload_register('\go\DB\autoload');
}