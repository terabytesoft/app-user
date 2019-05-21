<?php

namespace ModuleUser;

use ModuleUser\AcceptanceTester;
use yii\helpers\Yii;

/**
 * SingUpCest
 *
 * tests acceptance
 **/
class SignUpCest
{
    /**
     * _before
     *
     **/
    public function _before(AcceptanceTester $I)
    {
        $I->amOnPage('/user/registration/register');
    }

    /**
     * SignUpPageTest
     *
     **/
    public function SignUpPageTest(AcceptanceTester $I)
    {
        $I->wantTo('ensure that Sing up page works.');
        $I->expectTo('see page sign up.');
        $I->see(Yii::t('ModuleUser', 'Sign up'), 'h2');
    }

    /**
     * SignUpAlreadyRegisteredLink
     *
     **/
    public function SignUpAlreadyRegisteredLink(AcceptanceTester $I)
    {
        $I->wantTo('ensure that link already registered link works.');
        $I->SeeLink(Yii::t('ModuleUser', 'Already registered? Sign in!'));
        $I->click(Yii::t('ModuleUser', 'Already registered? Sign in!'));
        $I->expectTo('see page login.');
        $I->see(Yii::t('ModuleUser', 'Login'), 'h2');
    }

   /**
    * SignUpRegisterSuccessDataTest
    *
    **/
    public function SignUpRegisterSuccessDataTest(AcceptanceTester $I)
    {
        $I->amGoingTo('sign up submit form register with success data.');
        $I->fillField('#register-form-email', 'administrator@example.com');
        $I->fillField('#register-form-username', 'admin');
        $I->fillField('#register-form-password', '123456');
        $I->click(Yii::t('ModuleUser', 'Sign up'), '.btn');
        $I->expectTo('see messages register confirm');
        $I->see(Yii::t('ModuleUser', 'Your account has been created and a message with further instructions has been sent to your email'), '.alert');
        $I->dontSeeLink(Yii::t('ModuleUser', 'Sign up'), '.btn');
    }

    /**
     * SignUpRegisterEmptyDataTest
     *
     **/
    public function SignUpRegisterEmptyDataTest(AcceptanceTester $I)
    {
        $I->amGoingTo('sign up submit form register with empty data.');
        $I->click(Yii::t('ModuleUser', 'Sign up'), '.btn');
        $I->expectTo('see validations errors.');
        $I->see(Yii::t('ModuleUser', 'Email cannot be blank.'), '.invalid-feedback');
        $I->see(Yii::t('ModuleUser', 'Username cannot be blank.'), '.invalid-feedback');
        $I->see(Yii::t('ModuleUser', 'Password cannot be blank.'), '.invalid-feedback');
        $I->See(Yii::t('ModuleUser', 'Sign up'), '.btn');
    }

   /**
    * SignUpRegisterWrongEmailDataTest
    *
    **/
    public function SignUpRegisterWrongEmailDataTest(AcceptanceTester $I)
    {
        $I->amGoingTo('sign up submit form register with wrong email data.');
        $I->fillField('#register-form-email', 'register');
        $I->fillField('#register-form-username', 'register');
        $I->fillField('#register-form-password', '123456');
        $I->click(Yii::t('ModuleUser', 'Sign up'), '.btn');
        $I->expectTo('see validation email errors');
        $I->see(Yii::t('ModuleUser', 'Email is not a valid email address.'), '.invalid-feedback');
        $I->See(Yii::t('ModuleUser', 'Sign up'), '.btn');
    }

   /**
    * SignUpRegisterEmailExistDataTest
    *
    **/
    public function SignUpRegisterEmailExistDataTest(AcceptanceTester $I)
    {
        $I->amGoingTo('sign up submit form register with email exist data.');
        $I->fillField('#register-form-email', 'administrator@example.com');
        $I->fillField('#register-form-username', 'administrator');
        $I->fillField('#register-form-password', '123456');
        $I->click(Yii::t('ModuleUser', 'Sign up'), '.btn');
        $I->expectTo('see validation email errors');
        $I->see(Yii::t('ModuleUser', 'This email address has already been taken.'), '.invalid-feedback');
        $I->See(Yii::t('ModuleUser', 'Sign up'), '.btn');
    }

   /**
    * SignUpRegisterInvalidUsernameDataTest
    *
    **/
    public function SignUpRegisterInvalidUsernameDataTest(AcceptanceTester $I)
    {
        $I->amGoingTo('sign up submit form register with invalid username data.');
        $I->fillField('#register-form-email', 'demo@example.com');
        $I->fillField('#register-form-username', '**admin');
        $I->fillField('#register-form-password', '123456');
        $I->click(Yii::t('ModuleUser', 'Sign up'), '.btn');
        $I->expectTo('see validation username errors');
        $I->see(Yii::t('ModuleUser', 'Username is invalid.'), '.invalid-feedback');
        $I->amGoingTo('sign up submit form register with invalid username data.');
        $I->fillField('#register-form-email', 'demo@example.com');
        $I->fillField('#register-form-username', '**');
        $I->fillField('#register-form-password', '123456');
        $I->click(Yii::t('ModuleUser', 'Sign up'), '.btn');
        $I->expectTo('see validation username errors');
        $I->see(Yii::t('ModuleUser', 'Username should contain at least 3 characters.'), '.invalid-feedback');
        $I->See(Yii::t('ModuleUser', 'Sign up'), '.btn');
    }

   /**
    * SignUpRegisterUsernameExistDataTest
    *
    **/
    public function SignUpRegisterUsernameExistDataTest(AcceptanceTester $I)
    {
        $I->amGoingTo('sign up submit form register with exist username data.');
        $I->fillField('#register-form-email', 'demo@example.com');
        $I->fillField('#register-form-username', 'admin');
        $I->fillField('#register-form-password', '123456');
        $I->click(Yii::t('ModuleUser', 'Sign up'), '.btn');
        $I->expectTo('see validation username errors');
        $I->see(Yii::t('ModuleUser', 'This username has already been taken.'), '.invalid-feedback');
        $I->See(Yii::t('ModuleUser', 'Sign up'), '.btn');
    }

   /**
    * SignUpRegisterInvalidPasswordDataTest
    *
    **/
    public function SignUpRegisterInvalidPasswordDataTest(AcceptanceTester $I)
    {
        $I->amGoingTo('sign up submit form register with invalid password data.');
        $I->fillField('#register-form-email', 'demo@example.com');
        $I->fillField('#register-form-username', 'demo');
        $I->fillField('#register-form-password', '123');
        $I->click(Yii::t('ModuleUser', 'Sign up'), '.btn');
        $I->expectTo('see validation password errors');
        $I->see(Yii::t('ModuleUser', 'Password should contain at least 6 characters.'), '.invalid-feedback');
        $I->See(Yii::t('ModuleUser', 'Sign up'), '.btn');
    }
}
