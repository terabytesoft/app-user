<?php

namespace TerabyteSoft\Module\User\Forms;

use TerabyteSoft\Module\User\Mailer\Mailer;
use TerabyteSoft\Module\User\Models\UserModel;
use TerabyteSoft\Module\User\Traits\ModuleTrait;
use yii\base\Model;

/**
 * RecoveryForm
 *
 * Model for collecting data on password recovery
 *
 * Dependencies:
 * @property \TerabyteSoft\Module\User\Module module
 * @property \yii\web\Application app
 **/
class RecoveryForm extends Model
{
	use ModuleTrait;

    const SCENARIO_REQUEST = self::SCENARIO_DEFAULT;
    const SCENARIO_RESET = 'reset';

	protected $mailer;
	protected $userModel;
	protected $userQuery;
	protected $tokenModel;

    public $email;
    public $password;

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
		$this->userModel = $this->module->userModel;

        return [
            'emailTrim' => ['email', 'trim'],
            'emailRequired' => ['email', 'required'],
            'emailPattern' => ['email', 'email'],
			['email', 'exist',
				'targetClass' => $this->userModel,
				'message' => $this->app->t('ModuleUser', 'There is no user with this email address.'),
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
		$this->mailer = new Mailer();
		$this->tokenModel = $this->module->tokenModel;
		$this->userQuery = $this->module->userQuery;
        $this->userModel = $this->userQuery->findUserByEmail($this->email);

        if ($this->userModel instanceof UserModel) {
            $token = new $this->tokenModel;
            $token->user_id = $this->userModel->id;
            $token->type = $token::TYPE_RECOVERY;

            if (!$token->save(false)) {
                $result = false;
            }

            if (!$this->mailer->sendRecoveryMessage($this->userModel, $token)) {
                $result = false;
			}

			$result = true;
        }

        return $result;
    }
}
