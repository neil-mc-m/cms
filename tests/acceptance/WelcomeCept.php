<?php
$I = new AcceptanceTester($scenario);
$I->wantTo('ensure the articles link on the homepage works');
$I->amOnPage('/');
$I->seeLink('Articles');
$I->click('Articles');
