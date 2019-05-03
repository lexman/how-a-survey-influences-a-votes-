<?php

require("survey_lib.php");

function redirect_and_exit() {
    header('Location: https://www.data.gouv.fr/fr/datasets/carte-de-ma-commune/'); 
    die("");
}

function user_was_forged($db, $user) {
    return ! user_has_first_visit($db, $user);
}

if ( (! isset($_COOKIE['theme'])) || (! isset($_GET['vote'])) ) {
    redirect_and_exit();
}

$user = $_COOKIE['theme'];
$user_class = get_user_class($user, 13);
$ua = $_SERVER['HTTP_USER_AGENT'];
$referer = $_SERVER['HTTP_REFERER'];
$ip = $_SERVER['REMOTE_ADDR'];
$vote = $_GET['vote'];
if ( ($vote != 'yes') && ($vote != 'no') ) {
    redirect_and_exit();
}

$db = initdb('.db/survey.db');

if (user_was_forged($db, $user)) {
    redirect_and_exit();
}
if (user_has_voted($db, $user)) {
    redirect_and_exit();
}
register_vote($db, $user, $user_class, $ua, $referer, $ip, $vote);
redirect_and_exit();
?>
