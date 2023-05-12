<!DOCTYPE html>

<?php //jt19712, 1903201 // THOMA23107
session_start();
  $username = $_SESSION['username'];
  $id = $_SESSION['id'];
  if(!isset($_SESSION['id'])) {
    header("Location: index.php");
  }
  include("database.php");
  $link=connect();
  $user_data = get_user($link, $username);
  $adminc = get_admin($link, $username);
  $admin = $adminc[0]['is_admin'];
  $attach ="";
  if ($admin == 1) {
    $_SESSION['username'] = $username;
    $_SESSION['id'] = $user_data[0]['id'];
    $attach="admin";
  }
  if ($admin == 0) {
    
    $_SESSION['username'] = $username;
    $_SESSION['id'] = $user_data[0]['id'];
    $attach="";
  }


?>




<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>User Menu</title>
    <link rel="stylesheet" href="styles.CSS" type="text/css" />
    <style>
      .active {
        background-color: #121212;
      }
      a {
        outline: 0px;
        text-decoration: none;
      }
      a:link,
      a:visited {
        color: #868a8f;
      }

      p {
        margin: 0;
      }
    </style>
  </head>
  <body style="overflow-y: auto;">
    <div class="navbar">
      <a href="logout.php" class="ex1">Logout</a>
      <a href="manageaccount.php" class="ex1"><?php echo $username; ?></a>
    </div>
    <h1
      style="text-align: left; padding: 10px; padding-left: 60px; color: #f2f2f2;"
    >
      Rynek
    </h1>
    <div>
      <div>
        <ul>
          <li>
            <?php echo "<a id='games' href='gamescatalogue".$attach.".php' class='ex4'>"; ?>
              <div
                class="nav1"
                style="width: 300px;
                height: 400px;"
              >
                <img
                  src="controller.png"
                  alt="Browse Games"
                  style="border-radius: 100%;"
                  height="10%"
                  ;
                />
                <br />
                <br />
                <h1 style="color: #f2f2f2; ">Browse games</h1>
                <p>• View our full games catalogue</p>
                <br />
                <p>• New releases</p>
                <br />
                <p>• Classics</p>
                <br /></div
            ></a>
          </li>
          <li>
            <a id="community" href="community.html" class="ex4"
              ><div
                class="nav1"
                style="width: 300px;
        height: 400px;"
              >
                <img
                  src="speechbubbles.png"
                  alt="Community"
                  style="height: 10%;"
                />
                <br />
                <br />
                <h1 style="color: #f2f2f2; ">Community</h1>
                <p>• Reviews</p>
                <br />
                <p>• Discussions</p>
                <br />
                <p>• Help</p>
              </div></a
            >
          </li>
          <li>
            <a id="manacc" href="manageaccount.php" class="ex4"
              ><div
                class="nav1"
                style="width: 300px;
        height: 400px;"
              >
                <img src="lock.png" alt="Manage Account" style="height: 10%;" />
                <br />
                <br />
                <h1 style="color: #f2f2f2; ">Manage account</h1>
                <p>• Manage your personal details</p>
                <br />
                <p>• View bookmarks</p>
                <br />
                <p>• Change Password</p>
              </div></a
            >
          </li>
        </ul>
      </div>
    </div>
  </body>
</html>
