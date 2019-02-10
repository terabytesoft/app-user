<?php

namespace app\user;

use yii\activerecord\ActiveQuery;
use yii\base\Model;
use yii\base\Module as BaseModule;

/**
 * Class Module.
 *
 * This is the main module class for the app-user
 *
 * @property array $modelMap
 **/
class Module extends BaseModule
{
	const VERSION = '0.0.1';

	/**
	 * Email is changed right after user enter's new email address.
	 **/
	const STRATEGY_INSECURE = 0;

	/**
	 * Email is changed after user clicks confirmation link sent to his new email address.
	 **/
	const STRATEGY_DEFAULT = 1;

	/**
	 * Email is changed after user clicks both confirmation links sent to his old and new email addresses.
	 **/
	const STRATEGY_SECURE = 2;

	/**
	 * @var array
	 *
	 * An array of administrator's usernames
	 **/
	public $accountAdmins = [];

	/**
	 * @var bool
	 *
	 * Whether user can remove his account
	 **/
	public $accountDelete;

	/**
	 * @var bool
	 *
	 * Whether user has to confirm his account
	 **/
	public $accountConfirmation;

	/**
	 * @var bool
	 *
	 * Whether to remove password field from registration form
	 **/
	public $accountGeneratingPassword;

	/**
	 * @var bool
	 *
	 * Enable the 'impersonate as another user' function
	 **/
	public $accountImpersonateUser;

	/**
	 * @var bool
	 *
	 * Whether to enable password recovery
	 **/
	public $accountPasswordRecovery;

	/**
	 * @var bool
	 *
	 * Whether to enable registration
	 **/
	public $accountRegistration;

	/**
	 * @var bool
	 *
	 * Whether to allow logging in without confirmation
	 **/
	public $accountUnconfirmedLogin;

	/**
	 * @var string
	 *
	 * The Administrator permission name
	 **/
	public $adminPermission;

	/**
	 * @var int
	 *
	 * Cost parameter used by the Blowfish hash algorithm
	 **/
	public $cost;

	/**
	 * @var string
	 *
	 * The database connection to use for models in this module
	 **/
	public $dbConnection = 'db';

	/**
	 * @var bool
	 *
	 * The user module in DEBUG mode? Will be set to false automatically
	 * if the application leaves debug mode
	 **/
	public $debug;

	/**
	 * @var int
	 *
	 * Email changing strategy
	 **/
	public $emailChangeStrategy;

	/**
	 * @var bool
	 *
	 * Floatting Labels Bootstrap4
	 **/
	public $floatLabels;

	/**
	 * @var array
	 *
	 * Form Model Overriding Map
	 **/
	public $formMap = [];

	/**
	 * @var array
	 *
	 * Mailer configuration
	 **/
	public $mailer = [];

	/**
	 * @var array
	 *
	 * Model Overriding Map
	 **/
	public $modelMap = [];

	/**
	 * @var array
	 *
	 * Query Overriding Map
	 **/
	public $queryMap = [];

	/**
	 * @var array
	 *
	 * Search Overriding Map
	 **/
	public $searchMap = [];

	/**
	 * @var int
	 *
	 * The time you want the user will be remembered without asking for credentials
	 **/
	public $rememberFor;

	/**
	 * @var int
	 *
	 * The time before a confirmation token becomes invalid
	 **/
	public $tokenConfirmWithin;

	/**
	 * @var int
	 *
	 * The time before a recovery token becomes invalid
	 **/
	public $tokenRecoverWithin;

	/**
	 * @var string
	 *
	 * The prefix for user module URL
	 *
	 * @See [[GroupUrlRule::prefix]]
	 */
	public $urlPrefix;

	/**
	 * @var array
	 *
	 * The rules to be used in URL management
	 **/
	public $urlRules = [];

	/**
	 * @var Model
	 *
	 * The account model
	 **/
	protected $accountModel;

	/**
	 * @var ActiveQuery
	 *
	 * The account query
	 **/
	protected $accountQuery;

