<?php //jt19712, 1903201 // THOMA23107
// Provided by Joseph Walton-Rivers for ce154

/**
 * This script is used for connecting to databases
 */

// there are oo and procedural interfaces, we're using the OO interface.
// oh yeah... PHP supports classes.

// could use seperate variables here to.
$db = array();

// CHANGE THESE TO MATCH YOUR SETUP!
$db['host'] = "localhost";
$db['user'] = "root";
$db['pass'] = "";
$db['name'] = "ce154";

/**
 * Function to connect to the database
 */
function connect(){
    global $db;
    $link = new mysqli($db['host'], $db['user'], $db['pass'], $db['name']);
    if  ($link->connect_errno) {
        die("Failed to connect to MySQL: " . $link->connect_error);
    }

    return $link;
}

function get_games($link) {
    $records = array();

    $results = $link->query("SELECT id FROM games");

    // didn't work? return no results
    if ( !$results ) {
        return $records;
    }

    while ( $row = $results->fetch_assoc() ) {
        $records[] = $row['id'];
    }
    
    return $records;
}


function search_games($link, $search, $genre) {
    $records = array();

    $results = $link->query("SELECT id FROM games WHERE title LIKE '%$search%' AND genre = '$genre'");

    // didn't work? return no results
    if ( !$results ) {
        return $records;
    }

    while ( $row = $results->fetch_assoc() ) {
        $records[] = $row;
    }
    
    return $records;
}

function search_genre($link, $genre) {
    $records = array();

    $results = $link->query("SELECT id FROM games WHERE genre = '$genre'");

    // didn't work? return no results
    if ( !$results ) {
        return $records;
    }

    while ( $row = $results->fetch_assoc() ) {
        $records[] = $row;
    }
    
    return $records;
}

function search_name($link, $search) {
    $records = array();

    $results = $link->query("SELECT id FROM games WHERE title LIKE '%$search%'");

    // didn't work? return no results
    if ( !$results ) {
        return $records;
    }

    while ( $row = $results->fetch_assoc() ) {
        $records[] = $row;
    }
    
    return $records;
}

function get_user($link, $username) {
    $records = array();

    $results = $link->query("SELECT * FROM users WHERE uname = '$username'");

    // didn't work? return no results
    if ( !$results ) {
        echo "Username not found";
        return $records;
    }

    while ( $row = $results->fetch_assoc() ) {
        $records[] = $row;
    }
    return $records;
}


function get_pass($link, $username) {
    $records = array();

    $results = $link->query("SELECT pass FROM users WHERE uname = '$username'");

    if ( !$results ) {
        echo "Password not found. ";
        return $records;
    } 

    while ( $row = $results->fetch_assoc() ) {
        $records[] = $row;
    }
    return $records;
}

function get_salt($link, $username) {
    
    $records = array();

    $results = $link->query("SELECT salt FROM users WHERE uname = '$username' LIMIT 1");

    if ( !$results ) {
        echo "Salt not found. ";
        return $records;
    } 
    while ( $row = $results->fetch_assoc() ) {
        $records[] = $row;
    }
    return $records;
}




function get_admin($link, $username) {
    
    $records = array();

    $results = $link->query("SELECT is_admin FROM users WHERE uname = '$username' LIMIT 1");

    if ( !$results ) {
        echo "is_admin not found. ";
        return $records;
    } 
    while ( $row = $results->fetch_assoc() ) {
        $records[] = $row;
    }
    return $records;
}

function get_image($link, $ids) {
    $records = array();

    $results = $link->query("SELECT image FROM games WHERE id = '$ids' ");

    // didn't work? return no results
    if ( !$results ) {
        echo 'not found';
        return $records;
    }

    while ( $row = $results->fetch_assoc() ) {
        $records[] = $row;
    }
    
    return $records;
}


function get_title($link, $ids) {
    $records = array();

    $results = $link->query("SELECT title FROM games WHERE id = '$ids' LIMIT 1");

    // didn't work? return no results
    if ( !$results ) {
        return $records;
    }

    while ( $row = $results->fetch_assoc() ) {
        $records[] = $row;
    }
    
    return $records;
}

function get_rating($link, $ids) {
    $records = array();

    $results = $link->query("SELECT rating FROM games WHERE id = '$ids' LIMIT 1");

    // didn't work? return no results
    if ( !$results ) {
        return $records;
    }

    while ( $row = $results->fetch_assoc() ) {
        $records[] = $row;
    }
    
    return $records;
}

function get_genre($link, $ids) {
    $records = array();

    $results = $link->query("SELECT genre FROM games WHERE id = '$ids' LIMIT 1");

    // didn't work? return no results
    if ( !$results ) {
        return $records;
    }

    while ( $row = $results->fetch_assoc() ) {
        $records[] = $row;
    }
    
    return $records;
}

function get_gameid($link, $title) {
    $records = array();

    $results = $link->query("SELECT id FROM games WHERE title = '$title'");

    // didn't work? return no results
    if ( !$results ) {
        return $records;
    }

    while ( $row = $results->fetch_assoc() ) {
        $records[] = $row;
    }
    
    return $records;
}

function get_info($ids) {
    $link = connect();

    $records = array();
              
    $image_arr = get_image($link, $ids);
    $image = $image_arr[0]['image'];
    $records[] = $image;

    $title_arr = get_title($link, $ids);
    $title = $title_arr[0]['title'];
    $records[] = $title;

    $rating_arr = get_rating($link, $ids);
    $rating = $rating_arr[0]['rating'];
    $records[] = $rating;

    $genre_arr = get_genre($link, $ids);
    $genre = $genre_arr[0]['genre'];
    $records[] = $genre;

    return $records;
}

function get_reviews($link, $id) {
    $records = array();

    $results = $link->query("SELECT * FROM reviews WHERE game_id = '$id'");

    // didn't work? return no results
    if ( !$results ) {
        echo "No reviews found.";
        return $records;
    }

    while ( $row = $results->fetch_assoc() ) {
        $records[] = $row;
    }
    
    return $records;
}


function existing_review($link, $id, $gameid) {
    $records = array();

    $results = $link->query("SELECT * FROM reviews WHERE user_id = '$id' and game_id = '$gameid'");

    // didn't work? return no results
    if ( !$results ) {
        echo "No reviews found.";
        return $records;
    }

    while ( $row = $results->fetch_assoc() ) {
        $records[] = $row;
    }
    
    return $records;
}

function existing_bookmark($link, $id, $gameid) {
    $records = array();

    $results = $link->query("SELECT * FROM bookmarks WHERE user_id = '$id' and game_id = '$gameid'");

    // didn't work? return no results
    if ( !$results ) {
        echo "No reviews found.";
        return $records;
    }

    while ( $row = $results->fetch_assoc() ) {
        $records[] = $row;
    }
    
    return $records;
}

function register_acc($link, $username, $password) {
    $salt = randomChars('0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz', 6);
    $password = sha1($password.$salt);
    $link->query("INSERT INTO users (uname, pass, salt, is_admin) VALUES ('$username', '$password', '$salt', 0)");
}

function get_bookmarks($link, $id) {
    $records = array();

    $results = $link->query("SELECT * FROM bookmarks WHERE user_id = '$id'");

    // didn't work? return no results
    if ( !$results ) {
        echo "No reviews found.";
        return $records;
    }

    while ( $row = $results->fetch_assoc() ) {
        $records[] = $row;
    }
    
    return $records;
}

function randomChars($str, $numchars) {
    return substr(str_shuffle($str), 0, $numchars);
}
?>