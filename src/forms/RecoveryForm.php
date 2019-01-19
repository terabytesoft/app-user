<?php

namespace app\user\forms;

use app\user\finder\Finder;
use app\user\mailer\Mailer;
use app\user\models\Token;
use app\user\models\User;
use app\user\traits\ModuleTrait;
use yii\base\Model;

/**
 * Model for collecting data on password recovery.
 *
 * @property self $app
 **/
class RecoveryForm extends Model
{
	use ModuleTrait;

    const SCENARIO_REQUEST = self::SCENARIO_DEFAULT;
    const SCENARIO_RESET = 'reset';

	protected $finder;
    protected $mailer;
    protected $result;

    public $email;
    public $password;

    /**
	 * scenarios
	 *
     * @return array scenarios validation.
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
     * @return array the validation rules.
     **/
    public function rules(): array
    {
        return [
            'emailTrim' => ['email', 'trim'],
            'emailRequired' => ['email', 'required'],
            'emailPattern' => ['email', 'email'],
			['email', 'exist',
				'targetClass' => User::class,
				'message' => $this->app->t('user', 'There is no user with this email address.'),
            ],
            'passwordRequired' => ['password', 'required'],
            'passwordLength' => ['password', 'string', 'max' => 72, 'min' => 6],
        ];
    }

	/**
	 * formName
	 *
     * @return string.
     **/
    public function formName(): string
    {
        return 'recovery-form';
    }

    /**
     * sendRecoveryMessage
     *
     * @return bool sends recovery message.
     **/
    public function sendRecoveryMessage()
    {
		$this->finder = new Finder();
		$this->mailer = new Mailer();
        $this->result = true;

        $user = $this->finder->findUserByEmail($this->email);

        if ($user instanceof User) {
            $token = new Token();
            $token->user_id = $user->id;
            $token->type = Token::TYPE_RECOVERY;

            if (!$token->save(false)) {
                $this->result = false;
            }

            if (!$this->mailer->sendRecoveryMessage($user, $token)) {
                $this->result = false;
            }
        }

        return $this->result;
    }
}
