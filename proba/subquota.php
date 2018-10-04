<?php

/*********************************************************************
* subquota.php [version 0.1]
*
* Author: Ryan Caught (ryan@gu-ru.net)
* Created: 2001-11-16 15:03
* Revised: 2002-01-11 20:18
*
* Purpose: To impose makeshift disk quotas on subdirectories.
*
* Script Usage and Disclaimer: Please read the README @
* http://www.gu-ru.net/scripts/subquota/
*
* Released under the terms of the GNU General Public License.
* This script uses code from DiskSpace 0,23.
*
* Latest version available at http://www.gu-ru.net/scripts/subquota/.
*********************************************************************/

/*********************************************************************
* VARIABLES
*********************************************************************/

$path_to = "/home/yoursite/public_html/";  // A default path of your choosing
$admin_name = "Your Name";                 // Your name
$admin_email = "you@your.domain";          // Your email address
$default_space = 20;                       // A default disk quota for user accounts (mb)
$p_over = 90;                              // At this percentage of disk space usage (or over) an email shall be sent to you

// Array of user directories and corresponding disk quotas
// Change values to suite your directories and quotas

$uu = array (
    $path_to . "dir1/" => $default_space,
    $path_to . "dir2/" => $default_space,
    $path_to . "dir3/" => $default_space,
    $path_to . "dir4/" => $default_space,
);

/*********************************************************************
* SCRIPT
*********************************************************************/

// Checks the amount of space used and compares against the amount designated

foreach($uu as $u_dir => $u_space)
{
    exec("du -s $u_dir", $du);
    $space_taken = split(" ", $du[0]);
    $space_taken = $space_taken[0] / 1024;
    $space_left = $u_space - $space_taken;
    $p = $u_space / 100;
    $p_space_taken = round($space_taken / $p);

// If the space used by the user is over the allowed limit send an email

    if ($p_space_taken >= $p_over)
    {
        // Subject
        
		$u_sub = str_replace ($path_to, "../", $u_dir);
        $subject = "Disk Usage - " . $u_sub;

        // Message

        $message .= $admin_name . ",\n";
        $message .= "A user account at \"" . $u_dir . "\" has reached " . $p_space_taken . "% of its total disk quota.\n\n";
        $message .= "The disk quota you set for this account was " . make_me_pretty($u_space) . "mb.";
        $message .= "  " . make_me_pretty($space_taken) . "mb has been used.\n\n";
        $message .= "Please take action to ensure that this account complies to its disk quota.";
        $message .= "  You may like to consider one or more of the following actions.\n\n";
        $message .= "- Disable the users account\n- Warn the user of their situation\n- Increase the disk quota for the users account\n\n";
        $message .= "A summary of the current users situation is printed below for your convenience.\n\n";
        $message .= "----------\nUser Directory - " . $u_dir . "\n";
        $message .= "Space Allocated - " . $u_space . "mb\n";
        $message .= "Space Used - " . make_me_pretty($space_taken) . "mb\n";
        $message .= "Space Left - " . make_me_pretty($space_left) . "mb\n";
        $message .= "----------\n\nSubQuota [version 0.1]\nryan@gu-ru.net\nhttp://www.gu-ru.net/";

        // headers

        $headers .= "From: SubQuota <ryan@gu-ru.net>\n";
        $headers .= "X-Sender: <ryan@gu-ru.net>\n";
        $headers .= "X-Mailer: PHP\n";
        $headers .= "X-Priority: 1\n";
        $headers .= "Return-Path: <" . $admin_email . ">\n";  // Return path for errors

        // Send

        mail($admin_email, $subject, $message, $headers);
    }
    else
    {
    }
unset ($u_dir, $p_space_taken, $u_space, $space_taken, $space_left, $subject, $message, $headers, $du, $p);
}

// Function for formatting numbers

function make_me_pretty($tal)
{
    if (ereg("\.", $tal))                            // Example: $tal = 12.2547821
    {
        $tal = split("\.", $tal);                    // $tal[0] = 12 and $tal[1] = 2547821
        $tal[1] = substr($tal[1], 0, 2);             // $tal[1] = 25
        $ciffer1 = substr($tal[1], 0, 1);            // $ciffer1 = 2
        $ciffer2 = substr($tal[1], 1, 2);            // $ciffer2 = 5
        if ($ciffer2 >= 5) $ciffer1 = $ciffer1 + 1;  // $ciffer1 now becomes 3
        $tal = "$tal[0].$ciffer1";                   // $tal is now 12.3
    }
    return $tal;
}

?>