<?php

require_once "Template.php";

class NavbarItem extends Template {
    private $name;
    private $URL;
    private $active;

    public function __construct($name, $URL) {
        $this->name = $name;
        $this->URL = $URL;

        $this->load(__DIR__ . "/../templates/NavbarItem.tpl.php");

        $this->checkActive();
    }

    public function renderHTML() {
        if ($this->checkActive()) {
            $this->set("activeClass", 'class="active"');
        }
        $this->set("URL", $this->URL);
        $this->set("name", $this->name);

        return parent::renderHTML();
    }

    public function checkActive() {
        $active = ($_SERVER["REQUEST_URI"] == $this->URL);

        if ($active) {
            $this->URL = "#";
        }

        $this->active = $active;
        return $active;
    }
}

?>