<?php declare(strict_types=1);
use PHPUnit\Framework\TestCase;
use App\Model\Database;

final class DatabaseTest extends TestCase
{
    public function testCanInitializeDatabase()
    {
        $db  = new Database();
        $db->connect();
        $this->assertInstanceOf("\\PDO", $db->getConn());
    }
}
