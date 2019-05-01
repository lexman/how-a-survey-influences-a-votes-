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
        $db->exec('CREATE TABLE hit (dt STRING, user STRING, already_seen INTEGER, user_agent STRING, referer STRING, ip STRING)');
    }
    return $db;
}

function insert_hit($db, $user, $already_seen, $ua, $referer, $ip) {
    $insert = 'INSERT INTO hit (dt, user, already_seen, user_agent, referer, ip) VALUES (DATETIME("now"), :user, :already_seen, :ua, :referer, :ip)';
    $stmt = $db->prepare($insert);
    $nb_lines = $stmt->execute(array($user, $already_seen, $ua, $referer, $ip));
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

header('Location: https://www.data.gouv.fr/fr/datasets/carte-de-ma-commune/'); 
?>
