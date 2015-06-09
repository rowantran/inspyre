<!DOCTYPE html>

<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="application-name" content="Goals">
    <meta name="description" content="Make meaningful changes in your life">
    <meta name="viewport" content="width=device-width, initial-scale=1">

  <body>
      
<?php
     include __DIR__ . "/../auth.php";

if (isset($_COOKIE["token"])) {
    deleteTokenFromTokenVal($_COOKIE["token"]);

    unset($_COOKIE["token"]);
    setcookie("token", "", time()-3600);
}
 
redirectToPage("/");
   ?>

  </body>
</html>
