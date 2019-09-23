<?php

class Movie {
    public $id;
    public $title;
    public $url;
    public $img;
    public $views;

    public function __construct($id,$title,$url,$img,$views) {
        $this->id = $id;
        $this->title = $title;
        $this->url = $url;
        $this->img = $img;
        $this->views = $views;
    }
}

class Category {
    public $id;
    public $name;

    public function __construct($id,$name) {
        $this->id = $id;
        $this->name = $name;
    }
}