<?
/**
 * Возвращает TRUE, если клиент является браузером и FALSE в противном случае (клиент явл. роботом).
 * Определение браузера происходит по заголовку запроса HTTP_USER_AGENT согласно спецификации.
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
    #кэширование при повторных вызовах
    static $is_browser = null;
    if ($is_browser !== null) return $is_browser;

    /*
    РОБОТЫ:
      Детектируем роботы: поисковые машины, скрипты, программы поиска уязвимостей
      Примеры некоторых HTTP_USER_AGENT:
      http://yandex.ru/     http://webmaster.yandex.ru/faq.xml?id=502499#user-agent
                            У Яндекса есть несколько роботов, которые представляются по-разному.
                              "Yandex/1.01.001 (compatible; Win16; I)" — основной индексирующий робот
                              "Yandex/1.01.001 (compatible; Win16; P)" — индексатор картинок
                              "Yandex/1.01.001 (compatible; Win16; H)" — робот, определяющий зеркала сайтов
                              "Yandex/1.02.000 (compatible; Win16; F)" — робот, индексирующий пиктограммы сайтов (favicons)
                              "Yandex/1.03.003 (compatible; Win16; D)" — робот, обращающийся к странице при добавлении ее через форму «Добавить URL»
                              "Yandex/1.03.000 (compatible; Win16; M)" — робот, обращающийся при открытии страницы по ссылке «Найденные слова»
                              "YaDirectBot/1.0 (compatible; Win16; I)" — робот, индексирующий страницы сайтов, участвующих в Рекламной сети Яндекса
                            Кроме роботов у Яндекса есть несколько агентов-«простукивалок», которые определяют, доступен ли в данный момент сайт или документ, на который стоит ссылка в соответствующем сервисе.
                              "Yandex/2.01.000 (compatible; Win16; Dyatel; C)" — «простукивалка» Яндекс.Каталога. Если сайт недоступен в течение нескольких дней, он снимается с публикации. Как только сайт начинает отвечать, он автоматически появляется в Каталоге.
                              "Yandex/2.01.000 (compatible; Win16; Dyatel; Z)" — «простукивалка» Яндекс.Закладок. Ссылки на недоступные сайты помечаются серым цветом.
                              "Yandex/2.01.000 (compatible; Win16; Dyatel; D)" — «простукивалка» Яндекс.Директа. Она проверяет корректность ссылок из объявлений перед модерацией. Никаких автоматических действий не предпринимается.
                              "Yandex/2.01.000 (compatible; Win16; Dyatel; N)" — «простукивалка» Яндекс.Новостей. Она формирует отчет для контент-менеджера, который оценивает масштаб проблем и, при необходимости, связывается с партнером.
      http://rambler.ru/      "StackRambler/2.0 (MSIE incompatible)"
      http://google.com/      "Mozilla/5.0 (compatible; Googlebot/2.1; +http://www.google.com/bot.html)"
      http://yahoo.com/       "Mozilla/5.0 (compatible; Yahoo! Slurp; http://help.yahoo.com/help/us/ysearch/slurp)"
      http://search.msn.com/  "msnbot/1.0 (+http://search.msn.com/msnbot.htm)"
      XSpider 7.5             "Mozilla/4.0 (compatible; MSIE 6.0; Windows NT 7.0) PTX"

    БРАУЗЕРЫ:
      Internet Explorer       Mozilla/4.0 (compatible; MSIE 6.0; Windows NT 5.1; SV1; .NET CLR 2.0.50727)
                              Mozilla/4.0 (compatible; MSIE 6.0; Windows NT 5.1; SV1; Mozilla/4.0 (compatible; MSIE 6.0; Windows NT 5.1; SV1) ;  Embedded Web Browser from: http://bsalsa.com/)
                              Mozilla/4.0 (compatible; MSIE 7.0; Windows NT 5.1; <a href='http://radioclicker.com'>radio</a>; RadioClicker Lite; .NET CLR 2.0.50727)
      FireFox                 Mozilla/5.0 (Windows; U; Windows NT 5.1; ru; rv:1.8.1) Gecko/20061010 Firefox/2.0
      Opera                   Opera/9.23 (Windows NT 5.1; U; ru)
    */
    $is_robot = empty($_SERVER['HTTP_USER_AGENT']) #~ анонимные/неграмотные роботы
                #Browsers: IE, Opera, Firefox, Safari, Konqueror
                || ! preg_match('/^(?:Mozilla|Opera)\/\d+(?>\.\d+)+\x20/s', $_SERVER['HTTP_USER_AGENT'])
                #параноидальный способ (в большинстве случаев сработают первые 2 проверки):
                || preg_match('/(?<![a-z])  #предыдущий символ не буква
                                (?: #сигнатуры известных роботов:
                                    yandex|googlebot|stackrambler|aport|mail\.ru|yahoo|goku|msnbot|cazoodlebot|irlbot|gigabot|altavista|findlinks #|ptx
                                    
                                    #теоретически возможные названия остальных роботов:
                                    | spider|crawler|search|robot
                                    
                                    #DEPRECATED, т.к. плагины и надстройки к браузеру дописывают URL адреса
                                    #некоторые роботы вставляют ссылки:
                                    #| http:\/\/[a-z\d]+
                                )
                                (?![a-z])   #следующий символ не буква
                               /six', $_SERVER['HTTP_USER_AGENT']);
    return $is_browser = ! $is_robot;
}
?>