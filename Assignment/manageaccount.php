<!DOCTYPE html>
<?php //jt19712, 1903201 // THOMA23107
session_start();
$username = $_SESSION['username'];
$id = $_SESSION['id'];
if(!isset($_SESSION['id'])) {
    header("Location: index.php");
}
include("database.php");
$link = connect();

$bookmarks = get_bookmarks($link, $id);
sort($bookmarks);

if(isset($_POST['Changepass'])) {
  
    $password = strip_tags($_POST['password']);
    $password_confirm = strip_tags($_POST['password_confirm']);
    
    
    
    $password = stripslashes($password);
    $password_confirm = stripslashes($password_confirm);

  if($password == "" || $password_confirm == "") {
    echo "Please enter a password.";
    
  } else {

    if($password != $password_confirm) {
      echo "Your passwords do not match.";
      
    } else {

      $salt = get_salt($link, $username);
      $hashed_password = sha1($password.$salt[0]['salt']);

      echo $password;
      var_dump($salt);
      echo $hashed_password;

      $link->query("UPDATE users SET pass = '$hashed_password' WHERE id = $id");
      echo "Password updated.";
}
  }}

    
    





?>

<style>

.bordering {
  position: absolute;
  align-items: left;
  top: 50%;
  left: 50%;
  transform: translate(-50%, -50%);
  background-color: #36393f;
  padding: 20px 20px;
  width: 600px;
  height: 800px;
  box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2), 0 6px 20px 0 rgba(0, 0, 0, 0.19);
  border-radius: 5px;
  
}

.nav1 input[type="submit"] {
        width: 50%;
        font-size: small; 
        text-align: center;
        color: #f2f2f2; 
        padding: 10px; 
        border-radius: 5px;
        border-style: solid;
        background-color: #27afbd;
        border-color: #27afbd;
      }
      .nav1 input[type="submit"]:hover,
      .nav1 input[type="submit"]:active {
        background-color: #337cff;
        border-color: #337cff;
      }


</style>

<html lang="en">
  <head>
    <meta charset="UTF-8"/>
    <meta
      name="viewport"
      content="width=device-width, initial-scale=1.0, height=device-height,"
    />
    <title>Rynex Manage Account</title>
    <link rel="stylesheet" href="styles.CSS" type="text/css" />
    <style>
      html {
        overflow-y: hidden;
        overflow-x: hidden;
      }
    </style>
  </head>





  <body>
  <div class="navbar">
      <a href="logout.php" class="ex1">Logout</a>
      <a href="manageaccount.php" class="ex1"><?php echo $username; ?></a>
    </div>
    <h1
      style="text-align: left; padding: 10px; padding-left: 60px; color: #f2f2f2;"
    >
      Rynek
    </h1>
  </body>

  <body>
    <div class="bordering">
        <br><br>
        <h1 style="color:#f2f2f2"><?php echo $username?></h1>
        <br><br>
        <div class="nav1" style="width: 50%; align-items:left;">
        <form method="post" action="manageaccount.php"  enctype="multipart/form-data">
        <h2 style="color: #f2f2f2">Change Password</h2>
        <p style="float:left;">Password</p>
        <br><br>
        <input
          type="password"
          name="password"
          class="textbox"
          style="float:left; width: 95%; border: thin;"
        />
        <br /><br />
        <p style="float:left;">Confirm Password</p>
        <br><br>
        <input
          type="password"
          name="password_confirm"
          class="textbox"
          style="float: left; width: 95%; border: thin;"
        />
        <br />
      <br />
      <br>
      <input

            name="Changepass"
            type="submit"
            value="Change Password"
            action="manageaccount.php"
            method="post"
            enctype="multipart/form-data"
            />
            
      <br><br><br>
        </form>
        </div>
        <br><br>
      <div class="nav1" style=" height: 30%;align-items:center;">
      <h2 style="color: #f2f2f2">Your Bookmarks</h2>
      
      <?php 
      $index = 0; 
      
      ?>
      <?php foreach ( $bookmarks as $item ) { 
        $gameinfo = get_info($bookmarks[$index]['game_id']); ?>
        <?php echo "<a href=\"gamepage.php?id=".$bookmarks[$index]['game_id']."\" class='textbox' style=font-size: 1;>$gameinfo[1]</a><br /><br />"; ?>
        <?php 
        $index = $index+1; 
        ?>
      <?php } ?>
      
      </div>
    </div>
    
  </body>
</html>
