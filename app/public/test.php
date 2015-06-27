<html>
  <head>
    <link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/css/bootstrap.min.css">
  </head>
  <body>
    <?php
       include __DIR__ . "/../classes/Navbar.php";
include __DIR__ . "/../classes/NavbarItem.php";

$itemsLeft = array(new NavbarItem("Home", "/"));
$itemsRight = array(new NavbarItem("Register", "/register"), new NavbarItem("Login", "/login"));

$navbar = new Navbar("Inspyre", $itemsLeft, $itemsRight);
echo $navbar->renderHTML();
       ?>
  </body>
</html>
