<?php
		// <!-- ��������� �� ������-->
       go\DB\Storage::getInstance()->get()->close();
		//		<!-- Piwik -->
		if ($_SERVER['HTTP_HOST'] == stristr(mb_substr(get_domain(), 0, -1), "al")) {
				// ��� ������� ������� API, ����� �������� ������ �������� ����� ��� ������� URL.
				// ����� ���������� � ������ ������ �������� ���� � HTML ������
				function DisplayTopKeywords($url = "") {

						// �� ������� ������, ��� 1 ������� ������� ������
						@ini_set("default_socket_timeout", $timeout = 1);
						// �������� ������ �������� �����
						$url      = empty($url) ? "http://".$_SERVER["HTTP_HOST"].$_SERVER["REQUEST_URI"] : $url;
						$api      =
								"http://fotosait.no-ip.org/piwik/?module=API&method=Referers.getKeywordsForPageUrl&format=php&filter_limit=10&token_auth=deb5fe1a329264e8858b152d7983508d&date=previous1&period=week&idSite=1&url="
								.urlencode($url);
						$keywords = @unserialize(file_get_contents($api));
						// echo ('<br><br><br><br><pre>'.$keywords.'</pre>');
						if ($keywords === false || isset($keywords["result"])) {
								// DEBUG ONLY: uncomment for troubleshooting an empty output (the URL output reveals the token_auth)
								// echo "������ ��� ������� <p><a href='$api'>��� �������� ����� �� Piwik</a></p>?";
								return;
						}
						// Display the list in HTML
						$url    = htmlspecialchars($url, ENT_QUOTES);
						$output = "<h2>��� �������� ����� ��� <a href='".$url."'>$url</a></h2><ul>";
						foreach ($keywords as $keyword) {
								$output .= "<li>".$keyword[0]."</li>";
						}
						if (empty($keywords)) {
								$output .= "���� ���...";
						}
						$output .= "</ul>";
						echo $output;
				}
				//	DisplayTopKeywords();
		}
//<!-- End Piwik Tracking Code -->
       $dir = $_SERVER['DOCUMENT_ROOT'];
       clearDirRec($dir.'/tmp/');  //�����, ������� ������
       ?>
       <!--GoogleAnalytics-->
       <script>
        (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
               (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
                     m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
        })(window,document,'script','//www.google-analytics.com/analytics.js','ga');
              ga('create', 'UA-49928883-1', 'aleks.od.ua');
              ga('send', 'pageview');
        </script>