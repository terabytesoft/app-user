<?php

namespace ModuleUser;

use ModuleUser\AcceptanceTester;
use yii\helpers\Yii;

/**
 * AdminCest
 *
 * Acceptance tests user admin logged.
 */
class AdminCest
{
    /**
     * @depends ModuleUser\SignUpCest:signUpRegisterSuccessDataTest
     *
     * adminPageManageUser
     *
     * Test page manage user.
     */
    public function adminPageManageUser(AcceptanceTester $I)
    {
        $I->amOnPage('/user/security/login');

        $I->amGoingTo('Login SubmitForm With Data Success.');
        $I->fillField('#login-form-login', 'admin');
        $I->fillField('#login-form-password', '123456');
        $I->click(Yii::t('ModuleUser', 'Login'), '#form-security-login');

        $I->expectTo('Menu Options Links Logged.');
        $I->SeeLink(Yii::t('ModuleUser', 'Manage Users'));
        $I->SeeLink(Yii::t('ModuleUser', 'Settings Account'));
        $I->SeeLink(Yii::t('ModuleUser', 'Settings Profile'));
        $I->SeeLink(Yii::t('ModuleUser', 'Logout'));

        $I->wantTo('Ensure Page Managers Users Work.');
        $I->expectTo('See Page Manage User.');
        $I->click(Yii::t('ModuleUser', 'Manage Users'));
        $I->see(Yii::t('ModuleUser', 'Manage Users'), 'h2');
    }

    /**
     * adminPageSettingsAccount
     *
     * Test pages settings account.
     *
     * @param AcceptanceTester $I
     * @return void
     */
    public function adminPageSettingsAccount(AcceptanceTester $I)
    {
        $I->amOnPage('/user/security/login');

        $I->amGoingTo('Login SubmitForm With Data Success.');
        $I->fillField('#login-form-login', 'admin');
        $I->fillField('#login-form-password', '123456');
        $I->click(Yii::t('ModuleUser', 'Login'), '#form-security-login');

        $I->expectTo('Menu Options Links Logged.');
        $I->SeeLink(Yii::t('ModuleUser', 'Manage Users'));
        $I->SeeLink(Yii::t('ModuleUser', 'Settings Account'));
        $I->SeeLink(Yii::t('ModuleUser', 'Settings Profile'));
        $I->SeeLink(Yii::t('ModuleUser', 'Logout'));

        $I->wantTo('Ensure Page Settings Account Work.');
        $I->expectTo('See Page Settings Account.');
        $I->click(Yii::t('ModuleUser', 'Settings Account'));
        $I->see(Yii::t('ModuleUser', 'Account Form'), 'h2');
    }

    /**
     * adminPageSettingsProfile
     *
     * Test pages settings profile.
     *
     * @param AcceptanceTester $I
     * @return void
     */
    public function adminPageSettingsProfile(AcceptanceTester $I)
    {
        $I->amOnPage('/user/security/login');

        $I->amGoingTo('Login SubmitForm With Data Success.');
        $I->fillField('#login-form-login', 'admin');
        $I->fillField('#login-form-password', '123456');
        $I->click(Yii::t('ModuleUser', 'Login'), '#form-security-login');

        $I->expectTo('Menu Options Links Logged.');
        $I->SeeLink(Yii::t('ModuleUser', 'Manage Users'));
        $I->SeeLink(Yii::t('ModuleUser', 'Settings Account'));
        $I->SeeLink(Yii::t('ModuleUser', 'Settings Profile'));
        $I->SeeLink(Yii::t('ModuleUser', 'Logout'));

        $I->wantTo('Ensure Page Settings Profile Work.');
        $I->expectTo('See Page Settings Profile.');
        $I->click(Yii::t('ModuleUser', 'Settings Account'));
        $I->see(Yii::t('ModuleUser', 'Account Form'), 'h2');
    }

    /**
     * adminPageLogout
     *
     * Test action logout.
     *
     * @param AcceptanceTester $I
     * @return void
     */
    public function adminPageLogout(AcceptanceTester $I)
    {
        $I->amOnPage('/user/security/login');

        $I->amGoingTo('Login SubmitForm With Data Success.');
        $I->fillField('#login-form-login', 'admin');
        $I->fillField('#login-form-password', '123456');
        $I->click(Yii::t('ModuleUser', 'Login'), '#form-security-login');

        $I->expectTo('Menu Options Links Logged.');
        $I->SeeLink(Yii::t('ModuleUser', 'Manage Users'));
        $I->SeeLink(Yii::t('ModuleUser', 'Settings Account'));
        $I->SeeLink(Yii::t('ModuleUser', 'Settings Profile'));
        $I->SeeLink(Yii::t('ModuleUser', 'Logout'));

        $I->wantTo('Ensure Page Logout Work.');
        $I->expectTo('See Page Home.');
        $I->click(Yii::t('ModuleUser', 'Logout'));
        $I->SeeLink(Yii::t('ModuleUser', 'Sign up'));
        $I->SeeLink(Yii::t('ModuleUser', 'Login'));
    }
}
