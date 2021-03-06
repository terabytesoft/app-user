<?php

namespace TerabyteSoft\Module\User\Forms;

use TerabyteSoft\Module\User\Traits\ModuleTrait;
use yii\base\Model;

/**
 * RegistrationForm
 *
 * Registration form collects user input on registration process, validates it and creates new User model
 *
 * Dependencies:
 * @property \TerabyteSoft\Module\User\Module module
 * @property \yii\web\Application app
 **/
class RegistrationForm extends Model
{
    use ModuleTrait;

	protected $userModel;

    public $email;
    public $password;
	public $username;

    /**
	 * rules
	 *
     * @return array the validation rules
     **/
    public function rules(): array
    {
		$this->userModel = $this->module->userModel;

        return [
            // username rules
            'usernameTrim'     => ['username', 'trim'],
            'usernameLength'   => ['username', 'string', 'min' => 3, 'max' => 255],
            'usernamePattern'  => ['username', 'match', 'pattern' => $this->userModel::$usernameRegexp],
            'usernameRequired' => ['username', 'required'],
            'usernameUnique'   => [
                'username',
                'unique',
                'targetClass' => $this->userModel,
                'message' => $this->app->t('ModuleUser', 'This username has already been taken.')
            ],
            // email rules
            'emailTrim'     => ['email', 'trim'],
            'emailRequired' => ['email', 'required'],
            'emailPattern'  => ['email', 'email'],
            'emailUnique'   => [
                'email',
                'unique',
                'targetClass' => $this->userModel,
                'message' => $this->app->t('ModuleUser', 'This email address has already been taken.')
            ],
            // password rules
            'passwordRequired' => ['password', 'required', 'skipOnEmpty' => $this->module->accountGeneratingPassword],
            'passwordLength'   => ['password', 'string', 'min' => 6, 'max' => 72],
        ];
    }

	/**
	 * formName
	 *
     * @return string
     **/
    public function formName(): string
    {
        return 'register-form';
    }

    /**
	 * register
	 *
     * registers a new user account. If registration was successful it will set flash message
     * @params Model $model
     *
     * @return bool
     **/
    public function register(bool $result = true): bool
    {
        $this->userModel->setScenario('register');

        $this->loadAttributes();

        if (!$this->userModel->register()) {
            $result = false;
        }

        return $result;
    }

    /**
	 * loadAttributes
	 *
     * loads attributes to the user model. You should override this method if you are going to add new fields to the
     * registration form. You can read more in special guide
     *
     * by default this method set all attributes of this model to the attributes of User model, so you should properly
     * configure safe attributes of your User model
     *
     **/
    protected function loadAttributes(): void
    {
        $this->userModel->setAttributes($this->attributes);
    }
}
