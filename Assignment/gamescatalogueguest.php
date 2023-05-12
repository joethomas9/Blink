<!DOCTYPE html>
<?php //jt19712, 1903201 // THOMA23107
session_start();
  
include("database.php");

$link = connect();
$numgames = get_games($link);
sort($numgames);
$_SESSION['gameid'] = array();
$_SESSION['link'] = $link;


if(isset($_POST['submit'])) {

  $search = "";
  $search = strip_tags($_POST['search']);
  $search = stripslashes($search); 
  $search = preg_replace("#[^0-9a-z]#i","",$search);
  
  $genre = strip_tags($_POST['genre']);
  $genre = stripslashes($genre);

  if ($search == "") {
      $games = search_genre($link, $genre);
  } else {
    if ($genre == "*") {
      $games = search_name($link, $search);
    } else {
      $games = search_games($link, $search, $genre);
    }
  }
  
  sort($games);
  
  $index = 0;
  echo "<ul>";
  foreach ( $games as $item ) { 
    echo "<li>";
    $gameinfo = get_info($games[$index]['id']);
    echo "<li>";
    echo "<a href=\"gamepageguest.php?id=".$games[$index]['id']."\" class='ex4'>";
        echo "<div class='nav1' style='width: 300px; height: 400px; color: #f2f2f2;'>";
        echo "<img src='$gameinfo[0]' alt='' style='border-radius: 5px; height: 70%; width: 100%;'>";
        echo "<br><br>";
        echo "<h4><?php echo $gameinfo[1]; ?></h4>";
        echo "<p style='text-align: left; font-size: small;'>Rating: $gameinfo[2] /100</p>";
        echo "<p style='text-align: left; font-size: small;'>Genre: $gameinfo[3] </p>";
      echo "</div>";
      echo "</a>";
    echo "</li>";
    $index = $index+1;
    }
    echo "</ul>";
  }
  

?>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Rynek Games Catalogue</title>
    <link rel="stylesheet" href="styles.css" type="text/css" />
    <style>
      .active {
        background-color: #121212;
      }

      a {
        outline: 0px;
        text-decoration: none;
      }

      p {
        margin: 0;
      }

      .nav1 input[type="submit"] {
        width: 30%;
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
  </head>

  <body>
    <div class="navbar">
      <a href="logout.php" class="ex1">Logout</a>
      <a href="manageaccount.php" class="ex1">Guest</a>
    </div>
    <h1
      style="text-align: left; padding: 20px; padding-left: 60px; color: #f2f2f2;"
    >
      Rynek
    </h1>
    </body>
    <body>
      
    <div style="padding-left: 60px;" class="search">
    <form action="gamescatalogue.php" method="post">
      <ul style="float: left;">
        <li>
      <input
        name="search"
        type="text"
        class="textbox"
        style="width: 300px; padding: 10px 20px"
        placeholder="Search for a game"        
      />
      </li>
      <li>
        <select name="genre" id="genre" class="textbox" style="height: 40px">
          <option value="*">-- Genre --</option>
          <option value="fps">First Person Shooters</option>
          <option value="rpg">Role-play Games</option>
          <option value="sim">Simulation Games</option>
          <option value="str">Strategy Games</option>
          <option value="???">Other Games</option>
        </select>
      </li>
      <li>
      <input
        name="submit"
        style="padding: 10px 10px"
        type="submit"
        value=">>"
        />
        </li>
        </ul>
    </form>
      <br>
      <br>
      <br>
    </div>
    
  </body>

  <body style="overflow-y: auto;">
  
    <div>
      <div>
        <ul>
        <?php foreach( $numgames as $item ) { ?>
          
          <li>
          <?php echo "<a href=\"gamepageguest.php?id=".$item."\" class='ex4'>"?>
              <div
                class="nav1"
                style="width: 300px; height: 400px; color: #f2f2f2;"
              >
              <?php               
              $gameinfo = get_info($item);
              
              ?>
              <img src="<?php echo $gameinfo[0]; ?>" alt="" style="border-radius: 5px; height: 70%; width: 100%;">
              <br><br>
              <h4><?php echo $gameinfo[1]; ?></h4>
              
              <p style="text-align: left; font-size: small;">Rating: <?php echo $gameinfo[2]; ?>/100</p>
              
              <p style="text-align: left; font-size: small;">Genre: <?php echo $gameinfo[3]; ?></p>
              <?php echo "<form action=\"bookmark.php?id=".$item."\" method='post'>" ?>
                <input type="submit" value="Bookmark" name="bookmark" style="float:right">
              </form>
            </div>
            </a>
          </li>
          
        <?php } ?>

        </ul>
      </div>
    </div>
    <br><br>
  </body>
</html>
