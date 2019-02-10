<?php

namespace app\user;

use app\user\forms\LoginForm;
use app\user\forms\RecoveryForm;
use app\user\forms\RegistrationForm;
use app\user\forms\ResendForm;
use app\user\forms\SettingsForm;
use app\user\models\AccountModel;
use app\user\models\ProfileModel;
use app\user\models\TokenModel;
use app\user\models\UserModel;
use app\user\querys\AccountQuery;
use app\user\querys\ProfileQuery;
use app\user\querys\TokenQuery;
use app\user\querys\UserQuery;
use app\user\searchs\UserSearch;
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
	 * An array of administrator's usernames.
	 *
	 * @var array
	 **/
	public $accountAdmins = [];

	/**
	 * Whether user can remove his account.
	 *
	 * @var bool
	 **/
	public $accountDelete;

	/**
	 * Whether user has to confirm his account.
	 *
	 * @var bool
	 **/
	public $accountConfirmation;

	/**
	 * Whether to remove password field from registration form.
	 *
	 * @var bool
	 **/
	public $accountGeneratingPassword;

	/**
	 * Enable the 'impersonate as another user' function.
	 *
	 * @var bool
	 **/
	public $accountImpersonateUser;

	/**
	 * Whether to enable password recovery.
	 *
	 * @var bool
	 **/
	public $accountPasswordRecovery;

	/**
	 * Whether to enable registration.
	 *
	 * @var bool
	 **/
	public $accountRegistration;

	/**
	 * Whether to allow logging in without confirmation.
	 *
	 * @var bool
	 **/
	public $accountUnconfirmedLogin;

	/**
	 * The Administrator permission name.
	 *
	 * @var string
	 **/
	public $adminPermission;

	/**
	 * Cost parameter used by the Blowfish hash algorithm.
	 *
	 * @var int
	 **/
	public $cost;

	/**
	 * The database connection to use for models in this module.
	 *
	 * @var string
	 **/
	public $dbConnection = 'db';

	/**
	 * The user module in DEBUG mode? Will be set to false automatically
	 * if the application leaves debug mode.
	 *
	 * @var bool
	 **/
	public $debug;

	/**
	 * Email changing strategy.
	 *
	 * @var int
	 **/
	public $emailChangeStrategy;

	/**
	 * Floatting Labels Bootstrap4.
	 *
	 * @var bool
	 **/
	public $floatLabels;

	/**
	 * Form Overriding Map.
	 *
	 * @var array
	 **/
	public $formMap = [];

	/**
	 * Mailer configuration.
	 *
	 * @var array
	 **/
	public $mailer = [];

	/**
	 * Model Overriding Map.
	 *
	 * @var array
	 **/
	public $modelMap = [];

	/**
	 * Query Overriding Map.
	 *
	 * @var array
	 **/
	public $queryMap = [];

	/**
	 * Search Overriding Map.
	 *
	 * @var array
	 **/
	public $searchMap = [];

	/**
	 * The time you want the user will be remembered without asking for credentials.
	 *
	 * @var int
	 **/
	public $rememberFor;

	/**
	 * The time before a confirmation token becomes invalid.
	 *
	 * @var int
	 **/
	public $tokenConfirmWithin;

	/**
	 * The time before a recovery token becomes invalid.
	 *
	 * @var int
	 **/
	public $tokenRecoverWithin;

	/**
	 * The prefix for user module URL.
	 *
	 * @See [[GroupUrlRule::prefix]]
	 *
	 * @var string
	 */
	public $urlPrefix;

	/**
	 * The rules to be used in URL management.
	 *
	 * @var array
	 **/
	public $urlRules = [];

	/**
	 * The value of accountModel.
	 *
	 * @var \app\user\models\AccountModel
	 **/
	protected $accountModel;

	/**
	 * The value of accountQuery.
	 *
	 * @var \app\user\querys\AccountQuery
	 **/
	protected $accountQuery;

	/**
	 * The value of loginForm.
	 *
	 * @var \app\user\forms\LoginForm
	 **/
	protected $loginForm;

	/**
	 * The value of profileModel.
	 *
	 * @var \app\user\models\ProfileModel
	 **/
	protected $profileModel;

	/**
	 * The value of profileQuery.
	 *
	 * @var \app\user\querys\ProfileQuery
	 **/
	protected $profileQuery;

	/**
	 * The value of recoveryForm.
	 *
	 * @var \app\user\forms\RecoveryForm
	 **/
	protected $recoveryForm;

	/**
	 * The value of registrationForm.
	 *
	 * @var \app\user\forms\RegistrationForm
	 **/
	protected $registrationForm;

	/**
	 * The value of resendForm.
	 *
	 * @var \app\user\forms\ResendForm
	 **/
	protected $resendForm;

	/**
	 * The value of settingsForm.
	 *
	 * @var \app\user\forms\SettingsForm
	 **/
	protected $settingsForm;

	/**
	 * The value of tokenModel.
	 *
	 * @var \app\user\models\TokenModel
	 **/
	protected $tokenModel;

	/**
	 * The value of tokenQuery.
	 *
	 * @var \app\user\querys\TokenQuery
	 **/
	protected $tokenQuery;

	/**
	 * The value of userModel.
	 *
	 * @var \app\user\models\UserModel
	 **/
	protected $userModel;

	/**
	 * The value of userQuery.
	 *
	 * @var \app\user\querys\UserQuery
	 **/
	protected $userQuery;

	/**
	 * The value of userSearch.
	 *
	 * @var \app\user\searchs\UserSearch
	 **/
	protected $userSearch;

	/**
	 * Get the value of accountModel.
	 *
	 * @return \app\user\models\AccountModel
	 **/
	public function getAccountModel(): AccountModel
	{
		return new $this->modelMap['AccountModel']();
	}

	/**
	 * Get the value of accountQuery.
	 *
	 * @return \app\user\querys\AccountQuery
	 **/
	public function getAccountQuery(): AccountQuery
	{
		return new $this->queryMap['AccountQuery']($this->modelMap['AccountModel']);
	}

	/**
	 * Get the value of loginForm.
	 *
	 * @return \app\user\forms\LoginForm
	 **/
	public function getLoginForm(): LoginForm
	{
		return new $this->formMap['LoginForm']();
	}

	/**
	 * Get the value of profileModel.
	 *
	 * @return \app\user\models\ProfileModel
	 **/
	public function getProfileModel(): ProfileModel
	{
		return new $this->modelMap['ProfileModel']();
	}

	/**
	 * Get the value of profileQuery.
	 *
	 * @return \app\user\querys\ProfileQuery
	 **/
	public function getProfileQuery(): ProfileQuery
	{
		return new $this->queryMap['ProfileQuery']($this->modelMap['ProfileModel']);
	}

	/**
	 * Get the value of recoveryForm.
	 *
	 * @return \app\user\forms\RecoveryForm
	 **/
	public function getRecoveryForm(): RecoveryForm
	{
		return new $this->formMap['RecoveryForm']();
	}

	/**
	 * Get the value of registrationForm.
	 *
	 * @return \app\user\forms\RegistrationForm
	 **/
	public function getRegistrationForm(): RegistrationForm
	{
		return new $this->formMap['RegistrationForm']();
	}

	/**
	 * Get the value of resendForm.
	 *
	 * @return \app\user\forms\ResendForm
	 **/
	public function getResendForm(): ResendForm
	{
		return new $this->formMap['ResendForm']();
	}

	/**
	 * Get the value of settingsForm.
	 *
	 * @return \app\user\forms\SettingsForm
	 **/
	public function getSettingsForm(): SettingsForm
	{
		return new $this->formMap['SettingsForm']();
	}

	/**
	 * Get the value of tokenModel.
	 *
	 * @return \app\user\models\TokenModel
	 **/
	public function getTokenModel(): TokenModel
	{
		return new $this->modelMap['TokenModel']();
	}

	/**
	 * Get the value of tokenQuery.
	 *
	 * @return \app\user\querys\TokenQuery
	 **/
	public function getTokenQuery(): TokenQuery
	{
		return new $this->queryMap['TokenQuery']($this->modelMap['TokenModel']);
	}

	/**
	 * Get the value of userModel.
	 *
	 * @return \app\user\models\UserModel
	 **/
	public function getUserModel(): UserModel
	{
		return new $this->modelMap['UserModel']();
	}

	/**
	 * Get the value of userQuery.
	 *
	 * @return \app\user\querys\UserQuery
	 **/
	public function getUserQuery(): UserQuery
	{
		return new $this->queryMap['UserQuery']($this->modelMap['UserModel']);
	}

	/**
	 * Get the value of userSearch.
	 *
	 * @return \app\user\searchs\UserSearch
	 **/
	public function getUserSearch(): UserSearch
	{
		return new $this->searchMap['UserSearch']();
	}
}
