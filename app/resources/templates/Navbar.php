<?php

require_once "NavbarItem.php";

class Navbar {
    private $brand;
    private $page;
    private $itemsLeft;
    private $itemsRight;

    public function Navbar($brand = "", $page = "index", $itemsLeft = array(), $itemsRight = array()) {
        $this->setBrand($brand);

        $this->setPage($page);

        $this->$itemsLeft = $itemsLeft;
        foreach ($this->$itemsLeft as $item) {
            if ($item->getPage() == $this->getPage()) {
                $item->setURL("#");
            }
        }

        $this->itemsRight = $itemsRight;
        foreach ($this->$itemsRight as $item) {
            if ($item->getPage() == $this->$page) {
                $item->setURL("#");
            }
        }
    }

    public function setBrand($brand) {
        $this->$brand = $brand;
    }

    public function setPage($page) {
        $this->$page = $page;
    }

    public function getPage() {
        return $this->$page;
    }

    public function addItemLeft($item) {
        $this->$itemsLeft[] = $item;           
        if ($item->getPage() == $this->getPage()) {
            $item->setURL("#");
            $item->setActive(true);
        }
    }

    public function addItemRight($item) {
        $this->$itemsRight[] = $item;
        if ($item->getPage() == $this->getPage()) {
            $item->setURL("#");
            $item->setActive(true);
        }
    }

    public function renderHTML() {
        $HTML = <<<HTML
<nav class="navbar navbar-default">
  <div class="container-fluid">
    <div class="navbar-header">
      <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#navbar">
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </button>
      $this->$brand
    </div>
    <div class="collapse navbar-collapse" id="navbar">
      <ul class="nav navbar-nav">
        $this->$itemsLeft
      </ul>
      <ul class="nav navbar-nav navbar-right">
        $this->$itemsRight
      </ul>
    </div>
  </div>
</nav>
HTML;

        return $HTML;
    }
}

?>
