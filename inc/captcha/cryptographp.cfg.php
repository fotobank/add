<?php

// -------------------------------------
// ������������ ������������
// -------------------------------------

$cryptwidth  = 120;  // Largeur du cryptogramme (en pixels)
$cryptheight = 38;   // Hauteur du cryptogramme (en pixels)

$bgR  = 231;         // ���� ���� � ������� RGB: Red (0->255)
$bgG  = 225;         // ���� ���� � ������� RGB: Green (0->255)
$bgB  = 227;         // ���� ���� � ������� RGB: Blue (0->255)

$bgclear = true;     // ���������� ��� (true/false)
                     // ������������� ������ ��� PNG

$bgimg = '';                 // � ������������ ��� ����� ����
                             // PNG, GIF ��� JPG. �������� ���� �����������
                             // ������: $fondimage = 'photo.gif';
				                 // ����������� ����� �������� ������
                             // ����� ���������� � ������������.
                             // ���� ������� ��������� ����� -
                             // ��� ����� ���� ������
                             // �� ��������� �������� r�pertoire

$bgframe = false;    // ��������� ����� (true/false)


// ----------------------------
// Configuration des caract�res
// ----------------------------

// Couleur de base des caract�res

$charR = 0;     // Couleur des caract�res au format RGB: Red (0->255)
$charG = 0;     // Couleur des caract�res au format RGB: Green (0->255)
$charB = 0;     // Couleur des caract�res au format RGB: Blue (0->255)

$charcolorrnd = true;      // Choix al�atoire de la couleur. ����� �����.
$charcolorrndlevel = 2;    // Niveau de clart� des caract�res si choix al�atoire (0->4)
                           // 0: Aucune s�lection  ���
                           // 1: Couleurs tr�s sombres (surtout pour les fonds clairs)  ����� ������ ����� (�������� ��� �������� ����)
                           // 2: Couleurs sombres  ������ �����
                           // 3: Couleurs claires   ������� �����
                           // 4: Couleurs tr�s claires (surtout pour fonds sombres)  ����� ����� ����� (�������� ��� ������ �����)

$charclear = 0;   // Intensit� de la transparence des caract�res (0->127)
                  // 0=opaques; 127=invisibles
	                // interessant si vous utilisez une image $bgimg
	                // Uniquement si PHP >=3.2.1

// Polices de caract�res

//$tfont[] = 'Alanden_.ttf';       // Les polices seront al�atoirement utilis�es.
//$tfont[] = 'bsurp___.ttf';       // Vous devez copier les fichiers correspondants
//$tfont[] = 'ELECHA__.TTF';       // sur le serveur.
$tfont[] = 'luggerbu.ttf';         // Ajoutez autant de lignes que vous voulez
//$tfont[] = 'RASCAL__.TTF';       // Respectez la casse !
//$tfont[] = 'SCRAWL.TTF';
//$tfont[] = 'WAVY.TTF';


// Caracteres autoris�s
// Attention, certaines polices ne distinguent pas (ou difficilement) les majuscules
// et les minuscules. Certains caract�res sont faciles � confondre, il est donc
// conseill� de bien choisir les caract�res utilis�s.

$charel = 'ABCDEFGHKLMNPRTWXYZ234569';       // Caract�res autoris�s

$crypteasy = false;       // Cr�ation de cryptogrammes "faciles � lire" (true/false)
                         // compos�s alternativement de consonnes et de voyelles.

$charelc = 'BCDFGHKLMNPRTVWXZ';   // Consonnes utilis�es si $crypteasy = true
$charelv = 'AEIOUY';              // Voyelles utilis�es si $crypteasy = true

$difuplow = false;          // Diff�rencie les Maj/Min lors de la saisie du code (true, false)

$charnbmin = 4;         // ����������� ����� �������� �� ��������
$charnbmax = 5;         // ������������ ����� �������� �� ��������

