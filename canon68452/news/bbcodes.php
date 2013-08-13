<?

include 'sys/func.php';
include 'sys/head.php';
admin_only();
echo '<div class="title">BB коды</div>
<div class="content">
<div class="content2">[b] [/b] - <b>Жирный текст</b></div>
<div class="content2">[u] [/u] - <u>Подчеркнутый текст</u></div>
<div class="content2">[i] [/i] - <i>Курсив</i><br/></div>
<div class="content2">[color=цвет] [/color] - Пример:<br/> [color=red] <font color="red">Текст</font> [/color]</div>
<div class="content2">[url=ссылка] название ссылки [/url] - Пример:<br/> [url=http://google.com] Поиск [/url] - <a href="http://google.com">Поиск</a></div>
<div class="title"><a href="newsadm.php">Управление новостями</a></div></div>';


include 'sys/end.php';