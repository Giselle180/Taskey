<?php

namespace App\models;

use phpDocumentor\Reflection\Types\Integer;

class Task
{
    public integer $id;

    public string $title;

    public string $description;

    public integer $priority;

    public integer $status;

    public integer $progress;

    public integer $createdAt;

    public integer $completedAt;

    public function __construct()
    {
        // Later
    }
}
