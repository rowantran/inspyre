<!DOCTYPE html>

<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="application-name" content="Goals">
    <meta name="description" content="Make meaningful changes in your life">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Goals | Rate goal</title>

    <link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
    <script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/js/bootstrap.min.js"></script>
  </head>


  <body>
<?php
require_once __DIR__ . "/../resources/lib/auth.php";
require_once __DIR__ . "/../resources/lib/goals.php";

$uid = getAndVerifyToken();
if (!$uid) {
    redirectToPage("/login");
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (!empty($_POST["rating"])) {
        $rating = testInput($_POST["rating"]);
    }
    if (!empty($_POST["gid"])) {
        $gid = testInput($_POST["gid"]);
    }
    rateGoal($uid, $gid, $rating);
    
    redirectToPage("/");
}
?>
    <!-- Body -->
    <div class="container-fluid">
      <div class="well">
        <form action="/auth/rategoal" method="post" role="form">
          <div class="form-group">
            <input type="radio" name="rating" value="0">Bad</input>
            <input type="radio" name="rating" value="1">Decent</input>
            <input type="radio" name="rating" value="2">Good</input>
            <?php
               if (isset($_GET["goalID"])) {
                   $gid = $_GET["goalID"];
                   echo '<input type="hidden" name="gid" value="' . $gid . '">';
               }
             ?>
          </div>
          <div class="form-group">
            <input type="submit" class="btn btn-success" value="Rate">
          </div>
        </form>
      </div>
    </div>

  </body>
</html>
