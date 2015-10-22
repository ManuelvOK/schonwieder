<?php

//error_reporting(0);
require_once 'config/config.php';
$page = filter_input(INPUT_GET, "page");
$inc = filter_input(INPUT_GET, "inc");
$conn = mysql_connect($conf['db']['host'], $conf['db']['user'], $conf['db']['pass']) or die('Could not connect to server.');
$db = mysql_select_db($conf['db']['database'], $conn) or die('Could not select DB');

$query = "SELECT * FROM ".$conf['db']['prefix']."count";
$result = mysql_query($query);

$row = NULL;

while ($row = mysql_fetch_assoc($result))
    if ($page == $row['name'])
        break;
if ($row) {
    if ($inc) {
        mysql_query("
            UPDATE ".$conf['db']['prefix']."count 
            SET count = count + 1
            WHERE name = \"".$page."\"
        ") or die("NONONO");
        header("Location: ".$conf['baseurl'].$page);
    }
    $query = "SELECT count FROM ".$conf['db']['prefix']."count WHERE name = \"".$page."\"";
    $result = mysql_query($query);
    echo "<h1>".mysql_fetch_assoc($result)['count']."</h1>";
    echo "<br><a href=\"".$conf['baseurl'].$page."/inc\">inc</a>";
}
else {
    mysql_query("
            INSERT INTO ".$conf['db']['prefix']."count 
            (name, count)
            VALUES (\"".$page."\",1)
        ");
    header("Location: ".$conf['baseurl'].$page);
}