</td></tr></table>
</div>
<div class="end_content_gost"></div>
</div>
<div id="footer">
<div id="foot_JavaScript1" style="position:absolute;left:960px;top:-13px;width:269px;height:25px;z-index:10;">
<div style="color:#fff;font-size:10px;font-family:Verdana;font-weight:normal;font-style:normal;text-decoration:none" id="copyrightnotice"></div>
<script type="text/javascript">
   var now = new Date();
   var startYear = "1995";
   var text =  "Copyright &copy; ";
   if (startYear != '')
   {
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
if ($_SESSION['us_name'] == 'test')
{
?> 
<div class="ttext_orange" style="position:absolute; margin-top: -55px;">
<?
echo "Память в конце: ".memory_get_usage()." байт; \n";
echo " Пик: ".memory_get_peak_usage()." байт; \n";
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
<script type="text/javascript">
var pkBaseURL = (("https:" == document.location.protocol) ? "https://192.168.1.232/piwik/" : "http://192.168.1.232/piwik/");
document.write(unescape("%3Cscript src='" + pkBaseURL + "piwik.js' type='text/javascript'%3E%3C/script%3E"));
</script><script type="text/javascript">
try {
var piwikTracker = Piwik.getTracker(pkBaseURL + "piwik.php", 1);
piwikTracker.trackPageView();
piwikTracker.enableLinkTracking();
} catch( err ) {}
</script><noscript><p><img src="http://fotosait.no-ip.org/piwik/piwik.php?idsite=1" style="border:0" alt="" /></p></noscript>
<!-- End Piwik Tracking Code -->

    <p id="back-top">
        <a href="#top"><span></span>Вверх</a>
    </p>
    <script type="text/javascript"> Cufon.now(); </script>

</body>
</html>
<?
mysql_close();
?>