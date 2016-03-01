<?php
use \LightCMS\dbmodel;

class ExampleTest extends \Codeception\TestCase\Test
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
        $db = new \LightCMS\dbmodel();
        $db->showOneArticle('1');
        $this->tester->seeInDatabase('articles', array('id' => '1'));


    }
}
