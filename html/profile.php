<!DOCTYPE html>

<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="application-name" content="Goals">
    <meta name="description" content="Make meaningful changes in your life">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <?php
     require_once __DIR__ . "/../accounts.php";
require_once __DIR__ . "/../goals.php";

if (isset($_GET["username"])) {
    $username = testInput($_GET["username"]);
    echo "<title>Goals | " . $username . "</title>";
}
       ?>

    <link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
    <script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/js/bootstrap.min.js"></script>
  </head>


  <body>

    <!-- Body -->
    <div class="container-fluid">

      <!-- Navbar -->
      <nav class="navbar navbar-default">
        <div class="container-fluid">
          <div class="navbar-header">
            <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#myNavbar">
              <span class="icon-bar"></span>
              <span class="icon-bar"></span>
              <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="/">Goals</a>
          </div>
          <div class="collapse navbar-collapse" id="myNavbar">
            <ul class="nav navbar-nav">
              <li><a href="/auth/index/">Home</a></li>
              <li><a href="/auth/addgoal">Add goal</a></li>
            </ul>
            <ul class="nav navbar-nav navbar-right">
              <li><a href="/logout"><span class="glyphicon glyphicon-log-out"></span> Log out</a></li>
            </ul>
          </div>
        </div>
      </nav>
      
      <?php
    $uid = getIDFromName($username);

$rows = fetchGoals($uid, MYSQLI_ASSOC);

$goals = "<h1>" . $username . "</h1>";
foreach ($rows as $row) {
    $goalID = $row["g_id"];
    $goalName = $row["g_name"];
    $pointsGoal = $row["points_goal"];
    $points = $row["points_current"];
    $percentage = ($points/$pointsGoal) * 100;
    if ($percentage > 100) {$percentage = 100;}

    if ($percentage == 100) {
        $panelType = "panel-success";
        $progressType = "progress-bar-success";
    } else {
        $panelType = "panel-info";
        $progressType = "";
    }
    
    $goal = '<div class="panel ' . $panelType . '"><div class="panel-heading">';
    $goal .= $goalName;
    $goal .= '<span class="pull-right">';
    if ($percentage == 100) {$goal .= '<strong>Goal reached! </strong>';}
    $goal .= '<a href="/auth/rategoal/' . $goalID . '">';
    $goal .= '<span class="glyphicon glyphicon-plus-sign"></span></a>';
    $goal .= '</span>';
    $goal .= '</div><div class="panel-body"><div class="progress"><div class="progress-bar ' . $progressType . '" role="progressbar" aria-valuenow="' . $points . '" aria-valuemin="0" aria-valuemax="' . $pointsGoal . '" style="min-width: 2em; width: ' . $percentage . '%;">';
    $goal .= $points . "/" . $pointsGoal . "</div></div></div></div>";
    
    $goals .= $goal;
}
echo $goals;
      ?>
      
    </div>

  </body>
</html>
