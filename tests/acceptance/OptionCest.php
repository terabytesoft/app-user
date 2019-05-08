<?php

use yii\helpers\Yii;

/**
 * LoginCest
 *
 * tests acceptance
 **/
class OptionCest
{
	public function logInFloatLabels(AcceptanceTester $I)
	{
        $I->paramUpdate("'user.setting.floatLabels' => false", "'user.setting.floatLabels' => true");
        $I->amOnPage('/user/security/login');
		$sourceFloatLabels =
<<<'HTML'
Floating_Labels.css
HTML;
		\PHPUnit_Framework_Assert::assertContains($sourceFloatLabels, $I->grabPageSource());
	}
}
