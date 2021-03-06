<?php // vim:set ts=4 sw=4 sts=4 et:
require_once "config.php";
require_once "html.php";
require_once "db-func.php";
require_once "utils.php";

// Redirect to the login page, if not logged in
$uid = isLoggedIn();

// Start HTML
head("author", "Author Overview");
?>
    <h3><a href="submit-new.php">Submit New Puzzle Idea</a></h3>
    <h3>&nbsp;</h3>
    <h3>Your Puzzles</h3>
<?php
$puzzles = getPuzzlesForAuthor($uid);
displayQueue($uid, $puzzles, "notes summary editornotes answer authorsandeditors", FALSE);

// End the HTML
foot();
?>
