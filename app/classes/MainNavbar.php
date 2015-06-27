<?php

require_once "Navbar.php";
require_once "NavbarBrand.php";
require_once "NavbarItem.php";

class MainNavbar extends Navbar {
    public function __construct() {
        $brand = new NavbarBrand("Inspyre", "/");
        $itemsLeft = array(new NavbarItem('Home', "/"));
        $itemsRight = array(new NavbarItem('<span class="glyphicon glyphicon-user"></span> Register', "/register"),
                           new NavbarItem('<span class="glyphicon glyphicon-log-in"></span> Login', "/login"));

        parent::__construct($brand, $itemsLeft, $itemsRight);
    }
}

?>