<?php

namespace app\user\forms;

use app\user\finder\Finder;
use app\user\helpers\PasswordHelper;
use app\user\traits\ModuleTrait;
use yii\base\Model;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\helpers\Yii;

/**
 * LoginForm
 *
 * LoginForm get user's login and password, validates them and logs the user in. If user has been blocked, it adds
 * an error to login form
 *
 * Dependencies:
 * @property \app\user\Module module
 * @property \yii\web\Application app
 **/
class LoginForm extends Model
{
	use ModuleTrait;

	private $_finder;
	private $_passwordhelper;
	private $_user;

    public $login;
    public $password;
    public $rememberMe = false;

    /**
     * __construct
	 *
     **/
    public function __construct()
    {
		$this->_finder = new Finder();
		$this->_passwordhelper = new PasswordHelper();
		$this->_user = new $this->module->modelMap['User'];
    }

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
                    if ($this->_user !== null) {
                        $confirmationRequired = $this->module->enableConfirmation
							&& !$this->module->enableUnconfirmedLogin;

                        if ($confirmationRequired && !$this->_user->getIsConfirmed()) {
                            $this->addError($attribute, $this->app->t('user', 'You need to confirm your email address'));
						}

                        if ($this->_user->getIsBlocked()) {
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
				['password', 'validatePassword'],
            ]);
        }

        return $rules;
    }

    /**
	 * beforeValidate
	 *
     * @return bool
     **/
    public function beforeValidate(bool $result = false): bool
    {
        if (parent::beforeValidate()) {
            $this->_user = $this->_finder->findUserByUsernameOrEmail(trim($this->login));
            $result = true;
		}

		return $result;
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
    public function login(bool $result = false): bool
    {
        if ($this->validate() && $this->_user) {
            $isLogged = $this->app->user->login($this->_user, $this->rememberMe ? $this->module->rememberFor : 0);

            if ($isLogged) {
                $this->_user->updateAttributes(['last_login_at' => time()]);
			}

            $result = $isLogged;
        }

        return $result;
	}

    /**
     * loginList
     *
     * @return array gets all users to generate the dropdown list when in debug mode
     **/
    public function loginList(): array
    {
		$userModel = $this->_user;

        return ArrayHelper::map($userModel::find()->where(['blocked_at' => null])->all(), 'username', function ($userModel) {
            return sprintf('%s (%s)', Html::encode($userModel->username), Html::encode($userModel->email));
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
        if ($this->_user === null || !$this->_passwordhelper->validate($this->password, $this->_user->password_hash)) {
            $this->addError($attribute, $this->app->t('user', 'Invalid login or password'));
        }
    }
}
