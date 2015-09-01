<?php

require_once "Template.php";

class Form extends Template {
    public function __construct($items) {
        $this->items = $items;

        $this->load(__DIR__ . "/../templates/Form.tpl.php");
    }

    public function renderHTML() {
        $items = "";

        foreach ($this->items as $item) {
            $items .= $item->renderHTML();
        }
    
        $this->set("items", $items);

        return parent::renderHTML();
    }
}