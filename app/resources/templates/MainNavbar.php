<?php

require_once "Navbar.php";
require_once "NavbarItem.php";

class MainNavbar extends Navbar {
    public function MainNavbar($page = "index") {
        $this->setPage($page);
        
        if ($page == "index") {
            $this->setBrand('<a class="navbar-brand" href="#">Inspyre</a>');
        } else {
            $this->setBrand('<a class="navbar-brand" href="/">Inspyre</a>');
        }

        $this->addItemLeft(new NavbarItem(false, "index", "/"));

        $itemsRight = array(new NavbarItem(false, "register", "/register"),
                            new NavbarItem(false, "login", "/login"));

        foreach ($itemsRight as $item) {
            $this->addItemRight($item);
        }
    }

    public function setPage($page = "index") {
        $this->$page = $page;

        if ($page == "index") {
            $this->setBrand('<a class="navbar-brand" href="#">Inspyre</a>');
        } else {
            $this->setBrand('<a class="navbar-brand" href="/">Inspyre</a>');
        }
    }

?>