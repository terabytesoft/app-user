<?php

namespace app\user;

use yii\activerecord\ActiveQuery;
use yii\base\Module as BaseModule;
use yii\base\Model;

/**
 * Module
 *
 * This is the main module class for the app-user
 *
 * @property array $modelMap
 **/
class Module extends BaseModule implements \yii\di\Initiable
{
    const VERSION = '0.0.1';

    /** email is changed right after user enter's new email address **/
    const STRATEGY_INSECURE = 0;

    /** email is changed after user clicks confirmation link sent to his new email address **/
    const STRATEGY_DEFAULT = 1;

    /** email is changed after user clicks both confirmation links sent to his old and new email addresses **/
    const STRATEGY_SECURE = 2;

    public $accountModel;

    public $accountQuery;

	public $loginForm;

	public $profileModel;

	public $profileQuery;

	public $tokenModel;

	public $tokenQuery;

	public $userModel;

	public $userQuery;

	public $userSearch;

    /** @var bool Whether to show flash messages **/
    public $enableFlashMessages = true;

    /** @var bool Whether to enable registration **/
    public $enableRegistration = true;

    /** @var bool Whether to remove password field from registration form **/
    public $enableGeneratingPassword = false;

    /** @var bool Whether user has to confirm his account **/
    public $enableConfirmation = true;

    /** @var bool Whether to allow logging in without confirmation **/
    public $enableUnconfirmedLogin = false;

    /** @var bool Whether to enable password recovery **/
    public $enablePasswordRecovery = true;

    /** @var bool Whether user can remove his account **/
    public $enableAccountDelete = false;

    /** @var bool Enable the 'impersonate as another user' function **/
    public $enableImpersonateUser = true;

    /** @var int Email changing strategy **/
    public $emailChangeStrategy = self::STRATEGY_DEFAULT;

    /** @var int The time you want the user will be remembered without asking for credentials **/
    public $rememberFor = 1209600; // two weeks

    /** @var int The time before a confirmation token becomes invalid **/
    public $confirmWithin = 86400; // 24 hours

    /** @var int The time before a recovery token becomes invalid **/
    public $recoverWithin = 21600; // 6 hours

    /** @var int Cost parameter used by the Blowfish hash algorithm **/
    public $cost = 10;

    /** @var array An array of administrator's usernames **/
    public $admins = [];

    /** @var string The Administrator permission name **/
    public $adminPermission;

    /** @var array Mailer configuration **/
    public $mailer = [];

    /** @var array Model map **/
    public $modelMap = [
    ];

	/** @var array Form map **/
    public $formMap = [
    ];

	/** @var array Query map **/
    public $queryMap = [
    ];

	/** @var array Search map **/
	public $searchMap = [
	];

    /**
     * @var string the prefix for user module URL
     *
     * @See [[GroupUrlRule::prefix]]
     */
    public $urlPrefix = 'user';

    /**
     * @var bool is the user module in DEBUG mode? Will be set to false automatically
     * if the application leaves debug mode
     */
    public $debug = false;

    /** @var string The database connection to use for models in this module **/
    public $dbConnection = 'db';

    /** @var array The rules to be used in URL management **/
    public $urlRules = [
        '<id:\d+>'                               => 'profile/show',
        '<action:(login|logout|auth)>'           => 'security/<action>',
        '<action:(register|resend)>'             => 'registration/<action>',
        'confirm/<id:\d+>/<code:[A-Za-z0-9_-]+>' => 'registration/confirm',
        'forgot'                                 => 'recovery/request',
        'recover/<id:\d+>/<code:[A-Za-z0-9_-]+>' => 'recovery/reset',
        'settings/<action:\w+>'                  => 'settings/<action>'
	];

    /**
     * __construct
	 *
     **/
    public function init(): void
    {
		$this->accountQuery = $this->getAccountQuery();
		$this->accountModel = $this->getAccountModel();
		$this->profileModel = $this->getProfileModel();
		$this->profileQuery = $this->getProfileQuery();
		$this->tokenModel = $this->getTokenModel();
		$this->tokenQuery = $this->getTokenQuery();
		$this->userModel = $this->getUserModel();
		$this->userQuery = $this->getUserQuery();
		$this->userSearch = $this->getUserSearch();
    }

    /**
	 * getAccountModel
	 *
     * @return Model
     **/
    public function getAccountModel(): Model
    {
		return new $this->modelMap['AccountModel'];
	}

    /**
	 * getAccountQuery
	 *
     * @return ActiveQuery
     **/
    public function getAccountQuery(): ActiveQuery
    {
		return new $this->queryMap['AccountQuery']($this->modelMap['AccountModel']);
	}

	/**
	 * getProfileModel
	 *
     * @return Model
     **/
    public function getProfileModel(): Model
    {
		return new $this->modelMap['ProfileModel'];
	}

    /**
	 * getAccountQuery
	 *
     * @return ActiveQuery
     **/
    public function getProfileQuery(): ActiveQuery
    {
		return new $this->queryMap['ProfileQuery']($this->modelMap['ProfileModel']);
	}

	/**
	 * getUserModel
	 *
     * @return Model
     **/
    public function getTokenModel(): Model
    {
		return new $this->modelMap['TokenModel'];
	}

    /**
	 * getAccountQuery
	 *
     * @return ActiveQuery
     **/
    public function getTokenQuery(): ActiveQuery
    {
		return new $this->queryMap['TokenQuery']($this->modelMap['TokenModel']);
	}

	/**
	 * getUserModel
	 *
     * @return Model
     **/
    public function getUserModel(): Model
    {
		return new $this->modelMap['UserModel'];
	}

    /**
	 * getUserQuery
	 *
     * @return ActiveQuery
     **/
    public function getUserQuery(): ActiveQuery
    {
		return new $this->queryMap['UserQuery']($this->modelMap['UserModel']);
	}

	/**
	 * getUserSearch
	 *
     * @return Model
     **/
    public function getUserSearch(): Model
    {
		return new $this->searchMap['UserSearch'];
	}
}
