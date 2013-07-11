<?php

/**
 * Вырезает лишний "мусор" из JPEG файлов, уменьшая его размер.
 * Качество файла при этом не страдает.
 * Скрипт был взят с сайта http://bolk.exler.ru/files/ и модифицирован.
 *
 * @param    string   $input_file
 * @param    string   $output_file
 * @return   mixed(bool/int)  FALSE + E_USER_WARNING, если неправильный формат файла или кол-во удаленных байт.
 *
 * @tags     jpeg, jpg, cleaner, cruncher, optimizer, clean, clear, purge, cleanse
 * @charset  ANSI
 * @version  1.0.1
 */
function jpeg_cleaner($input_file, $output_file)
{
    $fp = fopen($input_file, 'r');
    #Check for SOI segment
    if ("\xFF\xD8" != fread($fp, 2))
    {
        trigger_error('Invalid file format (not a JPEG file).', E_USER_WARNING);
        return false;
    }
    $fd = fopen($output_file, 'w');
    fwrite($fd, "\xFF\xD8");  #Write JPEG header
    for ($sum = 0; ! feof($fp); )
    {
        $handle = fread($fp, 2);
        $seg = join('', unpack('H*', $handle));

        if ($handle[0] != "\xFF")
        {
            trigger_error('Invalid file format (not a JPEG file).', E_USER_WARNING);
            fclose($fd);
            unlink($output_file);
            return false;
        }
        if ($handle[1] == "\x01" || $handle[1] >= "\xD0" && $handle[1] <= "\xD7") continue; # Two-bytes segment
        if ($handle[1] == "\xDA") break;

        $type = jpeg_cleaner_TypeOfSeg($handle[1]);
        $len = join('', unpack('n', $str = fread($fp, 2)));

        if ($type == 'UNKNOWN' || $handle[1] >= "\xE0" && $handle[1] <= "\xEF" || $handle[1] == "\xFE")
        {
            fseek($fp, $len - 2, SEEK_CUR);
            $sum += $len + 2;
        }
        else
        {
            fwrite($fd, $handle);
            fwrite($fd, $str.fread($fp, $len - 2));
        }
    }

    if (! feof($fp))
    {
        fwrite($fd, "\xFF\xDA"); #Write SOS signature
        while (! feof($fp)) fwrite($fd, fread($fp, 4096)); #Copy content
    }

    fclose($fp);
    fclose($fd);
    return $sum;
}

#вспомогательные функции:
function jpeg_cleaner_SegReg($h, $str, $s, $e)
{
    if ($h >= $s && $h <= $e) return $str.(ord($h) - ord($s));
    return false;
}
function jpeg_cleaner_TypeOfSeg($h)
{
    $type = array ("\xC4" => "DHT", "\xC8" => 'JPG', "\xCC" => 'DAC', "\xD8" => 'SOI', "\xD9" => 'EOI', "\xDA" => 'SOS', "\xDB" => 'DQT', "\xDC" => 'DNL', "\xDD" => 'DRI', "\xFE" => 'COM');
    if (isset($type[$h])) return $type[$h];
    if (($v = jpeg_cleaner_SegReg($h, 'SOF', "\xC0", "\xCA")) !== false) return $v;
    if (($v = jpeg_cleaner_SegReg($h, 'RST', "\xD0", "\xD7")) !== false) return $v;
    if (($v = jpeg_cleaner_SegReg($h, 'APP', "\xE0", "\xEF")) !== false) return $v;
    return 'UNKNOWN';
}

?>