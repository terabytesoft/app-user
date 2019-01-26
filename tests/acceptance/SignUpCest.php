<?php

use yii\helpers\Yii;

/**
 * SingUpCest
 *
 * tests login form
 **/
class SignUpCest
{
    /**
     * _before
     *
     **/
    public function _before(FunctionalTester $I)
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
        $I->see(Yii::t('user', 'Sign up'), 'h2');
    }

    /**
     * SignUpAlreadyRegisteredLink
     *
     **/
    public function SignUpAlreadyRegisteredLink(AcceptanceTester $I)
    {
        $I->wantTo('ensure that link already registered link works.');
        $I->SeeLink(Yii::t('user', 'Already registered? Sign in!'));
        $I->click(Yii::t('user', 'Already registered? Sign in!'));
        $I->expectTo('see page login.');
        $I->see(Yii::t('user', 'Login'), 'h2');
    }

   /**
    * SignUpFormRegisterSuccessDataTest
    *
    **/
    public function SignUpFormRegisterSuccessDataTest(AcceptanceTester $I)
    {
        $I->amGoingTo('sign up submit form register with success data.');
        $I->fillField('#register-form-email', 'administrator@example.com');
        $I->fillField('#register-form-username', 'admin');
        $I->fillField('#register-form-password', '123456');
        $I->click(Yii::t('user', 'Sign up'), '.btn');
        $I->expectTo('see messages register confirm');
        $I->see(Yii::t('user', 'Your account has been created and a message with further instructions has been sent to your email'), '.alert');
        $I->SeeLink(Yii::t('user', 'Sign up'));
        $I->SeeLink(Yii::t('user', 'Login'));
    }

    /**
     * SignUpFormRegisterEmptyDataTest
     *
     **/
    public function SignUpFormRegisterEmptyDataTest(AcceptanceTester $I)
    {
        $I->amGoingTo('sign up submit form register with empty data.');
        $I->click(Yii::t('user', 'Sign up'), '.btn');
        $I->expectTo('see validations errors.');
        $I->see(Yii::t('user', 'Email cannot be blank.'), '.invalid-feedback');
        $I->see(Yii::t('user', 'Username cannot be blank.'), '.invalid-feedback');
        $I->see(Yii::t('user', 'Password cannot be blank.'), '.invalid-feedback');
        $I->SeeLink(Yii::t('user', 'Sign up'));
        $I->SeeLink(Yii::t('user', 'Login'));
    }

   /**
    * SignUpFormRegisterWrongEmailDataTest
    *
    **/
    public function SignUpFormRegisterWrongEmailDataTest(AcceptanceTester $I)
    {
        $I->amGoingTo('sign up submit form register with wrong email data.');
        $I->fillField('#register-form-email', 'register');
        $I->fillField('#register-form-username', 'register');
        $I->fillField('#register-form-password', '123456');
        $I->click(Yii::t('user', 'Sign up'), '.btn');
        $I->expectTo('see validation email errors');
        $I->see(Yii::t('user', 'Email is not a valid email address.'), '.invalid-feedback');
        $I->SeeLink(Yii::t('user', 'Sign up'));
        $I->SeeLink(Yii::t('user', 'Login'));
    }

   /**
    * SignUpFormRegisterEmailExistDataTest
    *
    **/
    public function SignUpFormRegisterEmailExistDataTest(AcceptanceTester $I)
    {
        $I->amGoingTo('sign up submit form register with email exist data.');
        $I->fillField('#register-form-email', 'administrator@example.com');
        $I->fillField('#register-form-username', 'administrator');
        $I->fillField('#register-form-password', '123456');
        $I->click(Yii::t('user', 'Sign up'), '.btn');
        $I->expectTo('see validation email errors');
        $I->see(Yii::t('user', 'This email address has already been taken.'), '.invalid-feedback');
        $I->SeeLink(Yii::t('user', 'Sign up'));
        $I->SeeLink(Yii::t('user', 'Login'));
    }

   /**
    * SignUpFormRegisterInvalidUsernameDataTest
    *
    **/
    public function SignUpFormRegisterInvalidUsernameDataTest(AcceptanceTester $I)
    {
        $I->amGoingTo('sign up submit form register with invalid username data.');
        $I->fillField('#register-form-email', 'demo@example.com');
        $I->fillField('#register-form-username', '**admin');
        $I->fillField('#register-form-password', '123456');
        $I->click(Yii::t('user', 'Sign up'), '.btn');
        $I->expectTo('see validation username errors');
        $I->see(Yii::t('user', 'Username is invalid.'), '.invalid-feedback');
        $I->SeeLink(Yii::t('user', 'Sign up'));
        $I->SeeLink(Yii::t('user', 'Login'));
        $I->amGoingTo('sign up submit form register with invalid username data.');
        $I->fillField('#register-form-email', 'demo@example.com');
        $I->fillField('#register-form-username', '**');
        $I->fillField('#register-form-password', '123456');
        $I->click(Yii::t('user', 'Sign up'), '.btn');
        $I->expectTo('see validation username errors');
        $I->see(Yii::t('user', 'Username should contain at least 3 characters.'), '.invalid-feedback');
        $I->SeeLink(Yii::t('user', 'Sign up'));
        $I->SeeLink(Yii::t('user', 'Login'));
    }

   /**
    * SignUpFormRegisterUsernameExistDataTest
    *
    **/
    public function SignUpFormRegisterUsernameExistDataTest(AcceptanceTester $I)
    {
        $I->amGoingTo('sign up submit form register with exist username data.');
        $I->fillField('#register-form-email', 'demo@example.com');
        $I->fillField('#register-form-username', 'admin');
        $I->fillField('#register-form-password', '123456');
        $I->click(Yii::t('user', 'Sign up'), '.btn');
        $I->expectTo('see validation username errors');
        $I->see(Yii::t('user', 'This username has already been taken.'), '.invalid-feedback');
        $I->SeeLink(Yii::t('user', 'Sign up'));
        $I->SeeLink(Yii::t('user', 'Login'));
    }

   /**
    * SignUpFormRegisterInvalidPasswordDataTest
    *
    **/
    public function SignUpFormRegisterInvalidPasswordDataTest(AcceptanceTester $I)
    {
        $I->amGoingTo('sign up submit form register with invalid password data.');
        $I->fillField('#register-form-email', 'demo@example.com');
        $I->fillField('#register-form-username', 'demo');
        $I->fillField('#register-form-password', '123');
        $I->click(Yii::t('user', 'Sign up'), '.btn');
        $I->expectTo('see validation password errors');
        $I->see(Yii::t('user', 'Password should contain at least 6 characters.'), '.invalid-feedback');
        $I->SeeLink(Yii::t('user', 'Sign up'));
        $I->SeeLink(Yii::t('user', 'Login'));
    }
}
