<!DOCTYPE html>

<html>
  <head>
    <meta charset="utf-8">
    <meta name="application-name" content="Goals">
    <meta name="description" content="Make meaningful changes in your life">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Inspyre | Home</title>

    <link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/css/bootstrap.min.css">
    <link rel="stylesheet" href="/css/custom.css">

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
    <script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/js/bootstrap.min.js"></script>
  
    <script>
      var xmlhttp = new XMLHttpRequest();

      xmlhttp.onreadystatechange = function() {
          if (xmlhttp.readyState == 4) {
              var userExists = JSON.parse(xmlhttp.responseText).userExists;
              if (userExists) {
                  $('.form-username').removeClass("has-error");
                  window.location.replace("/profile/" + $("#form-username").val());
              } else {
                  $('#form-username').val("");
                  $('.form-username').addClass("has-error");
              }
          }
      };

      function submitForm() {
          var ajaxURL = "/ajax_userExists/" + $('#form-username').val();
          
          xmlhttp.open("GET", ajaxURL, true);
          xmlhttp.send();
      }
    </script>

  </head>


  <body>
      
<?php
      require_once __DIR__ . "/../auth.php";
require_once __DIR__ . "/../accounts.php";
require_once __DIR__ . "/../goals.php";
    
$uid = getAndVerifyToken();

?>

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
            <a class="navbar-brand" href="#">Inspyre</a>
          </div>
          <div class="collapse navbar-collapse" id="myNavbar">
            <ul class="nav navbar-nav">
              <li class="active"><a href="#">Home</a></li>
              <li><a href="/auth/addgoal">Add goal</a></li>
              <li><a href="/auth/following">Following</a></li>
            </ul>
            <ul class="nav navbar-nav navbar-right">
              <li class="dropdown">
                <a class="dropdown-toggle" data-toggle="dropdown" href="#" id="dropdown-profile">
                  <?php
                     echo getNameFromID($uid);
                     ?> <span class="caret"></span>
                </a>
                <ul class="dropdown-menu list-group" role="menu" aria-labelledby="dropdown-profile">
                  <li><a href="/logout"><span class="glyphicon glyphicon-log-out"></span> Log out</a></li>
                </ul>
              </li>
            </ul>
            <ul class="nav navbar-nav navbar-right">
              <li class="dropdown">
                <a class="dropdown-toggle" data-toggle="dropdown" href="#"><span class="glyphicon glyphicon-inbox"></span></a>
                <ul class="dropdown-menu list-group" role="menu">
                    <?php
    $ratings = getRatings($uid, MYSQLI_ASSOC);
deleteRatings($uid);
$ratingsHTML = "";

foreach ($ratings as $row) {
    $goalID = $row["g_id"];
    $rater = $row["u_from"];
    $ratingNum = $row["rating"];
    
    $rating = '';
    $rating .= '<li class="list-group-item">User ' . getNameFromID($rater) . ' rated your goal "' . getGoalName($goalID) . '" ' . mapRatingToText($ratingNum) . ' (' . $ratingNum . ' point(s))</li>';

    $ratingsHTML .= $rating;
}

    echo $ratingsHTML;
                    ?>
                </ul>
              </li>
            </ul>
            <form class="navbar-form navbar-right" onsubmit="submitForm();return false;">
              <div class="input-group form-username">
                <span class="input-group-addon" id="basic-addon1">@</span>
                <input type="text" class="form-control" name="username" id="form-username" placeholder="Username" aria-describedby="basic-addon1">
              </div>
              <button class="btn btn-default">Search</button>
            </form>
          </div>
        </div>
      </nav>
      
      <?php
$rows = fetchGoals($uid, MYSQLI_ASSOC);

$goals = "";
if (count($rows) != 0) {
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
        $goal .= '<a href="/auth/deletegoal/' . $goalID . '" class="confirmation"><span class="glyphicon glyphicon-remove"></span></a>';
        $goal .= '</span>';
        $goal .= '</div><div class="panel-body"><div class="progress"><div class="progress-bar ' . $progressType . '" role="progressbar" aria-valuenow="' . $points . '" aria-valuemin="0" aria-valuemax="' . $pointsGoal . '" style="min-width: 5em; width: ' . $percentage . '%;">';
        $goal .= $points . "/" . $pointsGoal . "</div></div></div></div>";
        
        $goals .= $goal;
    }
} else {
    $goals = '<div class="text-center">You have no goals! <a href="/auth/addgoal/">Create one?</a></div>';
}

echo $goals;
      ?>
      
    </div>

  </body>
</html>
