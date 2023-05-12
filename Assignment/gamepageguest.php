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
$gameid = $_GET['id'];
$reviews = get_reviews($link, $gameid);



if(isset($_POST['addreview'])) {

    $id=intval($id);
    $gameid = $_GET['id'];
    $gameid = intval($gameid);
    
    
    $title = strip_tags($_POST['title']);
    $title = stripslashes($title); 

    $review = strip_tags($_POST['review']);
    $review = stripslashes($review);

    $rating = strip_tags($_POST["rating"]);
    $rating = stripslashes($rating);
    $rating = (int)$rating;

    $existingreview = existing_review($link, $id, $gameid);

    if(!$existingreview){
    
    $link->query("INSERT INTO reviews (user_id, game_id, rating, title, review) VALUES ($id, $gameid, $rating, '$title', '$review')");
    } else {
      $link->query("UPDATE reviews SET title = $title, review = $review WHERE user_id = $id AND game_id = $gameid");
    }
    

  

  
}
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

.slideshow-container {
    max-width: 100%;
    position: relative;
    margin: auto;
}


</style>

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
  <div class="navbar">
      <a href="logout.php" class="ex1">Logout</a>
      <a href="#manageaccount" class="ex1"><?php echo $username; ?></a>
    </div>
    <h1
      style="text-align: left; padding: 10px; padding-left: 60px; color: #f2f2f2;"
    >
      Rynek
    </h1>
  </body>







  <body>
    <div class="bordering">
        <?php               
            $gameinfo = get_info($gameid);
                
        ?>
        <div style = "width: 100%; height: 320px;">
            <img src="<?php echo $gameinfo[0]; ?>" alt=""  style="border-radius: 5px; width: 50%; float: left;">
            <br><br>
            <h1 style="color: #f2f2f2;"><?php echo $gameinfo[1]; ?></h1>
                    
            <p style="padding-top: 50px; text-align: right; font-size: small; ">Rating: <?php echo $gameinfo[2]; ?>/100</p>
                    
            <p style="text-align: right; font-size: small; ">Genre: <?php echo $gameinfo[3]; ?></p>
        </div>
        
        <div class="nav1" style="width: 50%; align-items:left;">
        <h6 style="text-align: left; color: #f2f2f2;">Write your own review!</h6>
        <h6 style="text-align: left;">Note: enter Rating as number /100</h6>
        <?php echo "<form method='post' action=\"gamepage.php?id=".$gameid."\" >";?>
        
        
        <input type="text" name="rating" id="intrating" placeholder="Rating" class="textbox" style="width: 15%; float: left;" />
        <input type="text" name="title" id="reviewtit" placeholder="Title of review" class="textbox" style="margin-left: 10px; float:left; width: 76%;"><br><br>
            
            <textarea name="review" id="reviewbox" placeholder="Content of review" cols="30" rows="5"  class="textbox" style=" width: 95%; height: 5%; float: left;"></textarea>
            <br><br><br><br><br>
            <input 
            name="addreview" 
            type="submit" 
            value="Add review"
            method="post"
            enctype="multipart/form-data"
            style="float: left;"
            <?php echo 'action="gamepage.php?id='.$gameid.'"'; ?>
            />
            
            
            
        </form>
    </div>
        <br><br><br><br>
        <h3 style="color: #f2f2f2; text-align: left;">Reviews</h3>
            
        <div style="float: left;">
            <?php foreach( $reviews as $item ) { ?>
                <li>
                    <div class="textbox" style="height: auto; width: 100%;">
                        <p><?php echo $reviews[0]['title']?></p>
                        <p style="font-size: small; text-align: left;"><?php echo $reviews[0]['review']?></p>
                    </div>
                        
                
                </li>
            <?php } ?>
        </div>
        
    </div>
    
  </body>
</html>
