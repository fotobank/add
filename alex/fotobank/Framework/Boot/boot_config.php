<?php
       /**
        * Framework Component
        *
        * @framework  ALEX_FOTOBANK
        * @author  Alex Jurii <jurii@mail.ru>
        *
        * The MIT License (MIT)
        *
        * Copyright (c) 2016
        *
        * Permission is hereby granted, free of charge, to any person obtaining a copy
        * of this software and associated documentation files (the "Software"), to deal
        * in the Software without restriction, including without limitation the rights
        * to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
        * copies of the Software, and to permit persons to whom the Software is
        * furnished to do so, subject to the following conditions:
        *
        * The above copyright notice and this permission notice shall be included in all
        * copies or substantial portions of the Software.
        *
        * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
        * IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
        * FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
        * AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
        * LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
        * OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE
        * SOFTWARE.
        */
       version_compare(phpversion(), '7.1', '>=') === true or die ('PHP 7.1 is required, you have '.phpversion());
       defined('DEBUG_MODE') or define('DEBUG_MODE', true);
       // use for production mode 'production' or for developer 'developer'
       defined('APP_MODE') or define('APP_MODE', DEBUG_MODE ? 'developer' : 'production');
       defined('DEBUG_LOG') or define('DEBUG_LOG', true);
       defined('PATH_SEPARATOR') or define('PATH_SEPARATOR', getenv('COMSPEC') ? ';' : ':');
       defined('DS') or defined('DS') or define('DS', DIRECTORY_SEPARATOR);
       defined('SALT') or define('SALT', 'qE3!nT^(gj)+?|6~d&.ru|');
       // Paths
       /**
        * путь к корневой папке сайта
        */
       defined('ROOT_PATH') or define('ROOT_PATH', dirname(__DIR__, 4) . DS);
       /**
        * путь к framework
        */
       defined('SYS_DIR') or define('SYS_DIR', dirname(__DIR__) . DS);
       /**
        * путь к сайту
        */
       defined('SITE_DIR') or define('SITE_DIR', dirname(__DIR__, 2) . DS . 'Site' . DS);
       // защита страницы
       defined('ACCESS') or define('ACCESS', true);
       // директории сканирования конфигов
       defined('CONFIGS_DEFINE_PATH') or define('CONFIGS_DEFINE_PATH', SYS_DIR  . 'Configs'.DS.'define'.DS);
       defined('CONFIGS_SITE_PATH') or define('CONFIGS_SITE_PATH', SITE_DIR . 'Configs'.DS.'define'.DS);

       define('CHARSET', 'cp1251');

