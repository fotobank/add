<?php

/**
 * ThumbnailImage class, version 2.0 (for PHP >= 4.3)
 * (c) 2008 Vagharshak Tozalakyan <vagh{at}tozalakyan{dot}com>
 *
 * This class can resize images to generate thumbnail versions. It can generate
 * thumbnail images keeping the proportions between the width and the height. It
 * may also add optional text labels with a given color, font, size, rotation
 * angle and position in the resized images. It can load images from files of
 * any format supported by the GD extension and generate thumbnails in either
 * JPEG, PNG or GIF formats. The resized images can be saved to a given file or
 * served directly to the user browser.
 *
 * Permission is hereby granted, free of charge, to any person obtaining a copy
 * of this software and associated documentation files (the "Software"), to deal
 * in the Software without restriction, including without limitation the rights
 * to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
 * copies of the Software, and to permit persons to whom the Software is
 * furnished to do so, subject to the following conditions:
 *
 * The above copyright notice and this permission notice shall be included in
 * all copies or substantial portions of the Software.
 *
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
 * IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
 * FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
 * AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
 * LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
 * OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN
 * THE SOFTWARE.
 *
 * @version  1.2
 * @author   Vagharshak Tozalakyan <vagh{at}tozalakyan{dot}com>
 * @license  http://www.opensource.org/licenses/mit-license.php
 */

define('TI_MAX_IMG_SIZE', 100000);

define('TI_JPEG', 'image/jpeg');
define('TI_PNG', 'image/png');
define('TI_GIF', 'image/gif');

define('TI_INTERLACE_OFF', 0);
define('TI_INTERLACE_ON', 1);

define('TI_STDOUT', '');
define('TI_RESOURCE', '-1000');

define('TI_NO_LOGO', '');
define('TI_NO_LABEL', '');

define('TI_POS_LEFT', 0);
define('TI_POS_RIGHT', 1);
define('TI_POS_CENTER', 2);
define('TI_POS_TOP', 3);
define('TI_POS_BOTTOM', 4);

class ThumbnailImage
{
    var $srcFile = '';
    var $destFile = TI_STDOUT;
    var $destType = TI_JPEG;
    var $interlace = TI_INTERLACE_OFF;
    var $jpegQuality = -1;
    var $maxWidth = 100;
    var $maxHeight = 100;
    var $fitToMax = false;
    var $logo = array();
    var $label = array();
    var $rotateAngle = 0;
    var $rotateBgColor = '#ffffff';

    function ThumbnailImage($srcFile = '')
    {
        $this->srcFile = $srcFile;
        $this->logo['file'] = TI_NO_LOGO;
        $this->logo['vertPos'] = TI_POS_TOP;
        $this->logo['horzPos'] = TI_POS_LEFT;
        $this->label['text'] = TI_NO_LABEL;
        $this->label['vertPos'] = TI_POS_BOTTOM;
        $this->label['horzPos'] = TI_POS_RIGHT;
        $this->label['font'] = '';
        $this->label['size'] = 20;
        $this->label['color'] = '#000000';
        $this->label['angle'] = 0;
    }

    function parseColor($hexColor)
    {
        if (strpos($hexColor, '#') === 0) {
            $hexColor = substr($hexColor, 1);
        }
        $r = hexdec(substr($hexColor, 0, 2));
        $g = hexdec(substr($hexColor, 2, 2));
        $b = hexdec(substr($hexColor, 4, 2));
        return array ($r, $g, $b);
    }

    function getImageStr($imageFile)
    {
        if (function_exists('file_get_contents')) {
            $str = @file_get_contents($imageFile);
            if (!$str) {
                $err = sprintf('Failed reading image data from <b>%s</b>', $imageFile);
                trigger_error($err, E_USER_ERROR);
            }
            return $str;
        }
        $f = fopen($imageFile, 'rb');
        if (!$f) {
            $err = sprintf('Failed reading image data from <b>%s</b>', $imageFile);
            trigger_error($err, E_USER_ERROR);
        }
        $fsz = @filesize($imageFile);
        if (!$fsz) {
            $fsz = TI_MAX_IMG_SIZE;
        }
        $str = fread($f, $fsz);
        fclose ($f);
        return $str;
    }

    function loadImage($imageFile, &$imageWidth, &$imageHeight)
    {
        $imageWidth = 0;
        $imageHeight = 0;
        $imageData = $this->getImageStr($imageFile);
        $image = imagecreatefromstring($imageData);
        if (!$image) {
            $err = sprintf('Cannot create the copy of <b>%s</b>', $imageFile);
            trigger_error($err, E_USER_ERROR);
        }
        if ($this->rotateAngle && function_exists('imagerotate')) {
            list($r, $g, $b) = $this->parseColor($this->rotateBgColor);
            $bgColor = imagecolorallocate($image, $r, $g, $b);
            $image = imagerotate($image, $this->rotateAngle, $bgColor);
        }
        $imageWidth = imagesx($image);
        $imageHeight = imagesy($image);
        return $image;
    }

