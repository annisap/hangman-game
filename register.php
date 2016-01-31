<?php

session_start();

include_once 'includes/common.inc.php';
//if form submitted do not display the form

if(isset($_POST['btn-signup']))
{

    $uname = $dbc->real_escape_string(htmlspecialchars(trim($_POST['user_name'])));
    $upass = $dbc->real_escape_string(htmlspecialchars(trim($_POST['password'])));
    $isadmin=0;
    $motto = $dbc->real_escape_string(htmlspecialchars(trim($_POST['motto'])));
    $age   = $dbc->real_escape_string(trim($_POST['age']));

    //password hashing API to secure our code

    $new_password = password_hash($upass, PASSWORD_DEFAULT);

    //validation of all the fields
    if(!empty($uname)&& !empty($upass) && !empty($motto) && !empty($age))
    {

        //check the unique existence of username in table user before adding him/her

        if ($check_uname = $dbc->query("SELECT name_u FROM user WHERE name_u='$uname'"))
        {
            $count = $check_uname->num_rows;


            if ($count == 0)
            {

                $query = "INSERT INTO user(name_u, pass , isAdmin, motto , age) VALUES('$uname','$new_password','$isadmin','$motto',
'$age')";
                //success of query and make a message

                if ($dbc->query($query))
                {
                    header("Location: index.php");
                }

                else
                {
                    $msg = "<div class='alert alert-danger'>
      <span class='glyphicon glyphicon-info-sign'></span> &nbsp; error while registering !
     </div>";
                }
            } //close count=0 !

            else
            {

                $msg = "<div class='alert alert-danger'>
     <span class='glyphicon glyphicon-info-sign'></span> &nbsp; sorry username already taken !
    </div>";
            }
        } //close check user's name!
    }

    else
    {
        echo "all the fields are required";
    }

    $dbc->close();

} //close button sign
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
<div class="container main-content">
    ​
    <div class="row form-container">
        <div class="col-xs-12 col-sm-6 col-sm-offset-3 col-md-4 col-md-offset-4">
            <div class="signin-form open">
                <form class="form-signin" method="post" action ="" id="sign-up-form">
                    ​
                    <h2 class="form-signin-heading">Sign Up.</h2><hr />
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

                    <div class="form-group">
                        <input type="text" class="form-control" placeholder="Motto" name="motto" maxlength="30"/>
                    </div>

                    <div class="form-group">
                        <input type="text" class="form-control" placeholder="Age" name="age" maxlength="11"/>
                    </div>

                    <hr />

                    <!--button submit sign-up of form-group -->

                    <div class="form-group">
                        <button type="submit" class="btn" name="btn-signup">
                            <span class="glyphicon glyphicon-log-in"></span> &nbsp; Create Account
                        </button>

                        <!--button submit login of form-group -->
                        <a href="./index.php" class="btn">Log In Here</a>

                    </div>
                </form>
            </div>
        </div>
    </div>

</div><!-- Container End -->

<script type="text/javascript" src="js/main.js"></script>

</body>
</html>

