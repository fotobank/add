<div id="footer">
    <div id="foot_JavaScript1" style="position:absolute;left:960px;top:-13px;width:269px;height:25px;z-index:10;">
        <div style="color:#000;font-size:10px;font-family:Verdana,serif;font-weight:normal;font-style:normal;text-decoration:none" id="copyrightnotice">
        </div>
        <script type="text/javascript">
            var now = new Date();
            var startYear = "1995";
            var text = "Copyright &copy; ";
            if (startYear != '') {
                text = text + startYear + "-";
            }
            text = text + now.getFullYear() + ", www.aleks.od.ua";
            var copyrightnotice = document.getElementById('copyrightnotice');
            copyrightnotice.innerHTML = text;
        </script>
    </div>
    <div style="padding-top: 13px; padding-left: 42%;">
        <hfooter> Creative ls &copy; 2013</hfooter>
    </div>

    <?
    if (isset($_SESSION['us_name']) && $_SESSION['us_name'] == 'test')
    {
	?>
	<div class="ttext_blue" style="position:absolute; margin-top: 45px;">
		<?
	/**
	 * $actions - переменная String с действиями:
	 * '' - добавление ошибок в список ошибок,
	 * 'w' - пишет сообщение об ошибке на экран,
	 * 'а' - выводит список всех сообщений на экран,
	 * "d" - очищает стек ошибки,
	 * 's' - остановить исполнение,
	 * 'l' - пишет log,
	 * 'm' - отправляет по электронной почте (значения могут быть объединены, например: 'ws')
	 */
	  //	$error_processor->err_proc("" , "w", $error_processor->error);
//	$error_processor->err_proc("", "w", "");
	  //	$error_processor->err_proc("", "am", "");
   /*$deb = "
	   Версия PHP: ".phpversion().
	   "\n\tИспользуемая память в начале: ".$startMem." Кбайт, Память в конце: ".intval(memory_get_usage() / 1024)." Кбайт, Пик: ".intval(memory_get_peak_usage() / 1024)." Кбайт";
		$time = microtime();
		$time = explode(' ', $time);
		$time = $time[1] + $time[0];
		$finishTime = $time;
		$total_time = round(($finishTime - $startTime), 4);
	  $deb .=  "\tСтраница сгенерированна за: ".$total_time." секунд.";*/
//	   debugHC($deb, "сообщение");
        }
        ?>
    </div>
	
    <!-- Piwik -->
	<?	
	if($_SERVER['SERVER_NAME'] != 'aleks.od.ua')
	{
// Эта функция вызовет API, чтобы получить лучшие ключевые слова для данного URL.
// Затем записывает в список лучших ключевых слов в HTML список
function DisplayTopKeywords($url = "")
{
	// Не тратить больше, чем 1 секунду выборка данных
	@ini_set("default_socket_timeout", $timeout = 1);
	// Получить данные ключевые слова
	$url = empty($url) ? "http://". $_SERVER["HTTP_HOST"] . $_SERVER["REQUEST_URI"] : $url;	
	$api = "http://192.168.1.232/piwik/?module=API&method=Referers.getKeywordsForPageUrl&format=php&filter_limit=10&token_auth=deb5fe1a329264e8858b152d7983508d&date=previous1&period=week&idSite=1&url=".urlencode($url);
	$keywords = @unserialize(file_get_contents($api));
	// echo ('<br><br><br><br><pre>'.$keywords.'</pre>');
	if($keywords === false || isset($keywords["result"])) {
		// DEBUG ONLY: uncomment for troubleshooting an empty output (the URL output reveals the token_auth)
		// echo "Ошибка при выборке <p><a href='$api'>Топ ключевые слова из Piwik</a></p>?";
		return;
	}
	
	// Display the list in HTML
	$url = htmlspecialchars($url, ENT_QUOTES);
	$output = "<h2>Топ ключевые слова для <a href='$url'>$url</a></h2><ul>";
	foreach($keywords as $keyword) {
		$output .= "<li>". $keyword[0]. "</li>";
	}
	if(empty($keywords)) { $output .= "Пока нет..."; }
	$output .= "</ul>";
	echo $output;
}
// DisplayTopKeywords();
	
	?>	  
    <script type="text/javascript">
        var pkBaseURL = (("https:" == document.location.protocol) ? "https://fotosait.no-ip.org/piwik/" : "http://fotosait.no-ip.org/piwik/");
        document.write(unescape("%3Cscript src='" + pkBaseURL + "piwik.js' type='text/javascript'%3E%3C/script%3E"));
    </script>
    <script type="text/javascript">
        try {
            var piwikTracker = Piwik.getTracker(pkBaseURL + "piwik.php", 1);
            piwikTracker.trackPageView();
            piwikTracker.enableLinkTracking();
        } catch (err) {
        }
    </script>
    <noscript><p><img src="http://fotosait.no-ip.org/piwik/piwik.php?idsite=1" style="border:0" alt=""/></p></noscript>
    <?
     }
    ?>
	<!-- End Piwik Tracking Code -->
	
    <script type='text/javascript' src='/js/jquery.easing.1.3.js'></script>
    <script type='text/javascript'>
        /* <![CDATA[ */
       var mv_dynamic_to_top = {"text":"0","version":"0","min":"200","speed":"1000","easing":"easeInOutExpo","margin":"20"};
        /* ]]> */
    </script>
    <script type='text/javascript' src='/js/dynamic.to.top.dev.js'></script>
    <!-- <script type="text/javascript"> Cufon.now(); </script> -->
    <a id="dynamic_to_top" href="#" style="display: inline;">
        <span> </span>
    </a>
</div>

    </body>
    </html>
<?
$db->close();
?>