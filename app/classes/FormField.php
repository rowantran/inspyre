<?php

require_once "Template.php";

class FormField extends Template {
    private $type;
    private $name;
    private $placeholder;

    public function __construct($type, $name, $placeholder) {
        $this->type = $type;
        $this->name = $name;
        $this->placeholder = $placeholder;

        $this->load(__DIR__ . "/../templates/FormField.tpl.php");
    }

    public function renderHTML() {
        $this->set("type", $this->type);
        $this->set("name", $this->name);
        $this->set("placeholder", $this->placeholder);
    
        return parent::renderHTML();
    }
}

?>