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
    private DAOsBet $dao;

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

    protected function setUp(): void
    {
        $this->dao = new DAOsBet(self::$db);
    }

    protected function tearDown(): void
    {
        $this->dao->deleteAll();
    }

    public static function provideBet(): array
    {
        $bet = new Bet(15.5, 1.2);

        return [
            'simple bet' => [$bet],
        ];
    }

    public static function provideBets(): array
    {
        $bets = [];

        for ($i=0; $i < rand(0, 10); $i++) { 
            $bets[] = new Bet((rand(100, 1000) / 100), (rand(100, 1000) / 100));
        }

        return [
            'many bets' => [$bets],
        ];
    }

    #[DataProvider('provideBet')]
    public function testInsertAndGetBet(Bet $bet)
    {
        $this->dao->insert($bet);

        $bets = $this->dao->getAll();
        $this->assertCount(1, $bets);
        $this->assertSame($bets[0]->getValue(), $bet->getValue());
        $this->assertSame($bets[0]->getResult(), $bet->getResult());
        $this->assertSame($bets[0]->getMultiplier(), $bet->getMultiplier());
    }

    /** @param Bet[] $bets */
    #[DataProvider('provideBets')]
    public function testInsertAndGetManyBets(array $bets)
    {
        foreach ($bets as $bet) {
            $this->dao->insert($bet);
        }

        $result = $this->dao->getAll();
        $this->assertCount(count($bets), $result);
        
        for ($i=0; $i < count($bets); $i++) { 
            $this->assertSame($bets[$i]->getValue(), $result[$i]->getValue());
            $this->assertSame($bets[$i]->getMultiplier(), $result[$i]->getMultiplier());
        }
    }
}