<!DOCTYPE html>

<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="application-name" content="Goals">
    <meta name="description" content="Make meaningful changes in your life">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Inspyre | Log in</title>

    <link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/css/bootstrap.min.css">
    <link rel="stylesheet" href="css/custom.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
    <script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/js/bootstrap.min.js"></script>
  </head>


  <body class="login">
    
    <?php
      require_once __DIR__ . "/../accounts.php";
require_once __DIR__ . "/../auth.php";
require_once __DIR__ . "/../db.php";

$badInfo = false;

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (!empty($_POST["username"])) {
        $username = testInput($_POST["username"]);
    }

    if (!empty($_POST["password"])) {
        $password = testInput($_POST["password"]);
    }
    
    $hash = getHash(getIDFromName($username));
    if ($hash != DB_NO_USER_FOUND) {
        if (password_verify($password, $hash)) {
            $uid = getIDFromName($username);
            $token = generateToken();
            updateToken($uid, $token);
            
            setcookie("token", $token, time()+60*60*24);
            
            redirectToPage("/auth/index");
        } else {
            $badInfo = true;
        }
    } else {
        $badInfo = true;
    }
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
            <a class="navbar-brand" href="/">Inspyre</a>
          </div>
          <div class="collapse navbar-collapse" id="myNavbar">
            <ul class="nav navbar-nav">
              <li><a href="/">Home</a></li>
            </ul>
            <ul class="nav navbar-nav navbar-right">
              <li><a href="register"><span class="glyphicon glyphicon-user"></span> Register</a></li>
              <li class="active"><a href="#"><span class="glyphicon glyphicon-log-in"></span> Login</a></li>
            </ul>
          </div>
        </div>
      </nav>
      
      <?php
         if ($badInfo) {
             $error = "<div class=\"alert alert-danger alert-dismissible\" role=\"alert\"><strong>Oh no!</strong> Check your username and password and try again.</div>";
             echo $error;
         }
      ?>

      <div class="col-md-6 col-md-offset-3 login-form">
        <form action="login" method="post" role="form">
          <div class="form-group">
            <div class="input-group">
              <span class="input-group-addon"><span class="glyphicon glyphicon-user"></span></span>
              <input type="text" class="form-control" id="username" name="username" placeholder="Username">
            </div>
          </div>
          <div class="form-group">
            <div class="input-group">
              <span class="input-group-addon"><span class="glyphicon glyphicon-lock"></span></span>
              <input type="password" class="form-control" id="password" name="password" placeholder="Password">
            </div>
          </div>
          <div class="form-group">
            <input type="submit" class="btn btn-primary" value="Login">
          </div>
        </form>
      </div>
    </div>
  </body>
</html>
