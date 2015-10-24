<?php

//error_reporting(0);
require_once 'config/config.php';
$page = filter_input(INPUT_GET, "page");
$inc = filter_input(INPUT_GET, "inc");
$db = mysqli_connect($conf['db']['host'], $conf['db']['user'], $conf['db']['pass'], $conf['db']['database']);

$sex = "Es";
if ($_SERVER['SERVER_NAME'] == $conf['domain']['male'])
    $sex = "Er";
else if ($_SERVER['SERVER_NAME'] == $conf['domain']['female'])
    $sex = "Sie";

if ($db->connect_errno)
    echo "Failed to connect to MySQL: " . $mysqli->connect_error;

$result = getCount();

if (isset($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {
    if ($inc)
        inc();
    
    echo json_encode(getCount()['count']);
    exit();
}

if ($result) {
    if ($inc) {
        inc();
        header("Location: ".$conf['baseurl'].$page);
    }
    $count = $result['count'];
    include('tpl/main.tpl');
}
else {
    create();
    header("Location: ".$conf['baseurl'].$page);
}

function inc() {
    global $db, $conf, $page;
    $db->query("
        UPDATE ".$conf['db']['prefix']."count 
        SET count = count + 1
        WHERE name = \"".$db->real_escape_string($page)."\"
    ");
}

function create() {
    global $db, $conf, $page;
    $db->query("
        INSERT INTO ".$db->real_escape_string($conf['db']['prefix'])."count 
        (name, count)
        VALUES (\"".$db->real_escape_string($page)."\",1)
    ");
}

function getCount() {
    global $db, $conf, $page;
    return $db->query("
        SELECT *
        FROM ".$db->real_escape_string($conf['db']['prefix'])."count
        WHERE name = '".$db->real_escape_string($page)."'"
    )->fetch_assoc();
}