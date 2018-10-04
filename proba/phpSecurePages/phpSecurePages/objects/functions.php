<?php

// functions and libraries
define('FUNCTIONS_LOADED', true);

function admEmail() {
        // create administrators email link
        global $admEmail;
        return("<A HREF='mailto:$admEmail'>$admEmail</A>");
        }

function is_in_array($needle, $haystack) {
        // check if the value of $needle exist in array $haystack
        if ($needle && $haystack) {
                return(in_array($needle, $haystack));
                }
        else return(false);
        }
?>
