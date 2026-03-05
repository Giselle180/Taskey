<?php

namespace App\models;

class Project
{
    public int $id;

    public string $title;

    public string $description;

    public function __construct()
    {
        // id
        $this->title = "";
        $this->description = "";
    }
}
