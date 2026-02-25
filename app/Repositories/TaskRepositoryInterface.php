<?php

namespace App\Repositories;

interface TaskRepositoryInterface
{
    public function all(): array;

    public function find(int $id): ?Task;
}
