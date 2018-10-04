<?
/**
 * ���������� TRUE, ���� ������ �������� ��������� � FALSE � ��������� ������ (������ ���. �������).
 * ����������� �������� ���������� �� ��������� ������� HTTP_USER_AGENT �������� ������������.
 *
 * @return  bool
 *
 * @license  http://creativecommons.org/licenses/by-nc-sa/3.0/
 * @author   Nasibullin Rinat <n a s i b u l l i n  at starlink ru>
 * @charset  ANSI
 * @version  1.1.2
 */
function is_browser()
{
    #����������� ��� ��������� �������
    static $is_browser = null;
    if ($is_browser !== null) return $is_browser;

    /*
    ������:
      ����������� ������: ��������� ������, �������, ��������� ������ �����������
      ������� ��������� HTTP_USER_AGENT:
      http://yandex.ru/     http://webmaster.yandex.ru/faq.xml?id=502499#user-agent
                            � ������� ���� ��������� �������, ������� �������������� ��-�������.
                              "Yandex/1.01.001 (compatible; Win16; I)" � �������� ������������� �����
                              "Yandex/1.01.001 (compatible; Win16; P)" � ���������� ��������
                              "Yandex/1.01.001 (compatible; Win16; H)" � �����, ������������ ������� ������
                              "Yandex/1.02.000 (compatible; Win16; F)" � �����, ������������� ����������� ������ (favicons)
                              "Yandex/1.03.003 (compatible; Win16; D)" � �����, ������������ � �������� ��� ���������� �� ����� ����� ��������� URL�
                              "Yandex/1.03.000 (compatible; Win16; M)" � �����, ������������ ��� �������� �������� �� ������ ���������� �����
                              "YaDirectBot/1.0 (compatible; Win16; I)" � �����, ������������� �������� ������, ����������� � ��������� ���� �������
                            ����� ������� � ������� ���� ��������� �������-��������������, ������� ����������, �������� �� � ������ ������ ���� ��� ��������, �� ������� ����� ������ � ��������������� �������.
                              "Yandex/2.01.000 (compatible; Win16; Dyatel; C)" � �������������� ������.��������. ���� ���� ���������� � ������� ���������� ����, �� ��������� � ����������. ��� ������ ���� �������� ��������, �� ������������� ���������� � ��������.
                              "Yandex/2.01.000 (compatible; Win16; Dyatel; Z)" � �������������� ������.��������. ������ �� ����������� ����� ���������� ����� ������.
                              "Yandex/2.01.000 (compatible; Win16; Dyatel; D)" � �������������� ������.�������. ��� ��������� ������������ ������ �� ���������� ����� ����������. ������� �������������� �������� �� ���������������.
                              "Yandex/2.01.000 (compatible; Win16; Dyatel; N)" � �������������� ������.��������. ��� ��������� ����� ��� �������-���������, ������� ��������� ������� ������� �, ��� �������������, ����������� � ���������.
      http://rambler.ru/      "StackRambler/2.0 (MSIE incompatible)"
      http://google.com/      "Mozilla/5.0 (compatible; Googlebot/2.1; +http://www.google.com/bot.html)"
      http://yahoo.com/       "Mozilla/5.0 (compatible; Yahoo! Slurp; http://help.yahoo.com/help/us/ysearch/slurp)"
      http://search.msn.com/  "msnbot/1.0 (+http://search.msn.com/msnbot.htm)"
      XSpider 7.5             "Mozilla/4.0 (compatible; MSIE 6.0; Windows NT 7.0) PTX"

    ��������:
      Internet Explorer       Mozilla/4.0 (compatible; MSIE 6.0; Windows NT 5.1; SV1; .NET CLR 2.0.50727)
                              Mozilla/4.0 (compatible; MSIE 6.0; Windows NT 5.1; SV1; Mozilla/4.0 (compatible; MSIE 6.0; Windows NT 5.1; SV1) ;  Embedded Web Browser from: http://bsalsa.com/)
                              Mozilla/4.0 (compatible; MSIE 7.0; Windows NT 5.1; <a href='http://radioclicker.com'>radio</a>; RadioClicker Lite; .NET CLR 2.0.50727)
      FireFox                 Mozilla/5.0 (Windows; U; Windows NT 5.1; ru; rv:1.8.1) Gecko/20061010 Firefox/2.0
      Opera                   Opera/9.23 (Windows NT 5.1; U; ru)
    */
    $is_robot = empty($_SERVER['HTTP_USER_AGENT']) #~ ���������/����������� ������
                #Browsers: IE, Opera, Firefox, Safari, Konqueror
                || ! preg_match('/^(?:Mozilla|Opera)\/\d+(?>\.\d+)+\x20/s', $_SERVER['HTTP_USER_AGENT'])
                #�������������� ������ (� ����������� ������� ��������� ������ 2 ��������):
                || preg_match('/(?<![a-z])  #���������� ������ �� �����
                                (?: #��������� ��������� �������:
                                    yandex|googlebot|stackrambler|aport|mail\.ru|yahoo|goku|msnbot|cazoodlebot|irlbot|gigabot|altavista|findlinks #|ptx
                                    
                                    #������������ ��������� �������� ��������� �������:
                                    | spider|crawler|search|robot
                                    
                                    #DEPRECATED, �.�. ������� � ���������� � �������� ���������� URL ������
                                    #��������� ������ ��������� ������:
                                    #| http:\/\/[a-z\d]+
                                )
                                (?![a-z])   #��������� ������ �� �����
                               /six', $_SERVER['HTTP_USER_AGENT']);
    return $is_browser = ! $is_robot;
}
?>