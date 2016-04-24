<?php


class ImageTest extends \Codeception\TestCase\Test
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
        $image = new CMS\Image();
        $image->setId('1');
        $this->assertEquals($image->getId(), '1');

        $image->setContentId('10');
        $this->assertEquals($image->getContentId(), '10');

        $image->setImagePath('forest.jpg');
        $this->assertEquals($image->getImagePath(), '/images/forest.jpg" class="img-resp" alt="forest_pic"'); 
    }
}