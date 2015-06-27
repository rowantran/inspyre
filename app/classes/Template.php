<?php

class Template {
    private $template;

    public function __construct($template = null) {
        if (isset($template)) {
            $this->load($template);
        }
    }

    public function renderHTML() {
        $this->removeEmpty();
        return $this->template;
    }

    public function set($var, $content) {
        $this->template = str_replace("{" . "$var" . "}", $content, $this->template);
    }

    public function removeEmpty() {
        $this->template = preg_replace('^{.*}^', "", $this->template);
    }

    public function load($template) {
        if (file_exists($template)) {
            $this->template = file_get_contents($template);
        }
    }
}

?>