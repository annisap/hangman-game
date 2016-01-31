<?php
session_start();
/* -------------------------- */
/* START VARIABLE SETUP       */
/* -------------------------- */

include_once 'includes/common.inc.php';

// === Cut whitespaces, Convert special characters to HTML entities and Escape special characters in a string
// for use in the SQL statement, When login button is pushed === //


if(isset($_POST['btn-login']))
{

    $uname = $dbc->real_escape_string(htmlspecialchars(trim($_POST['user_name'])));
    $upass = $dbc->real_escape_string(htmlspecialchars(trim($_POST['password'])));

    if(!empty($uname) && !empty($upass)) {

        if ($query = $dbc->query("SELECT * FROM user WHERE name_u='$uname'")) {
            $row = $query->fetch_assoc();//fetch the result row as an array


            if (password_verify($upass, $row['pass'])) //password and hashed matched
            {
                $_SESSION['userSession'] = $row['user_id'];
                $_SESSION['username'] = $row['name_u'];
                header("Location: home.php");
            }
            else
            {
                $msg = "username or password does not exist!";
            }
        }
    }
    else
        echo "please complete all the fields";


    $dbc->close();

}
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
<? include 'includes/header.php'; ?>
<div class="container main-content">
    ​
    <div class="row form-container">
        <div class="col-xs-12 col-sm-6 col-sm-offset-3 col-md-4 col-md-offset-4">
            <div class="signin-form">
                <form class="form-signin" method="post" action ="" id="login-form">
                    ​
                    <h2 class="form-signin-heading">Sign In.</h2><hr />
                    ​
                    <?
                    if(isset($msg)){
                        echo $msg;
                    }

                    ?>
                    <!-- User's inputs into form-group-->
                    ​
                    <div class="form-group">
                        <input type="text" class="form-control" placeholder="Username" name="user_name" maxlength="10"/>
                    </div>
                    ​
                    <div class="form-group">
                        <input type="password" class="form-control" placeholder="Password" name="password"
                               maxlength="16"/>
                    </div>
                    ​
                    <div class="form-group">
                        <button type="submit" class="btn btn-sign-in" name="btn-login" id="btn-login">
                            <span class="glyphicon glyphicon-log-in"></span> &nbsp; Sign In
                        </button>
                        ​
                        <a href="register.php" class="btn btn-sign-up" style="float:right;">Sign Up Here</a>
                        ​
                    </div>
                </form>
            </div>
        </div>
    </div>

</div><!-- Container End -->

<script type="text/javascript" src="js/main.js"></script>

</body>
</html>
