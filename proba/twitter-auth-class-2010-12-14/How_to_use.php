<?php

/*
First, get your Application's "conusmer key" & "consumer secret" from
http://dev.twitter.com
& put them in twitterWrapper.php
*/
    session_start();

    // authenticate twitter users

    require_once 'twitterWrapper.php';
    $myT = new twitterWrapper();
    $myT->authenticate();

    // security check done.
?>

To print the user's Twitter username, you can call:

<?php echo "Thanks for authenticating yourself, " . $myT->getIdentifier(); ?>