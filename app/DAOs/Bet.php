<?php

namespace App\DAOs;

use App\Interfaces\Database;
use App\Models\Bet as ModelsBet;
use PDO;

class Bet
{
    // TODO: Implements a Query Builder
    private PDO $con;
    public function __construct(Database $db) {
        $this->con = $db->getConnection();
    }

    public function insert(ModelsBet $bet): void
    {
        $sql = 'INSERT INTO bets ("value", "winner", "multiplier") VALUES (?, ?, ?)';
        $stmt = $this->con->prepare($sql);
        $stmt->bindValue(1, $bet->getValue());
        $stmt->bindValue(2, $bet->getResult());
        $stmt->bindValue(3, $bet->getMultiplier());
        $stmt->execute();
    }

    public function update(ModelsBet $bet): bool
    {
        $sql = 'UPDATE bets SET value = :value, winner = :winner, multiplier = :multiplier WHERE id = :id';
        $stmt = $this->con->prepare($sql);
        $stmt->bindValue(':value', $bet->getValue());
        $stmt->bindValue(':winner', $bet->getResult());
        $stmt->bindValue(':multiplier', $bet->getMultiplier());
        $stmt->bindValue(':id', $bet->getId(), PDO::PARAM_INT);
        return $stmt->execute();
    }

    public function find(int $id): ModelsBet
    {
        $sql = 'SELECT * from bets WHERE id = :id';
        $stmt = $this->con->prepare($sql);
        $stmt->bindValue(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        $result = $stmt->fetch();

        return new ModelsBet($result['value'], $result['multiplier'], $result['id'], $result['winner']);
    }

    /**
     * @return ModelsBet[]
     */
    public function getAll(): array
    {
        $sql = 'SELECT * from bets';
        $stmt = $this->con->query($sql);
        $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $bets = [];
        foreach ($results as $bet) {
            $bets[] = new ModelsBet($bet['value'], $bet['multiplier'], $bet['id'], $bet['winner']);
        }

        return $bets;
    }

    public function deleteAll(): void
    {
        $sql = 'DELETE FROM bets WHERE true';
        $this->con->exec($sql);
    }
}