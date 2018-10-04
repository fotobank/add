<?php

/**
 * ImageBatchProcessor class, version 1.0 (for PHP >= 4.3)
 * (c) 2008 Vagharshak Tozalakyan <vagh{at}tozalakyan{dot}com>
 *
 * This class can be used to perform different kind of operations over a group
 * of images. It can proportionally resize images (create thumbnails), rotate
 * images, convert between different image formats, append textual labels and/or
 * small graphic watermarks to images, etc.
 *
 * Transformation parameters may be applied to all images in a directory or
 * separately to each image in a set - the images in source or destination sets
 * may be located in the same or different directories.
 *
 * The class also contains a traversal method which walks through a directory
 * and calls a callback function for each item. The method may be used, for
 * example, to rename all images (or other files) in a directory using
 * predefined naming template (photo01.jpg, photo02.jpg, ...).
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
 * @version  1.0
 * @author   Vagharshak Tozalakyan <vagh{at}tozalakyan{dot}com>
 * @license  http://www.opensource.org/licenses/mit-license.php
 */

define('IBP_IMAGE_REGEXP', '/^(.*)(\.jpg|\.jpeg|\.gif|\.png)$/is');
define('IBP_ALL_REGEXP', '/^(.*)$/is');

require_once 'class.ThumbnailImage.php';

class ImageBatchTransformation
{
    var $source = '';
    var $destination = '';
    var $format = TI_JPEG;
    var $jpegQuality = -1;
    var $interlace = TI_INTERLACE_OFF;
    var $maxWidth = 800;
    var $maxHeight = 600;
    var $fitToMax = false;
    var $logo = array();
    var $label = array();
    var $rotateAngle = 0;
    var $rotateBgColor = '#ffffff';
    var $replaceExisted = true;

    function ImageBatchTransformation()
    {
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

}

class ImageBatchProcessor
{
    var $thumbnail = null;
    var $extensions = array(TI_JPEG => '.jpg', TI_GIF => '.gif', TI_PNG => '.png');

    function ImageBatchProcessor()
    {
        $this->transform = new ImageBatchTransformation();
        $this->thumbnail = new ThumbnailImage();
    }

    function applyTransformation($transformObj, &$thumbnailObj)
    {
        $thumbnailObj->srcFile = $transformObj->source;
        $thumbnailObj->destFile = $transformObj->destination;
        $thumbnailObj->destType = $transformObj->format;
        $thumbnailObj->interlace = $transformObj->interlace;
        $thumbnailObj->jpegQuality = $transformObj->jpegQuality;
        $thumbnailObj->maxWidth = $transformObj->maxWidth;
        $thumbnailObj->maxHeight = $transformObj->maxHeight;
        $thumbnailObj->fitToMax = $transformObj->fitToMax;
        $thumbnailObj->logo = $transformObj->logo;
        $thumbnailObj->label = $transformObj->label;
        $thumbnailObj->rotateAngle = $transformObj->rotateAngle;
        $thumbnailObj->rotateBgColor = $transformObj->rotateBgColor;
    }

    function normalizePath($path)
    {
        $path = str_replace('\\', '/', trim($path));
        if (!empty($path) && substr($path, -1) != '/') {
            $path .= '/';
        }
        return $path;
    }

    function process($transformObj, $filter = IBP_IMAGE_REGEXP, $count = 0)
    {
        $srcDir = $this->normalizePath($transformObj->source);
        $destDir = $this->normalizePath($transformObj->destination);
        $this->applyTransformation($transformObj, $this->thumbnail);
        if (!($dir = opendir($srcDir))) {
            return false;
        }
        $i = 0;
        while (false !== ($f = readdir($dir))) {
            if ($f == '.' || $f == '..' || !preg_match($filter, $f)) {
                continue;
            }
            $ext = substr($f, strrpos($f, '.'));
            if ($count <= 0 || $i < $count) {
                $this->thumbnail->srcFile = $srcDir . $f;
                $this->thumbnail->destFile = $destDir . basename($f, $ext) . $this->extensions[$transformObj->format];
                if ($transformObj->replaceExisted || !file_exists($this->thumbnail->destFile)) {
                    $this->thumbnail->output();
                    $i++;
                }
            }
        }
        closedir($dir);
        return $i;
    }

    function processEx($transformArray)
    {
        foreach ($transformArray as $i => $transformObj) {
            $this->applyTransformation($transformObj, $this->thumbnail);
            if ($transformObj->replaceExisted || !file_exists($transformObj->destination)) {
                $this->thumbnail->output();
            }
        }
        return $i + 1;
    }

    function dirWalk($path, $callback, $filter = IBP_ALL_REGEXP)
    {
        $path = $this->normalizePath($path);
        $files = array();
        if (!($dir = opendir($path))) {
            return false;
        }
        while (false !== ($f = readdir($dir))) {
            if ($f == '.' || $f == '..' || !preg_match($filter, $f)) {
                continue;
            }
            $ext = substr($f, strrpos($f, '.'));
            $files[] = array(basename($f, $ext), $ext);
        }
        closedir($dir);
        $numFiles = sizeof($files);
        $l = strlen(strval($numFiles));
        foreach ($files as $i => $file) {
            $oldName = $file[0] . $file[1];
            $padded = str_pad(strval($i + 1), $l, '0', STR_PAD_LEFT);
            $newName = $callback($path, $i, $padded, $oldName, $file[0], $file[1]);
        }
        return $numFiles;
    }

}

?>