	/**
	 * @var Model
	 *
	 * The login form model
	 **/
	protected $loginForm;

	/**
	 * @var Model
	 *
	 * The profile model
	 **/
	protected $profileModel;

	/**
	 * @var ActiveQuery
	 *
	 * The profile query
	 **/
    protected $profileQuery;

	/**
	 * @var Model
	 *
	 * The recovery form model
	 **/
    protected $recoveryForm;

	/**
	 * @var Model
	 *
	 * The registration form model
	 **/
	protected $registrationForm;

	/**
	 * @var Model
	 *
	 * The resend form model
	 **/
	protected $resendForm;

	/**
	 * @var Model
	 *
	 * The token model
	 **/
	protected $tokenModel;

	/**
	 * @var ActiveQuery
	 *
	 * The token query
	 **/
	protected $tokenQuery;

	/**
	 * @var Model
	 *
	 * The user model
	 **/
	protected $userModel;

	/**
	 * @var ActiveQuery
	 *
	 * The user query
	 **/
	protected $userQuery;

	/**
	 * @var Model
	 *
	 * The user search model
	 **/
	protected $userSearch;

	/**
	 * Get the value of accountModel.
	 *
	 * @return Model
	 **/
	public function getAccountModel(): Model
	{
		return new $this->modelMap['AccountModel']();
	}

	/**
	 * Get the value of accountQuery.
	 *
	 * @return ActiveQuery
	 **/
	public function getAccountQuery(): ActiveQuery
	{
		return new $this->queryMap['AccountQuery']($this->modelMap['AccountModel']);
	}

	/**
	 * Get the value of loginForm.
	 *
	 * @return Model
	 **/
	public function getLoginForm()
	{
		return new $this->formMap['LoginForm']();
	}

	/**
	 * Get the value of profileModel.
	 *
	 * @return Model
	 **/
	public function getProfileModel(): Model
	{
		return new $this->modelMap['ProfileModel']();
	}

	/**
	 * Get the value of profileQuery.
	 *
	 * @return ActiveQuery
	 **/
	public function getProfileQuery(): ActiveQuery
	{
		return new $this->queryMap['ProfileQuery']($this->modelMap['ProfileModel']);
	}

	/**
	 * Get the value of recoveryForm.
	 *
	 * @return Model
	 **/
	public function getRecoveryForm()
	{
		return new $this->formMap['RecoveryForm']();
	}

	/**
	 * Get the value of registrationForm.
	 *
	 * @return Model
	 **/
	public function getRegistrationForm()
	{
		return new $this->formMap['RegistrationForm']();
	}

	/**
	 * Get the value of resendForm.
	 *
	 * @return Model
	 **/
	public function getResendForm()
	{
		return new $this->formMap['ResendForm']();
	}

	/**
	 * Get the value of settingsForm.
	 *
	 * @return Model
	 **/
	public function getSettingsForm()
	{
		return new $this->formMap['SettingsForm']();
	}

	/**
	 * Get the value of tokenModel.
	 *
	 * @return Model
	 **/
	public function getTokenModel(): Model
	{
		return new $this->modelMap['TokenModel']();
	}

	/**
	 * Get the value of tokenQuery.
	 *
	 * @return ActiveQuery
	 **/
	public function getTokenQuery(): ActiveQuery
	{
		return new $this->queryMap['TokenQuery']($this->modelMap['TokenModel']);
	}

	/**
	 * Get the value of userModel.
	 *
	 * @return Model
	 **/
	public function getUserModel(): Model
	{
		return new $this->modelMap['UserModel']();
	}

	/**
	 * Get the value of userQuery.
	 *
	 * @return ActiveQuery
	 **/
	public function getUserQuery(): ActiveQuery
	{
		return new $this->queryMap['UserQuery']($this->modelMap['UserModel']);
	}

	/**
	 * Get the value of userSearch.
	 *
	 * @return Model
	 **/
	public function getUserSearch(): Model
	{
		return new $this->searchMap['UserSearch']();
	}
}
