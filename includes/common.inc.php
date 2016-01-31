<?php
//connect the database to server
    $dbhost = 'localhost';
    $dbuser='root';
    $dbpass='root';
    $dbname= 'testdb';

$dbc= new mysqli($dbhost, $dbuser, $dbpass, $dbname);
// Check connection
if($dbc->connect_error)
{
    die('Connect Error (' . $dbc->connect_errno . ') '
        . $dbc->connect_error);
}
/*
if (!$dbc->set_charset("utf8")) {
    printf("Error loading character set utf8: %s\n", $dbc->error);
    exit();
} else {
    printf("Current character set: %s\n", $dbc->character_set_name());
}
*/
$dbc->set_charset("utf8");