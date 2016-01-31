<?php

session_start();

/* -------------------------- */
/* START VARIABLE SETUP       */
/* -------------------------- */

include('includes/common.inc.php');

include('functions.php');

if (!isset($_SESSION['numtries']))
{
    $_SESSION['numtries'] = 0;
}

$hasWon = false;
$gameEnd = false;
$points= 0;
$msg = '';
$modalClass = '';

// === Check the difficulty of the game === //

if(isset($_GET['novice']))
{
    $_SESSION['maxTries'] = 7;
}
else if(isset($_GET['expert']))
{
    $_SESSION['maxTries'] = 4;
}

/*
 *  Check if the user has logged in as Admin
 *  so that we redirect to admin page
 */

if(($_SESSION['username'])=='admin')
{
    header("Location: home.php");
}


// Define the user status

if(!isset($_SESSION['userSession']))
{
    header("Location: index.php");
}else {
    $user = $_SESSION['userSession'];
}
// if 'Games' is clicked, show all games saved in db

if(isset($_SESSION['worden'])) {
    $word = $_SESSION['worden'];
}

if(!($_SESSION['game'])) {

    $result = $dbc->query("SELECT * FROM word");

    $numRows = $result->num_rows;
    if ($numRows == 0) {
        $gameError = "No words available, please login as Admin and upload some words.";
        exit;
    }
    //  Generate a random number
    $randomNumber = mt_rand(0, $numRows-1);
    //  Select the random number (+1 row)
    $wordRow = $dbc->query("SELECT * FROM word LIMIT 1 OFFSET ". $randomNumber) or die("Query error: " .
        $dbc->error);
    $row = $wordRow->fetch_assoc();
    $wordID = $row['id_w'];
    $word = $row['word_en'];
    $greek = $row['word_gr'];
    $synonym = $row['synonym'];

    // Check if the word is returned
     if($wordID!=0){

        $_SESSION['id'] = $wordID;
        $user = $_SESSION['userSession'];
        $date = date('Y-m-d H:i:s');//returns the date & time in the same format as the MySQL function NOW()
        $gameInsert = $dbc->query("INSERT INTO game(user_id, id_w, insert_time) VALUES('$user','$wordID','$date')");
        $game = $dbc->insert_id;

        $_SESSION['game'] = $game;
        $_SESSION['worden'] = $word;
        $_SESSION['id'] = $wordID;
        $length = strlen($word);
        $letters[] = $word[0];
        $letters[] = $word[$length - 1];
        $_SESSION['letters'] = $letters;

    }
}


/*
 *  When the user guesses a letter we take it and return the result
*/

if(isset($_POST['submit']) && isset($_SESSION['game'])) //if the user post a letter
    {

          $oldHashWord = replace_hash_letters($_SESSION['letters'], $word);

          $letter = $_POST['letter'];

          array_push($_SESSION['letters'], $letter);

          $newHashWord = replace_hash_letters($_SESSION['letters'], $word);


          if($oldHashWord == $newHashWord){
              $_SESSION['numtries']++;
          }

          if($_SESSION['numtries']==$_SESSION['maxTries'])
          {
              if(preg_match('/_/',$newHashWord))
              {
                  $modalClass = 'modal-lost';
                  $msg = "Be cleverer the other time";
                  $gameEnd =true;


              }
          }
          else if($_SESSION['numtries']<=$_SESSION['maxTries'] && !preg_match('/_/',$newHashWord)){
              $points=25;
              $hasWon = true;
              $gameEnd =true;
              $modalClass = 'modal-won';
              $msg = "Congratulations! Well done!";

          }
      }
/*
 *  When the user resets the game
*/
else if (isset($_POST['start-new']) && isset($_SESSION['game'])){
    $gameEnd = false;
    $game = $dbc->query("UPDATE game SET points=" . $points ." WHERE id_g=" . $_SESSION['game']);
    unset($_SESSION['game']);
    unset($_SESSION['worden']);
    unset($_SESSION['id']);
    unset($_SESSION['letters']);
    unset($_SESSION['numtries']);
    header('Location: gameview.php');
}
if(isset($_POST['next'])){
    unset($_SESSION['game']);
    unset($_SESSION['worden']);
    unset($_SESSION['id']);
    unset($_SESSION['letters']);
    unset($_SESSION['numtries']);
    header('Location: gameview.php');

}

/*
 *  When the game ends update the base
*/

if($gameEnd)
{
    $game = $dbc->query("UPDATE game SET points=" . $points ." WHERE id_g=" . $_SESSION['game']);

}

// Close db connection
$dbc->close();

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>Hangman</title>
    <link href="utils/bootstrap/css/bootstrap.min.css" rel="stylesheet" media="screen">
    <link href="utils/bootstrap/css/bootstrap-theme.min.css" rel="stylesheet" media="screen">
    <link rel="stylesheet" href="css/keyboard.css" type="text/css" />
    <link rel="stylesheet" href="css/main.css" type="text/css" />
    <script type="text/javascript" src="https://code.jquery.com/jquery-2.1.4.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js" integrity="sha384-0mSbJDEHialfmuBBQP6A4Qrprq5OVfW37PRR3j5ELqxss1yVqOtnepnHVP9aJ7xS" crossorigin="anonymous"></script>

