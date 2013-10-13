<?php 
/**
 * ������ �������� ������������.
 */


$post_data = array(
       'key' => 'V4GMEyBlzzg5fI8', // ��� ���� ������� (�������� key) �� �������� http://www.content-watch.ru/api/request/
       'text' => iconv( "windows-1251", "UTF-8", $text),
       'test' => 0 // ��� �������� 1 �� �������� �������� ��������� ����� (�������� �� �����, ������ �� ����� �������)
);

$curl = curl_init();
curl_setopt($curl, CURLOPT_RETURNTRANSFER, TRUE);
curl_setopt($curl, CURLOPT_POST, TRUE);
curl_setopt($curl, CURLOPT_POSTFIELDS, $post_data);
curl_setopt($curl, CURLOPT_URL, 'http://www.content-watch.ru/public/api/');
$return = json_decode(trim(curl_exec($curl)), TRUE);
curl_close($curl);

// ���� � ������ ��� ���������� error, ������ ������ �� ������
if (!isset($return['error'])) {
       echo '������ �������';

       // ���� ���������� error �� ������, ������ ��� �������� �������� ������
} else if (!empty($return['error'])) {
       echo '�������� ������: ' . iconv("UTF-8", "windows-1251", $return['error']);

       // ������ �����
} else {
       // �������������� ��������� ��������
       $defaults = array(
              'text' => '',
              'percent' => '100.0',
              'highlight' => array(),
              'matches' => array()
       );
       $return = array_merge($defaults, $return);

       // ������� ��������� ��������
       echo '
        <h2>������������ ������: ' . $return['percent'] . '</h2>';

       // ������� � ��������� ���� ������ �����, ������� ����� ������������ ��� ������ ��� ��������� ����������
       echo '
        <div id="clean_text" style="display: none;">' . iconv( "UTF-8", "windows-1251", $return['text']) . '</div>';

       // ������� ���� ��� ������ � ���������� ����������
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

       // ��� �������� �������� ������������ ����� ����������
       echo '
        <script type="text/javascript">
        $(document).ready(function()
        {
            highlight_words(' . json_encode($return['highlight']) . ');
        });
        </script>';

       // ������� ����������
       echo '
        <table border="0" cellpadding="5" cellspacing="0">';

       foreach ($return['matches'] as $match)
       {
              echo '
            <tr>
                <td><a href="'.$match['url'].'" target="_blank">'.$match['url'].'</a></td>
                <td><strong>&nbsp;&nbsp;'.$match['percent'].'%&nbsp;&nbsp;</strong></td>
                <td><a href="#" onclick=\'return highlight_words('.json_encode($match['highlight']).');\'>���������� ����������</a></td>
            </tr>';
       }
       echo '
        </table>
        <p><a href="#" onclick=\'return highlight_words(' . json_encode($return['highlight']) . ');\'>���������� ��� ����������</a></p>';
}