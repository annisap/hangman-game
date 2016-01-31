<?php
session_start();
/* -------------------------- */
/* START VARIABLE SETUP       */
/* -------------------------- */

include_once 'includes/common.inc.php';

//go to login page/index if the session isn't set
if(!isset($_SESSION['userSession']))
{
    header("Location: index.php");

}

$dbc->close();

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <!--<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />-->
    <meta charset = "utf-8">
    <title>Hangman</title>

    <!--meta name = "viewport" content ="width-device-width, initial-scale=1"-->

    <!-- Latest compiled and minified CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" integrity="sha384-1q8mTJOASx8j1Au+a5WDVnPi2lkFfwwEAa8hDDdjZlpLegxhjVME1fgjWPGmkzs7" crossorigin="anonymous">

    <!-- Optional theme -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap-theme.min.css" integrity="sha384-fLW2N01lMqjakBkx3l/M9EahuwpSfeNvV63J5ezn3uZzapT0u7EYsXMjQV+0En5r" crossorigin="anonymous">
    <link rel="stylesheet" href="css/main.css" type="text/css" />

    <!-- Latest compiled and minified JavaScript -->
    <script type="text/javascript" src="https://code.jquery.com/jquery-2.1.4.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js" integrity="sha384-0mSbJDEHialfmuBBQP6A4Qrprq5OVfW37PRR3j5ELqxss1yVqOtnepnHVP9aJ7xS" crossorigin="anonymous"></script>
</head>
<body>
<!-- welcome the user-->
<? include 'includes/header.php';?>

<div class="container-fluid home-section">
    <div class="row">
        <div class="col-xs-12 col-md-4 col-md-offset-4 msg">
            <?
                $now = getdate();
                echo "Good ";
                if($now['hours'] < 9)
                echo "morning ";
                else if($now['hours'] < 12)
                echo "day ";
                else if($now['hours'] < 17)
                echo "afternoon ";
                else if($now['hours'] < 20)
                echo "evening ";
                else
                echo "night ";
                echo " " . $_SESSION['username'];
                if($now['wday'] == 0 || $now['wday'] == 6)
                echo ". Little weekend surfing, I see ";
                else
                echo "Hard at school, eh? ";
            ?>
        </div>
    </div>

    <?if($_SESSION['username'] != 'admin')
    {

    ?>
        <div class="row">
            <div class="col-xs-12 col-md-4 col-md-offset-4">
                <div id="play" type="button" class="btn btn-play-game">
                    <a href="gameview.php?novice">
                        Play Novice Hangman
                        <span class="glyphicon glyphicon-fire" aria-hidden="true"></span>
                    </a>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-xs-12 col-md-4 col-md-offset-4">
                <div id="play" type="button" class="btn btn-play-game">
                    <a href="gameview.php?expert">
                        Play Expert Hangman
                        <span class="glyphicon glyphicon-fire" aria-hidden="true"></span>
                    </a>
                </div>
            </div>
        </div>

        <?
    }else if($_SESSION['username'] == 'admin')
{?>
    <div class="row">
        <div class="col-xs-12 col-md-4 col-md-offset-4">
            <div id="play" type="button" class="btn btn-play-game">
                <a href="games.php">
                    <span class="glyphicon glyphicon-king"></span>
                    Manage games
                </a>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-xs-12 col-md-4 col-md-offset-4">
            <div id="play" type="button" class="btn btn-play-game">
                <a href="words.php">
                    <span class="glyphicon glyphicon-education"></span>
                    Manage words
                </a>
            </div>
        </div>
    </div>
<?}
?>
</div>
</body>
</html>