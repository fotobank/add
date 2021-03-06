<?php
       // �������������� Windows 1251 -> Unicode
       function win2uni($s)
       {
              $s = convert_cyr_string($s, 'w', 'i'); // �������������� win1251 -> iso8859-5
              // �������������� iso8859-5 -> unicode:
              for ($result = '', $i = 0; $i < strlen($s); $i++) {
                     $charcode = ord($s[$i]);
                     $result   .= ($charcode > 175) ? "&#".(1040 + ($charcode - 176)).";" : $s[$i];
              }
              return $result;
       }

       // ��������� �������� ����������� 
       function imageresize($outfile, $infile, $neww, $newh, $quality, $warermark = 0, $ip_marker = 0, $sharping = 0)
       {
              $ext = strtolower(substr($infile, strrpos($infile, '.') + 1));
              switch ($ext) {
                     default:
                     case 'jpg':
                     case 'jpeg':
                            $im = imagecreatefromJPEG($infile);
                            break;
                     case 'gif':
                            $im = imagecreatefromGIF($infile);
                            break;
                     case 'png':
                            $im = imagecreatefromPNG($infile);
                            break;
              }
              if ($im) {
                     $imgInfo = getimagesize($infile);
                     $w_i     = $imgInfo[0];
                     $h_i     = $imgInfo[1];
                     if ($w_i > $h_i) {
                            $x_o = ($w_i - $h_i) / 2;
                            $min = $h_i;
                            $otn = $w_i / $h_i;
                     } else {
                            $min = $w_i;
                            $x_o = 0;
                            $otn = $h_i / $w_i;
                     }
                     if ($neww / $newh == 1) {
                            $w_o = $h_o = $min;
                            $w_n = $neww;
                            $h_n = $newh;
                     } else {
                            $w_o = $w_i;
                            $h_o = $h_i;
                            $x_o = 0;
                            if ($w_i > $h_i) {
                                   $w_n = $neww;
                                   $h_n = round($neww / $otn);
                            } else {
                                   $w_n = round($neww / $otn);
                                   $h_n = $neww;
                            }
                     }
                     $img_o = imagecreatetruecolor($w_n, $h_n);
                     imagecopyresampled($img_o, $im, 0, 0, $x_o, 0, $w_n, $h_n, $w_o, $h_o);
                     if ($ip_marker == 1) {
                            $iTextColor = imagecolorallocate($img_o, 250, 250, 250); // ���������� ���� ������
                            $sIP        = Get_IP(); // ���������� IP ����������
                            $zap        = basename($infile);
                            $rs         = go\DB\query('SELECT nm FROM photos WHERE img = ?string', [$zap], 'el');
                            $text       = win2uni("��� IP-adress: {$sIP}, ���������� # {$rs}");
                            define('WIDTH', $w_n);
                            define('HEIGHT', $h_n);
                            define('FONT_NAME', __DIR__.'/../fonts/LUA.TTF');
                            define('FONT_SIZE', 12);
                            $coord = imagettfbbox(
                                   FONT_SIZE,  // ������ ������
                                   0,          // ���� ������� ������ (0 = �� ���������)
                                   FONT_NAME,  // ��� ������, � ���� ������, ttf-�����
                                   $text       // ����������, �����
                            );
                            $width  = $coord[2] - $coord[0];
                            $height = $coord[1] - $coord[7];
                            $X      = (WIDTH - $width) / 2;
                            $Y      = (HEIGHT + $height) / 10;
                            imagettftext(
                                   $img_o,      // ��� ������, ������������� �������
                                   FONT_SIZE,   // ������ ������
                                   0,           // ���� ������� ������
                                   $X, $Y,      // ���������� (x,y), ��������������� ������ ������� ���� ������� �������
                                   $iTextColor, // ���� ������
                                   FONT_NAME,   // ��� ttf-�����
                                   $text
                            );
                     }
                     if ($warermark == 1) {
                            $aWmImgInfo = getimagesize("img/vz.png");
                            if (is_array($aWmImgInfo) && count($aWmImgInfo)) {
                                   //  ������� ����������� �������� �����
                                   $rWmImage = imagecreatefrompng("img/vz.png");
                                   // �������� ����������� �������� ����� �� ����������� ��������
                                   imagecopy($img_o, $rWmImage, $w_n / 2 - $aWmImgInfo[0] / 2, $h_n * 0.5, 0, 0,
                                             $aWmImgInfo[0], $aWmImgInfo[1]);
                            }
                     }
                     if ($sharping == 1) {
                            $sharpenMatrix = [
                                   [0, -1, 0],
                                   [-1, 15, -1],
                                   [0, -1, 0]
                            ];
                            $divisor       = array_sum(array_map('array_sum', $sharpenMatrix));
                            $offset        = 0;
                            imageconvolution($img_o, $sharpenMatrix, $divisor, $offset);
                     }
                     imagejpeg($img_o, $outfile, $quality);
                     imagedestroy($im);
                     imagedestroy($img_o);
                     return 'true';
              } else {
                     return 'false';
              }
       }
