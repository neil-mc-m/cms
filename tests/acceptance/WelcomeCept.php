<?php 
$I = new AcceptanceTester($scenario);
$I->wantTo('ensure home page works');
$I->amOnPage('/home');
$I->see('Home');
