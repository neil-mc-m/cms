<?php


class PageTest extends \Codeception\TestCase\Test
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
        
        $page = new CMS\Page();
        $page->pageName = 'home';
        $this->assertEquals($page->getPageName(), 'home');

        $page->setPageRoute('Woodland Walks');
        $this->assertEquals($page->getPageRoute(), 'woodland-walks');

        $page->setPageName('home');
        $this->assertEquals($page->getPageName(), 'home'); 
    }
}