<!DOCTYPE html>

<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="application-name" content="Goals">
    <meta name="description" content="Make meaningful changes in your life">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Goals | Add goal</title>

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
      require_once __DIR__ . "/../auth.php";
require_once __DIR__ . "/../accounts.php";
require_once __DIR__ . "/../goals.php";
    
$uid = getAndVerifyToken();
if (!getAndVerifyToken()) {
    redirectToPage("/login");
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (!empty($_POST["goalName"])) {
        $goalName = testInput($_POST["goalName"]);
    }

    if (!empty($_POST["pointsGoal"])) {
        $pointsGoal = testInput($_POST["pointsGoal"]);
    }

    createGoal($uid, $goalName, $pointsGoal);
}
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
            <a class="navbar-brand" href="#">Goals</a>
          </div>
          <div class="collapse navbar-collapse" id="myNavbar">
            <ul class="nav navbar-nav">
              <li class="active"><a href="#">Home</a></li>
              <li><a href="/auth/addgoal">Add goal</a></li>
            </ul>
            <form class="navbar-form navbar-right" onsubmit="submitForm();return false;">
              <div class="input-group form-username">
                <span class="input-group-addon" id="basic-addon1">@</span>
                <input type="text" class="form-control" name="username" id="form-username" placeholder="Username" aria-describedby="basic-addon1">
              </div>
              <button class="btn btn-default">Search</button>
            </form>
            <ul class="nav navbar-nav navbar-right">
              <li><a href="/logout"><span class="glyphicon glyphicon-log-out"></span> Log out</a></li>
            </ul>
          </div>
        </div>
      </nav>
      
      <div class="well">
        <form action="/auth/addgoal" method="post" role="form">
          <div class="form-group">
            <input type="text" class="form-control" name="goalName" placeholder="Goal name" maxlength="255" required>
          </div>
          <div class="form-group">
            <input type="number" class="form-control" name="pointsGoal" placeholder="Weekly points goal" required>
          </div>
          <div class="form-group">
            <input type="submit" class="btn btn-success" value="Create goal">
        </form>
      </div>
      
  </body>
</html>
