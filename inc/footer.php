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
						$output = "<h2>��� �������� ����� ��� <a href='$url'>$url</a></h2><ul>";
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