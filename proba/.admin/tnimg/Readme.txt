ThumbnailImage 1.0.1 - Readme.txt (April 5, 2005)
http://vagh.armdex.com/tnimg

********************************************************
CONTENTS

1. Introduction
2. Features Listing
3. License Agreement
4. How to Use
5. Bugs Reporting
6. Author Contacts

********************************************************



1. INTRODUCTION

ThumbnailImage is a class written in PHP that allow you
to create with easy thumbnail galleries and to perform
different operations over images. Description of methods
and properties can be found in the same directory with
this file.


2. FEATURES LISTING

 - Working with all graphic formats supported in your
version of GD library in input. Creating JPEG, PNG and
GIF in output.

 - Converting images from any of GD supported formats to
JPEG, PNG or GIF.

 - Resizing images proportionally, fitting to specified
bounding rectangle.

 - Dynamically adding text labels in any font, size and
color and logo images in any supported format.
Positioning labels and logos to any corner of created
image.

 - Processing output directly to the browser or into the
disc files.


Version 1.0.1

Now it is possible to load image files by url.
Thanks to Luis Larrateguy for the idea.


3. LICENSE AGREEMENT

This code is released under GNU/LGPL license. It is free,
so you can use it at no cost.

However, if you release a script, an application, a
library or any kind of code using ThumbnailImages (or a
part of it), you must:

 - Indicate in the documentation (or a readme file),
that your work uses ThumbnailImage Class, and make a
reference to the author and the web site;

 - Give the ability to the final user to update the
class.

I will also appreciate that you send me an e-mail, just
to be aware that someone is using ThumbnailImage.

Warning!!!

This class and the associated files are non commercial,
non professional work. It should not have unexpected
results. However, if any damage is caused by this
software the author can not be responsible. The use of
this software is at the risk of the user.


4. HOW TO USE

1) Copy TNIMG.LIB.PHP somewhere on your server.

2) Include the library to your script:

  require_once ( '/tnimg.lib.php' );

3) Create the ThumbnailImage object:

  $ti = new ThumbnailImage ( );

4) Specify values for class properties:

  $ti->src_file = 'images/mypic.jpg';
  $ti->dest_type = THUMB_JPEG;
  $ti->dest_file = STDOUT;
  $ti->max_width = 300;
  $ti->max_height = 300;

5) Call Output() to proceed:

  $ti->Output ( );

Please read more detailed description of class methods
and properties in HELP files.


5. BUGS REPORTING

Please publish bugs reports here:
http://vagh.armdex.com/tnimg/forum.php


6. AUTHOR CONTACTS

This software was written by author on its leasure time.

E-mail: vagh@armdex.com

Phone numbers:

(+ 374 1) 58 88 75 (home)
(+ 374 9) 49 17 34 (mobile)

Postal address:

Vagharshak Tozalakyan,
Proshian str. 3/2,
Yerevan 19, ARMENIA.