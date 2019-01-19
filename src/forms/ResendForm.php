<?php

namespace app\user\forms;

use app\user\finder\Finder;
use app\user\mailer\Mailer;
use app\user\models\Token;
use app\user\models\User;
use app\user\traits\ModuleTrait;
use yii\base\Model;

/**
 * ResendForm gets user email address and if user with given email is registered it sends new confirmation message
 * to him in case he did not validate his email.
 *
 * @property self $app
 **/
class ResendForm extends Model
{
	use ModuleTrait;

    public $email;

    protected $finder;
    protected $mailer;
    protected $result;

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
				'targetClass' => User::class,
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
     * creates new confirmation token and sends it to the user.
     *
     * @return bool
     **/
    public function resend(): bool
    {
		$this->finder = new Finder();
		$this->mailer = new Mailer();
		$this->result = false;

        $user = $this->finder->findUserByEmail($this->email);

        if ($user instanceof User && !$user->isConfirmed) {
            $token = new Token();
            $token->user_id = $user->id;
            $token->type = Token::TYPE_CONFIRMATION;
            $token->save(false);

            $this->mailer->sendConfirmationMessage($user, $token);

            $this->result = true;
        }

        return $this->result;
    }
}
