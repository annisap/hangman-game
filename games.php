<?php

session_start();
/* -------------------------- */
/* START VARIABLE SETUP       */
/* -------------------------- */
include_once 'includes/common.inc.php';


// === Pagination === //

global $a;

$page = $_GET['page'];
//the first time the page loads or the first page
if($page=="" || $page=="1")
{
    $page1=0;

}
else
{
    $page1 = ($page*5)-5;
}

//Limit data selection to 5 rows

if ($games = $dbc->query("SELECT id_g, game.user_id, word.id_w,points, insert_time, word.lower  FROM game, word WHERE
 game.id_w = word.id_w  ORDER BY id_g  LIMIT " . $page1 . ",5"))
{
    $wordinfo = array();
    while ($row_word = $games->fetch_assoc())
    {
        $wordinfo[] = $row_word;
    }
}

// === Search a word === //

else if(isset($_POST['search']))
{
    $search = $dbc->real_escape_string(htmlspecialchars(trim($_POST['search'])));
    $searchQuery = $dbc->query("SELECT id_w FROM word WHERE word_en=" . $search) or die("Query
    error: " . $dbc->error);
    $count = $searchQuery->num_rows;
    if($numRows==0)
    {
        echo "there is no such word in the game";
    }
    else
    {
        $wordinfo = array();
        while ($row_word = $searchQuery->fetch_assoc())
        {
            $wordinfo[] = $row_word;
        }
    }
}

?>
<!DOCTYPE html>
<html >
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
<? include './includes/header.php'; ?>

<div class="container-fluid container-games">

    <div class="panel panel-games">

        <div class="panel-heading bg-black-medium">
            <div class="row">

                <div class="col-xs-12 col-sm-4">
                    <div class="panel-title">
                        Games Table
                    </div>
                </div>
            </div>
        </div>
        <div class="panel-body bg-black-light">
            <form action="" method="post">

            <table class="table">
                <thead>
                <?if(isset($_POST['search']))
                ?>
                <tr>
                    <th>GAME ID</th>
                    <th>USER</th>
                    <th>ID WORD</th>
                    <th>SCORE</th>
                    <th>DATE</th>
                    <th>DIFFICULTY LEVEL</th>
                    <?if(($_SESSION['username'])=='admin'){?>
                    <th>ACTIONS</th>
                    <?}?>
                </tr>
                </thead>
                <tbody>
                <? foreach ($wordinfo as $word) {
                    if ($word['lower'] == 1)
                        $level = "elementary";
                    else
                        $level = "advanced";

                    echo "<tr><td>" . $word['id_g'] . "</td><td>". $word['user_id'] ."</td><td>". $word['id_w'] ."</td><td>"
                        . $word['points'] .
                        "</td><td>" . $word['insert_time'] . "</td><td>" . $level . "</td>";

                    if(($_SESSION['username'])=='admin'){
                        echo "<td> <div id='delete' type='button' class='btn bg-white-medium' value = '{$word['id_g']}'>
                                  <a href='delete_game.php?id={$word['id_g']}'><span class='glyphicon glyphicon-trash'
                                 aria-hidden='true'></span></a>
                                </div></td></td></tr>";}

                    if(($_SESSION['username'])!='admin')
                    {
                        echo "</tr>";
                    }

                }
    ?>

    </tbody>

    </table>

    </div>
    </div>
    <div class="row">
        <div class="col-xs-12 pagination-container">
            <nav>
                <ul class="pagination">
                    <li>
                        <a href="games.php?page=1" aria-label="Previous">
                            <span aria-hidden="true">&laquo;</span>
                        </a>
                    </li>
                    <?
                        //this is for counting the number of the pages
                        $games_all = $dbc->query("SELECT * FROM game");
                        $numRows = $games_all->num_rows;
                        $a = ceil($numRows/5);
                        for($i=1; $i<=$a; $i++)
                        {
                            ?><li><a href="games.php?page=<?echo $i;?>" style="text-decoration: none "><? echo $i . " "; ?></a></li><?

                        }
                        $dbc->close();
                    ?>
                    <li>
                        <a href="games.php?page=<? echo $a ?>" aria-label="Next">
                            <span aria-hidden="true">&raquo;</span>
                        </a>
                    </li>
                </ul>
            </nav>
        </div>
    </div>
</div>
</body>
</html>