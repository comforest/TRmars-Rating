<?php
include_once $_SERVER["DOCUMENT_ROOT"]."/secret/mysql_info.php";
$mysqli = mysqli_connect($mysql_server, $mysql_id, $mysql_pass, $mysql_db);
 
/* check connection */
if ($mysqli->connect_errno) {
    printf("Connect failed: %s\n", $mysqli->connect_error);
    exit();
}
?>