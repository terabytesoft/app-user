<?php

namespace TerabyteSoft\Module\User\Forms;

use TerabyteSoft\Module\User\Mailer\Mailer;
use TerabyteSoft\Module\User\Models\UserModel;
use TerabyteSoft\Module\User\Traits\ModuleTrait;
use yii\base\Model;

/**
 * ResendForm
 *
 * ResendForm gets user email address and if user with given email is registered it sends new confirmation message
 * to him in case he did not validate his email
 *
 * Dependencies:
 * @property \TerabyteSoft\Module\User\Module module
 * @property \yii\web\Application app
 **/
class ResendForm extends Model
{
	use ModuleTrait;

	protected $mailer;
	protected $tokenModel;
	protected $userModel;
	protected $userQuery;

    public $email;

	/**
	 * rules
	 *
     * @return array the validation rules
     **/
    public function rules(): array
    {
		$this->userModel = $this->module->userModel;

        return [
            'emailRequired' => ['email', 'required'],
            'emailPattern' => ['email', 'email'],
            'emailPattern'  => ['email', 'email'],
			['email', 'exist',
				'targetClass' => $this->userModel,
				'message' => $this->app->t('ModuleUser', 'There is no user with this email address.'),
            ],
        ];
    }

	/**
	 * formName
	 *
     * @return string
     **/
    public function formName(): string
    {
        return 'resend-form';
    }

    /**
	 * resend
	 *
     * creates new confirmation token and sends it to the user
     *
     * @return bool
     **/
    public function resend(bool $result = false): bool
    {
		$this->mailer = new Mailer();
		$this->tokenModel = $this->module->tokenModel;
		$this->userQuery = $this->module->userQuery;
		$this->userModel = $this->userQuery->findUserByEmail($this->email);

        if ($this->userModel instanceof UserModel && !$this->userModel->isConfirmed) {
            $token = $this->tokenModel;
            $token->user_id = $this->userModel->id;
            $token->type = $token::TYPE_CONFIRMATION;
            $token->save(false);
            $this->mailer->sendConfirmationMessage($this->userModel, $token);
            $result = true;
        }

        return $result;
    }
}
