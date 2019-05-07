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
    public function _before(AcceptanceTester $I)
    {
        $I->amOnPage('/user/security/login');
    }

    /**
     * logInPageTest
     *
     **/
    public function logInPageTest(AcceptanceTester $I)
    {
        $I->wantTo('ensure that login page works.');
        $I->expectTo('see page login.');
        $I->see(Yii::t('user', 'Login'), 'h2');
    }

    /**
     * logInResetPasswordLink
     *
     **/
    public function logInResetPasswordLink(AcceptanceTester $I)
    {
        $I->wantTo('ensure that link reset password link works.');
        $I->SeeLink(Yii::t('user', 'reset it here'));
        $I->click(Yii::t('user', 'reset it here'));
        $I->expectTo('see page recover password.');
        $I->see(Yii::t('user', 'Recover your password'), 'h2');
    }

    /**
     * logInResendReceiveConfirmationMessageLink
     *
     **/
    public function logInResendReceiveConfirmationMessageLink(AcceptanceTester $I)
    {
        $I->wantTo('ensure that link resend receive confirmation message link works.');
        $I->SeeLink(Yii::t('user', 'Didn\'t receive confirmation message?'));
        $I->click(Yii::t('user', 'Didn\'t receive confirmation message?'));
        $I->expectTo('see page request new confirmation message.');
        $I->see(Yii::t('user', 'Request new confirmation message'), 'h2');
    }

    /**
     * logInDontIHaveAccountLink
     *
     **/
    public function logInDontIHaveAccountLink(AcceptanceTester $I)
    {
        $I->wantTo('ensure that link receive confirmation message works.');
        $I->SeeLink(Yii::t('user', 'Don\'t have an account? Sign up!'));
        $I->click(Yii::t('user', 'Don\'t have an account? Sign up!'));
        $I->expectTo('see page sign up.');
        $I->see(Yii::t('user', 'Sign up'), 'h2');
    }

    /**
     * logInEmptyDataTest
     *
     **/
    public function logInEmptyDataTest(AcceptanceTester $I)
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
     * logInSubmitFormWrongDataTest
     *
     **/
    public function logInSubmitFormWrongDataTest(AcceptanceTester $I)
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
     * logInSubmitFormSuccessDataTest
     *
     * @depends SignUpCest:SignUpRegisterSuccessDataTest
     **/
    public function logInFormSubmitFormSuccessDataTest(AcceptanceTester $I)
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
