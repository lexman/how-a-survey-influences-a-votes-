<?php
/*
 * The survey result affects an id to the user
 * when the user gets an id, the exposed result is affected to the user 
 * 
 * when the user clics on one of the 2 images (Yes / No)
 * 
 * if the user has already answered no buttons to vote
 * when the u
 * 
 * 
 * note how many times the user's seen the result before voting
 * 
 * 
 * 
 */
 
require("survey_lib.php");

function response_file($user_class) {    
    $pct = percent_from_class($user_class);
    if ($pct == null) {
        return 'white.png';
    } else {
        return "responses/response_$pct.png";
    }
}

if (isset($_COOKIE['theme'])) {
    $first_visit = 0; // because false is mapped to NULL
    $user = $_COOKIE['theme'];
} else {
    $first_visit = 1;
    $user = uniqid("green");
    setcookie('theme', $user, time() + 3600 * 24 * 30);
}

$ua = $_SERVER['HTTP_USER_AGENT'];
$referer = $_SERVER['HTTP_REFERER'];
$ip = $_SERVER['REMOTE_ADDR'];
$user_class = get_user_class($user, 13);

$db = initdb('.db/survey.db');
insert_visit($db, $user, $user_class, $first_visit, $ua, $referer, $ip);

force_no_cache();
send_image(response_file($user_class));

?>
