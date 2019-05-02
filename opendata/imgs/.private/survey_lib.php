<?php

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
        $db->exec('CREATE TABLE vote (dt STRING, user STRING, user_class INTEGER, already_seen INTEGER, user_agent STRING, referer STRING, ip STRING, vote STRING)');
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

?>
