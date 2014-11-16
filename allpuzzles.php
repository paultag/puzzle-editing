<?php
        require_once "config.php";
        require_once "html.php";
        require_once "db-func.php";
        require_once "utils.php";

        // Redirect to the login page, if not logged in
        $uid = isLoggedIn();

        // Start HTML
        head("allpuzzles", "All Puzzles");
        echo '<style type="text/css">.puzzideasummary {background-color: #000000;}</style>';
        // Check for lurker permissions
        if (!canSeeAllPuzzles($uid)  && !isApprover($uid)) {
                echo "<div class='errormsg'>You do not have permissions for this page.</div>";
                foot();
                exit(1);
        }

        $filt = isValidPuzzleFilter();

        displayPuzzleStats($uid);
?>

        <div class="inlbox">
        <form method="get" action="allpuzzles.php" class="inlform">
        <input type="hidden" name="filterkey" value="status">
        <select name="filtervalue">
<?php
        $statuses = getPuzzleStatuses();
        foreach ($statuses as $sid => $sname) {
                echo "<option value='$sid'>$sname</option>";
        }
?>
        </select>
        <input type="submit" value="Filter status">
        </form>
        <form method="get" action="allpuzzles.php" class="inlform">
        <input type="hidden" name="filterkey" value="approver">
        <select name="filtervalue">
<?php
        $editors = getAllEditors();
	if(USING_APPROVERS) { $editors = getAllApprovalEditors(); }
        asort($editors);
        foreach ($editors as $uid => $fullname) {
                echo "<option value='$uid'>$fullname</option>";
        }
?>
        </select>
        <input type="submit" value="Filter approver">
        </form>
        <form method="get" action="allpuzzles.php" class="inlform">
        <input type="hidden" name="filterkey" value="author">
        <select name="filtervalue">
<?php
        $authors = getAllAuthors();
        asort($authors);
        foreach ($authors as $uid => $fullname) {
                echo "<option value='$uid'>$fullname</option>";
        }
?>
        </select>
        <input type="submit" value="Filter author">
        </form>
        <form method="get" action="allpuzzles.php" class="inlform">
        <input type="hidden" name="filterkey" value="tag">
        <select name="filtervalue">
<?php
        $tags = getAllTags();
        asort($tags);
        foreach ($tags as $tid => $name) {
                echo "<option value='$tid'>$name</option>";
        }
?>
        </select>
        <input type="submit" value="Filter tag">
        </form>
        </div>
<?php

        $puzzles = getAllPuzzles();
	$uid = isLoggedIn();
        echo "(Hiding dead puzzles by default)<br><br>";
        displayQueue($uid, $puzzles, "notes answer summary editornotes tags authorsandeditors", FALSE, $filt);


        // End HTML
        foot();
?>

