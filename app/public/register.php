z<!DOCTYPE html>

<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="application-name" content="Goals">
    <meta name="description" content="Make meaningful changes in your life">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Inspyre | Register</title>

    <link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/css/bootstrap.min.css">
    <link rel="stylesheet" href="../css/custom.css">

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
    <script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/js/bootstrap.min.js"></script>
    <script src="/home/rj/Scripts/goals/html/js/validator.js"></script>
  </head>


  <body class="register">

    <!-- Body -->
    <div class="container-fluid">

<?php

    require_once __DIR__ . "/../classes/MainNavbar.php";
require_once __DIR__ . "/../classes/Form.php";

echo (new MainNavbar)->renderHTML();

$form = new Form;
?>
      
      <div class="col-md-6 col-md-offset-3 register-form">
        <form action="register" method="post" role="form">
          <div class="form-group">
            <div class="input-group">
              <span class="input-group-addon" id="basic-addon1"><span class="glyphicon glyphicon-user"></span></span>
              <input type="text" class="form-control" name="username" placeholder="Username" required>
            </div>
          </div>
          <div class="form-group">
            <div class="row">
              <div class="form-group col-sm-6">
                <div class="input-group">
                  <span class="input-group-addon" id="basic-addon1"><span class="glyphicon glyphicon-lock"></span></span>
                  <input type="password" class="form-control" name="password" placeholder="Password" required>
                </div>
              </div>
              <div class="form-group col-sm-6">
                <input type="password" class="form-control" placeholder="Confirm" required>
              </div>
            </div>
          </div>
          <div class="form-group">
            <div class="input-group">
              <span class="input-group-addon" id="basic-addon1"><span class="glyphicon glyphicon-envelope"></span></span>
              <input type="email" class="form-control" name="email" placeholder="Email" required>
            </div>
          </div>
          <div class="form-group checkbox">
            <label>
              <input type="checkbox" name="emailNotifications"> Receive notifications when your goals are rated
            </label>
          </div>
          <div class="form-group">
            <input type="submit" class="btn btn-success" value="Register">
          </div>
        </form>
      </div>
  </body>
</html>
