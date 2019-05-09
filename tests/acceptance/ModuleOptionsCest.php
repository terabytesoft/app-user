<?php

use yii\helpers\Yii;

/**
 * LoginCest
 *
 * tests acceptance
 **/
class ModuleOptionsCest
{
    /**
     * _before
     *
     **/
    public function _before(AcceptanceTester $I)
    {
        $I->paramUpdate("'user.setting.floatLabels' => false", "'user.setting.floatLabels' => true");
    }

    /**
     * _after
     *
     **/
    public function _after(AcceptanceTester $I)
    {
        $I->paramUpdate("'user.setting.floatLabels' => true", "'user.setting.floatLabels' => false");
    }

	public function ModuleOptionsFloatLabels(AcceptanceTester $I)
	{
        $I->amOnPage('/user/security/login');
        $sourceFloatLabels =
<<<'HTML'
Floating_Labels.css
HTML;
		\PHPUnit_Framework_Assert::assertContains($sourceFloatLabels, $I->grabPageSource());
	}
}
