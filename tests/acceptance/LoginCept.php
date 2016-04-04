<?php
$I = new AcceptanceTester($scenario);
$I->wantTo('ensure the login form works');
$I->amOnPage('/login');
$I->see('Password');
$I->see('Username');
$I->fillField('Username', 'admin');
$I->fillField('Password', 'foo');
$I->click('login');
$I->see('Welcome');

