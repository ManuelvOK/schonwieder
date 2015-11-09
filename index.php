<?php
header('Access-Control-Allow-Origin: *');
//error_reporting(0);
require_once 'config/config.php';
$page = filter_input(INPUT_GET, "page");
$inc = filter_input(INPUT_GET, "inc");
$xmlhttp = filter_input(INPUT_POST, "xmlhttp");
$db = mysqli_connect($conf['db']['host'], $conf['db']['user'], $conf['db']['pass'], $conf['db']['database']);

if ($db->connect_errno)
    echo "Failed to connect to MySQL: " . $mysqli->connect_error;

$sex = "Es";
if ($_SERVER['SERVER_NAME'] == $conf['domain']['male'])
    $sex = "Er";
else if ($_SERVER['SERVER_NAME'] == $conf['domain']['female'])
    $sex = "Sie";

if ($xmlhttp && filter_input(INPUT_POST, "name")) {

    $page = filter_input(INPUT_POST, "name");

    if (filter_input(INPUT_POST, "inc") === 'true')
        inc();

    echo json_encode(getCount()['count']);
    exit();
}

if ($page == NULL)
    header("Location: ".$conf['baseurl']."default");

$result = getCount();

if ($result) {
    if ($inc) {
        inc();
        header("Location: ".$conf['baseurl'].$page);
    }
    $count = $result['count'];
    $last = strtotime($result['last']);
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
