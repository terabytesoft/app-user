<?php

use yii\helpers\Yii;

/**
 * LoginCest
 *
 * tests acceptance
 **/
class LogInCest
{
    /**
     * _before
     *
     **/
    public function _before(FunctionalTester $I)
    {
        $I->amOnPage('/user/security/login');
    }

    /**
     * LogInPageTest
     *
     **/
    public function LogInPageTest(AcceptanceTester $I)
    {
        $I->wantTo('ensure that login page works.');
        $I->expectTo('see page login.');
        $I->see(Yii::t('user', 'Login'), 'h2');
    }

    /**
     * LogInResetPasswordLink
     *
     **/
    public function LogInResetPasswordLink(AcceptanceTester $I)
    {
        $I->wantTo('ensure that link reset password link works.');
        $I->SeeLink(Yii::t('user', 'reset it here'));
        $I->click(Yii::t('user', 'reset it here'));
        $I->expectTo('see page recover password.');
        $I->see(Yii::t('user', 'Recover your password'), 'h2');
    }

    /**
     * LogInResendReceiveConfirmationMessageLink
     *
     **/
    public function LogInResendReceiveConfirmationMessageLink(AcceptanceTester $I)
    {
        $I->wantTo('ensure that link resend receive confirmation message link works.');
        $I->SeeLink(Yii::t('user', 'Didn\'t receive confirmation message?'));
        $I->click(Yii::t('user', 'Didn\'t receive confirmation message?'));
        $I->expectTo('see page request new confirmation message.');
        $I->see(Yii::t('user', 'Request new confirmation message'), 'h2');
    }

    /**
     * LogInDontIHaveAccountLink
     *
     **/
    public function LogInDontIHaveAccountLink(AcceptanceTester $I)
    {
        $I->wantTo('ensure that link receive confirmation message works.');
        $I->SeeLink(Yii::t('user', 'Don\'t have an account? Sign up!'));
        $I->click(Yii::t('user', 'Don\'t have an account? Sign up!'));
        $I->expectTo('see page sign up.');
        $I->see(Yii::t('user', 'Sign up'), 'h2');
    }

    /**
     * LogInEmptyDataTest
     *
     **/
    public function LogInEmptyDataTest(AcceptanceTester $I)
    {
        $I->amGoingTo('login submit form with empty data.');
        $I->click(Yii::t('user', 'Login'), '.btn');
        $I->expectTo('see validations errors.');
        $I->see(Yii::t('user', 'Login cannot be blank.'), '.invalid-feedback');
        $I->see(Yii::t('user', 'Password cannot be blank.'), '.invalid-feedback');
        $I->SeeLink(Yii::t('user', 'Sign up'));
        $I->SeeLink(Yii::t('user', 'Login'));
    }

    /**
     * LogInSubmitFormWrongDataTest
     *
     **/
    public function LogInSubmitFormWrongDataTest(AcceptanceTester $I)
    {
        $I->amGoingTo('login submit form with data wrong.');
        $I->fillField('#login-form-login', 'admin');
        $I->fillField('#login-form-password', '1234567');
        $I->click(Yii::t('user', 'Login'), '.btn');
        $I->expectTo('invalid login or password.');
        $I->see(Yii::t('user', 'Invalid login or password.'), '.invalid-feedback');
        $I->SeeLink(Yii::t('user', 'Sign up'));
        $I->SeeLink(Yii::t('user', 'Login'));
    }

    /**
     * LogInSubmitFormSuccessDataTest
     *
     * @depends SignUpCest:SignUpRegisterSuccessDataTest
     **/
    public function LogInFormSubmitFormSuccessDataTest(AcceptanceTester $I)
    {
        $I->amGoingTo('login submit form with data success.');
        $I->fillField('#login-form-login', 'admin');
        $I->fillField('#login-form-password', '123456');
        $I->click(Yii::t('user', 'Login'), '.btn');
        $I->expectTo('link logout');
        $I->dontSeeLink(Yii::t('user', 'Login'));
        $I->dontSeeLink(Yii::t('user', 'Sign up'));
        $I->dontSeeLink(Yii::t('user', 'Login'));
        $I->seeLink(Yii::t('user', 'Logout'));
    }
}
