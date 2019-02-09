<?php

use yii\helpers\Yii;

/**
 * LoginFormCest
 *
 * tests functional
 **/
class LogInFormCest
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
     * LogInFormPageTest
     *
     **/
    public function LogInFormPageTest(FunctionalTester $I)
    {
        $I->wantTo('ensure that login page works.');
        $I->expectTo('see page login.');
        $I->see(Yii::t('user', 'Login'), '.form-security-login-title');
    }

    /**
     * LogInFormResetPasswordLink
     *
     **/
    public function LogInFormResetPasswordLink(FunctionalTester $I)
    {
        $I->wantTo('ensure that link reset password link works.');
        $I->SeeLink(Yii::t('user', 'reset it here'), '/user/recovery/request');
        $I->click(['link' => Yii::t('user', 'reset it here')]);
        $I->expectTo('see page recover password.');
        $I->see(Yii::t('user', 'Recover your password'), '.form-recovery-request-title');
    }

    /**
     * LogInResendReceiveConfirmationMessageLink
     *
     **/
    public function LogInResendReceiveConfirmationMessageLink(FunctionalTester $I)
    {
        $I->wantTo('ensure that link resend receive confirmation message link works.');
        $I->SeeLink(Yii::t('user', 'Didn\'t receive confirmation message?'), '/user/registration/resend');
        $I->click(['link' => Yii::t('user', 'Didn\'t receive confirmation message?')]);
        $I->expectTo('see page request new confirmation message.');
        $I->see(Yii::t('user', 'Request new confirmation message'), '.form-registration-resend-title');
    }

    /**
     * LogInDontIHaveAccountLink
     *
     **/
    public function LogInDontIHaveAccountLink(FunctionalTester $I)
    {
        $I->wantTo('ensure that link receive confirmation message works.');
        $I->SeeLink(Yii::t('user', 'Don\'t have an account? Sign up!'), '/user/registration/register');
        $I->click(['link' => Yii::t('user', 'Don\'t have an account? Sign up!')]);
        $I->expectTo('see page sign up.');
        $I->see(Yii::t('user', 'Sign up'), '.form-registration-register-title');
    }

    /**
     * LogInFormEmptyDataTest
     *
     **/
    public function LogInFormEmptyDataTest(FunctionalTester $I)
    {
        $I->amGoingTo('login submit form with empty data.');
        $I->submitForm('#form-security-login', []);
        $I->expectTo('see validations errors.');
        $I->see(Yii::t('user', 'Login cannot be blank.'), '.invalid-feedback');
        $I->see(Yii::t('user', 'Password cannot be blank.'), '.invalid-feedback');
        $I->SeeLink(Yii::t('user', 'Sign up'), '/user/registration/register');
        $I->SeeLink(Yii::t('user', 'Login'), '/user/security/login');
    }

    /**
     * LogInFormSubmitFormWrongDataTest
     *
     **/
    public function LogInFormSubmitFormWrongDataTest(FunctionalTester $I)
    {
        $I->amGoingTo('login submit form with data wrong.');
        $I->submitForm('#form-security-login', [
            'login-form[login]' => 'admin',
            'login-form[password]' => '1234567',
        ]);
        $I->expectTo('invalid login or password.');
        $I->see(Yii::t('user', 'Invalid login or password.'), '.invalid-feedback');
        $I->SeeLink(Yii::t('user', 'Sign up'), '/user/registration/register');
        $I->SeeLink(Yii::t('user', 'Login'), '/user/security/login');
    }

    /**
     * LogInFormSubmitFormSuccessDataTest
     *
     * @depends SignUpFormCest:SignUpFormRegisterSuccessDataTest
     **/
    public function LogInFormSubmitFormSuccessDataTest(FunctionalTester $I)
    {
        $I->amGoingTo('login submit form with data success.');
        $I->submitForm('#form-security-login', [
            'login-form[login]' => 'demo',
            'login-form[password]' => '123456',
        ]);
        $I->expectTo('link logout');
        $I->dontSeeLink(Yii::t('user', 'Login'), '/user/security/login');
        $I->dontSeeLink(Yii::t('user', 'Sign up'), '/user/registration/register');
        $I->seeLink(Yii::t('user', 'Logout'), '/user/security/logout');
    }
}
