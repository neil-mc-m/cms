<?php 
$I = new AcceptanceTester($scenario);
$I->wantTo('sign in');
$I->amOnPage('/login');
$I->fillField('#username', 'admin');
$I->fillField('#password', 'admin');
$I->click('login');
$I->see('Welcome');
