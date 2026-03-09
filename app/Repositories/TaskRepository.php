<?php

namespace App\Repositories;

use App\models\Task;
use Framework\Database;

class TaskRepository implements TaskRepositoryInterface
{
    private Database $database;

    public function __construct(Database $database)
    {
        $this->database = $database;
    }

    /** @return Task[] */
    public function all(): array
    {
        $stmt = $this->database->query("SELECT * FROM tasks");
        $stmt->execute();
        $result = $stmt->fetchAll();
        $tasks = array();
        foreach ($result as $row) {
            $tasks[] = $this->fromDatabase($row);
        }

        return $tasks;
    }

    public function find(int $id): ?Task
    {
        $stmt = $this->database->run("SELECT * FROM tasks WHERE id = :id", ['id' => $id])->fetch();

        if (!$stmt) {
            return null;
        }

        return $this->fromDatabase($stmt);
    }

    public function fromDatabase(array $row): Task
    {
        $task = new Task();

        $task->id = $row['id'];
        $task->title = $row['title'];
        $task->description = $row['description'];
        $task->priority = $row['priority'];
        $task->status = $row['status'];
        $task->progress = $row['progress'];
        $task->createdAt = $row['created_at'];
        $task->completedAt = $row['completed_at'];

        return $task;
    }

    public function insert(Task $task): ?Task
    {
        $stmt = $this->database->run(
            "INSERT INTO tasks (title, description, priority, status, progress, created_at, completed_at)
            VALUES (:title, :description, :priority, :status, :progress, :createdAt, :completed_at)",
            [
                "title" => $task->title,
                "description" => $task->description,
                "priority" => $task->priority,
                "status" => $task->status,
                "progress" => $task->progress,
                "created_at" => $task->createdAt,
                "completed_at" => $task->completedAt,
            ]
        );

        if ($stmt->rowCount() === 0) {
            return null;
        }

        $task->id = $this->database->getLastID();

        return $task;
    }

    public function update(Task $task): bool
    {
        // SQLite codes
        $stmt = $this->database->run("UPDATE tasks SET title = :title,
            descripttion = :description,
            priority = :priority,
            status = :status,
            progress = :progress,
            created_at = :createdAt,
            completed_at = :completedAt,
            WHERE id = :id",
                 [
                 "title" => $task->title,
                "description" => $task->description,
                "priority" => $task->priority,
                "status" => $task->status,
                "progress" => $task->progress,
                "created_at" => $task->createdAt,
                "completed_at" => $task->completedAt,
                 ]
        );

        return $stmt->rowCount() === 0;
    }

    public function delete(Task $task): bool
    {
        $stmt = $this->database->run("DELETE FROM tasks WHERE id = :id", ['id' => $task->id]);

        return $stmt->rowCount() === 0;
    }
}
