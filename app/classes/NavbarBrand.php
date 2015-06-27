<?php

require_once "NavbarItem.php";

class NavbarBrand extends NavbarItem {
    public function __construct($name, $URL) {
        $this->name = $name;
        $this->URL = $URL;
        
        $this->load(__DIR__ . "/../templates/NavbarBrand.tpl.php");
       
        $this->checkActive();
    }

    public function renderHTML() {
        $this->checkActive();
        $this->set("URL", $this->URL);
        $this->set("name", $this->name);

        return parent::renderHTML();
    }
}

?>