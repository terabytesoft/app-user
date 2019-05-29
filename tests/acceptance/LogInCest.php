<?php

namespace ModuleUser;

use ModuleUser\AcceptanceTester;
use yii\helpers\Yii;

/**
 * LoginCest
 *
 * Acceptance tests login.
 */
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
        $I->see(Yii::t('ModuleUser', 'Login'), 'h2');
    }

    /**
     * logInResetPasswordLink
     *
     **/
    public function logInResetPasswordLink(AcceptanceTester $I)
    {
        $I->wantTo('ensure that link reset password link works.');
        $I->SeeLink(Yii::t('ModuleUser', 'reset it here'));
        $I->click(Yii::t('ModuleUser', 'reset it here'));
        $I->expectTo('see page recover password.');
        $I->see(Yii::t('ModuleUser', 'Recover your password'), 'h2');
    }

    /**
     * logInResendReceiveConfirmationMessageLink
     *
     **/
    public function logInResendReceiveConfirmationMessageLink(AcceptanceTester $I)
    {
        $I->wantTo('ensure that link resend receive confirmation message link works.');
        $I->SeeLink(Yii::t('ModuleUser', 'Didn\'t receive confirmation message?'));
        $I->click(Yii::t('ModuleUser', 'Didn\'t receive confirmation message?'));
        $I->expectTo('see page request new confirmation message.');
        $I->see(Yii::t('ModuleUser', 'Request new confirmation message'), 'h2');
    }

    /**
     * logInDontIHaveAccountLink
     *
     **/
    public function logInDontIHaveAccountLink(AcceptanceTester $I)
    {
        $I->wantTo('ensure that link receive confirmation message works.');
        $I->SeeLink(Yii::t('ModuleUser', 'Don\'t have an account? Sign up!'));
        $I->click(Yii::t('ModuleUser', 'Don\'t have an account? Sign up!'));
        $I->expectTo('see page sign up.');
        $I->see(Yii::t('ModuleUser', 'Sign up'), 'h2');
    }

    /**
     * logInEmptyDataTest
     *
     **/
    public function logInEmptyDataTest(AcceptanceTester $I)
    {
        $I->amGoingTo('login submit form with empty data.');
        $I->click(Yii::t('ModuleUser', 'Login'), '#form-security-login');
        $I->expectTo('see validations errors.');
        $I->see(Yii::t('ModuleUser', 'Login cannot be blank.'), '.invalid-feedback');
        $I->see(Yii::t('ModuleUser', 'Password cannot be blank.'), '.invalid-feedback');
        $I->See(Yii::t('ModuleUser', 'Login'), '#form-security-login');
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
        $I->click(Yii::t('ModuleUser', 'Login'), '#form-security-login');
        $I->expectTo('invalid login or password.');
        $I->see(Yii::t('ModuleUser', 'Invalid login or password.'), '.invalid-feedback');
        $I->See(Yii::t('ModuleUser', 'Login'), '#form-security-login');
    }

    /**
     * @depends ModuleUser\SignUpCest:signUpRegisterSuccessDataTest
     */
    public function logInSubmitFormSuccessDataTest(AcceptanceTester $I)
    {
        $I->amGoingTo('login submit form with data success.');
        $I->fillField('#login-form-login', 'admin');
        $I->fillField('#login-form-password', '123456');
        $I->click(Yii::t('ModuleUser', 'Login'), '#form-security-login');
        $I->expectTo('link logout');
        $I->SeeLink(Yii::t('ModuleUser', 'Manage Users'));
        $I->SeeLink(Yii::t('ModuleUser', 'Settings Account'));
        $I->SeeLink(Yii::t('ModuleUser', 'Settings Profile'));
        $I->SeeLink(Yii::t('ModuleUser', 'Logout'));
    }
}