$charspace = 22;        // �������� �������� ��������� ����� ��������� � ��������.
$charsizemin = 18;      // �����������  ������ ��������.
$charsizemax = 18;      // ������������ ������ ��������.

$charanglemax  = 20;     // ������������ ���� �������� �������  (0-360)
$charup   = false;        // D�placement vertical al�atoire des caract�res (true/false)

// Effets suppl�mentaires

$cryptgaussianblur = true; // �������������� �������� ����������� �����������: ����� ������ �������� (true/false)
                            // ������ si PHP >= 5.0.0
$cryptgrayscal = false;     // �������������� �������� ����������� ������ (true/false)
                            // ������ si PHP >= 5.0.0

// ----------------------
// ��������� ����
// ----------------------

$noisepxmin = 4;      // ���: Nb minimum de pixels al�atoires
$noisepxmax = 4;      // ���: Nb maximum de pixels al�atoires

$noiselinemin = 4;     // ���: Nb minimum de lignes al�atoires
$noiselinemax = 4;     // ���: Nb maximum de lignes al�atoires

$nbcirclemin = 4;      // ���: Nb ����������� ���������� ������ al�atoires
$nbcirclemax = 4;      // ���: ������������ ����� ������ al�atoires

$noisecolorchar  = 3;  // ���: ��������� ����� ��������, �����, �����:
                       // 1: ���� ������� caract�res des caract�res
                       // 2: ���� ����
                       // 3: ���� ��������� ����
                       
$brushsize = 1;        // ������ ������ princeaiu (� ��������)
                        // 1 � 25 (��� ���� �������� ����� �������� �
                        // ���������� ������ ������� �� ��������� ������� PHP / GD)
                        // �� �������� �� ������ ������������� PHP / GD

$noiseup = true;      // ��� est-il par dessus l'ecriture (true) ou en dessous (false)

// --------------------------------
// ������������ ������� � ������������ � ����������
// --------------------------------

$cryptformat = "png";   //  ������ ����� ����������� "GIF", "PNG" ��� "JPG"
				                // ���� �� ������ ���������� �����, ����������� "PNG" (�� "GIF")
				                // Attention certaines versions de la bibliotheque GD ne gerent pas GIF !!!

$cryptsecure = "sha1";    // M�thode de crytpage utilis�e: "md5", "sha1" ou "" (aucune)
                         // "sha1" seulement si PHP>=4.2.0
                         // Si aucune m�thode n'est indiqu�e, le code du cyptogramme est stock� 
                         // en clair dans la session.
                       
$cryptusetimer = 0;        //������� (� ��������) ����� ���, �������� �������������� ����� ������������


$cryptusertimererror = 2;  // ���� ����������� ����� �� �����������:
                           // 1: ������, �� ������������ �����������.
	                        // 2: ��������� ����������� "images/erreur2.png"
                           // 3: �������� ��������� � $ ����� �� ����� ������ cryptusetimer (�������� �������� �� ����-���
                           //��� �� ����������, ������� ����� PHP ������� ����� 30 ������)
                           //��� ��. "max_execution_time" ���������� � ����� ������������ PHP

$cryptusemax = 1000;  // ������������ ���������� ��� ������������ ����� �������� ������������
                      // Si d�passement, l'image renvoy�e est "images/erreur1.png"
                      // PS: Par d�faut, la dur�e d'une session PHP est de 180 mn, sauf si 
                      // l'hebergeur ou le d�veloppeur du site en ont d�cid� autrement... 
                      // Cette limite est effective pour toute la dur�e de la session. 
                      
$cryptoneuse = false;  // Si vous souhaitez que la page de verification ne valide qu'une seule    ���� �� ������, ����� �������� �������� ���� ������
                       // fois la saisie en cas de rechargement de la page indiquer "true".       ����� ����� ��� ������������ �������� ��������� "true".
                       // Sinon, le rechargement de la page confirmera toujours la saisie.        � ��������� ������ ������������ �������� ������ ����� ����������� ����.
                      
?>
