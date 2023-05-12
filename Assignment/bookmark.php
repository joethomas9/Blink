<?php //jt19712, 1903201 // THOMA23107
session_start();
$username = $_SESSION['username'];
$id = $_SESSION['id'];
if(!isset($_SESSION['id'])) {
    header("Location: index.php");
}
include("database.php");
$link = connect();

$gameid = $_GET['id'];

$id = intval($id);
$gameid = intval($gameid);

$existing = existing_bookmark($link, $id, $gameid);

if (!$existing) {
    $link->query("INSERT INTO bookmarks (user_id, game_id) VALUES ($id, $gameid)");
    header("location: gamescatalogue.php");
} else {
    
    header("location: gamescatalogue.php");

}
?>
