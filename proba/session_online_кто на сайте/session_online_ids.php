<?php
/**
 * ������������ ���-�� �����������, �������������� ������ �� �����,
 * �.�. ���������� �������� ���-����� �� ��������� ��������� �����,
 * � ��� �� ����������� ��������������� ���-�� ����������� �� ����� ������������.
 * ����� ������� �� �������.
 * ��������! ������� session_start() ��� �.�. �������!
 *
 * @param   int                 $idle_ttl   ����� �������� � ��������, � ������� �������� ������������,
 *                                          ���������� ����� �������� �����, ������������ �� ����� (� ��-�����)
 * @return  mixed(array/false)  FALSE � ������ ������ ��� ������ ���������� ����:
 *                              array(
 *                                  #������� �������� session_id, ���������� ����� ���������� ��������� � unixtime:
 *                                  'session_ids' => array(<session_id> => <unixtime>, ...)
 *                                  #����������� ��������������� ���-�� ����������� �� ����� ������������:
 *                                  'online_max' => array('count' => <count>, 'utime' => <unixtime>)
 *                              )
 *
 * @license  http://creativecommons.org/licenses/by-nc-sa/3.0/
 * @author   Nasibullin Rinat <n a s i b u l l i n  at starlink ru>
 * @charset  ANSI
 * @version  2.2.0
 */
function session_online_ids($idle_ttl = 300)
{
    $sid = session_id();
    if ($sid == '')
    {
        trigger_error('Result of session_id() is empty!', E_USER_WARNING);
        return false;
    }

    $filename = 'log/sessionUser';

    #������� ������� ������ ����, ���� ��� ��� ���; ���� �� ���� ����������, ��� ��� �� ��������
    fclose(fopen($filename, 'a+b'));
    #��������� � ��������� ����
    $fp = fopen($filename, 'r+b');
    if (! $fp) return false;
    if (! flock($fp, LOCK_EX)) #����, ���� �� �� ������ �������������
    {
        fclose($fp);
        return false;
    }
    #� ���� ����� �� ����� ���� �������, ��� ������ ��� ��������� �������� � ������
    #������ ���� �������, ��� ���� ��������� ����� ��������� � �����
    $data = @fread($fp, filesize($filename));

    if (! is_array($a = @unserialize($data))) #�������� ������?
    {
        $a = array(
            'session_ids' => array(),  #���������� �� ����� ������
            #����������� ��������������� ���-�� ����������� �� ����� ������������:
            'online_max' => array('count' => 0, 'utime' => null),
        );
    }

    /*
    ������� ������ ��� ��������, ������� �������� ������� ������������� ������.
    ��� ��������� ��������� "��������" �������� �� ���� ��������� � �������
    � ����� ����� ������������ ���������� "��������" ��������.
    */
    if (! array_key_exists(session_name(), $_REQUEST) || $sid !== $_REQUEST[session_name()])
    {
        fclose($fp);
        return $a;
    }

    /*
    ��������� ������� ������ ����������, ������� ������ �������� ��������, �.�. "�����" �����������.
    */
    if (! function_exists('is_browser')) require_once 'is_browser.php';
    if (! is_browser())
    {
        fclose($fp);
        return $a;
    }

    $time = time();
    #������� ������� �� �������� ������ � ��������� � �����
    if (array_key_exists($sid, $a['session_ids'])) unset($a['session_ids'][$sid]);
    $a['session_ids'][$sid] = $time;
    #������� ������������ ��������
    foreach ($a['session_ids'] as $sid => &$t)
    {
        if ($t + $idle_ttl > $time) break;
        unset($a['session_ids'][$sid]);
    }

    #��������� ������������ ���-�� ����������� �� ����� ������������
    if (count($a['session_ids']) > $a['online_max']['count'])
    {
        $a['online_max'] = array(
            'count' => count($a['session_ids']),
            'utime' => $time,
        );
    }

    $data = serialize($a);
    fseek($fp, 0);                  #������ ��������� �� ������ �����
    ftruncate($fp, strlen($data));  #�������� ���� �� �������� ����� (����������� ������)
    fwrite($fp, $data);             #��������� ������ � ����
    #c������ ����������
    #flock($fp, LOCK_UN);  #��� �������������, �.�. ��� �������� ������������� ��� �������� �����
    fclose($fp);
    return $a;
}
?>