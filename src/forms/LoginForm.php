<?php

namespace app\user\forms;

use app\user\finder\Finder;
use app\user\helpers\Password;
use app\user\traits\ModuleTrait;
use yii\base\Model;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\helpers\Yii;

/**
 * LoginForm get user's login and password, validates them and logs the user in. If user has been blocked, it adds
 * an error to login form
 *
 * @property self $app
 * @property string $module
 **/
class LoginForm extends Model
{
	use ModuleTrait;

    protected $user;
	protected $finder;
	protected $result;

    public $login;
    public $password;
    public $rememberMe = false;

    /**
	 * rules
	 *
     * @return array the validation rules
     **/
    public function rules(): array
    {
        $rules = [
        	'loginTrim' => ['login', 'trim'],
            'requiredFields' => [['login'], 'required'],
            'confirmationValidate' => [
            	'login',
                function ($attribute) {
                    if ($this->user !== null) {
                        $confirmationRequired = $this->module->enableConfirmation
							&& !$this->module->enableUnconfirmedLogin;
                        if ($confirmationRequired && !$this->user->getIsConfirmed()) {
                            $this->addError($attribute, $this->app->t('user', 'You need to confirm your email address'));
						}
                        if ($this->user->getIsBlocked()) {
                            $this->addError($attribute, $this->app->t('user', 'Your account has been blocked'));
                        }
                    }
                }
            ],
            'rememberMe' => ['rememberMe', 'boolean'],
        ];

        if (!$this->module->debug) {
            $rules = array_merge($rules, [
                'requiredFields' => [['login', 'password'], 'required'],
                'passwordValidate' => [
                    'password',
                    function ($attribute) {
                        if ($this->user === null || !Password::validate($this->password, $this->user->password_hash)) {
                            $this->addError($attribute, $this->app->t('user', 'Invalid login or password'));
                        }
                    }
                ]
            ]);
        }

        return $rules;
    }

    /**
	 * beforeValidate
	 *
     * @return bool
     **/
    public function beforeValidate(): bool
    {
		$this->result = false;

        if (parent::beforeValidate()) {
            $this->finder = new Finder();
            $this->user = $this->finder->findUserByUsernameOrEmail(trim($this->login));
            $this->result = true;
		}

		return $this->result;
	}

	/**
	 * formName
	 *
     * @return string
     **/
    public function formName(): string
    {
        return 'login-form';
	}

    /**
     * login
     *
     * @return bool whether the user is logged in successfully
     **/
    public function login(): bool
    {
		$this->result = false;

        if ($this->validate() && $this->user) {
            $isLogged = $this->app->user->login($this->user, $this->rememberMe ? $this->module->rememberFor : 0);

            if ($isLogged) {
                $this->user->updateAttributes(['last_login_at' => time()]);
            }
            $this->result = $isLogged;
        }

        return $this->result;
    }

    /**
     * loginList
     *
     * @return array gets all users to generate the dropdown list when in debug mode
     **/
    public static function loginList(): array
    {
        $userModel = $this->module->modelMap['User'];

        return ArrayHelper::map($userModel::find()->where(['blocked_at' => null])->all(), 'username', function ($user) {
            return sprintf('%s (%s)', Html::encode($user->username), Html::encode($user->email));
        });
    }

    /**
	 * validatePassword
	 *
     * validates if the hash of the given password is identical to the saved hash in the database
     * it will always succeed if the module is in DEBUG mode
     *
     * @return void
     **/
    public function validatePassword($attribute, $params): void
    {
        if ($this->user === null || !Password::validate($this->password, $this->user->password_hash)) {
            $this->addError($attribute, $this->app->t('user', 'Invalid login or password'));
        }
    }
}
