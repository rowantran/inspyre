<!DOCTYPE html>

<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="application-name" content="Goals">
    <meta name="description" content="Make meaningful changes in your life">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Goals | Register</title>

    <link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
    <script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/js/bootstrap.min.js"></script>
    <script src="/home/rj/Scripts/goals/html/js/validator.js"></script>
  </head>


  <body>

    <?php
      require_once __DIR__ . "/../accounts.php";
      require_once __DIR__ . "/../auth.php";

      $username = $password = $email = "";

      if ($_SERVER["REQUEST_METHOD"] == "POST") {
        if (!empty($_POST["username"])) {
          $username = test_input($_POST["username"]);
        }
       
        if (!empty($_POST["password"])) {
          $password = test_input($_POST["password"]);
        }
       
        if (!empty($_POST["email"])) {
          $email = test_input($_POST["email"]);
        }
        
        createUser($username, createHash($password), $email);

        $login = "login.php";
        header('Location: ' . $login);
      }
       
      function test_input($data) {
        $data = htmlspecialchars(stripslashes(trim($data)));
        return $data;
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
            <a class="navbar-brand" href="index.php">Goals</a>
          </div>
          <div class="collapse navbar-collapse" id="myNavbar">
            <ul class="nav navbar-nav">
              <li><a href="index.php">Home</a></li>
            </ul>
            <ul class="nav navbar-nav navbar-right">
              <li class="active"><a href="#"><span class="glyphicon glyphicon-user"></span> Register</a></li>
              <li><a href="login.php"><span class="glyphicon glyphicon-log-in"></span> Login</a></li>
            </ul>
          </div>
        </div>
      </nav>
      
      <div class="well">
        <form action="register.php" method="post" role="form">
          <div class="form-group">
            <input type="text" class="form-control" name="username" placeholder="Username" required>
          </div>
          <div class="form-group">
            <div class="row">
              <div class="form-group col-sm-6">
                <input type="password" class="form-control" name="password" placeholder="Password" required>
              </div>
              <div class="form-group col-sm-6">
                <input type="password" class="form-control" placeholder="Confirm" required>
              </div>
            </div>
          </div>
          <div class="form-group">
            <input type="email" class="form-control" name="email" placeholder="Email" required>
          </div>
          <div class="form-group">
            <input type="submit" class="btn btn-success" value="Register">
          </div>
        </form>
      </div>
    </div>
  </body>
</html>
