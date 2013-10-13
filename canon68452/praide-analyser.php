<?php 
/**
 * Скрипт проверки уникальности.
 */


$post_data = array(
       'key' => 'V4GMEyBlzzg5fI8', // ваш ключ доступа (параметр key) со страницы http://www.content-watch.ru/api/request/
       'text' => iconv( "windows-1251", "UTF-8", $text),
       'test' => 0 // при значении 1 вы получите валидный фиктивный ответ (проверки не будет, деньги не будут списаны)
);

$curl = curl_init();
curl_setopt($curl, CURLOPT_RETURNTRANSFER, TRUE);
curl_setopt($curl, CURLOPT_POST, TRUE);
curl_setopt($curl, CURLOPT_POSTFIELDS, $post_data);
curl_setopt($curl, CURLOPT_URL, 'http://www.content-watch.ru/public/api/');
$return = json_decode(trim(curl_exec($curl)), TRUE);
curl_close($curl);

// если в ответе нет переменной error, значит запрос не удался
if (!isset($return['error'])) {
       echo 'Ошибка запроса';

       // если переменная error не пустая, значит при проверке возникла ошибка
} else if (!empty($return['error'])) {
       echo 'Возникла ошибка: ' . iconv("UTF-8", "windows-1251", $return['error']);

       // парсим ответ
} else {
       // инициализируем дефолтные значения
       $defaults = array(
              'text' => '',
              'percent' => '100.0',
              'highlight' => array(),
              'matches' => array()
       );
       $return = array_merge($defaults, $return);

       // выводим результат проверки
       echo '
        <h2>Уникальность текста: ' . $return['percent'] . '</h2>';

       // выводим в невидимое поле чистый текст, который будем использовать как основу для подсветки совпадений
       echo '
        <div id="clean_text" style="display: none;">' . iconv( "UTF-8", "windows-1251", $return['text']) . '</div>';

       // выводим поле для текста с подсветкой совпадений
       echo '
        <div id="hl_text"></div>
        <script type="text/javascript">
        function highlight_words(hl_array)
        {
            var t_hl = $("#clean_text").text().split(" ");
            for (i = 0; i < hl_array.length; i++)
            {
                if (hl_array[i] instanceof Array) {
                    t_hl[ hl_array[i][0] ] = "<b>" + (t_hl[ hl_array[i][0] ] === undefined ? "" : t_hl[ hl_array[i][0] ]);
                    t_hl[ hl_array[i][1] ] = (t_hl[ hl_array[i][1] ] === undefined ? "" : t_hl[ hl_array[i][1] ]) + "</b>";
                } else {
                    t_hl[ hl_array[i] ] = "<b>" + t_hl[ hl_array[i] ] + "</b>";
                }
            }
            $("#hl_text").html(t_hl.join(" "));
            return false;
        }
        </script>';

       // при загрузке страницы подсвечиваем общие совпадения
       echo '
        <script type="text/javascript">
        $(document).ready(function()
        {
            highlight_words(' . json_encode($return['highlight']) . ');
        });
        </script>';

       // выводим совпадения
       echo '
        <table border="0" cellpadding="5" cellspacing="0">';

       foreach ($return['matches'] as $match)
       {
              echo '
            <tr>
                <td><a href="'.$match['url'].'" target="_blank">'.$match['url'].'</a></td>
                <td><strong>&nbsp;&nbsp;'.$match['percent'].'%&nbsp;&nbsp;</strong></td>
                <td><a href="#" onclick=\'return highlight_words('.json_encode($match['highlight']).');\'>подсветить совпадения</a></td>
            </tr>';
       }
       echo '
        </table>
        <p><a href="#" onclick=\'return highlight_words(' . json_encode($return['highlight']) . ');\'>Подсветить все совпадения</a></p>';
}