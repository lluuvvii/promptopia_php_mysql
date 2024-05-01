<?php

class HomeController
{
    public function index()
    {
        echo 'Halaman Utama';
    }
}

$controller = new HomeController();

$controller->index();