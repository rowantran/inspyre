<?php

class NavbarItem {
    private $active;
    private $page;
    private $URL;

    public function NavbarItem($active = false, $page = "Home", $URL = "/") {
        $this->active = $active;
        $this->$page = $page;
        $this->$URL = ($active ? "#" : $URL);
    }

    public function setActive($active = false) {
        $this->$active = $active;
    }

    public function setPage($page = "Home") {
        $this->$page = $page;
    }

    public function getPage() {
        return $this->$page;
    }

    public function setURL($URL = "/") {
        $this->$URL = ($this->$active ? "#" : $URL);
    }

    public function renderHTML() {
        $activeClass = ($this->$active ? 'class="active"' : '');

        $HTML = <<<HTML
<li $activeClass><a href="$this->$URL">$this->$page</a></li>
HTML;

        return $HTML;
    }
}

?>