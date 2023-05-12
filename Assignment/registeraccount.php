<!DOCTYPE html>
<?php //jt19712, 1903201 // THOMA23107
  
  
  if(isset($_POST['register'])) {
    session_start();
    include("database.php");

    $username = strip_tags($_POST['username']);
    $password = strip_tags($_POST['password']);
    $password_confirm = strip_tags($_POST['password_confirm']);
    
    
    $username = stripslashes($username);
    $password = stripslashes($password);
    $password_confirm = stripslashes($password_confirm);
    

    $link = connect();
    $user_exist = get_user($link, $username); 
    
    if($user_exist) {
      echo "Username taken, please enter another.";
      
    } else {

    if($username == ""){
      echo "Please enter a username.";
      
    } else {

      if($password == "" || $password_confirm == "") {
        echo "Please enter a password.";
        
      } else {
    
        if($password != $password_confirm) {
          echo "Your passwords do not match.";
          
        } else {
          
          echo "making account";
          register_acc($link, $username, $password);
          header("location: index.php");
        }
    }
  }
  }
}
  


?>


<style>


</style>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta
      name="viewport"
      content="width=device-width, initial-scale=1.0, height=device-height,"
    />
    <title>index</title>
    <link rel="stylesheet" href="styles.CSS" type="text/css" />
    <style>
      html {
        overflow-y: hidden;
        overflow-x: hidden;
      }
      .register input[type="submit"] {
        width: 100%;
        font-size: small; 
        text-align: center;
        color: #f2f2f2; 
        padding: 10px 132px; 
        border-radius: 5px;
        border-style: solid;
        background-color: #27afbd;
        border-color: #27afbd;
      }
      .register input[type="submit"]:hover,
      .register input[type="submit"]:active {
        background-color: #337cff;
        border-color: #337cff;
      }
    </style>
  </head>

  <body>
    <h1 style="text-align: left;  color: #f2f2f2; padding: 40px;">
      Rynek
    </h1>
  </body>

  <body>
    <div class="nav">
      
      <p style="color: #f2f2f2; font-size: 20px;">Sign Up</p>

      <div style="font-size: small; text-align: left;" class="register">
      <form method="post" action="registeraccount.php"  enctype="multipart/form-data">
        <br><br>
        <p>Username</p>
        <input type="text" name="username" class="textbox" style="width: 98%; border: thin;" />
        <br /><br />
        <p>Password</p>
        <input
          type="password"
          name="password"
          class="textbox"
          style="width: 98%; border: thin;"
        />
        <br /><br />
        <p>Confirm Password</p>
        <input
          type="password"
          name="password_confirm"
          class="textbox"
          style="width: 98%; border: thin;"
        />
        <br />
      <br />
      <br>
      <input
            name="register"
            type="submit"
            value="register"
            action="registeraccount.php"
            method="post"
            enctype="multipart/form-data"/>
      <br><br><br>
        </form>
      </div>
      
      <div style="text-align: right;">
        <a class="ex1" href="#homepage"><p>Continue as guest</p></a>
      </div>
    </div>
  </body>
</html>
