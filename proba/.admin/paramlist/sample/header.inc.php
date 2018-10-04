<?php

  // Include class definition
  require_once('../paramlist.class.php');

  // Default values of parameters
  $init_params = array('lang'=>'english', 'skin'=>'yellow');

  // Create class object, session will be opened automatically, because the
  // second parameter of constructor is TRUE, if you want to call session_start()
  // by yourself than make it FALSE.
  $pl = new ParamList($init_params, TRUE);

  // Cookie expires after 10 days
  $pl->cookie_expired = 10 * 24 * 3600;

  // Important!!! No spaces before calling Proceed!
  $pl->Proceed();

  // Read all available languages
  $languages = array();
  if ($hndl = opendir('languages'))
  {
    while ($fname = readdir($hndl))
    {
      if (is_file('languages/' . $fname) && substr($fname, -8) == '.inc.php')
      {
        $languages[] = substr($fname, 0, -8);
      }
    }
    closedir($hndl);
  }

  // Read all available skins
  $skins = array();
  if ($hndl = opendir('skins'))
  {
    while ($fname = readdir($hndl))
    {
      if (is_file('skins/' . $fname) && substr($fname, -4) == '.css')
      {
        $skins[] = substr($fname, 0, -4);
      }
    }
    closedir($hndl);
  }

  // Check if the value of active language or skin is wrong.
  if (!in_array($pl->params['lang'], $languages))
  {
    $pl->params['lang'] = $init_params['lang'];
  }
  if (!in_array($pl->params['skin'], $skins))
  {
    $pl->params['skin'] = $init_params['skin'];
  }

  // Include language specific strings.
  require_once('languages/' . $pl->params['lang'] . '.inc.php');

  // Current page
  $page = $_SERVER['PHP_SELF'];

?>

<html>
<head>
<meta http-equiv="Content-type" content="text/html; charset=windows-1251" />
<title><?php echo $l_title; ?></title>
<link rel="stylesheet" href="skins/<?php echo $pl->params['skin']; ?>.css" type="text/css" />
</head>
<body>

<?php

  // Print language link
  if ($pl->params['lang'] == 'english')
  {
    echo sprintf($l_change_lang, '<a href="' . $page . '?lang=russian">Russian</a>');
  }
  else
  {
    echo sprintf($l_change_lang, '<a href="' . $page . '?lang=english">English</a>');
  }
  echo '<br />';

  // Print skin link
  if ($pl->params['skin'] == 'yellow')
  {
    echo sprintf($l_change_skin, '<a href="' . $page . '?skin=blue">Blue</a>');
  }
  else
  {
    echo sprintf($l_change_skin, '<a href="' . $page . '?skin=yellow">Yellow</a>');
  }
  echo '<hr />';

?>