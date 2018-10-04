<?php
/**
 * Подсчитывает кол-во посетителей, присутствующих сейчас на сайте,
 * т.е. посетивших страницы веб-сайта за последние несколько минут,
 * а так же максимально зафиксированное кол-во посетителей на сайте одновременно.
 * Метод основан на сессиях.
 * Внимание! Функция session_start() уже д.б. вызвана!
 *
 * @param   int                 $idle_ttl   время ожидания в секундах, в течение которого пользователи,
 *                                          посетившие любую страницу сайта, присутствуют на сайте (в он-лайне)
 * @return  mixed(array/false)  FALSE в случае ошибки или массив следующего вида:
 *                              array(
 *                                  #ключами являются session_id, значениями время последнего посещения в unixtime:
 *                                  'session_ids' => array(<session_id> => <unixtime>, ...)
 *                                  #максимально зафиксированное кол-во посетителей на сайте одновременно:
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

    #вначале создаем пустой файл, ЕСЛИ ЕГО ЕЩЕ НЕТ; если же файл существует, это его не разрушит
    fclose(fopen($filename, 'a+b'));
    #открываем и блокируем файл
    $fp = fopen($filename, 'r+b');
    if (! $fp) return false;
    if (! flock($fp, LOCK_EX)) #ждем, пока мы не станем единственными
    {
        fclose($fp);
        return false;
    }
    #в этой точке мы можем быть уверены, что только эта программа работает с файлом
    #читаем файл целиком, при этом указатель файла смещается в конец
    $data = @fread($fp, filesize($filename));

    if (! is_array($a = @unserialize($data))) #разбитые данные?
    {
        $a = array(
            'session_ids' => array(),  #посетители на сайте сейчас
            #максимально зафиксированное кол-во посетителей на сайте одновременно:
            'online_max' => array('count' => 0, 'utime' => null),
        );
    }

    /*
    Считаем только тех клиентов, которые прислали обратно идентификатор сессии.
    Это позволяет исключить "случайно" зашедших на сайт браузеров и роботов
    и более точно подсчитывать количество "активных" клиентов.
    */
    if (! array_key_exists(session_name(), $_REQUEST) || $sid !== $_REQUEST[session_name()])
    {
        fclose($fp);
        return $a;
    }

    /*
    Посещения роботов портят статистику, считаем только реальные браузеры, т.е. "живых" посетителей.
    */
    if (! function_exists('is_browser')) require_once 'is_browser.php';
    if (! is_browser())
    {
        fclose($fp);
        return $a;
    }

    $time = time();
    #удаляем элемент из середины списка и добавляем в конец
    if (array_key_exists($sid, $a['session_ids'])) unset($a['session_ids'][$sid]);
    $a['session_ids'][$sid] = $time;
    #удаляем просроченные элементы
    foreach ($a['session_ids'] as $sid => &$t)
    {
        if ($t + $idle_ttl > $time) break;
        unset($a['session_ids'][$sid]);
    }

    #фиксируем максимальное кол-во посетителей на сайте одновременно
    if (count($a['session_ids']) > $a['online_max']['count'])
    {
        $a['online_max'] = array(
            'count' => count($a['session_ids']),
            'utime' => $time,
        );
    }

    $data = serialize($a);
    fseek($fp, 0);                  #ставим указатель на начало файла
    ftruncate($fp, strlen($data));  #обрезаем файл до заданной длины (отбрасываем лишнее)
    fwrite($fp, $data);             #сохраняем данные в файл
    #cнимаем блокировку
    #flock($fp, LOCK_UN);  #нет необходимости, т.к. это делается автоматически при закрытии файла
    fclose($fp);
    return $a;
}
?>