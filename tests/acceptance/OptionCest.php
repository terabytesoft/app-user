<?php

use yii\helpers\Yii;

/**
 * LoginCest
 *
 * tests acceptance
 **/
class OptionCest
{
	/**
	 * _before.
	 *
	 **/
	public function _before(AcceptanceTester $I)
	{
		$I->amOnPage('/user/security/login');
	}

	public function logInFloatLabels(AcceptanceTester $I)
	{
		$I->amOnPage('/user/security/login');
		$I->paramUpdate("'user.setting.floatLabels' => false", "'user.setting.floatLabels' => true");
		$sourceFloatLabels =
<<<'HTML'
floating_labels.css
HTML;
		\PHPUnit_Framework_Assert::assertContains($sourceFloatLabels, $I->grabPageSource());
	}
}
