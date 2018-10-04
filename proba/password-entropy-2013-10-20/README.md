Password Entropy Estimator
==========================

Copyright (c) 2013, Peter Kahl. All rights reserved.

[https://github.com/peterkahl/password-entropy-estimator](https://github.com/peterkahl/password-entropy-estimator)

About
=====

Estimates entropy of a password.

Usage Example
=============

```php
<?php

$password = 'McF-GU*".k9B[';

require 'class.password-entropy-estimator.php';
$ent = new password_entropy_estimator;
echo $ent->entropy($password); // 85 bits

?>
```

License
=======

This program is free software: you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation, either version 3 of the License, or
(at your option) any later version.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with this program.  If not, see [http://www.gnu.org/licenses/](http://www.gnu.org/licenses/).

Change Log
==========

1.0.0 ..... 2012-10-13
	Initial release

