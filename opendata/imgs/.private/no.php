<?php
require("survey_lib.php");

if (! isset($_COOKIE['theme']) ) {
    send_image('no.png');
    exit();
} 

$user = $_COOKIE['theme'];

$db = initdb('.db/survey.db');
if (user_has_voted($db, $user)) {
    send_image('white.png');
} else {
    send_image('no.png');
}
?>
