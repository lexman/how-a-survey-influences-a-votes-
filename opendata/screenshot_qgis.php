<?php

function getOrCreateDb() {
    if ($db = sqlite_open('../.private/hits.db', 0666, $sqliteerror)) {
        sqlite_query($db,'CREATE TABLE hit (dt, cookie, already_seen)');
    } else {
        die ($sqliteerror);
    }
}

if (isset($_COOKIE['color'])) {
    $already_seen = true;
    $user = uniqid("green");
    echo "15";
} else {
    $already_seen = false;
    $user = $_COOKIE['color'];
    setcookie('color', $user, time() + 3600 * 24 * 30);
    echo "19";
}

echo "20";
?>
$db = getOrCreateDb();

echo "23"

$query = "INSERT INTO hit (dt, cookie, already_seen) VALUES (NOW(), '" . sqlite_escape_string($user) . "', '" . $already_seen ."')";


echo $query;
?>
$query_result = sqlite_exec($dbn $query);
if (!$query_result) {
    exit("Erreur dans la requête : '$error'");
} else {
    echo 'Nombre de lignes modifiées : ', sqlite_changes($db);
}

?>
