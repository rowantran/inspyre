<?php

require_once "Template.php";

class Navbar extends Template {
    private $brand;
    private $itemsLeft;
    private $itemsRight;

    public function __construct($brand, $itemsLeft, $itemsRight) {
        $this->brand = $brand;
        $this->itemsLeft = $itemsLeft;
        $this->itemsRight = $itemsRight;

        $this->load(__DIR__ . "/../templates/Navbar.tpl.php");
    }

    public function renderHTML() {
        $itemsLeft = "";
        $itemsRight = "";

        foreach ($this->itemsLeft as $item) {
            $itemsLeft .= $item->renderHTML();
        }
        foreach ($this->itemsRight as $item) {
            $itemsRight .= $item->renderHTML();
        }

        $this->set("brand", $this->brand->renderHTML());
        $this->set("itemsLeft", $itemsLeft);
        $this->set("itemsRight", $itemsRight);

        return parent::renderHTML();
    }
}

?>