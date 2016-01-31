<?php
session_start();
/* -------------------------- */
/* START VARIABLE SETUP       */
/* -------------------------- */
include 'includes/common.inc.php';
$msg = '';
$isModalOpened = 'false';
$warn = false;
$warnClass = 'hidden';

if (isset ($_POST['submit'])) {

    $english = $dbc->real_escape_string(htmlspecialchars($_POST['english']));
    $lower = $_POST['lower'];
    $greek = $dbc->real_escape_string(htmlspecialchars($_POST['greek']));
    $synonym = $dbc->real_escape_string(htmlspecialchars($_POST['synonym']));

    if(!empty($english)  && !empty($greek) && !empty($synonym)) {

        $result = $dbc->query("INSERT INTO word (word_en, lower, word_gr, synonym) VALUES ('$english', '$lower', '$greek', '$synonym')") or die("Query
    error: " . $dbc->error);

        if (($dbc->affected_rows) > 0) {
            $msg = 'A new word has successfully been inserted!';
            $isModalOpened = 'true';
        } else
            $msg =  "Could not insert word";
            $isModalOpened = 'true';
    }
    else
    {
        $warn = true;
        $warnClass = '';
    }

    //$dbc->close();
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
        <link rel="stylesheet" href="css/form.css" type="text/css" />

        <!-- Latest compiled and minified JavaScript -->
        <script type="text/javascript" src="https://code.jquery.com/jquery-2.1.4.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js" integrity="sha384-0mSbJDEHialfmuBBQP6A4Qrprq5OVfW37PRR3j5ELqxss1yVqOtnepnHVP9aJ7xS" crossorigin="anonymous"></script>
    </head>

    <body>
    <div class="container-fluid container-insert">
        <div class="row">
            <div class="login">
                <div class="heading">
                <form action="" method="POST" class="form-insert">
                    <div class="input-group input-group-lg">
                        <span class="input-group-addon" id="eng">ENGLISH</span>
                        <input type="text" class="form-control" placeholder="Enter the word" name="english"
                               aria-describedby="eng" maxlength="20">
                    </div>
                    <div class="input-group input-group-lg">
                        <span class="input-group-addon" id="level">LEVEL</span>
                        <select class="form-control" name="lower" aria-describedby="level">
                            <option value="1">Elementary</option>
                            <option value="0">Advanced</option>
                        </select>

                    </div>

                    <div class="input-group input-group-lg">
                        <span class="input-group-addon" id="gr">GREEK</span>
                        <input type="text" class="form-control" placeholder="Enter the word" name="greek"
                               aria-describedby="gr" maxlength="20">
                    </div>

                    <div class="input-group input-group-lg">
                        <span class="input-group-addon" id="synonym">SYNONYM</span>
                        <input type="text" class="form-control" placeholder="Enter the synonym" name="synonym"
                               aria-describedby="synonym" maxlength="50">
                    </div>
                    <button class="float" name="submit" type="submit" value="Insert">Insert</button>
                    <div class="alert alert-danger <? echo $warnClass; ?>" role="alert">All fields are required</div>

                </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Window -->
    <div class="modal fade" id="info-modal" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="information
modal">
        <div class="modal-dialog modal-sm">
            <div class="modal-content modal-success">
                <div class="modal-header">
                    <h4 class="modal-title">
                        <? echo $msg; ?>
                    </h4>
                </div>
                <div class="modal-body">
                    <p>Back to words list!&hellip;</p>
                </div>
                <div class="modal-footer">
                    <div class="form-letter">
                        <form class="form-game" method="post" action="">
                            <div class="form-group modal-form">
                                <a href="words.php">BACK</a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div><!-- Modal Window End -->
    <script type="application/javascript">
        var isModalOpened = <? echo $isModalOpened;?>;


        if (isModalOpened) {
            var $modal = $('#info-modal');

            $modal.modal('show');
        }
    </script>
    </body>
    </html>


