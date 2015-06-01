<!DOCTYPE html>

<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="application-name" content="Goals">
    <meta name="description" content="Make meaningful changes in your life">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Goals | Home</title>

    <link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
    <script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/js/bootstrap.min.js"></script>
  </head>


  <body>
      
<?php
      if (isset($_COOKIE["token"])) {
          $URL = "auth_index.php";
          header('Location: ' . $URL);
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
            <a class="navbar-brand" href="#">Goals</a>
          </div>
          <div class="collapse navbar-collapse" id="myNavbar">
            <ul class="nav navbar-nav">
              <li class="active"><a href="#">Home</a></li>
            </ul>
            <ul class="nav navbar-nav navbar-right">
              <li><a href="register.php"><span class="glyphicon glyphicon-user"></span> Register</a></li>
              <li><a href="login.php"><span class="glyphicon glyphicon-log-in"></span> Login</a></li>
            </ul>
          </div>
        </div>
      </nav>
      
      
      <div class="jumbotron">
        <h1>Goals</h1>
        <p>Goals helps you create meaningful change in your life. Start tracking your milestones with the help of your peers today.</p>
      </div>
    </div>
    
  </body>
</html>
