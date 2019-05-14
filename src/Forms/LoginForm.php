<?php

namespace TerabyteSoft\Module\User\Forms;

use TerabyteSoft\Module\User\Helpers\PasswordHelper;
use TerabyteSoft\Module\User\Traits\ModuleTrait;
use yii\base\Model;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;

/**
 * LoginForm
 *
 * LoginForm get user's login and password, validates them and logs the user in. If user has been blocked, it adds
 * an error to login form
 *
 * Dependencies:
 * @property \TerabyteSoft\Module\User\Module module
 * @property \yii\web\Application app
 **/
class LoginForm extends Model
{
	use ModuleTrait;

	protected $passwordHelper;
	protected $user;
	protected $userQuery;

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
                        $confirmationRequired = $this->module->accountConfirmation
							&& !$this->module->accountUnconfirmedLogin;

                        if ($confirmationRequired && !$this->user->getIsConfirmed()) {
                            $this->addError($attribute, $this->app->t('ModuleUser', 'You need to confirm your email address'));
						}

                        if ($this->user->getIsBlocked()) {
                            $this->addError($attribute, $this->app->t('ModuleUser', 'Your account has been blocked'));
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
			$this->userQuery = $this->module->userQuery;
            $this->user = $this->userQuery->findUserByUsernameOrEmail(trim($this->login));
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
     * @return \app\user\models\UserModel
     */
    public function getUser()
    {
        return $this->user;
	}

    /**
     * login
     *
     * @return bool whether the user is logged in successfully
     **/
    public function login(bool $result = false): bool
    {
        if ($this->validate() && $this->user) {
            $isLogged = $this->app->user->login($this->user, $this->rememberMe ? $this->module->rememberFor : 0);
            if ($isLogged) {
                $this->user->updateAttributes(['last_login_at' => time()]);
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
		$userModel = $this->module->userModel;

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
		$this->passwordHelper = new PasswordHelper();
        if ($this->user === null || !$this->passwordHelper->validate($this->password, $this->user->password_hash)) {
            $this->addError($attribute, $this->app->t('ModuleUser', 'Invalid login or password.'));
        }
    }
}
