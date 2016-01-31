<?php
session_start();

if(!isset($_SESSION['userSession']))
{
    header("Location: index.php");
}

else if(isset($_SESSION['userSession'])!="")
{
    header("Location: home.php");
}

else if(isset($_SESSION['isAdmin'])!="")
{
    header("Location: words.php");
}

if(isset($_GET['logout']))
{
    session_destroy();
    unset($_SESSION['userSession']);
    header("Location: index.php");
}
