<?php 
$I = new AcceptanceTester($scenario);
$I->wantTo('check links');
$I->amOnPage('/home');
$I->seeLink('Woodland walks', 'woodland-walks');
$I->seeLink('read more', 'home/19');
$I->click(['link' => 'Woodland walks']);
$I->see('Walks');