</head>
<body>
<? include 'includes/header.php'; ?>
<div class="container-fluid">

    <!-- Word Container -->
    <div class="row word-container">
        <div class="word">
        <?php if($gameEnd) echo $word; else echo replace_hash_letters($_SESSION['letters'], $word);  ?>
        </div>
    </div>
    <div class = "used-letters hidden">
        <? foreach ($_SESSION['letters'] as $key => $value) {
            echo $value . "<br />";
        } ?>
    </div>
    <!-- Word Container End -->

    <!-- Number of tries left -->
    <div class = "num-tries">
        <? for ($i=0; $i < ($_SESSION['maxTries'] - $_SESSION['numtries']); $i++) {
            ?>
            <div class="tries tries-left"></div>
        <?}
        ?>
        <? for ($i=0; $i < ($_SESSION['numtries']); $i++) {
            ?>
            <div class="tries tries-used"></div>
        <?}
        ?>
    </div>

    <!-- Start New Button -->
    <div class="row">
        <div class="col-xs-4 col-xs-offset-4">
            <form class="form-game start-new" method="post" action="">
                <div class="form-group">
                    <input type="submit" name="start-new" class="hidden"/>
                    <button type="submit" name="start-new" class="btn btn-start-new" data="modal" id="btn-start-new">
                        <i class="glyphicon glyphicon-refresh"></i>Start New
                    </button>
                </div>
            </form>
        </div>
    </div>
    <!-- Start New Button End -->


    <!-- Letter Input -->
    <div class="row">
        <div class="col-xs-12 col-sm-4 col-sm-offset-4">
            <div class="letter-container">
                <form class="form-letter form-inline" method="post" action ="" >
                    <div class="form-group">
                        <input type="text" class="form-control letter" name = "letter" maxlength="1"/>
                        <button type="submit" name = "submit" class="btn btn-letter" id="btn-login">
                            TRY
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!-- Letter Input End -->

    <!-- Keyboard -->
    <div class="col-xs-12 col-md-4 col-md-offset-4">
        <div class="keyboard">
            <div class="key-wrapper">
                <ul class="row">
                    <li class="key k65">a</li>
                    <li class="key k69">e</li>
                    <li class="key k73">i</li>
                    <li class="key k79">o</li>
                    <li class="key k85">u</li>
                    <li class="key k89">y</li>
                </ul>
                <ul class="row">
                    <li class="key k66">b</li>
                    <li class="key k67">c</li>
                    <li class="key k68">d</li>
                    <li class="key k70">f</li>
                    <li class="key k71">g</li>
                    <li class="key k74">j</li>
                </ul>
                <ul class="row">
                    <li class="key k72">h</li>
                    <li class="key k75">k</li>
                    <li class="key k76">l</li>
                    <li class="key k77">m</li>
                    <li class="key k78">n</li>
                    <li class="key k80">p</li>
                </ul>
                <ul class="row">
                    <li class="key k81">q</li>
                    <li class="key k82">r</li>
                    <li class="key k83">s</li>
                    <li class="key k84">t</li>
                    <li class="key k86">v</li>
                    <li class="key k87">w</li>
                </ul>
                <ul class="row">
                    <li class="key k88">x</li>
                    <li class="key k90">z</li>
                </ul>
            </div>
        </div>
    </div>
    <!-- Keyboard end -->

</div><!-- Container end -->

<!--<button type="button" class="btn btn-primary" data-toggle="modal" data-target="#info-modal">Small modal</button>-->

<!-- Modal Window -->
<div class="modal fade" id="info-modal" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="information
modal">
    <div class="modal-dialog modal-sm">
        <div class="modal-content <? echo $modalClass ?>">
            <div class="modal-header">
                <h4 class="modal-title">
                    <? echo $msg;?>
                </h4>
            </div>
            <div class="modal-body">
                <p>Press the button and play again!&hellip;</p>
            </div>
            <div class="modal-footer">
                <div class="form-letter">
                    <form class="form-game" method="post" action="">
                        <div class="form-group modal-form">
                            <input type="submit" name="next" class="hidden"/>
                            <button type="submit" name="next" class="btn btn-modal bg-black-light" data="modal" id="btn-next">
                                Next Game
                                <i class="glyphicon glyphicon-arrow-right arrow-next"></i>
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div><!-- Modal Window End -->
<script type="text/javascript">
    var gameEnd = false;
    var hasWon = false;
    <?if($gameEnd){?>
        gameEnd = true;
        <?if($hasWon){?>
          var hasWon = true;
    <?}
    }?>

</script>
<script type="text/javascript" src="js/main.js"></script>
</body>
</html>