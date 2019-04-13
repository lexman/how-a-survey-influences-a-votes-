<html>
    <head>
        <meta http-equiv="content-type" content="text/html; charset=utf-8" />
        <style>
table {
 border-collapse:collapse;
 width:90%;
 }
th, td {
 border:1px solid black;
 width:20%;
 }
td {
 text-align:center;
 }
caption {
 font-weight:bold
 }
        </style>
    </head>
<body>
<table>
  <tr>
    <th>User</th>
    <th>First visit</th>
    <th>Last visit</th> 
    <th>Nb Visits</th> 
  </tr>
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

$db = initdb('.db/hits.db');

$query = 'SELECT user, MIN(dt) AS first_visit, MAX(dt) as last_visit, COUNT(*) AS nb_visits FROM hit GROUP BY user';
$reponse = $db->query($query);
while ($row = $reponse->fetch())
{
    $line = "<td>${row['user']}</td>".
            "<td>${row['first_visit']}</td>".
            "<td>${row['last_visit']}</td>".
            "<td>${row['nb_visits']}</td>";
    print("<tr>$line</tr>\n");
}
?>
</table>

</body></html>
