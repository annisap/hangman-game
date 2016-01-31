<?php
//administrator's page

session_start();
/* -------------------------- */
/* START VARIABLE SETUP       */
/* -------------------------- */
include 'includes/common.inc.php';

if(!isset($_SESSION['userSession']))
{
    header("Location: index.php");
}

global $a;

$page = $_GET['page'];
//the first time the page loads or the first page
if($page=="" || $page=="1")
{
    $page1=0;

}
//from the second page and further
else
{
    $page1 = ($page*10)-10;
}

//it isn't necessary
if($query = $dbc->query("SELECT * FROM user WHERE user_id=".$_SESSION['userSession']))
{
    $userRow = $query->fetch_array();
    $user = $userRow['name_u'];
    $_SESSION['username']= $user;
}
//select the 10 first rows from db
if($q_w = $dbc->query("SELECT * FROM word ORDER BY id_w  LIMIT " . $page1 . ",10"))
{
    $wordinfo = array();

    while ($row_word = $q_w->fetch_assoc())
    {
        $wordinfo[] = $row_word;
    }
}

//if user search a word
if(isset($_POST['search']))
{
    $search = $dbc->real_escape_string(htmlspecialchars(trim($_POST['search'])));
    $searchQuery = $dbc->query("SELECT * FROM word WHERE word_en LIKE '$search'") or die("Query
    error: " . $dbc->error);
    $count = $searchQuery->num_rows;
    if($count==0)
    {
        echo "there is no such word in the game";
    }
    else
    {
        $word = $searchQuery->fetch_array(MYSQLI_ASSOC);

    }
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
    <div class="container-fluid container-words">


    <div class="panel panel-words bg-black-light">
        <!--search-->
        <div class="col-sm-3 col-md-3">
            <form action="" method="post" class="navbar-form" role="search">
                <div class="input-group">
                    <input type="text" name="search" class="form-control" placeholder="Search">
                    <div class="input-group-btn">
                        <button class="btn btn-default" type="submit"><i class="glyphicon glyphicon-search"></i></button>
                    </div>
                </div>
            </form>
        </div>
        <!--search ends-->
        <!--table of words-->
        <div class = "panel-heading bg-black-medium">Words Table</div>
        <div class="panel-body bg-black-light">

            <table class="table">
                <thead>
                <tr>
                    <th>ENGLISH</th>
                    <th>VOCABULARY LEVEL</th>
                    <th>GREEK</th>
                    <th>PHRASE/SYNONYM</th>
                    <th><div class= "btn btn-primary-sm" align="right" type="button" id = "add">
                            <a href="insert.php"><span class="glyphicon glyphicon-plus" ></span></a>
                        </div></th>
                </tr>
                </thead>
                <tbody>
                <?if(!isset($_POST['search'])){
                    foreach ($wordinfo as $word) {
                        if ($word['lower'] == 1)
                            $level = "elementary";
                        else
                            $level = "advanced";

                        echo "<tr><td>" . $word['word_en'] . "</td><td>" . $level . "</td><td>"
                            . $word['word_gr'] .
                            "</td><td>" .
                            $word['synonym'] . "</td><td><div
class='btn-group btn-group-sm' role='group' aria-label='Right Align'>
                            <div id='delete' type='button' class='btn bg-white-medium' value = '{$word['id_w']}'>
                              <a href='delete_word.php?id={$word['id_w']}'><span class='glyphicon glyphicon-trash'
                             aria-hidden='true'></span></a>
                            </div>

                            <div id='edit' type='button' class='btn bg-white-medium'>
                                <a href='edit.php?id={$word['id_w']}'><span class='glyphicon glyphicon-pencil'
                                aria-hidden='true' aria-hidden='true'></span>
                            </div>
                            </div></td></tr>";
                    }
                }
                else if(isset($_POST['search']))
                {
                    if ($word['lower'] == 1)
                        $level = "elementary";
                    else
                        $level = "advanced";

                    echo "<tr><td>" . $word['word_en'] . "</td><td>" . $level . "</td><td>"
                        . $word['word_gr'] .
                        "</td><td>" .
                        $word['synonym'] . "</td><td><div
class='btn-group btn-group-sm' role='group' aria-label='Right Align'>
                            <div id='delete' type='button' class='btn btn-danger' value = '{$word['id_w']}'>
                              <a href='delete_word.php?id={$word['id_w']}'><span class='glyphicon glyphicon-trash'
                             aria-hidden='true'></span></a>
                            </div>

                            <div id ='edit' type='button' class='btn btn-info'>
                                <a href='edit.php?id={$word['id_w']}'><span class='glyphicon glyphicon-pencil'
                                aria-hidden='true'aria-hidden='true'></span>
                            </div>
                            </div></td></tr>";
                }
                ?>

                </tbody>

            </table>

        </div>
        <!--table of words ends-->
    </div>
    <!--panel primary ends-->

    <div class="row">
        <div class="col-xs-12 pagination-container">
            <nav>
                <ul class="pagination">
                    <li>
                        <a href="words.php?page=1" aria-label="Previous">
                            <span aria-hidden="true">&laquo;</span>
                        </a>
                    </li>
                    <!--select the page you want to go-->
                    <?
                    $words_all = $dbc->query("SELECT * FROM word");
                    $numRows = $words_all->num_rows;
                    $a = ceil($numRows/10);
                    for($i=1; $i<=$a; $i++)
                    {
                        ?><li><a href="words.php?page=<?echo $i;?>" style="text-decoration: none "><? echo $i . "
                        "; ?></a></li><?

                    }
                    ?>
                    <li>
                        <a href="words.php?page=<? echo $a; ?>" aria-label="Next">
                            <span aria-hidden="true">&raquo;</span>
                        </a>
                    </li>
                </ul>
            </nav>
        </div>
    </div><!-- Pagination Ends-->
</div><!-- Container Ends-->

</body>
</html>


