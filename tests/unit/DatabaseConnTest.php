<?php


class DatabaseConnTest extends \Codeception\TestCase\Test
{
    /**
     * @var \UnitTester
     */
    protected $tester;

    protected function _before()
    {
    }

    protected function _after()
    {
    }

    // tests
    public function testMe()
    {
        $conn = new CMS\DbManager();
        $conn->getPdoInstance();
        $this->assertInstanceOf('PDO', $conn);
        
    }
}