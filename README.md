# Hangman

A user initially creates an account and then he chooses to play novice or expert hangman depending on the number of tries.
The player can also monitor his game progress and watch other's players games.

The application allows admin functions such as crud operations on words and delete only operations on games.

The database has three tables: Users, Words and Games and it stores only the basic data about each entity. I also used session to maintain the state of the user and of the game.

It supports responsive design with a little help from Bootstrap and animations with a little help from jQuery


**REQUIREMENTS**

Install WAMP/MAMP and be sure that php and apache works correctly.
Moreover choose a recent php version that supports mysqli.

**INSTALLATION**

 - Copy files into your working directory(phpstorm is a really good workplace).
 - Import the .sql file to the phpadmin interface to create the database.
 - Change the values of the variables in common.inc.php to match your
   database information.
