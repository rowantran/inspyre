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
  </head>


  <body>
      
<?php
      require_once __DIR__ . "/../auth.php";
require_once __DIR__ . "/../accounts.php";
    
$uid = getAndVerifyToken();
if (!getAndVerifyToken()) {
    die();
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
            <a class="navbar-brand" href="auth_index.php">Goals</a>
          </div>
          <div class="collapse navbar-collapse" id="myNavbar">
            <ul class="nav navbar-nav">
              <li><a href="auth_index.php">Home</a></li>
              <li class="active"><a href="#">Add goal</a></li>
            </ul>
            <ul class="nav navbar-nav navbar-right">
              <li><a href="logout.php"><span class="glyphicon glyphicon-log-out"></span> Log out</a></li>
            </ul>
          </div>
        </div>
      </nav>
      
      <div class="well">
        <form action="auth_addgoal.php" method="post" role="form">
          <div class="form-group">
            <input type="text" class="form-control" name="goalName" placeholder="Goal name" maxlength="255" required>
          </div>
          <div class="form-group">
            <input type="number" class="form-control" name="pointsGoal" placeholder="Weekly points goal" required>
          </div>
        </form>
      </div>
      
  </body>
</html>
