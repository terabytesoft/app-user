<?php

namespace TerabyteSoft\Module\User;

use TerabyteSoft\Module\User\Forms\LoginForm;
use TerabyteSoft\Module\User\Forms\RecoveryForm;
use TerabyteSoft\Module\User\Forms\RegistrationForm;
use TerabyteSoft\Module\User\Forms\ResendForm;
use TerabyteSoft\Module\User\Forms\SettingsForm;
use TerabyteSoft\Module\User\Models\AccountModel;
use TerabyteSoft\Module\User\Models\ProfileModel;
use TerabyteSoft\Module\User\Models\TokenModel;
use TerabyteSoft\Module\User\Models\UserModel;
use TerabyteSoft\Module\User\Querys\AccountQuery;
use TerabyteSoft\Module\User\Querys\ProfileQuery;
use TerabyteSoft\Module\User\Querys\TokenQuery;
use TerabyteSoft\Module\User\Querys\UserQuery;
use TerabyteSoft\Module\User\Searchs\UserSearch;
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
	 * @var \TerabyteSoft\Module\User\Models\AccountModel
	 **/
	protected $accountModel;

	/**
	 * The value of accountQuery.
	 *
	 * @var \TerabyteSoft\Module\User\Querys\AccountQuery
	 **/
	protected $accountQuery;

	/**
	 * The value of loginForm.
	 *
	 * @var \TerabyteSoft\Module\User\Forms\LoginForm
	 **/
	protected $loginForm;

	/**
	 * The value of profileModel.
	 *
	 * @var \TerabyteSoft\Module\User\Models\ProfileModel
	 **/
	protected $profileModel;

	/**
	 * The value of profileQuery.
	 *
	 * @var \TerabyteSoft\Module\User\Querys\ProfileQuery
	 **/
	protected $profileQuery;

	/**
	 * The value of recoveryForm.
	 *
	 * @var \TerabyteSoft\Module\User\Forms\RecoveryForm
	 **/
	protected $recoveryForm;

	/**
	 * The value of registrationForm.
	 *
	 * @var \TerabyteSoft\Module\User\Forms\RegistrationForm
	 **/
	protected $registrationForm;

	/**
	 * The value of resendForm.
	 *
	 * @var \TerabyteSoft\Module\User\Forms\ResendForm
	 **/
	protected $resendForm;

	/**
	 * The value of settingsForm.
	 *
	 * @var \TerabyteSoft\Module\User\Forms\SettingsForm
	 **/
	protected $settingsForm;

	/**
	 * The value of theme.
	 *
	 * @var bool
	 **/
    public $theme;

	/**
	 * The value of theme view login.
	 *
	 * @var string
	 **/
	public $themeViewsLogin;

	/**
	 * The value of theme view register.
	 *
	 * @var string
	 **/
	public $themeViewsRegister;

	/**
	 * The value of tokenModel.
	 *
	 * @var \TerabyteSoft\Module\User\Models\TokenModel
	 **/
	protected $tokenModel;

	/**
	 * The value of tokenQuery.
	 *
	 * @var \TerabyteSoft\Module\User\Querys\TokenQuery
	 **/
	protected $tokenQuery;

	/**
	 * The value of userModel.
	 *
	 * @var \TerabyteSoft\Module\User\Models\UserModel
	 **/
	protected $userModel;

	/**
	 * The value of userQuery.
	 *
	 * @var \TerabyteSoft\Module\User\Querys\UserQuery
	 **/
	protected $userQuery;

	/**
	 * The value of userSearch.
	 *
	 * @var \TerabyteSoft\Module\User\Searchs\UserSearch
	 **/
	protected $userSearch;

	/**
	 * Get the value of accountModel.
	 *
	 * @return \TerabyteSoft\Module\User\Models\AccountModel
	 **/
	public function getAccountModel(): AccountModel
	{
		return new $this->modelMap['AccountModel']();
	}

	/**
	 * Get the value of accountQuery.
	 *
	 * @return \TerabyteSoft\Module\User\Querys\AccountQuery
	 **/
	public function getAccountQuery(): AccountQuery
	{
		return new $this->queryMap['AccountQuery']($this->modelMap['AccountModel']);
	}

	/**
	 * Get the value of loginForm.
	 *
	 * @return \TerabyteSoft\Module\User\Forms\LoginForm
	 **/
	public function getLoginForm(): LoginForm
	{
		return new $this->formMap['LoginForm']();
	}

	/**
	 * Get the value of profileModel.
	 *
	 * @return \TerabyteSoft\Module\User\Models\ProfileModel
	 **/
	public function getProfileModel(): ProfileModel
	{
		return new $this->modelMap['ProfileModel']();
	}

	/**
	 * Get the value of profileQuery.
	 *
	 * @return \TerabyteSoft\Module\User\Querys\ProfileQuery
	 **/
	public function getProfileQuery(): ProfileQuery
	{
		return new $this->queryMap['ProfileQuery']($this->modelMap['ProfileModel']);
	}

	/**
	 * Get the value of recoveryForm.
	 *
	 * @return \TerabyteSoft\Module\User\Forms\RecoveryForm
	 **/
	public function getRecoveryForm(): RecoveryForm
	{
		return new $this->formMap['RecoveryForm']();
	}

	/**
	 * Get the value of registrationForm.
	 *
	 * @return \TerabyteSoft\Module\User\Forms\RegistrationForm
	 **/
	public function getRegistrationForm(): RegistrationForm
	{
		return new $this->formMap['RegistrationForm']();
	}

	/**
	 * Get the value of resendForm.
	 *
	 * @return \TerabyteSoft\Module\User\Forms\ResendForm
	 **/
	public function getResendForm(): ResendForm
	{
		return new $this->formMap['ResendForm']();
	}

	/**
	 * Get the value of settingsForm.
	 *
	 * @return \TerabyteSoft\Module\User\Forms\SettingsForm
	 **/
	public function getSettingsForm(): SettingsForm
	{
		return new $this->formMap['SettingsForm']();
	}

	/**
	 * Get the value of tokenModel.
	 *
	 * @return \TerabyteSoft\Module\User\Models\TokenModel
	 **/
	public function getTokenModel(): TokenModel
	{
		return new $this->modelMap['TokenModel']();
	}

	/**
	 * Get the value of tokenQuery.
	 *
	 * @return \TerabyteSoft\Module\User\Querys\TokenQuery
	 **/
	public function getTokenQuery(): TokenQuery
	{
		return new $this->queryMap['TokenQuery']($this->modelMap['TokenModel']);
	}

	/**
	 * Get the value of userModel.
	 *
	 * @return \TerabyteSoft\Module\User\Models\UserModel
	 **/
	public function getUserModel(): UserModel
	{
		return new $this->modelMap['UserModel']();
	}

	/**
	 * Get the value of userQuery.
	 *
	 * @return \TerabyteSoft\Module\User\Querys\UserQuery
	 **/
	public function getUserQuery(): UserQuery
	{
		return new $this->queryMap['UserQuery']($this->modelMap['UserModel']);
	}

	/**
	 * Get the value of userSearch.
	 *
	 * @return \TerabyteSoft\Module\User\Searchs\UserSearch
	 **/
	public function getUserSearch(): UserSearch
	{
		return new $this->searchMap['UserSearch']();
	}
}
