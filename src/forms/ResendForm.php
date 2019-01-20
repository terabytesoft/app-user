<?php

namespace app\user\forms;

use app\user\finder\Finder;
use app\user\mailer\Mailer;
use app\user\models\TokenModel;
use app\user\models\UserModel;
use app\user\traits\ModuleTrait;
use yii\base\Model;

/**
 * ResendForm
 *
 * ResendForm gets user email address and if user with given email is registered it sends new confirmation message
 * to him in case he did not validate his email.
 *
 **/
class ResendForm extends Model
{
	use ModuleTrait;

	private $_finder;
	private $_mailer;
	private $_user;

    public $email;

	/**
     * __construct
	 *
     */
    public function __construct()
    {
		$this->_finder = new Finder();
		$this->_mailer = new Mailer();
    }

	/**
	 * rules
	 *
     * @return array the validation rules.
     **/
    public function rules(): array
    {
        return [
            'emailRequired' => ['email', 'required'],
            'emailPattern' => ['email', 'email'],
            'emailPattern'  => ['email', 'email'],
			['email', 'exist',
				'targetClass' => UserModel::class,
				'message' => $this->app->t('user', 'There is no user with this email address.'),
            ],
        ];
    }

	/**
	 * formName
	 *
     * @return string.
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
        $this->_user = $this->_finder->findUserByEmail($this->email);

        if ($this->_user instanceof UserModel && !$this->_user->isConfirmed) {
            $token = new TokenModel();
            $token->user_id = $this->_user->id;
            $token->type = TokenModel::TYPE_CONFIRMATION;
            $token->save(false);
            $this->_mailer->sendConfirmationMessage($this->_user, $token);
            $result = true;
        }

        return $result;
    }
}
