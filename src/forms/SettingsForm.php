<?php

namespace TerabyteSoft\Module\User\Forms;

use TerabyteSoft\Module\User\Mailer\Mailer;
use TerabyteSoft\Module\User\Helpers\PasswordHelper;
use TerabyteSoft\Module\User\Traits\ModuleTrait;
use yii\base\Model;

/**
 * SettingsForm
 *
 * SettingsForm gets user's username, email and password and changes them
 *
 * Defined relations:
 * @property \TerabyteSoft\Module\User\Models\UserModels $user
 *
 * Dependencies:
 * @property \TerabyteSoft\Module\User\Module module
 * @property \yii\web\Application app
 **/
class SettingsForm extends Model
{
    use ModuleTrait;

	protected $mailer;
	protected $passwordhelper;
	protected $tokenModel;
	protected $userModel;

    public $email;
    public $username;
    public $new_password;
    public $current_password;

	/**
     * __construct
	 *
	 **/
    public function __construct()
    {
		$this->setAttributes([
            'username' => $this->user->username,
            'email'    => $this->user->unconfirmed_email ?: $this->user->email,
		], false);

		$this->mailer = new Mailer();
		$this->passwordhelper = new PasswordHelper();
		$this->tokenModel = $this->module->tokenModel;
    }

    /**
	 * rules
	 *
     * @return array the validation rules
     **/
    public function rules(): array
    {
        return [
            'usernameTrim' => ['username', 'trim'],
            'usernameRequired' => ['username', 'required'],
            'usernameLength'   => ['username', 'string', 'min' => 3, 'max' => 255],
            'usernamePattern' => ['username', 'match', 'pattern' => '/^[-a-zA-Z0-9_\.@]+$/'],
            'emailTrim' => ['email', 'trim'],
            'emailRequired' => ['email', 'required'],
            'emailPattern' => ['email', 'email'],
            'emailUsernameUnique' => [['email', 'username'], 'unique', 'when' => function ($model, $attribute) {
                return $this->userModel->$attribute != $model->$attribute;
            }, 'targetClass' => $this->userModel],
            'newPasswordLength' => ['new_password', 'string', 'max' => 72, 'min' => 6],
            'currentPasswordRequired' => ['current_password', 'required'],
            'currentPasswordValidate' => ['current_password', function ($attr) {
                if (!$this->passwordhelper->validate($this->$attr, $this->userModel->password_hash)) {
                    $this->addError($attr, $this->app->t('user', 'Current password is not valid'));
                }
            }],
        ];
	}

    /**
	 * defaultEmailChange
	 *
     * sends a confirmation message to user's email address with link to confirm changing of email
     *
     * @return void
     **/
    protected function defaultEmailChange(): void
    {
        $this->userModel->unconfirmed_email = $this->email;
		$token = $this->tokenModel;
		$token->user_id = $this->userModel->id;
		$token->type = $token::TYPE_CONFIRM_NEW_EMAIL;
        $token->save(false);

		$this->mailer->sendReconfirmationMessage($this->userModel, $token);

		$this->app->session->setFlash(
            'info',
            $this->app->t('user', 'A confirmation message has been sent to your new email address')
        );
    }

	/**
	 * formName
	 *
     * @return string
     **/
    public function formName(): string
    {
        return 'settings-form';
	}

	/**
     * getUser
     *
     * finds user by [[username]]
     *
	 * @return \TerabyteSoft\Module\User\Models\UserModel|null|true
	 **/
    public function getUser()
    {
        if ($this->userModel === null) {
            $this->userModel = $this->app->user->identity;
        }

        return $this->userModel;
    }

	/**
	 * insecureEmailChange
	 *
     * changes user's email address to given without any confirmation
     *
     * @return void
     **/
    protected function insecureEmailChange(): void
    {
        $this->userModel->email = $this->email;
        $this->app->session->setFlash('success', $this->app->t('user', 'Your email address has been changed'));
    }

    /**
	 * save
	 *
     * saves new account settings
     *
     * @return bool
     **/
    public function save(): bool
    {
        if ($this->validate()) {
            $this->userModel->scenario = 'settings';
            $this->userModel->username = $this->username;
            $this->userModel->password = $this->new_password;
            if ($this->email == $this->userModel->email && $this->userModel->unconfirmed_email != null) {
                $this->userModel->unconfirmed_email = null;
            } elseif ($this->email != $this->userModel->email) {
                switch ($this->module->emailChangeStrategy) {
                    case $this->module::STRATEGY_INSECURE:
                        $this->insecureEmailChange();
                        break;
                    case $this->module::STRATEGY_DEFAULT:
                        $this->defaultEmailChange();
                        break;
                    case $this->module::STRATEGY_SECURE:
                        $this->secureEmailChange();
                        break;
                    default:
                        throw new \OutOfBoundsException('Invalid email changing strategy');
                }
            }

            return $this->user->save();
        }

        return false;
    }

    /**
     * secureEmailChange
	 *
	 * sends a confirmation message to both old and new email addresses with link to confirm changing of email
     *
     * @throws \yii\exceptions\InvalidConfigException
     *
     * @return void
     **/
    protected function secureEmailChange(): void
    {
        $this->defaultEmailChange();

		$token = $this->tokenModel;
		$token->user_id = $this->userModel->id;
		$token->type = $token::TYPE_CONFIRM_OLD_EMAIL;
		$token->save(false);

        $this->mailer->sendReconfirmationMessage($this->userModel, $token);

        // unset flags if they exist
        $this->userModel->flags &= ~User::NEW_EMAIL_CONFIRMED;
        $this->userModel->flags &= ~User::OLD_EMAIL_CONFIRMED;
        $this->userModel->save(false);

        $this->app->session->setFlash(
            'info',
            $this->app->t(
                'user',
                'We have sent confirmation links to both old and new email addresses. You must click both links to complete your request'
            )
        );
    }
}
