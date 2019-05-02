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
 
function initdb($dbname) {
    $create_tables = ! file_exists($dbname);
    $db = new PDO("sqlite:$dbname");
    // Set errormode to exceptions
    $db->setAttribute(PDO::ATTR_ERRMODE, 
                            PDO::ERRMODE_EXCEPTION);
    if ( ! $db) {
        terminate($sqliteerror);
    }
    if ($create_tables) {
        $db->exec('CREATE TABLE user_visit (dt STRING, user STRING, user_class INTEGER, already_seen INTEGER, user_agent STRING, referer STRING, ip STRING)');
    }
    return $db;
}

function insert_visit($db, $user, $user_class, $already_seen, $ua, $referer, $ip) {
    $insert = 'INSERT INTO user_visit (dt, user, user_class, already_seen, user_agent, referer, ip) VALUES (DATETIME("now"), :user, :user_class, :already_seen, :ua, :referer, :ip)';
    $stmt = $db->prepare($insert);
    $nb_lines = $stmt->execute(array($user, $user_class, $already_seen, $ua, $referer, $ip));
    if ($nb_lines === false) {
        print_r($db->errorInfo());
        die("Unexpected error");
    }
}

function send_image($filename) {
    header('Content-Type: image/jpeg');
    header('Content-Length: ' . filesize($filename));
    readfile($filename);
}

function force_no_cache() {
    header('ETag: "' . uniqid("20c38-") . '"');
    header('Cache-Control: no-cache, must-revalidate');
}

$PCTS = array(4, 15, 28, 39, 44, 49, 51, 56, 61, 72, 85, 96);
function get_user_class($user) {
    global $PCTS;
    $nbclasses = sizeof($PCTS) + 1;
    if (substr($user, 0, strlen("green")) != "green") {
        die("Bad user" . $user);
    }
    $hex = substr($user, strlen("green"));
    $user_id_dec = hexdec($hex);
    return $user_id_dec % $nbclasses;
}

function percent_from_class($user_class) {
    global $PCTS;
    if ($user_class >= sizeof($PCTS)) {
        return null;
    }
    return $PCTS[$user_class];
}

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
