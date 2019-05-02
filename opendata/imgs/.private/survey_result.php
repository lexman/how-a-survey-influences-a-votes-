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

function response_file($pct) {
    return "responses/response_$pct.png";
}


if (isset($_COOKIE['color'])) {
    $already_seen = true;
    $user = $_COOKIE['color'];
} else {
    $already_seen = false;
    $user = uniqid("green");
    setcookie('color', $user, time() + 3600 * 24 * 30);
}

$user_class = get_user_class($user, 13);
$ua = $_SERVER['HTTP_USER_AGENT'];
$referer = $_SERVER['HTTP_REFERER'];
$ip = $_SERVER['REMOTE_ADDR'];

$db = initdb('.db/survey.db');
insert_visit($db, $user, $user_class, $already_seen, $ua, $referer, $ip);

$pct = percent_from_class($user_class);
force_no_cache();
send_image(response_file($pct));

?>
