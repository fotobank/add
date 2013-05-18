<?php
/******************************************************************
   Projectname:   Automatic Keyword Generator Application Script
   Version:       0.3
   Author:        Ver Pangonilo <smp@limbofreak.com>
   Last modified: 26 July 2006
   Copyright (C): 2006 Ver Pangonilo, All Rights Reserved

   * GNU General Public License (Version 2, June 1991)
   *
   * This program is free software; you can redistribute
   * it and/or modify it under the terms of the GNU
   * General Public License as published by the Free
   * Software Foundation; either version 2 of the License,
   * or (at your option) any later version.
   *
   * This program is distributed in the hope that it will
   * be useful, but WITHOUT ANY WARRANTY; without even the
   * implied warranty of MERCHANTABILITY or FITNESS FOR A
   * PARTICULAR PURPOSE. See the GNU General Public License
   * for more details.

   Description:
   This class can generates automatically META Keywords for your 
   web pages based on the contents of your articles. This will 
   eliminate the tedious process of thinking what will be the best
   keywords that suits your article. The basis of the keyword
   generation is the number of iterations any word or phrase
   occured within an article. 
   
   This automatic keyword generator will create single words, 
   two word phrase and three word phrases. Single words will be
   filtered from a common words list.

Change Log:
===========
0.3 Ver Pangonilo 26 July 2006
==============================
Revised to show changes in class.

******************************************************************/


//assuming that your site contents is from a database.
//set the outbase of the database to $data.

$data =<<<EOF


 то в детстве не мечтал надеть платье как у «олушки, хрустальные туфельки и в этом красивом нар€де подойти и обн€ть принца? ¬ день свадьбы сбываютс€ все мечты, потому что этот день похож на сказку!
     ’отите сохранить его в пам€ти на долгие годы? ћы с радостью поможем вам в этом.  
                                             Ќаша видеостуди€ создаст дл€ вас:
    -  трогательный фильм знаменательных событий вашей жизни с применением
       новейших видеотехнологий  
    -  монтаж любого уровн€ сложности
    -  индивидуальный подход к каждому клиенту.

EOF;

//this the actual application.
include('class.autokeyword.php');

echo "<H1>Input - text</H1>";
echo $data;

$params['content'] = $data; //page content
//set the length of keywords you like
$params['min_word_length'] = 5;  //minimum length of single words
$params['min_word_occur'] = 2;  //minimum occur of single words

$params['min_2words_length'] = 3;  //minimum length of words for 2 word phrases
$params['min_2words_phrase_length'] = 10; //minimum length of 2 word phrases
$params['min_2words_phrase_occur'] = 2; //minimum occur of 2 words phrase

$params['min_3words_length'] = 3;  //minimum length of words for 3 word phrases
$params['min_3words_phrase_length'] = 10; //minimum length of 3 word phrases
$params['min_3words_phrase_occur'] = 2; //minimum occur of 3 words phrase

$keyword = new autokeyword($params, "iso-8859-1");

echo "<H1>Output - keywords</H1>";

echo "<H2>words</H2>";
echo $keyword->parse_words();
echo "<H2>2 words phrase</H2>";
echo $keyword->parse_2words();
echo "<H2>2 words phrase</H2>";
echo $keyword->parse_3words();

echo "<H2>All together</H2>";
echo $keyword->get_keywords();
?>
