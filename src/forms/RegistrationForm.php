<?php

namespace app\user\forms;

use app\user\models\User;
use app\user\traits\ModuleTrait;
use yii\base\Model;

/**
 * Registration form collects user input on registration process, validates it and creates new User model.
 *
 * @property self $app
 **/
class RegistrationForm extends Model
{
    use ModuleTrait;

    public $email;
    public $password;
	public $username;

    protected $result;

    /**
	 * rules
	 *
     * @return array the validation rules.
     **/
    public function rules(): array
    {
        $user = $this->module->modelMap['User'];

        return [
            // username rules
            'usernameTrim'     => ['username', 'trim'],
            'usernameLength'   => ['username', 'string', 'min' => 3, 'max' => 255],
            'usernamePattern'  => ['username', 'match', 'pattern' => $user::$usernameRegexp],
            'usernameRequired' => ['username', 'required'],
            'usernameUnique'   => [
                'username',
                'unique',
                'targetClass' => $user,
                'message' => $this->app->t('user', 'This username has already been taken')
            ],
            // email rules
            'emailTrim'     => ['email', 'trim'],
            'emailRequired' => ['email', 'required'],
            'emailPattern'  => ['email', 'email'],
            'emailUnique'   => [
                'email',
                'unique',
                'targetClass' => $user,
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
     * @return string.
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
    public function register(): bool
    {
        $this->result = true;

        $user =new User();
        $user->setScenario('register');

        $this->loadAttributes($user);

        if (!$user->register()) {
            $this->result = false;
        }

        return $this->result;
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
     * @param User $user
     **/
    protected function loadAttributes(User $user): void
    {
        $user->setAttributes($this->attributes);
    }
}
