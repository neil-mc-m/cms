<?php
$I = new AcceptanceTester($scenario);
$I->wantTo('ensure the links on the homepage work');
$I->amOnPage('/');
$I->see('Php Programming');
$I->seeLink('About us', '/About-Us');
$I->click('About us');
$I->see('Introduction');