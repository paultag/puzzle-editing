<?php // vim:set ts=4 sw=4 sts=4 et:
require_once "config.php";
require_once "html.php";
require_once "db-func.php";
require_once "utils.php";

// Redirect to the login page, if not logged in
$uid = isLoggedIn();

// Start HTML
head("factcheck", "Fact Checking Overview");

// Check for permissions
if (!isFactChecker($uid)) {
?>
    <h3>Not a factchecker</h3>
    <p>You are not currently a factchecker. (If you are a blind testsolver, please do
    not use this page.</p>
    <p>Anybody can factcheck &mdash; please start by reading
    <a href="/HowToFactcheck">the instructions</a>.
    Once you've done that, the button below will grant you factchecking access.
    </p>
    <p><b>THIS WILL LET YOU VIEW ALL PUZZLES IN FACTCHECKING. PLEASE DON'T ABUSE
    IT.</b>
    </p>
    <p>It's fine if you claim a puzzle, then realize you have to throw it back for
    whatever reason. But please don't go through viewing all the puzzles for fun. :-)
    </p>
    <form action="form-submit.php" method="post">
        <input type="hidden" name="uid" value="<?php echo $uid; ?>" />
        <input type="submit" name="SelfAddFactchecker" value="I have read the instructions" />
    </form>
<?php
    foot();
    exit(1);
}

displayPuzzleStats($uid);

echo "<h2>Factchecking</h2>";

?>
    <form action="form-submit.php" method="post">
        <input type="hidden" name="uid" value="<?php echo $uid; ?>" />
        Enter Puzzle ID to factcheck: <input type="text" name="pid" />
        <input type="submit" name="FactcheckPuzzle" value="Go" />
    </form>
<?php

echo '<br/>';
echo '<h3>Your Puzzles:</h3>';
$puzzles = getPuzzlesForFactchecker($uid);
displayQueue($uid, $puzzles, "notes", FALSE);

echo '<br/>';
echo '<h3>Unclaimed Puzzles:</h3>';
$puzzles = getUnclaimedPuzzlesInFactChecking();
displayQueue($uid, $puzzles, "notes", FALSE);

echo '<br/>';
echo '<h3>Already Claimed:</h3>';
$puzzles = getClaimedPuzzlesInFactChecking();
displayQueue($uid, $puzzles, "notes", FALSE);

// End HTML
foot();
?>
