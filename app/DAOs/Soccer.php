<?php

namespace App\DAOs;

use App\Interfaces\Database;
use App\Models\Soccer as ModelsSoccer;
use PDO;

class Soccer
{
    // TODO: Implements a Query Builder
    private PDO $con;
    public function __construct(Database $db) {
        $this->con = $db->getConnection();
    }

    public function insert(ModelsSoccer $game): void
    {
        $sql = 'INSERT INTO soccer ("name", "result") VALUES (?, ?)';
        $stmt = $this->con->prepare($sql);
        $stmt->bindValue(1, $game->getName());
        $stmt->bindValue(2, $game->getResult());
        $stmt->execute();
    }

    public function update(ModelsSoccer $game): bool
    {
        $sql = 'UPDATE soccer SET name = :name, result = :result WHERE id = :id';
        $stmt = $this->con->prepare($sql);
        $stmt->bindValue(':name', $game->getName());
        $stmt->bindValue(':result', $game->getResult());
        $stmt->bindValue(':id', $game->getId(), PDO::PARAM_INT);
        return $stmt->execute();
    }

    public function find(int $id): ModelsSoccer
    {
        $sql = 'SELECT * from soccer WHERE id = :id';
        $stmt = $this->con->prepare($sql);
        $stmt->bindValue(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        $result = $stmt->fetch();

        return new ModelsSoccer($result['name'], $result['id'], $result['result']);
    }

    public function getAll(): array
    {
        $sql = 'SELECT * from soccer';
        $stmt = $this->con->query($sql);
        $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $games = [];
        foreach ($results as $game) {
            $games[] = new ModelsSoccer($game['name'], $game['id'], $game['result']);
        }

        return $games;
    }
}