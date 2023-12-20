<?php

namespace Tests\Integration\DAOs;

use App\DAOs\Bet as DAOsBet;
use App\Databases\SQLiteMemory;
use App\Models\Bet;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;

class BetTest extends TestCase
{
    private static $db;

    public static function setUpBeforeClass(): void
    {
        self::$db = new SQLiteMemory();
        self::$db->getConnection()->beginTransaction();
        $sql = file_get_contents(__DIR__ . '/../../assets/database.sql');
        self::$db->getConnection()->exec($sql);
    }

    public static function tearDownAfterClass(): void
    {
        self::$db->getConnection()->rollBack();
    }

    public static function provideBet(): array
    {
        $bet = new Bet(15.5, 1.2);

        return [
            'simple bet' => [$bet],
        ];
    }

    #[DataProvider('provideBet')]
    public function testInsertAndGetBet(Bet $bet)
    {
        $dao = new DAOsBet(self::$db);
        $dao->insert($bet);

        $bets = $dao->getAll();
        $this->assertCount(1, $bets);
        $this->assertSame($bets[0]->getValue(), $bet->getValue());
        $this->assertSame($bets[0]->getResult(), $bet->getResult());
        $this->assertSame($bets[0]->getMultiplier(), $bet->getMultiplier());
    }
}