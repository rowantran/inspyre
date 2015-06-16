<!DOCTYPE html>

<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="application-name" content="Goals">
    <meta name="description" content="Make meaningful changes in your life">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Inspyre | Home</title>

    <link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/css/bootstrap.min.css">
    <link rel="stylesheet" href="css/custom.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
    <script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/js/bootstrap.min.js"></script>
  </head>


  <body class="splash">
      
<?php
      require_once __DIR__ . "/../resources/lib/db.php";

      if (isset($_COOKIE["token"])) {
          redirectToPage("/auth/index");
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
            <a class="navbar-brand" href="#">Inspyre</a>
          </div>
          <div class="collapse navbar-collapse" id="myNavbar">
            <ul class="nav navbar-nav">
              <li class="active"><a href="#">Home</a></li>
            </ul>
            <ul class="nav navbar-nav navbar-right">
              <li><a href="/register"><span class="glyphicon glyphicon-user"></span> Register</a></li>
              <li><a href="/login"><span class="glyphicon glyphicon-log-in"></span> Login</a></li>
            </ul>
          </div>
        </div>
      </nav>
      
      
      <div class="jumbotron">
        <h1>Inspyre</h1>
        <p>Inspyre helps you create meaningful change in your life. Start tracking your goals with the help of your peers today.</p>
      </div>

      <div class="col-md-6 col-md-offset-3 col-main-center">
        <h2>Follow through</h2>
        <p>Never fail to follow through on your goals again. Inspyre lets your friends and family rate your progress on personal goals so that you'll always have an accurate measurement of how well you're doing.</p>

        <h2>Help others</h2>
        <p>Return the favor by rating others' goals as well. Inspyre allows you to follow users to receive information on their progress on goals; just switch over to the Following tab at your dashboard to check how many goals the users you are following have completed.</p>

        <h2>Make change</h2>
        <p>With Inspyre, you can make changes in your life while helping others make changes themselves. By creating your own goals and rating others', users help create an active environment that makes goalsetting easier than ever.</p>
      </div>

    </div>
    
  </body>
</html>
