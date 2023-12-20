<?php

namespace Tests\Integration\Databases;

use App\Databases\MySql;
use PDO;
use PHPUnit\Framework\TestCase;

final class MySqlTest extends TestCase
{
    public function testCreateConnectionWithDatabase()
    {
        $this->assertInstanceOf(PDO::class, MySql::getConnection());
    }
}