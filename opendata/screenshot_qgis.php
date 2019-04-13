<?php

function getOrCreateDb() {
    $dbname = './.private/hits.db';
    $create_tables = ! file_exists($dbname);
    echo "8";
    $db = sqlite_open($dbname);
    echo "8";
    $db = new SQLiteDatabase($dbname);
    echo "8";
    echo "8";
    if ($create_tables) {
        $db->query('CREATE TABLE hit (dt, user, already_seen)');
    }
    return $db;
}

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

if (isset($_COOKIE['color'])) {
    $already_seen = true;
    $user = $_COOKIE['color'];
    echo "15";
} else {
    $already_seen = false;
    $user = uniqid("green");
    setcookie('color', $user, time() + 3600 * 24 * 30);
    echo "19";
}
$ua = $_SERVER['HTTP_USER_AGENT'];
$referer = $_SERVER['HTTP_REFERER'];
$ip = $_SERVER['REMOTE_ADDR'];

$db = initdb('./.private/hits.db');

$sql = "SELECT * FROM hit";

$results = $db->query($sql);
foreach ($result as $row) {
    print(var_dump($row));
} 
$insert = 'INSERT INTO hit (dt, user, already_seen, user_agent, referer, ip) VALUES (DATETIME("now"), :user, :already_seen, :ua, :referer, :ip)';
$stmt = $db->prepare($insert);
$nb_lines = $stmt->execute(array($user, $already_seen, $ua, $referer, $ip));
if ($nb_lines === false) {
    print_r($db->errorInfo());
    break;
}

?>
