<?php

namespace app\user\forms;

use app\user\models\UserModel;
use app\user\traits\ModuleTrait;
use yii\base\Model;

/**
 * RegistrationForm
 *
 * Registration form collects user input on registration process, validates it and creates new User model.
 *
 **/
class RegistrationForm extends Model
{
    use ModuleTrait;

	private $_user;

    public $email;
    public $password;
	public $username;

    /**
     * __construct
	 *
     */
    public function __construct()
    {
		$this->_user = new $this->module->modelMap['User'];
    }

    /**
	 * rules
	 *
     * @return array the validation rules.
     **/
    public function rules(): array
    {
        return [
            // username rules
            'usernameTrim'     => ['username', 'trim'],
            'usernameLength'   => ['username', 'string', 'min' => 3, 'max' => 255],
            'usernamePattern'  => ['username', 'match', 'pattern' => $this->_user::$usernameRegexp],
            'usernameRequired' => ['username', 'required'],
            'usernameUnique'   => [
                'username',
                'unique',
                'targetClass' => $this->_user,
                'message' => $this->app->t('user', 'This username has already been taken')
            ],
            // email rules
            'emailTrim'     => ['email', 'trim'],
            'emailRequired' => ['email', 'required'],
            'emailPattern'  => ['email', 'email'],
            'emailUnique'   => [
                'email',
                'unique',
                'targetClass' => $this->_user,
                'message' => $this->app->t('user', 'This email address has already been taken')
            ],
            // password rules
            'passwordRequired' => ['password', 'required', 'skipOnEmpty' => $this->module->enableGeneratingPassword],
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
     * registers a new user account. If registration was successful it will set flash message.
     * @params Model $model
     *
     * @return bool.
     **/
    public function register(bool $result = true): bool
    {
        $this->_user->setScenario('register');

        $this->loadAttributes($this->_user);

        if (!$this->_user->register()) {
            $result = false;
        }

        return $result;
    }

    /**
	 * loadAttributes
	 *
     * loads attributes to the user model. You should override this method if you are going to add new fields to the
     * registration form. You can read more in special guide.
     *
     * by default this method set all attributes of this model to the attributes of User model, so you should properly
     * configure safe attributes of your User model.
     *
     * @param UserModel $user
     **/
    protected function loadAttributes(UserModel $_user): void
    {
        $this->_user->setAttributes($this->attributes);
    }
}
