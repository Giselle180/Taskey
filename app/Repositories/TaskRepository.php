<?php

namespace App\Repositories;

use App\models\Task;
use Framework\Database;

class TaskRepository implements TaskRepositoryInterface
{
    /** @var array<int, mixed> */
    private array $tempTasks = array(
        array(
            "id" => 1,
            "title" => "Form the Fellowship",
            "description" => "Assemble representatives of the Free Peoples in Rivendell",
            "priority" => 3,
            "status" => 4,
            "progress" => 100,
            "created_at" => 1008710400,
            "completed_at" => 1008720400),
        array(
            "id" => 2,
            "title" => "Cross the Misty Mountains",
            "description" => "Find a safe passage through or around the mountains",
            "priority" => 2,
            "status" => 1,
            "progress" => 50,
            "created_at" => 1008720400,
            "completed_at" => null),
        array(
            "id" => 3,
            "title" => "Enter Moria",
            "description" => "Take the risky path through the Mines of Moria",
            "priority" => 2,
            "status" => 3,
            "progress" => 0,
            "created_at" => 1008740400,
            "completed_at" => null)
    );

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
}
