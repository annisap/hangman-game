<?php
$title = '';
$href = 'home.php';

if(!isset($_SESSION['userSession'])) {
    $title = "Stranger";
}
else if(isset($_SESSION['userSession'])) {
    $title = $_SESSION['username'];
}
?>

<header class="header">
    <nav class="navbar">
        <div class="container container-fluid">
            <!-- Brand and toggle get grouped for better mobile display -->
            <div class="navbar-header">
                <a class="navbar-brand" href="<? echo $href ?>">
                    <span class="welcome">Welcome
                        <? echo $title; ?>
                    </span>
                </a>
            </div>
            ​
            <ul class="nav navbar-nav navbar-right">
                <li class="dropdown">

                    <?if(isset($_SESSION['userSession'])) {
                    ?>
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
                            <i class="glyphicon glyphicon-cog"></i>
                            <span class="caret"></span>
                        </a>
                        <ul class="dropdown-menu">
                            <li><a href="<? echo $href; ?>"><span class="glyphicon glyphicon-home"></span>
                                Home</a></li>
                            <li><a href="./games.php"><span class="glyphicon glyphicon-king"></span>&nbsp;
                                    Games</a></li>
                            <? if ($_SESSION['username'] == 'admin') {
                            ?>
                                <li>
                                    <a href="./words.php">
                                        <span class="glyphicon glyphicon-education"></span>
                                        Words
                                    </a>
                                </li>
                            <?
                            }?>
                            <li class="divider" role="seperator"></li>
                            <li><a href="./logout.php?logout"><span class="glyphicon glyphicon-log-out"></span>&nbsp;
                                    Logout</a></li>
                        </ul>
                    <?}
                    else if (!isset($_SESSION['userSession'])) {
                    ?>
                        <a class="play-button">SIGN IN</a>
                    <?
                    }
                    ?>
                </li>
            </ul>
        </div><!-- /.container-fluid -->
    </nav>
</header>
​