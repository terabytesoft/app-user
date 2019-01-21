<?php

namespace app\user\forms;

use app\user\finder\Finder;
use app\user\mailer\Mailer;
use app\user\models\UserModel;
use app\user\traits\ModuleTrait;
use yii\base\Model;

/**
 * RecoveryForm
 *
 * Model for collecting data on password recovery
 *
 * Dependencies:
 * @property \app\user\Module module
 * @property \yii\web\Application app
 **/
class RecoveryForm extends Model
{
	use ModuleTrait;

    const SCENARIO_REQUEST = self::SCENARIO_DEFAULT;
    const SCENARIO_RESET = 'reset';

	private $_finder;
	private $_mailer;
	private $_user;

    public $email;
    public $password;

	/**
     * __construct
	 *
     **/
    public function __construct()
    {
		$this->_finder = new Finder();
		$this->_mailer = new Mailer();
		$this->_user = new $this->module->modelMap['User'];
    }

    /**
	 * scenarios
	 *
     * @return array scenarios validation
     **/
    public function scenarios(): array
    {
        return [
            self::SCENARIO_REQUEST => ['email'],
            self::SCENARIO_RESET => ['password'],
        ];
    }

    /**
	 * rules
	 *
     * @return array the validation rules
     **/
    public function rules(): array
    {
        return [
            'emailTrim' => ['email', 'trim'],
            'emailRequired' => ['email', 'required'],
            'emailPattern' => ['email', 'email'],
			['email', 'exist',
				'targetClass' => $this->_user,
				'message' => $this->app->t('user', 'There is no user with this email address.'),
            ],
            'passwordRequired' => ['password', 'required'],
            'passwordLength' => ['password', 'string', 'max' => 72, 'min' => 6],
        ];
    }

	/**
	 * formName
	 *
     * @return string
     **/
    public function formName(): string
    {
        return 'recovery-form';
    }

    /**
     * sendRecoveryMessage
     *
     * @return bool sends recovery message
     **/
    public function sendRecoveryMessage(bool $result = false): bool
    {
        $this->_user = $this->_finder->findUserByEmail($this->email);

        if ($this->_user instanceof UserModel) {
            $token = new $this->module->modelMap['Token'];
            $token->user_id = $this->_user->id;
            $token->type = $token::TYPE_RECOVERY;

            if (!$token->save(false)) {
                $result = false;
            }

            if (!$this->_mailer->sendRecoveryMessage($this->_user, $token)) {
                $result = false;
			}

			$result = true;
        }

        return $result;
    }
}
