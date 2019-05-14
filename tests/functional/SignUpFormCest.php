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
        $I->see(Yii::t('ModuleUser', 'Sign up'), '.form-registration-register-title');
    }

    /**
     * SignUpFormAlreadyRegisteredLink
     *
     **/
    public function SignUpFormAlreadyRegisteredLink(FunctionalTester $I)
    {
        $I->wantTo('ensure that link already registered link works.');
        $I->SeeLink(Yii::t('ModuleUser', 'Already registered? Sign in!'), '/user/security/login');
        $I->click(['link' => Yii::t('ModuleUser', 'Already registered? Sign in!')]);
        $I->expectTo('see page login.');
        $I->see(Yii::t('ModuleUser', 'Login'), '.form-security-login-title');
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
        $I->see(Yii::t('ModuleUser', 'Your account has been created and a message with further instructions has been sent to your email'), '.alert');
        $I->dontSeeLink(Yii::t('ModuleUser', 'Sign up'), '.btn');
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
        $I->see(Yii::t('ModuleUser', 'Email cannot be blank.'), '.invalid-feedback');
        $I->see(Yii::t('ModuleUser', 'Username cannot be blank.'), '.invalid-feedback');
        $I->see(Yii::t('ModuleUser', 'Password cannot be blank.'), '.invalid-feedback');
        $I->See(Yii::t('ModuleUser', 'Sign up'), '.btn');
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
        $I->see(Yii::t('ModuleUser', 'Email is not a valid email address.'), '.invalid-feedback');
        $I->See(Yii::t('ModuleUser', 'Sign up'), '.btn');
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
        $I->see(Yii::t('ModuleUser', 'This email address has already been taken.'), '.invalid-feedback');
        $I->See(Yii::t('ModuleUser', 'Sign up'), '.btn');
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
		$I->see(Yii::t('ModuleUser', 'Username is invalid.'), '.invalid-feedback');
        $I->See(Yii::t('ModuleUser', 'Sign up'), '.btn');
		$I->amGoingTo('sign up submit form register with invalid username data.');
		$I->submitForm('#form-registration-register', [
			'register-form[email]' => 'demo@example.com',
			'register-form[username]' => '**',
			'register-form[password]' => '123456',
		]);
        $I->expectTo('see validation username errors');
        $I->see(Yii::t('ModuleUser', 'Username should contain at least 3 characters.'), '.invalid-feedback');
        $I->See(Yii::t('ModuleUser', 'Sign up'), '.btn');
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
        $I->see(Yii::t('ModuleUser', 'This username has already been taken.'), '.invalid-feedback');
        $I->See(Yii::t('ModuleUser', 'Sign up'), '.btn');
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
        $I->see(Yii::t('ModuleUser', 'Password should contain at least 6 characters.'), '.invalid-feedback');
        $I->See(Yii::t('ModuleUser', 'Sign up'), '.btn');
    }
}
