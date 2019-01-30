<?php

use yii\helpers\Yii;

/**
 * SingUpFormCest
 *
 * tests functional
 **/
class SignUpFormCest
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
     * SignUpFormPageTest
     *
     **/
    public function SignUpFormPageTest(FunctionalTester $I)
    {
        $I->wantTo('ensure that Sing up page works.');
        $I->expectTo('see page sign up.');
        $I->see(Yii::t('user', 'Sign up'), '.form-registration-register-title');
    }

    /**
     * SignUpFormAlreadyRegisteredLink
     *
     **/
    public function SignUpFormAlreadyRegisteredLink(FunctionalTester $I)
    {
        $I->wantTo('ensure that link already registered link works.');
        $I->SeeLink(Yii::t('user', 'Already registered? Sign in!'), '/user/security/login');
        $I->click(['link' => Yii::t('user', 'Already registered? Sign in!')]);
        $I->expectTo('see page login.');
        $I->see(Yii::t('user', 'Login'), '.form-security-login-title');
    }

   /**
    * SignUpFormRegisterSuccessDataTest
    *
    **/
    public function SignUpFormRegisterSuccessDataTest(FunctionalTester $I)
    {
        $I->amGoingTo('sign up submit form register with success data.');
        $I->submitForm('#form-registration-register', [
            'register-form[email]' => 'demo@example.com',
            'register-form[username]' => 'demo',
            'register-form[password]' => '123456',
        ]);
        $I->expectTo('see messages register confirm');
        $I->see(Yii::t('user', 'Your account has been created and a message with further instructions has been sent to your email'), '.alert');
        $I->SeeLink(Yii::t('user', 'Sign up'), '/user/registration/register');
        $I->SeeLink(Yii::t('user', 'Login'), '/user/security/login');
    }

    /**
     * SignUpFormRegisterEmptyDataTest
     *
     **/
    public function SignUpFormRegisterEmptyDataTest(AcceptanceTester $I)
    {
        $I->amGoingTo('sign up submit form register with empty data.');
        $I->submitForm('#form-registration-register', [
            'register-form[email]' => '',
            'register-form[username]' => '',
            'register-form[password]' => '',
        ]);
        $I->expectTo('see validations errors.');
        $I->see(Yii::t('user', 'Email cannot be blank.'), '.invalid-feedback');
        $I->see(Yii::t('user', 'Username cannot be blank.'), '.invalid-feedback');
        $I->see(Yii::t('user', 'Password cannot be blank.'), '.invalid-feedback');
        $I->SeeLink(Yii::t('user', 'Sign up'), '/user/registration/register');
        $I->SeeLink(Yii::t('user', 'Login'), '/user/security/login');
    }

   /**
    * SignUpFormRegisterWrongEmailDataTest
    *
    **/
    public function SignUpFormRegisterWrongEmailDataTest(AcceptanceTester $I)
    {
        $I->amGoingTo('sign up submit form register with wrong email data.');
        $I->submitForm('#form-registration-register', [
            'register-form[email]' => 'register',
            'register-form[username]' => 'register',
            'register-form[password]' => '123456',
        ]);
        $I->expectTo('see validation email errors');
        $I->see(Yii::t('user', 'Email is not a valid email address.'), '.invalid-feedback');
        $I->SeeLink(Yii::t('user', 'Sign up'), '/user/registration/register');
        $I->SeeLink(Yii::t('user', 'Login'), '/user/security/login');
    }

   /**
    * SignUpFormRegisterEmailExistDataTest
    *
    **/
    public function SignUpFormRegisterEmailExistDataTest(AcceptanceTester $I)
    {
        $I->amGoingTo('sign up submit form register with email exist data.');
        $I->submitForm('#form-registration-register', [
            'register-form[email]' => 'administrator@example.com',
            'register-form[username]' => 'administrator',
            'register-form[password]' => '123456',
        ]);
        $I->expectTo('see validation email errors');
        $I->see(Yii::t('user', 'This email address has already been taken.'), '.invalid-feedback');
        $I->SeeLink(Yii::t('user', 'Sign up'), '/user/registration/register');
        $I->SeeLink(Yii::t('user', 'Login'), '/user/security/login');
    }

   /**
    * SignUpFormRegisterInvalidUsernameDataTest
    *
    **/
    public function SignUpFormRegisterInvalidUsernameDataTest(AcceptanceTester $I)
    {
		$I->amGoingTo('sign up submit form register with invalid username data.');
		$I->submitForm('#form-registration-register', [
			'register-form[email]' => 'demo@example.com',
			'register-form[username]' => '**admin',
			'register-form[password]' => '123456',
		]);
		$I->expectTo('see validation username errors');
		$I->see(Yii::t('user', 'Username is invalid.'), '.invalid-feedback');
		$I->SeeLink(Yii::t('user', 'Sign up'), '/user/registration/register');
		$I->SeeLink(Yii::t('user', 'Login'), '/user/security/login');
		$I->amGoingTo('sign up submit form register with invalid username data.');
		$I->submitForm('#form-registration-register', [
			'register-form[email]' => 'demo@example.com',
			'register-form[username]' => '**',
			'register-form[password]' => '123456',
		]);
        $I->expectTo('see validation username errors');
        $I->see(Yii::t('user', 'Username should contain at least 3 characters.'), '.invalid-feedback');
        $I->SeeLink(Yii::t('user', 'Sign up'), '/user/registration/register');
        $I->SeeLink(Yii::t('user', 'Login'), '/user/security/login');
    }

   /**
    * SignUpFormRegisterUsernameExistDataTest
    *
    **/
    public function SignUpFormRegisterUsernameExistDataTest(AcceptanceTester $I)
    {
        $I->amGoingTo('sign up submit form register with exist username data.');
		$I->submitForm('#form-registration-register', [
			'register-form[email]' => 'demo@example.com',
			'register-form[username]' => 'admin',
			'register-form[password]' => '123456',
		]);
        $I->expectTo('see validation username errors');
        $I->see(Yii::t('user', 'This username has already been taken.'), '.invalid-feedback');
        $I->SeeLink(Yii::t('user', 'Sign up'), '/user/registration/register');
        $I->SeeLink(Yii::t('user', 'Login'), '/user/security/login');
    }

   /**
    * SignUpFormRegisterInvalidPasswordDataTest
    *
    **/
    public function SignUpFormRegisterInvalidPasswordDataTest(AcceptanceTester $I)
    {
        $I->amGoingTo('sign up submit form register with invalid password data.');
		$I->submitForm('#form-registration-register', [
			'register-form[email]' => 'demo@example.com',
			'register-form[username]' => 'demo',
			'register-form[password]' => '123',
		]);
        $I->expectTo('see validation password errors');
        $I->see(Yii::t('user', 'Password should contain at least 6 characters.'), '.invalid-feedback');
        $I->SeeLink(Yii::t('user', 'Sign up'), '/user/registration/register');
        $I->SeeLink(Yii::t('user', 'Login'), '/user/security/login');
    }
}
