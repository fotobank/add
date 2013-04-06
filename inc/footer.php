<div id="footer">
    <div id="foot_JavaScript1" style="position:absolute;left:960px;top:-13px;width:269px;height:25px;z-index:10;">
        <div style="color:#fff;font-size:10px;font-family:Verdana;font-weight:normal;font-style:normal;text-decoration:none" id="copyrightnotice">
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
    <div class="ttext_orange" style="position:absolute; margin-top: -55px;">

        Память в конце: <?=intval(memory_get_usage()/1024)?> Кбайт;
        Пик: <?=intval(memory_get_peak_usage()/1024)?> Кбайт;
	    <?
        $time = microtime();
        $time = explode(' ', $time);
        $time = $time[1] + $time[0];
        $finish = $time;
        $total_time = round(($finish - $start), 4);
        echo ' Страница сгенерированна за: '.$total_time.' секунд.'."\n";
        }
        ?>
    </div>

    <!-- Piwik -->
    <!--<script type="text/javascript">
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
    <noscript><p><img src="http://fotosait.no-ip.org/piwik/piwik.php?idsite=1" style="border:0" alt=""/></p></noscript> -->
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

mysql_close();
?>