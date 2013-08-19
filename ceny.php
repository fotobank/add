<?php
  include (dirname(__FILE__).'/inc/head.php');
?>

  <link href="/css/calkul.css" rel="stylesheet" type="text/css"/>
  <script src="/js/calkul.js"></script>

  <script src=" /js/textualizer.js"></script>

  <script type='text/javascript'>
	 $(function() {
	 var list = [
	  "Счастлив тот, кто может разглядеть красоту в обычных вещах, там, где другие ничего не видят! Всё — прекрасно, достаточно лишь уметь присмотреться. Камиль Писсарро.",
		"Полюбить — значит разглядеть сквозь дробность мира картину. Любовь — это обретение божества. Антуан де Сент-Экзюпери, «Цитадель»",
		"Какие бы причины ни были, настоящая любовь все равно продолжает жить в сердце. Ты ничего не можешь поделать с этой любовью и просто сохраняешь ее в себе. Эльчин Сафарли.",
		"Там, где встречаешь любовь, пространство сжимается до сердца одного человека.  Эльчин Сафарли, «Я вернусь…»",
	  "Величайшее несчастье — быть счастливым в прошлом. Боэций",
	   "В истинно любящем сердце или ревность убивает любовь, или любовь убивает ревность. Федор Михайлович Достоевский",
		"Дружба — это любовь без крыльев. Джордж Байрон.",
	  "Я люблю тебя не за то, кто ты, а за то, кто я, когда я с тобой.Габриель Гарсиа Маркес, «Сто лет одиночества».",
	  "Все женщины прелестны, а красоту им придает любовь мужчин. Александр Сергеевич Пушкин.",
	  "Легко скрыть ненависть, трудно скрыть любовь, всего труднее скрыть равнодушие. Людвиг Бёрне.",
	  "Хорошие люди принесут вам счастье, плохие люди наградят вас опытом, худшие — дадут вам урок, а лучшие — подарят воспоминания. Цените каждого. Уилл Смит.",
	  "Любовь — начало и конец нашего существования. Без любви нет жизни. Поэтому-то любовь есть то, перед чем преклоняется мудрый человек. Конфуций."

		       ];  // Абзацы текста
	 var txt = $('#citata');  //  Контейнер в котором рендерится текст

		var options = {
		  duration: 10000,          // Время (мс) показа каждого абзаца
		  rearrangeDuration: 1000, // Время (мс) смены абзацов
		  effect: 'random',        // эффект анимации появления символов fadeIn, slideLeft, slideTop, или random.
		  centered: true           // центрирование текста относительно его контейнера
		};
		 txt.textualizer(list, options); // textualize it!
	 txt.textualizer('start'); // start
	 });
  </script>;


  <div id="main">

<!--  <div id="wb_Shape1" style="position:absolute;left:-10px;width:1220px;height 200px;z-index:-5;">-->
<!--	 <img src="/img/imgFon.png" id="Shape1" alt="" style="width:1220px;height 200px;">-->
<!--  </div>-->

  <div class="header">
		<div id="wb_Shape2" style="position:relative; margin:20px auto 0;width:1050px;height:235px;z-index:1;">
		<img src="/img/gradient.png" id="Shape2" alt="" style="width:1050px;height:235px;">
	 </div>
	 <div id="wb_Image16" style="position:relative;margin:-50px auto 0;width:1000px;height:96px;z-index:0;">
		<img id="Image16" style="width:1000px;height:96px;" alt="" src="/img/shadow_horizontal_18.png">
	 </div>
  </div>