    function getThumbSize($srcWidth, $srcHeight)
    {
        $maxWidth = $this->maxWidth;
        $maxHeight = $this->maxHeight;
        $xRatio = $maxWidth / $srcWidth;
        $yRatio = $maxHeight / $srcHeight;
        $isSmall = ($srcWidth <= $maxWidth && $srcHeight <= $maxHeight);
        if (!$this->fitToMax && $isSmall) {
            $destWidth = $srcWidth;
            $destHeight = $srcHeight;
        } elseif ($xRatio * $srcHeight < $maxHeight) {
            $destWidth = $maxWidth;
            $destHeight = ceil($xRatio * $srcHeight);
        } else {
            $destWidth = ceil($yRatio * $srcWidth);
            $destHeight = $maxHeight;
        }
        return array ($destWidth, $destHeight);
    }

    function addLogo($thumbWidth, $thumbHeight, &$thumbImg)
    {
        extract($this->logo);
        $logoImage = $this->loadImage($file, $logoWidth, $logoHeight);
        if ($vertPos == TI_POS_CENTER) {
            $yPos = ceil($thumbHeight / 2 - $logoHeight / 2 );
        } elseif ($vertPos == TI_POS_BOTTOM) {
            $yPos = $thumbHeight - $logoHeight;
        } else {
            $yPos = 0;
        }
        if ($horzPos == TI_POS_CENTER) {
            $xPos = ceil($thumbWidth / 2 - $logoWidth / 2);
        } elseif ($horzPos == TI_POS_RIGHT) {
            $xPos = $thumbWidth - $logoWidth;
        } else {
            $xPos = 0;
        }
        if (!imagecopy($thumbImg, $logoImage, $xPos, $yPos, 0, 0, $logoWidth, $logoHeight)) {
            trigger_error('Cannot copy the logo image', E_USER_ERROR);
        }
    }

    function addLabel($thumbWidth, $thumbHeight, &$thumbImg)
    {
        extract($this->label);
        list($r, $g, $b) = $this->parseColor($color);
        $colorId = imagecolorallocate($thumbImg, $r, $g, $b);
        $textBox = imagettfbbox($size, $angle, $font, $text);
        $textWidth = $textBox[2] - $textBox[0];
        $textHeight = abs($textBox[1] - $textBox[7]);
        if ($vertPos == TI_POS_TOP) {
            $yPos = 5 + $textHeight;
        } elseif ($vertPos == TI_POS_CENTER) {
            $yPos = ceil($thumbHeight / 2 - $textHeight / 2);
        } elseif ($vertPos == TI_POS_BOTTOM) {
            $yPos = $thumbHeight - $textHeight;
        }
        if ($horzPos == TI_POS_LEFT) {
            $xPos = 5;
        } elseif ($horzPos == TI_POS_CENTER) {
            $xPos = ceil($thumbWidth / 2 - $textWidth / 2);
        } elseif ($horzPos == TI_POS_RIGHT) {
            $xPos = $thumbWidth - $textWidth - 5;
        }
        imagettftext($thumbImg, $size, $angle, $xPos, $yPos, $colorId, $font, $text);
    }

    function outputThumbImage($destImage)
    {
        imageinterlace($destImage, $this->interlace);
        header('Content-type: ' . $this->destType);
        if ($this->destType == TI_JPEG) {
            imagejpeg($destImage, '', $this->jpegQuality);
        } elseif ($this->destType == TI_GIF) {
            imagegif($destImage);
        } elseif ($this->destType == TI_PNG) {
            imagepng($destImage);
        }
    }

    function saveThumbImage($imageFile, $destImage)
    {
        imageinterlace($destImage, $this->interlace);
        if ($this->destType == TI_JPEG) {
            imagejpeg($destImage, $this->destFile, $this->jpegQuality);
        } elseif ($this->destType == TI_GIF) {
            imagegif($destImage, $this->destFile);
        } elseif ($this->destType == TI_PNG) {
            imagepng($destImage, $this->destFile);
        }
    }

    function output()
    {
        $srcImage = $this->loadImage($this->srcFile, $srcWidth, $srcHeight);
        $destSize = $this->getThumbSize($srcWidth, $srcHeight);
        $destWidth = $destSize[0];
        $destHeight = $destSize[1];
        $destImage = imagecreatetruecolor($destWidth, $destHeight);
        if (!$destImage) {
            trigger_error('Cannot create final image', E_USER_ERROR);
        }
        imagecopyresampled($destImage, $srcImage, 0, 0, 0, 0, $destWidth, $destHeight, $srcWidth, $srcHeight);
        if ($this->logo['file'] != TI_NO_LOGO) {
            $this->addLogo($destWidth, $destHeight, $destImage);
        }
        if ($this->label['text'] != TI_NO_LABEL) {
            $this->addLabel($destWidth, $destHeight, $destImage);
        }
        if ($this->destFile == TI_STDOUT) {
            $this->outputThumbImage($destImage);
        } elseif ($this->destFile == TI_RESOURCE) {
            imagedestroy($srcImage);
            return $destImage;
        } else {
            $this->saveThumbImage($this->destFile, $destImage);
        }
        imagedestroy($srcImage);
        imagedestroy($destImage);
    }

}

?>