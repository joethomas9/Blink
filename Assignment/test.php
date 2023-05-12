<?php //jt19712, 1903201 // THOMA23107

require("database.php");
$link = connect();

$users = get_user($link, "jwalto");
var_dump($users)
?>