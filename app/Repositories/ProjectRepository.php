<?php

namespace App\Repositories;

use App\Models\Project;
use App\models\Task;
use Framework\Database;

class ProjectRepository implements ProjectRepositoryInterface
{
    private Database $database;

    public function __construct(Database $database)
    {
        $this->database = $database;
    }

    /** @return Task[] */
    public function all(): array
    {
        $stmt = $this->database->query("SELECT * FROM projects");
        $stmt->execute();
        $result = $stmt->fetchAll();
        $tasks = array();
        foreach ($result as $row) {
            $tasks[] = $this->fromDatabase($row);
        }

        return $tasks;
    }

    public function find(int $id): ?Project
    {
        $stmt = $this->database->run("SELECT * FROM tasks WHERE id = :id", ['id' => $id])->fetch();

        if (!$stmt) {
            return null;
        }

        return $this->fromDatabase($stmt);
    }

    public function fromDatabase(array $row): Project
    {
        $task = new Project();

        $task->id = $row['id'];
        $task->title = $row['title'];
        $task->description = $row['description'];

        return $task;
    }

    public function insert(Project $project): ?Project
    {
        $stmt = $this->database->run(
            "INSERT INTO tasks (title, description)
            VALUES (:title, :description)",
            [
                "title" => $project->title,
                "description" => $project->description,
            ]
        );

        if ($stmt->rowCount() === 0) {
            return null;
        }

        $project->id = $this->database->getLastID();

        return $project;
    }

    public function update(Project $project): bool
    {
        // SQLite codes
        $stmt = $this->database->run("UPDATE tasks SET title = :title,
            description = :description
            WHERE id = :id",
            [
                "title" => $project->title,
                "description" => $project->description,
            ]
        );

        return $stmt->rowCount() === 0;
    }

    public function delete(Project $project): bool
    {
        $stmt = $this->database->run("DELETE FROM tasks WHERE id = :id", ['id' => $project->id]);

        return $stmt->rowCount() === 0;
    }
}
