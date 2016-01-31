<?php
$msg = '';

include('includes/common.inc.php');
if ($_GET['id'])
{
    $result = $dbc->query("DELETE FROM word WHERE id_w ='{$_GET['id']}'");
    if (($dbc->affected_rows)> 0)
    {
        $msg = 'Row deleted!';
    }
    else
        $msg = 'Delete failed';
}?>

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
<div class="container-fluid container-delete">
    <div class="col-xs-3 col-xs-offset-6">
        <h3><? echo $msg ?></h3>
        <div class="btn bg-black-medium">
            <a class="btn-back" href="words.php">Back to Words!</a>
        </div>
    </div>
</div>

</body>
</html>