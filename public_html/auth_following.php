<!DOCTYPE html>

<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="application-name" content="Goals">
    <meta name="description" content="Make meaningful changes in your life">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Inspyre | Following</title>

    <link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/css/bootstrap.min.css">
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
require_once __DIR__ . "/../resources/lib/accounts.php";
require_once __DIR__ . "/../resources/lib/auth.php";
require_once __DIR__ . "/../resources/lib/goals.php";
    
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
            <a class="navbar-brand" href="/">Inspyre</a>
          </div>
          <div class="collapse navbar-collapse" id="myNavbar">
            <ul class="nav navbar-nav">
              <li><a href="/">Home</a></li>
              <li><a href="/auth/addgoal">Add goal</a></li>
              <li class="active"><a href="#">Following</a></li>
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
        $following = getFollowing($uid);
$followingHTML = "";
foreach($following as $uidFollowing) {
    $userHTML = '<div class="media"><div class="media-left"><img class="media-object" src="/img/default_profile.jpg" alt="Profile image" height="32" width="32"></div><div class="media-body"><a href="/profile/' . getNameFromID($uidFollowing) . '"><h3 class="media-heading">' . getNameFromID($uidFollowing) . "</h3></a>You follow this user</div></div><hr>";
    $goalsComplete = 0;
    $goalsTotal = 0;
    foreach(fetchGoals($uidFollowing, MYSQLI_ASSOC) as $row) {
        $goalsTotal += 1;
        if ($row["points_current"] >= $row["points_goal"]) {$goalsComplete += 1;}
    }
    $percentage = ($goalsComplete/$goalsTotal) * 100;
    $userHTML .= '<div class="panel panel-info"><div class="panel-heading">Goals completed</div><div class="panel-body"><div class="progress"><div class="progress-bar progress-bar-info" role="progressbar" aria-valuenow="' . $goalsComplete . '" aria-valuemin="0" aria-valuemax="' . $goalsTotal . '" style="min-width: 5em; width: ' . $percentage . '%;">';
    $userHTML .= $goalsComplete . "/" . $goalsTotal . "</div></div></div></div>";
    $followingHTML .= $userHTML;
}
echo $followingHTML;
        ?>

    </div>

  </body>
</html>
