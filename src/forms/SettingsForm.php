<?php

namespace app\user\forms;

use app\user\Module;
use app\user\mailer\Mailer;
use app\user\helpers\PasswordHelper;
use app\user\traits\ModuleTrait;
use yii\base\Model;

/**
 * SettingsForm gets user's username, email and password and changes them.
 *
 **/
class SettingsForm extends Model
{
    use ModuleTrait;

	private $_mailer;
	private $_passwordhelper;
	private $_user;

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
		$this->_mailer = new Mailer();
		$this->_passwordhelper = new PasswordHelper();
        $this->setAttributes([
            'username' => $this->user->username,
            'email'    => $this->user->unconfirmed_email ?: $this->user->email,
		], false);
    }

    /**
	 * rules
	 *
     * @return array the validation rules.
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
                return $this->_user->$attribute != $model->$attribute;
            }, 'targetClass' => $this->module->modelMap['User']],
            'newPasswordLength' => ['new_password', 'string', 'max' => 72, 'min' => 6],
            'currentPasswordRequired' => ['current_password', 'required'],
            'currentPasswordValidate' => ['current_password', function ($attr) {
                if (!$this->_passwordhelper->validate($this->$attr, $this->_user->password_hash)) {
                    $this->addError($attr, $this->app->t('user', 'Current password is not valid'));
                }
            }],
        ];
	}

    /**
	 * defaultEmailChange
	 *
     * Sends a confirmation message to user's email address with link to confirm changing of email.
     **/
    protected function defaultEmailChange(): void
    {
        $this->_user->unconfirmed_email = $this->email;
		$token = new Token();
		$token->user_id = $this->user->id;
		$token->type = $token::TYPE_CONFIRM_NEW_EMAIL;
        $token->save(false);

		$this->mailer->sendReconfirmationMessage($this->user, $token);

		$this->app->session->setFlash(
            'info',
            $this->app->t('user', 'A confirmation message has been sent to your new email address')
        );
    }

	/**
	 * formName
	 *
     * @return string.
     **/
    public function formName()
    {
        return 'settings-form';
	}

	/**
     * getUser
     * Finds user by [[username]].
     *
	 * @return User|null|true
	 **/
    public function getUser()
    {
        if ($this->_user == null) {
            $this->_user = $this->app->user->identity;
        }

        return $this->_user;
    }

	/**
	 * insecureEmailChange
	 *
     * changes user's email address to given without any confirmation.
     **/
    protected function insecureEmailChange(): void
    {
        $this->user->email = $this->email;
        $this->module->session->setFlash('success', $this->app->t('user', 'Your email address has been changed'));
    }

    /**
	 * save
	 *
     * saves new account settings.
     *
     * @return bool
     **/
    public function save(): bool
    {
        if ($this->validate()) {
            $this->user->scenario = 'settings';
            $this->user->username = $this->username;
            $this->user->password = $this->new_password;
            if ($this->email == $this->user->email && $this->user->unconfirmed_email != null) {
                $this->user->unconfirmed_email = null;
            } elseif ($this->email != $this->user->email) {
                switch ($this->module->emailChangeStrategy) {
                    case Module::STRATEGY_INSECURE:
                        $this->insecureEmailChange();
                        break;
                    case Module::STRATEGY_DEFAULT:
                        $this->defaultEmailChange();
                        break;
                    case Module::STRATEGY_SECURE:
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
	 * sends a confirmation message to both old and new email addresses with link to confirm changing of email.
     *
     * @throws yii\exceptions\InvalidConfigException
     **/
    protected function secureEmailChange()
    {
        $this->defaultEmailChange();

		$token = new Token();
		$token->user_id = $this->user->id;
		$token->type = $token::TYPE_CONFIRM_OLD_EMAIL;
		$token->save(false);

        $this->mailer->sendReconfirmationMessage($this->user, $token);

        // unset flags if they exist
        $this->user->flags &= ~User::NEW_EMAIL_CONFIRMED;
        $this->user->flags &= ~User::OLD_EMAIL_CONFIRMED;
        $this->user->save(false);

        $this->app->session->setFlash(
            'info',
            $this->app->t(
                'user',
                'We have sent confirmation links to both old and new email addresses. You must click both links to complete your request'
            )
        );
    }
}
