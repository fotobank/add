<?php

// -------------------------------------
// Конфигурация криптограммы
// -------------------------------------

$cryptwidth  = 120;  // Largeur du cryptogramme (en pixels)
$cryptheight = 38;   // Hauteur du cryptogramme (en pixels)

$bgR  = 231;         // Цвет фона в формате RGB: Red (0->255)
$bgG  = 225;         // Цвет фона в формате RGB: Green (0->255)
$bgB  = 227;         // Цвет фона в формате RGB: Blue (0->255)

$bgclear = true;     // прозрачный фон (true/false)
                     // Действительно только для PNG

$bgimg = '';                 // В криптограмме фон может быть
                             // PNG, GIF или JPG. Показать файл изображения
                             // Пример: $fondimage = 'photo.gif';
				                 // Изображение будет изменять размер
                             // чтобы уместиться в криптограмму.
                             // если заданно несколько фонов -
                             // фон будет взят наугат
                             // из доступных заданных rйpertoire

$bgframe = false;    // Добавляет рамку (true/false)


// ----------------------------
// Configuration des caractиres
// ----------------------------

// Couleur de base des caractиres

$charR = 0;     // Couleur des caractиres au format RGB: Red (0->255)
$charG = 0;     // Couleur des caractиres au format RGB: Green (0->255)
$charB = 0;     // Couleur des caractиres au format RGB: Blue (0->255)

$charcolorrnd = true;      // Choix alйatoire de la couleur. выбор цвета.
$charcolorrndlevel = 2;    // Niveau de clartй des caractиres si choix alйatoire (0->4)
                           // 0: Aucune sйlection  нет
                           // 1: Couleurs trиs sombres (surtout pour les fonds clairs)  очень темные цвета (особенно для светлого фона)
                           // 2: Couleurs sombres  Темные цвета
                           // 3: Couleurs claires   Светлые цвета
                           // 4: Couleurs trиs claires (surtout pour fonds sombres)  очень яркие цвета (особенно для темных фонов)

$charclear = 0;   // Intensitй de la transparence des caractиres (0->127)
                  // 0=opaques; 127=invisibles
	                // interessant si vous utilisez une image $bgimg
	                // Uniquement si PHP >=3.2.1

// Polices de caractиres

//$tfont[] = 'Alanden_.ttf';       // Les polices seront alйatoirement utilisйes.
//$tfont[] = 'bsurp___.ttf';       // Vous devez copier les fichiers correspondants
//$tfont[] = 'ELECHA__.TTF';       // sur le serveur.
$tfont[] = 'luggerbu.ttf';         // Ajoutez autant de lignes que vous voulez
//$tfont[] = 'RASCAL__.TTF';       // Respectez la casse !
//$tfont[] = 'SCRAWL.TTF';
//$tfont[] = 'WAVY.TTF';


// Caracteres autorisйs
// Attention, certaines polices ne distinguent pas (ou difficilement) les majuscules
// et les minuscules. Certains caractиres sont faciles а confondre, il est donc
// conseillй de bien choisir les caractиres utilisйs.

$charel = 'ABCDEFGHKLMNPRTWXYZ234569';       // Caractиres autorisйs

$crypteasy = false;       // Crйation de cryptogrammes "faciles а lire" (true/false)
                         // composйs alternativement de consonnes et de voyelles.

$charelc = 'BCDFGHKLMNPRTVWXZ';   // Consonnes utilisйes si $crypteasy = true
$charelv = 'AEIOUY';              // Voyelles utilisйes si $crypteasy = true

$difuplow = false;          // Diffйrencie les Maj/Min lors de la saisie du code (true, false)

$charnbmin = 4;         // минимальное число символов на картинке
$charnbmax = 5;         // максимальное число символов на картинке

$charspace = 22;        // хранится значение интервала между символами в пикселях.
$charsizemin = 18;      // минимальный  размер символов.
$charsizemax = 18;      // максимальный размер символов.

$charanglemax  = 20;     // Максимальный угол поворота символа  (0-360)
$charup   = false;        // Dйplacement vertical alйatoire des caractиres (true/false)

// Effets supplйmentaires

$cryptgaussianblur = true; // Преобразования конечное изображение размыванием: Гаусс добрым способом (true/false)
                            // только si PHP >= 5.0.0
$cryptgrayscal = false;     // Преобразования конечное изображение серого (true/false)
                            // только si PHP >= 5.0.0

// ----------------------
// Настройка шума
// ----------------------

$noisepxmin = 4;      // Шум: Nb minimum de pixels alйatoires
$noisepxmax = 4;      // Шум: Nb maximum de pixels alйatoires

$noiselinemin = 4;     // Шум: Nb minimum de lignes alйatoires
$noiselinemax = 4;     // Шум: Nb maximum de lignes alйatoires

$nbcirclemin = 4;      // Шум: Nb Минимальное количество кругов alйatoires
$nbcirclemax = 4;      // Шум: Максимальное число кругов alйatoires

$noisecolorchar  = 3;  // Шум: Написание цвета пикселей, линии, круги:
                       // 1: Цвет почерка caractиres des caractиres
                       // 2: Цвет фона
                       // 3: Цвет Случайный цвет
                       
$brushsize = 1;        // Размер шрифта princeaiu (в пикселях)
                        // 1 а 25 (чем выше значения могут привести к
                        // Внутренняя ошибка сервера на некоторых версиях PHP / GD)
                        // Не работает на старых конфигурациях PHP / GD

$noiseup = true;      // Шум est-il par dessus l'ecriture (true) ou en dessous (false)

// --------------------------------
// Конфигурация системы и безопасности и безопасной
// --------------------------------

$cryptformat = "png";   //  Формат файла изображения "GIF", "PNG" или "JPG"
				                // Если Вы хотите прозрачным фоном, используйте "PNG" (не "GIF")
				                // Attention certaines versions de la bibliotheque GD ne gerent pas GIF !!!

$cryptsecure = "sha1";    // Mйthode de crytpage utilisйe: "md5", "sha1" ou "" (aucune)
                         // "sha1" seulement si PHP>=4.2.0
                         // Si aucune mйthode n'est indiquйe, le code du cyptogramme est stockй 
                         // en clair dans la session.
                       
$cryptusetimer = 0;        //Времени (в секундах) перед тем, способны регенерировать новые криптограммы


$cryptusertimererror = 2;  // Если минимальное время не соблюдается:
                           // 1: Ничего, не возвращаться изображения.
	                        // 2: Отправить изображение "images/erreur2.png"
                           // 3: сценарий находится в $ паузу во время секунд cryptusetimer (обратите внимание на тайм-аут
                           //    на недостаток, который режет PHP скрипты через 30 секунд)
                           //    см. "max_execution_time" переменную в вашей конфигурации PHP

$cryptusemax = 1000;  // Максимальное количество раз пользователь может выводить криптограммы
                      // Si dйpassement, l'image renvoyйe est "images/erreur1.png"
                      // PS: Par dйfaut, la durйe d'une session PHP est de 180 mn, sauf si 
                      // l'hebergeur ou le dйveloppeur du site en ont dйcidй autrement... 
                      // Cette limite est effective pour toute la durйe de la session. 
                      
$cryptoneuse = false;  // Si vous souhaitez que la page de verification ne valide qu'une seule    Если вы хотите, чтобы страница проверки была только
                       // fois la saisie en cas de rechargement de la page indiquer "true".       После ввода при перезагрузки страницы указывают "true".
                       // Sinon, le rechargement de la page confirmera toujours la saisie.        В противном случае перезагрузки страницы всегда будет подтвердить ввод.
                      
?>
