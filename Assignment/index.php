<?php //jt19712, 1903201 // THOMA23107

if (isset($_POST['login'])) { 
  session_start();
  include("database.php");
  

  $username = strip_tags($_POST["username"]);
  $password = strip_tags($_POST["password"]);

  $username = stripslashes($username);
  $password = stripslashes($password);


  if($username == ""){
    echo "Please enter a username.";
    
  } else {
    if($password == "") {
      echo "Please enter a password.";
      
    } else { 

    $link = connect();
    $user_data = get_user($link, $username);
    if (!$user_data) {
      echo "User not found.";
    } else {
    $salt = get_salt($link, $username);
    
    
    $hashed_password = sha1($password.$salt[0]['salt']);
    
    $dbpassword = get_pass($link, $username);
    $dbpass = $dbpassword[0]['pass'];
  
  

      if ($hashed_password != $dbpass) {
        echo "Incorrect password.";
      
        
      } else {
        echo "Correct password.";
      
        $adminc = get_admin($link, $username);
        $admin = $adminc[0]['is_admin'];
        
        if ($admin == 1) {
          $_SESSION['username'] = $username;
          $_SESSION['id'] = $user_data[0]['id'];
          header("location: userprofile.php");
        }
        if ($admin == 0) {
          
          $_SESSION['username'] = $username;
          $_SESSION['id'] = $user_data[0]['id'];
          header("location: userprofile.php");
        }
      }
    }
    }
}
}

?>
 

<!DOCTYPE html>

<html lang="en">
  <head>
    <meta charset="UTF-8"/>
    <meta
      name="viewport"
      content="width=device-width, initial-scale=1.0, height=device-height,"
    />
    <title>Rynex Login</title>
    <link rel="stylesheet" href="styles.CSS" type="text/css" />
    <style>
      html {
        overflow-y: hidden;
        overflow-x: hidden;
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
      <br />
      <p style="color: #f2f2f2; font-size: 20px;">Welcome!</p>
      <p>
        Thanks for visiting!
      </p>

      <div class="login" style="font-size: small; text-align: left;" >
      <form method="post" action="index.php"  enctype="multipart/form-data">
          <p>Username</p>
          <input type="username" name="username" id="name" class="textbox" style="width: 98%;" />
          <br /><br />
          <p>Password</p>
          <input type="password" name="password" id="password" class="textbox" style="width: 98%; border: thin;"/>
          <a class="ex2" href="passwordlhelp.html" style="font-size: x-small;"
          >Forgot your password?</a>
          <br />
          <br />
          <br />
          <input
            name="login"
            type="submit"
            value="login"
            action="index.php"
            method="post"
            enctype="multipart/form-data"/>
        </form>

        
      </div>
      
      <br />
      <br />
      <p style="font-size: small; text-align: left;">
        New here?
        <a class="ex2" href="registeraccount.php">Register</a>
      </p>
      <br />
      
      
      <div style="text-align: right;">
        <a class="ex1" href="guestmenu.php"><p>Continue as guest</p></a>
      </div>
    </div>
  </body>
</html>


