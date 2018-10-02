<?php
       use dump_r\Core;

       if (!function_exists('dump_r')) {
              function dump_r($raw, $ret = false, $html = true, $depth = 1e3, $expand = 1e3) {
                     return Core::dump_r($raw, $ret, $html, $depth, $expand);
              }
       }
       if (!function_exists('dump_d')) {
              function dump_d($obj) {
                     return dump_r(iconv("UTF-8", "WINDOWS-1251", print_r($obj, true)));
              }
       }
