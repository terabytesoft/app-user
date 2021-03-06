<?php

namespace ModuleUser;

use ModuleUser\FunctionalTester;
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
     * logInFormPageTest
     *
     **/
    public function logInFormPageTest(FunctionalTester $I)
    {
        $I->wantTo('ensure that login page works.');
        $I->expectTo('see page login.');
        $I->see(Yii::t('ModuleUser', 'Login'), '.form-security-login-title');
    }

    /**
     * logInFormResetPasswordLink
     *
     **/
    public function logInFormResetPasswordLink(FunctionalTester $I)
    {
        $I->wantTo('ensure that link reset password link works.');
        $I->SeeLink(Yii::t('ModuleUser', 'reset it here'), '/user/recovery/request');
        $I->click(['link' => Yii::t('ModuleUser', 'reset it here')]);
        $I->expectTo('see page recover password.');
        $I->see(Yii::t('ModuleUser', 'Recover your password'), '.form-recovery-request-title');
    }

    /**
     * logInFormResendReceiveConfirmationMessageLink
     *
     **/
    public function logInFormResendReceiveConfirmationMessageLink(FunctionalTester $I)
    {
        $I->wantTo('ensure that link resend receive confirmation message link works.');
        $I->SeeLink(Yii::t('ModuleUser', 'Didn\'t receive confirmation message?'), '/user/registration/resend');
        $I->click(['link' => Yii::t('ModuleUser', 'Didn\'t receive confirmation message?')]);
        $I->expectTo('see page request new confirmation message.');
        $I->see(Yii::t('ModuleUser', 'Request new confirmation message'), '.form-registration-resend-title');
    }

    /**
     * logInFormDontIHaveAccountLink
     *
     **/
    public function logInFormDontIHaveAccountLink(FunctionalTester $I)
    {
        $I->wantTo('ensure that link receive confirmation message works.');
        $I->SeeLink(Yii::t('ModuleUser', 'Don\'t have an account? Sign up!'), '/user/registration/register');
        $I->click(['link' => Yii::t('ModuleUser', 'Don\'t have an account? Sign up!')]);
        $I->expectTo('see page sign up.');
        $I->see(Yii::t('ModuleUser', 'Sign up'), '.form-registration-register-title');
    }

    /**
     * logInFormEmptyDataTest
     *
     **/
    public function logInFormEmptyDataTest(FunctionalTester $I)
    {
        $I->amGoingTo('login submit form with empty data.');
        $I->submitForm('#form-security-login', []);
        $I->expectTo('see validations errors.');
        $I->see(Yii::t('ModuleUser', 'Login cannot be blank.'), '.invalid-feedback');
        $I->see(Yii::t('ModuleUser', 'Password cannot be blank.'), '.invalid-feedback');
        $I->See(Yii::t('ModuleUser', 'Login'), '.btn');
    }

    /**
     * logInFormSubmitFormWrongDataTest
     *
     **/
    public function logInFormSubmitFormWrongDataTest(FunctionalTester $I)
    {
        $I->amGoingTo('login submit form with data wrong.');
        $I->submitForm('#form-security-login', [
            'login-form[login]' => 'admin',
            'login-form[password]' => '1234567',
        ]);
        $I->expectTo('invalid login or password.');
        $I->see(Yii::t('ModuleUser', 'Invalid login or password.'), '.invalid-feedback');
        $I->See(Yii::t('ModuleUser', 'Login'), '.btn');
    }

    /**
     * @depends ModuleUser\SignUpFormCest:SignUpFormRegisterSuccessDataTest
     *
     * logInFormSubmitFormSuccessDataTest
     *
     */
    public function logInFormSubmitFormSuccessDataTest(FunctionalTester $I)
    {
        $I->amGoingTo('login submit form with data success.');
        $I->submitForm('#form-security-login', [
            'login-form[login]' => 'demo',
            'login-form[password]' => '123456',
        ]);
        $I->expectTo('link logout');
        $I->dontSeeLink(Yii::t('ModuleUser', 'Login'), '.btn');
        $I->seeLink(Yii::t('ModuleUser', 'Logout'), '/user/security/logout');
    }
}
