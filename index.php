<?php

//error_reporting(0);
require_once 'config/config.php';
$page = filter_input(INPUT_GET, "page");
$inc = filter_input(INPUT_GET, "inc");
$db = mysqli_connect($conf['db']['host'], $conf['db']['user'], $conf['db']['pass'], $conf['db']['database']);
if ($db->connect_errno)
    echo "Failed to connect to MySQL: " . $mysqli->connect_error;

$query = "SELECT * FROM ".$conf['db']['prefix']."count";
$result = $db->query($query);

$row = NULL;

while ($row = $result->fetch_assoc())
    if ($page == $row['name'])
        break;
if ($row) {
    if ($inc) {
        $db->query("
            UPDATE ".$conf['db']['prefix']."count 
            SET count = count + 1
            WHERE name = \"".$page."\"
        ") or die("NONONO");
        header("Location: ".$conf['baseurl'].$page);
    }
    $query = "SELECT count FROM ".$conf['db']['prefix']."count WHERE name = \"".$page."\"";
    $result = $db->query($query);
    $count = $result->fetch_assoc()['count'];
    include('tpl/main.tpl');
}
else {
    $db->query("
            INSERT INTO ".$conf['db']['prefix']."count 
            (name, count)
            VALUES (\"".$page."\",1)
        ");
    header("Location: ".$conf['baseurl'].$page);
}