<div class="clear"></div>


  <!--Левая колонка-->
  <div class="l_colonka">
		  <div class="block lifted silver" >
			 <h2 class="silver">Рубрики</h2>
		  <dl id="menu">
			 <dt><a href="/index.php"><strong>Видео</strong> </a></dt>
			 <dt><a href="/index.php"><strong>Фото</strong> </a></dt>
			 <dt><a href="/index.php"><strong>Фотокниги</strong> </a></dt>
			 <dt><a href="/index.php"><strong>Слайд шоу</strong> </a></dt>
			 <dt><a href="/index.php"><strong>Коллажи</strong> </a></dt>
			 <dt><a href="/index.php"><strong>Прайс-лист по фотосъемке</strong> </a></dt>
			 <dt><a href="/index.php"><strong>Love Story</strong> </a></dt>
			 <dt><a href="/index.php"><strong>Прайс-лист по видеосъемке</strong> </a></dt>
			 <dt><a href="/index.php"><strong>Видео Love Story</strong> </a></dt>
			 <dt><a href="/index.php"><strong>Гид по фотобанку </strong> </a></dt>
			 <dt><a href="/index.php"><strong>Видеоуроки</strong> </a></dt>
		  </dl>
		</div>




	 <div class="clear"></div>
	 <div class="contact">
		<div class="small_head">
		  <p class="toptext_00">Контакты:</p>
		</div>
		<p class="text_contact" style="margin-top: 15px;">Видеооператор</p>

		<p class="text_contact" style="margin-top: -10px;">тел. 094-94-77-070</p>

		<p class="text_contact">
		  <object style="margin-top: -10px; margin-bottom: -10px;" width="115" height="50" data="img/1135_mail.swf" type="application/x-shockwave-flash">
			 <param name="wmode" value="transparent"/>
			 <param name="allowScriptAccess" value="always"/>
			 <param name="flashvars" value="&in_title=почта&&url=mailto:video@aleks.od.ua&"/>
			 <param name="src" value="img/1135_mail.swf"/>
		  </object>
		</p>
		<p class="text_contact">
		  <script type="text/javascript">// <![CDATA[
			 scrambleVideo();
			 // ]]></script>
		</p>
		<p class="text_contact" style="margin-top: 15px;">Фотограф</p>

		<p class="text_contact" style="margin-top: -10px;">тел. 703-01-67</p>

		<p class="text_contact">
		  <object style="margin-top: -10px; margin-bottom: -10px;" width="115" height="50" data="img/1135_mail.swf" type="application/x-shockwave-flash">
			 <param name="wmode" value="transparent"/>
			 <param name="allowScriptAccess" value="always"/>
			 <param name="flashvars" value="&in_title=почта&&url=mailto:foto@aleks.od.ua&"/>
			 <param name="src" value="img/1135_mail.swf"/>
		  </object>
		</p>
		<p class="text_contact">
		  <script type="text/javascript">// <![CDATA[
			 scrambleFoto();
			 // ]]></script>
		</p>
	 </div>

	 <div class="block lifted">
		<h2>Мы рекомендуем</h2>
		<p style="text-align: center;"></p>
		<h3>Наши друзья</h3>
		<p></p>
		<p style="text-align: center;">
		  <noindex>
			 <a target="_blank" rel="nofollow" href="javascript:void(0)" title="Видеокурс - Интернет-магазин под ключ">
				<img width="190" alt="Видеокурс Интернет-магазин под ключ" src="/reklama/photo/svadbi/Дети/06_Возле мягких игрушек.jpg">
			 </a>
		  </noindex>
		</p>
		<p style="text-align: left;">Видеокурс, не имеющий аналогов по качеству практических занятий и размаху подачи полезной информации — такого Вы больше нигде не встретите. По сути, это три полновесных курса с ценнейшим материалом, собранные в единый комплект.</p>
		<p style="text-align: center;">
		  <noindex>
			 <strong>
				<a target="_blank" rel="nofollow" href="javascript:void(0)" title="Видеокурс - Интернет-магазин под ключ">Подробнее »</a>
			 </strong>
		  </noindex>
		</p>
	 </div>

	      <!--<script type="text/javascript">
				$(document).ready(function(){
				  $(".selected").click(function() {
					 $(" #vragi").hide("fast", function() {
						$("#noVrag").show("fast");
					 });
						function shovNoVragi(){
						  $(" #vragi").hide("fast", function() {
							 $("#noVrag").show("fast");
					    });
				       }

				    });
				  });
			 </script>-->





	 <script type="text/javascript">
		$(document).ready(function() {
		  function visHide()
		  {
			 if ($("#noVrag").is(":hidden")) {$('#selectSmile').text('Вернуться »');
			 } else {$('#selectSmile').text('Подробнее »');
			 }
		  }
		  $('#selectSmile').click(function() {
			 visHide();
			 $('#vragi').toggle(200);$('#noVrag').toggle(200);
		});
		  $('#selectVrag, #smail').click(function() {
			 visHide();
			 $('#vragi').toggle(200);$('#noVrag').toggle(200);
		  });
		});
	 </script>

	 <div class="block lifted">
		<h2>Внимание</h2>
		<h3 style="color: #b21e0f;">Наши враги</h3>
		<div id="vragi">
		<p class="center">
		  <noindex>
			 <a id="selectVrag" href="javascript:void(0)" title="Наши враги">
				<img width="190" alt="Наши враги" src="/reklama/img/vragi.jpg">
			 </a>
		  </noindex>
		</p>
		<blockquote>
		<p>«Живи с людьми так, чтобы твои друзья не стали недругами, а недруги стали друзьями.»
		  <br>
		  <small style="float: right;">Пифагор</small>
		</p>
		</blockquote>
		</div>
		<div id="noVrag">
		  <div id="smail"></div>
		  <p class="center">	У нас их нет:)) </p>
		</div>
		  <p class="center">
			 <noindex>
				<strong>
				  <a id="selectSmile" class="selected" href="javascript:void(0)" title="Наши враги">Подробнее »</a>
				</strong>
			 </noindex>
		  </p>
		</div>
	</div>

  <!--Средняя колонка-->
  <div class="c_colonka">
		<div class="block lifted">
		  <h2>Направление деятельности</h2>
	<div id="citata"class="noteclassic" style="height: 70px;"></div>
		  <div class="post">
		  <h1>
			 <a title="Ссылка на запись Немного о нас" rel="bookmark" href="javascript:void(0)" onclick="$('#oNas').toggle(200);">Немного о нас</a>
		  </h1>
			 <div class="post-info">
				<span class="postdate">8 июля, 2013</span>
            <span class="author">
            <a rel="author" title="Записи Jurii" href="javascript:void(0)">Jurii</a>
            </span>
				<span class="view">Просмотрели: 173</span>
            <span class="comment">
            <a title="Прокомментировать запись «Немного о нас»" href="javascript:void(0)">Нет комментариев</a>
            </span>
			 </div>
		  <div class="entry">
			 <a title="Ссылка на запись Немного о нас (студия фото и видеосъёмки в Одессе Creative ls)" rel="bookmark" href="javascript:void(0)">
				<img class="post_thumbnail alignleft" width="140" height="140" alt="Немного о нас" src="/reklama/photo/svadbi/Лето/13.jpg"
				 onclick="$('#oNas').toggle(200);">
			 </a>
			 Студия «Креатив» - это команда профессионалов, занимающихся профессиональной фото и видеосъемкой свадеб, love story,
			 корпоративных вечеров, юбилеев,  дней рождений, крестин и других различных памятных торжеств.
			  репортажное, семейное, детское, портретное и гламурное фото и т.д.
			 От гламурного портрета, съемки детей, постановочного художественного свадебного фото до креативной репортажной съемки,
			 съемки спортивных соревнований или рекламы.
			 <p>Наши преимущества – соответствующее профильное образование, а так же...</p>
			 <div id="myCarousel" class="carousel slide"><!-- Carousel items -->
				<div class="carousel-inner">
				  <div class="active item">
					 <img width="190" alt="" src="/reklama/photo/deti/sm/01_Настя.jpg">
				  </div>
				  <div class="item">
					 <img width="190" alt="" src="/reklama/photo/deti/sm/03_Максим и Настя.jpg">
				  </div>
				  <div class="item">
					 <img width="190" alt="" src="/reklama/photo/deti/sm/04_Макс и Настёна.jpg">
				  </div>
				</div>
				<!-- Carousel nav --><a class="carousel-control left" href="#myCarousel" data-slide="prev">‹</a>
				<a class="carousel-control right" href="#myCarousel" data-slide="next">›</a>
			 </div>
			 <div id="oNas" style="display: none;">
			 <p> большой практический опыт организации съемок, монтажа и последующей обработки фото и
		  видеоматериала. Творчесский (креативный) подход к съемке и монтажу с учетом индивидуальных пожеланий клиентов в конечном итоге позволяет добиться наилучших
		  результатов нашей работы.   на различные темы. Лучший фотограф и оператор Одессы - в студии «Креатив». Обратившись к нам, Вы
		  останетесь довольны. Яркая память о Вашем празднике – наша основная задача! Стимулом нашего творчества являются многочисленные положительные отзывы наших клиентов.
		  Целью создания данного сайта является ознакомление максимальной аудитории будущих клиентов с профессиональным творчеством нашей студии.</p>

		  <p>В жизни каждого человека свадьба – это серьезный и ответственный шаг, это важный и запоминающийся день. Свадьба
		  – это тот радостный момент, когда невеста будет самой красивой девушкой в мире, когда всё внимание, все слова,
		  все поздравления будут адресованы лучшей паре на свете. Свадьба – это море радости, смеха, улыбок, брызги
		  шампанского, танцы и веселые конкурсы. Это момент, который запомнится молодой паре на всю жизнь!!! И, конечно же, не
		  секрет, что в жизни двух людей, любящих друг друга, самым знаменательным и значимым событием является День
		  Свадьбы. А все светлые и важные дни хочется запомнить навсегда. Но как сделать так, чтобы воспоминания
		  оставались живыми и динамичными? Все очень просто: вам нужна профессиональная свадебная фото и видеосъемка.</p>
			 </div>
			 <div class="clear"></div>
			 <div class="readmorecontent">
				<a title="Ссылка на запись Создаем эффектные вкладки (табы) для сайта" rel="bookmark" href="javascript:void(0)" onclick="$('#oNas').toggle(200);" >Читать Далее »</a>
			 </div>
	 </div>
		</div>


		<div class="post">
		  <h1><a title="Ссылка на запись Что-нибудь1" rel="bookmark" href="javascript:void(0)" onclick="$('#hide-1').toggle(200);">Что-нибудь1</a>
		  </h1>
		  <div class="post-info">
			 <span class="postdate">10 июля, 2013</span>
            <span class="author">
            <a rel="author" title="Записи Jurii" href="javascript:void(0)">Jurii</a>
            </span>
			 <span class="view">Просмотрели: 173</span>
            <span class="comment">
            <a title="Прокомментировать запись Что-нибудь2" href="javascript:void(0)" onclick="$('#hide-2').toggle(200);">Нет комментариев</a>
            </span>
		  </div>
		<div class="entry">
		  <a title="Ссылка на запись Что-нибудь" rel="bookmark" href="javascript:void(0)" onclick="$('#hide-1').toggle(200);">
			 <img class="post_thumbnail alignleft" width="140" height="140" alt="Создаем эффектные вкладки (табы) для сайта" src="/reklama/photo/svadbi/Лето/15.jpg">
		  </a>
		  Растет армия пользователей использующих для серфинга в интернете различные мобильные устройства: iPhone, iPad, мобильные телефоны и т.д и т.п. Все эти современные гаджеты имеют разные разрешения и возможности экранов, а значит перед разработчиками веб-сайтов еще острее встает вопрос юзабилити, т.е. логичность и простота в расположении элементов управления пользовательских ...
		  <div class="clear"></div>

		  <div id="hide-1" style="display: none;">
			 Растет армия пользователей использующих для серфинга в интернете различные мобильные устройства: iPhone, iPad, мобильные телефоны и т.д и т.п. Все эти современные гаджеты имеют разные разрешения и воз
		  </div>
		  <div class="clear"></div>
		  <div class="readmorecontent">
			 <a title="Ссылка на запись Создаем эффектные вкладки (табы) для сайта" rel="bookmark" href="javascript:void(0)" onclick="$('#hide-1').toggle(200);">Читать Далее »</a>
		  </div>
		</div>
   </div>


		  <div class="post">
			 <h1>
				<a title="Ссылка на запись Что-нибудь2" rel="bookmark" href="javascript:void(0)" onclick="$('#hide-2').toggle(200);">Что-нибудь2</a>
			 </h1>
			 <div class="post-info">
				<span class="postdate">10 июля, 2013</span>
            <span class="author">
            <a rel="author" title="Записи Jurii" href="javascript:void(0)">Jurii</a>
            </span>
				<span class="view">Просмотрели: 173</span>
            <span class="comment">
            <a title="Прокомментировать запись «Немного о нас»" href="javascript:void(0)">Нет комментариев</a>
            </span>
			 </div>
			 <div class="entry">
				<a title="Ссылка на запись Что-нибудь" rel="bookmark" href="javascript:void(0)" onclick="$('#hide-2').toggle(200);">
				  <img class="post_thumbnail alignleft" width="140" height="140" alt="Создаем эффектные вкладки (табы) для сайта" src="/reklama/photo/svadbi/Лето/14.jpg">
				</a>
				Растет армия пользователей использующих для серфинга в интернете различные мобильные устройства: iPhone, iPad, мобильные телефоны и т.д и т.п. Все эти современные гаджеты имеют разные разрешения и возможности экранов, а значит перед разработчиками веб-сайтов еще острее встает вопрос юзабилити, т.е. логичность и простота в расположении элементов управления пользовательских ...
				<div class="clear"></div>
				<div class="noteclassic">
				  Полюбить — значит разглядеть сквозь дробность мира картину.
				  <br>
				  Любовь — это обретение божества.
				  <p style="text-align: right;">
					 <em>Антуан де Сент-Экзюпери, «Цитадель»</em>
				  </p>
				</div>
				<div id="hide-2" style="display: none;">
				  Растет армия пользователей использующих для серфинга в интернете различные мобильные устройства: iPhone, iPad, мобильные телефоны и т.д и т.п. Все эти современные гаджеты имеют разные разрешения и воз
				</div>
				<div class="clear"></div>
				<div class="readmorecontent">
				  <a title="Ссылка на запись Создаем эффектные вкладки (табы) для сайта" rel="bookmark" href="javascript:void(0)" onclick="$('#hide-2').toggle(200);">Читать Далее »</a>
				</div>
			 </div>
		  </div>


  </div>


	 <div class="block lifted">
		<h2>Рекомендуем прочитать</h2>
		<ul class="yarlist">
		  <li>
			 <a title="Быстрый анализ цвета используемого в дизайне веб-сайтов" rel="bookmark" href="javascript:void(0)">Быстрый анализ цвета используемого в дизайне веб-сайтов</a>
		  </li>
		  <li>
			 <a title="Как быстро проверить текст статей на уникальность" rel="bookmark" href="javascript:void(0)">Как быстро проверить текст статей на уникальность</a>
		  </li>
		  <li>
			 <a title="Быстрый поиск различных кодов для символов" rel="bookmark" href="javascript:void(0)">Быстрый поиск различных кодов для символов</a>
		  </li>
		  <li>
			 <a title="Удобный онлайн генератор значений свойств CSS3" rel="bookmark" href="javascript:void(0)">Удобный онлайн генератор значений свойств CSS3</a>
		  </li>
		  <li>
			 <a title="Онлайн генераторы CSS3 — в обойме инструментов web-разработчика" rel="bookmark" href="javascript:void(0)">Онлайн генераторы CSS3 — в обойме инструментов web-разработчика</a>
		  </li>
		  <li>
			 <a title="Обзор онлайн-сервисов для веб-разработки и дизайна" rel="bookmark" href="javascript:void(0)">Обзор онлайн-сервисов для веб-разработки и дизайна</a>
		  </li>
		</ul>

		<div class="clear"></div>
	 </div>



		<div id="respond">
		  <div class="block">
			 <h2>Присоединяйтесь к обсуждению!</h2>
			 <div class="cancel-comment-reply">
				<small><a rel="nofollow" id="cancel-comment-reply-link"  style="display:none;"
					href="<?=$_SERVER['REQUEST_URI']?>#respond">Нажмите, чтобы отменить ответ.</a></small>
			 </div>
			 <form action="<?=$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI']?>#comment-5000" method="post" id="commentform">
				<p><input type="text" name="author" id="author" value="" size="22" tabindex="1" class="textarea"/>
				  <label for="author"><small>Имя (обязательно)</small></label></p>
				<p><input type="text" name="email" id="email" value="" size="22" tabindex="2" class="textarea"/>
				  <label for="email"><small>E-mail (не публикуется) (обязательно)</small></label></p>
				<p><input type="text" name="url" id="url" value="" size="22" tabindex="3" class="textarea"/>
				  <label for="url"><small>Ваш сайт</small></label></p>
				<div id="comment_quicktags">
				  <script src="/inc/wp-comment-quicktags-plus.php" type="text/javascript"></script>
				  <script type="text/javascript">edToolbar();</script>
				</div>
				<p><textarea name="comment" id="comment" cols="100%" rows="10" tabindex="4"></textarea></p>
				<p class="terms">Отправляя кoммeнтapий, Вы автоматически принимаете <a href="#t4" onclick="view('t4'); return false">правила кoммeнтиpoвaния</a> на этом блоге.</p>

				<div id="t4" class="terms">
				  <h3>Правила кoммeнтиpoвaния на сайте <?=$_SERVER['HTTP_HOST']?>:</h3>
				  <ol>
					 <li>Во избежание захламления спамом, <strong>первый кoммeнтapий</strong> всегда проходит премодерацию.</li>
					 <li>В поле "<strong>Ваш сайт</strong>" лучше указывать ссылку на главную страницу вашего сайта/блога. Ссылки на прочую веб-лабуду (в том числе блоги/сплоги, <strong>созданные не для людей</strong>) будут удалены.</li>
					 <li>Не используйте в качестве имени комментатора <strong>слоганы/названия сайтов, рекламные фразы, ключевые</strong> и т.п. слова. В случае несоблюдения этого условия, имя изменяю на свое усмотрение. Просьба указывать нормальное имя или ник.</li>
					 <li>Комментарии не по теме удаляются без предупреждения.</li>
				  </ol>
				</div>

				<p><input id="preview" type="submit" name="preview" tabindex="5" class="Cbutton" value="Предпросмотр" />
				  <input id="submit" type="submit" name="submit" tabindex="6" style="font-weight: bold" class="Cbutton" value="Отправить &raquo;" />
				  <input type='hidden' name='comment_post_ID' value='1481' id='comment_post_ID' />
				  <input type='hidden' name='comment_parent' id='comment_parent' value='2392' />
				</p>

				<p style="display: none;"><input type="hidden" id="akismet_comment_nonce" name="akismet_comment_nonce" value="4447100622" /></p>

				<p style="clear: both;" class="subscribe-to-comments">
				  <input type="checkbox" name="subscribe" id="subscribe" value="subscribe" style="width: auto;" />
				  <label for="subscribe">Оповещать о новых комментариях по почте</label>
				</p>

				<script type="text/javascript">
				  <!--
				  edCanvas = document.getElementById('comment');
				  //-->
				</script>
			 </form>
			 <form action="" method="post">
				<input type="hidden" name="solo-comment-subscribe" value="solo-comment-subscribe" />
				<input type="hidden" name="postid" value="1481" />
				<input type="hidden" name="ref" value="<?=$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI']?>%2Fcomment-page-1%3Freplytocom%3D2392" />

				<p class="solo-subscribe-to-comments">
				  Подписаться не комментируя:	<br />
				  <label for="solo-subscribe-email">E-mail:	<input type="text" name="email" id="solo-subscribe-email" size="22" value="" /></label>
				  <input type="submit" name="submit" value="Подписаться &raquo;" />
				</p>
			 </form>
		  </div>






  </div>



  <!--Правая колонка-->
	 <div class="r_colonka">


		<div class="block lifted">
		  <h2>Разное</h2>
		  <div class="news_title">Новости:</div>
		  <div class="entry">
		<div class="news" style="padding: 0;">

		  <div class="data">
			 <object style="margin-top: -3px; margin-left: -5px;" width="90" height="20" data="img/bigclock4.swf" type="application/x-shockwave-flash">
				<param name="wmode" value="transparent"/>
				<param name="src" value="img/bigclock4.swf"/>
			 </object>
		  </div>
		  <p class="news_tit" style="margin: 8px 0;">Скидка 400гр</p>

		  <div>
			 <span style="color: #000000;">на съемку свадеб - все дни, кроме<br/> <span style="text-align: center;"><span class="ttext_orange" style="font-family: Georgia,Times New Roman,Times,serif; font-size: 12px; font-weight: normal; color: #0000cd;">Пт,Сб и Вс.</span></span></span>
		  </div>
		  <div class="spec_title">Спецпредложения:</div>
		  <p style="font-family: Georgia,Times New Roman,Times,serif; font-size: 12px; font-weight: normal; color: #000000;">
			 padding-left: – определяет внутренний отступ слева. margin-top: – определяет внешний отступ сверху.
			 margin-left: – определяет внешний отступ слева. min-width: – определяет минимальную ширину. max-width: –
			 определяет максимальную ширину.</p>
		</div>
	 </div>
	</div>


		<div class="block lifted">
		  <h2>Поделитесь с друзьями</h2>
		  <!-- AddThis Button BEGIN -->
		  <div class="addthis_toolbox addthis_default_style addthis_32x32_style">
			 <a class="addthis_button_odnoklassniki_ru"></a> <a class="addthis_button_vk"></a>
			 <a class="addthis_button_mymailru"></a> <a class="addthis_button_compact"></a>
			 <a class="addthis_counter addthis_bubble_style"></a>
		  </div>
		  <script type="text/javascript">var addthis_config = {"data_track_addressbar": true};</script>
		  <script type="text/javascript" src="//s7.addthis.com/js/300/addthis_widget.js#pubid=ra-5130b3ac183d6054"></script>
		  <!-- AddThis Button END -->
		 </div>





		<div class="block lifted">
		  <h2>Видеокурсы</h2>
		  <div class="textwidget">
			 <p style="text-align: center;">
				<noindex>
				  <a target="_blank" rel="nofollow" href="javascript:void(0)">
					 <img width="140" alt="Корпоративный сайт под ключ" src="/reklama/photo/svadbi/Лето/10.jpg">
				  </a>
				</noindex>
			 </p>
			 <p style="text-align: left;">
				<strong>«Корпоративный сайт под ключ»</strong>
				- это практическое руководство и готовая универсальная система управления контентом плюс весь процесс ее создания с открытым кодом, который не имеет пределов расширения и совершенствования.
			 </p>
			 <p style="text-align: center;">
				<strong>
				  <noindex>
					 <a target="_blank" rel="nofollow" href="javascript:void(0)"> Подробнее »</a>
				  </noindex>
				</strong>
			 </p>
			 <hr>
			 <p style="text-align: center;">
				<noindex>
				  <a target="_blank" rel="nofollow" href="javascript:void(0)">
					 <img width="140" alt="Практика резиновой верстки сайта" src="/reklama/photo/svadbi/Лето/03.jpg">
				  </a>
				</noindex>
			 </p>
			 <p style="text-align: center;">
				<strong>Не тяните резину !</strong>
			 </p>
			 <p style="text-align: left;">
				Видеокурс
				<strong>"Практика резиновой верстки"</strong>
				. Без воды. Лишней теории. Убитого времени.
				<strong>37</strong>
				качественных уроков, более
				<strong>19</strong>
				часов видео с подробными инструкциями. Просто взять и сделать!
			 </p>
			 <p style="text-align: center;">
				<strong>
				  <noindex>
					 <a target="_blank" rel="nofollow" href="javascript:void(0)"> Подробнее »</a>
				  </noindex>
				</strong>
			 </p>
			 <hr>
			 <p style="text-align: center;">
				<noindex>
				  <a target="_blank" rel="nofollow" href="javascript:void(0)">
					 <img width="140" alt="Премиум уроки" src="/reklama/photo/svadbi/Лето/02.jpg">
				  </a>
				</noindex>
			 </p>
			 <p style="text-align: left;"> Основы самостоятельного сайтостроения - всё, что нужно новичкам и профи для создания сайтов, и даже больше.</p>
			 <p style="text-align: center;">
				<strong>
				  <noindex>
					 <a target="_blank" rel="nofollow" href="javascript:void(0)"> Подробнее »</a>
				  </noindex>
				</strong>
			 </p>
		  </div>
		</div>



		<div class="block">
		  <h2>Комментарии</h2>
		  <ul class="clearlist">
			 <li>
				<img class="avatar avatar-32 photo" width="32" height="32" src="http://1.gravatar.com/avatar/d80ca0b8a8f05b3f4b652dc3a8c648f5?s=32&d=&r=G" alt="">
				<div>
				  <span class="recent_comment_name">driver</span>
				  <span class="ctime">13-08-2013</span>
				</div>
				<a title="driver | Меню «Аккордеон» без javascript и изображений" href="http://dbmast.ru/menyu-akkordeon-bez-javascript-i-izobrazhenij#comment-3496">Виталий. Рад, что вам пригодились мои ...</a>
				<div class="clear"></div>
			 </li>
			 <li>
				<img class="avatar avatar-32 photo" width="32" height="32" src="http://1.gravatar.com/avatar/7d80f56916550f5d22f7d55227c3fb18?s=32&d=&r=G" alt="">
				<div>
				  <span class="recent_comment_name">Виталий</span>
				  <span class="ctime">13-08-2013</span>
				</div>
				<a title="Виталий | Меню «Аккордеон» без javascript и изображений" href="http://dbmast.ru/menyu-akkordeon-bez-javascript-i-izobrazhenij#comment-3495">Ну наконец-то, я нашел что-то стоящее! ...</a>
				<div class="clear"></div>
			 </li>
		  </ul>
		</div>




		<div class="block">
		  <h2>Подписка на Обновления</h2>

		  <p style="text-align: left;">
			 <a target="_blank" rel="nofollow" href="http://feedburner.google.com/fb/a/mailverify?uri=dobrovoi&loc=ru_RU" title="Получайте все обновления на Ваш E-mail!">
				<img width="64" height="64" border="0" alt="Получай обновления на почту" src="/img/email2.png" style="float:left; margin: -8px 5px 0 0; padding:1px; ">
			 </a>
			 Подпишитесь и получайте все обновления на <br>
			 <a target="_blank" rel="nofollow" href="javascript:void(0)" title="Получайте все обновления на E-mail!"> Ваш E-mail</a>
			 , чтобы всегда быть в курсе событий.
		  </p>
		  <form id="subscribeform" class="subscribeform" onsubmit="window.open('http://feedburner.google.com/fb/a/mailverify?uri=dobrovoi', 'popupwindow', 'scrollbars=yes,width=550,height=520');return true" target="popupwindow" method="post" >
			 <input class="subscribe-field" type="text" name="email" value="Укажите свой email" onfocus="if(this.value==this.defaultValue)this.value='';" onblur="if(this.value=='')this.value=this.defaultValue;">
			 <input type="hidden" name="uri" value="dobrovoi">
			 <input type="hidden" value="ru_RU" name="loc">
			 <button type="submit">Подписаться!</button>
		  </form>
		</div>


	 </div>
  <div class="clear"></div>
  </div>







  <!--  <h2>Раздел в разработке</h2>--><!--
	<div id="calculate">
		<div id="header"><p>Перед Вами - свадебный калькулятор. С помощью него Вы сможете примерно рассчитать расходы на это торжественное событие. Все цены указанные ниже - средние. Каждая свадьба - это уникальное событие и потому стоимость, определенная с помощью свадебного калькулятора может несколько отличаться от реальных расходов. </p></div>

		<form action="index.php" method="post" id="calk">
			<table id="tableSelect" width="100%" cellpadding="0" cellspacing="0">
				<tr>
					<th>Описание</th>
					<th>Ед.изм.</th>
					<th>Колличество</th>
					<th>Цена</th>
					<th>Сумма по позиции</th>
				</tr>

				<tr>
					<td>Ведущий</td>
					<td class="vertical">Часы</td>
					<td>
						<select id="pos_1" name="veduschiy">
							<option value="0" selected>-</option>
							<option value="1">1</option>
							<option value="2">2</option>
							<option value="3">3</option>
							<option value="4">4</option>
							<option value="5">5</option>
							<option value="6">6</option>
							<option value="7">7</option>
							<option value="8">8</option>
							<option value="9">9</option>
							<option value="10">10</option>
						</select>
					</td>
					<td class="vertical" id="pos_1_price">3000</td>
					<td id="pos_1_count">0</td>
				</tr>

				<tr>
					<td>Банкетный зал</td>
					<td class="vertical">Человек</td>
					<td>
						<input id="pos_2" type="text" name="people">
					</td>
					<td class="vertical" id="pos_2_price">2000</td>
					<td id="pos_2_count">0</td>
				</tr>

				<tr>
					<td>Теплоход</td>
					<td class="vertical">Человек</td>
					<td>
						<input id="pos_3" type="text" name="people_t">
					</td>
					<td class="vertical" id="pos_3_price">3000</td>
					<td id="pos_3_count">0</td>
				</tr>

				<tr>
					<td>Видеосъемка</td>
					<td class="vertical">Часов</td>
					<td>
						<select id="pos_4" name="video">
							<option value="0" selected>-</option>
							<option value="1">1</option>
							<option value="2">2</option>
							<option value="3">3</option>
							<option value="4">4</option>
							<option value="5">5</option>
							<option value="6">6</option>
							<option value="7">7</option>
							<option value="8">8</option>
							<option value="9">9</option>
							<option value="10">10</option>
						</select>
					</td>
					<td class="vertical" id="pos_4_price">2500</td>
					<td id="pos_4_count">0</td>
				</tr>

				<tr>
					<td>Автомобиль</td>
					<td class="vertical">Часов</td>
					<td>
						<select id="pos_5" name="automobile">
							<option value="0" selected>-</option>
							<option value="1">1</option>
							<option value="2">2</option>
							<option value="3">3</option>
							<option value="4">4</option>
							<option value="5">5</option>
							<option value="6">6</option>
							<option value="7">7</option>
							<option value="8">8</option>
							<option value="9">9</option>
							<option value="10">10</option>
						</select>
					</td>
					<td class="vertical" id="pos_5_price">2500</td>
					<td id="pos_5_count">0</td>
				</tr>

				<tr>
					<td>Украшение шарами</td>
					<td class="vertical">-</td>
					<td>
						<select id="pos_6" name="bubbles">
							<option value="0" selected>Нет</option>
							<option value="1">Да</option>
						</select>
					</td>
					<td class="vertical" id="pos_6_price">5000</td>
					<td id="pos_6_count">0</td>
				</tr>

				<tr>
					<td>Украшение цветами</td>
					<td class="vertical">-</td>
					<td>
						<select id="pos_7" name="flowers">
							<option value="0" selected>Нет</option>
							<option value="1">Да</option>
						</select>
					</td>
					<td class="vertical" id="pos_7_price">5000</td>
					<td id="pos_7_count">0</td>
				</tr>
			</table>
			<div id="count_price"><p>Итого: <span></span> руб.</p></div>
		</form>
	</div>
	-->
  <div id="cont_fb">
	 <? echo $db->query('select txt from content where id = ?i', array(3), 'el'); ?>
  </div>

<script type="text/javascript">
  function view(n) {
	 style = document.getElementById(n).style;
	 style.display = (style.display == 'block') ? 'none' : 'block';
  }
</script>

  </div>
  <div class="end_content"></div>
  </div>
<?php include (dirname(__FILE__).'/inc/footer.php');
?>