<?php

namespace app\user\models;

use app\user\helpers\PasswordHelper;
use app\user\mailer\Mailer;
use app\user\traits\ModuleTrait;
use yii\activerecord\ActiveRecord;
use yii\activerecord\ActiveQuery;
use yii\base\NotSupportedException;
use yii\behaviors\TimestampBehavior;
use yii\helpers\ArrayHelper;
use yii\helpers\Yii;
use yii\web\Application as WebApplication;
use yii\web\IdentityInterface;

/**
 * UserModel
 *
 * User ActiveRecord model:
 * @property bool    $isAdmin
 * @property bool    $isBlocked
 * @property bool    $isConfirmed
 *
 * Database fields:
 * @property integer $id
 * @property string  $username
 * @property string  $email
 * @property string  $unconfirmed_email
 * @property string  $password_hash
 * @property string  $auth_key
 * @property string  $registration_ip
 * @property integer $confirmed_at
 * @property integer $blocked_at
 * @property integer $created_at
 * @property integer $updated_at
 * @property integer $last_login_at
 * @property integer $flags
 *
 * Defined relations:
 * @property Account[] $accounts
 * @property Profile   $profile
 *
 * Dependencies:
 * @property \app\user\Module module
 * @property \yii\web\Application app
 * @property-read Mailer $mailer
 **/
class UserModel extends ActiveRecord implements IdentityInterface
{
    use ModuleTrait;

    const BEFORE_CREATE   = 'beforeCreate';
    const AFTER_CREATE    = 'afterCreate';
    const BEFORE_REGISTER = 'beforeRegister';
    const AFTER_REGISTER  = 'afterRegister';
    const BEFORE_CONFIRM  = 'beforeConfirm';
    const AFTER_CONFIRM   = 'afterConfirm';

    // following constants are used on secured email changing process
    const OLD_EMAIL_CONFIRMED = 0b1;
	const NEW_EMAIL_CONFIRMED = 0b10;

	protected $tokenQuery;
	protected $userQuery;

	private $_passwordhelper;

	/** @var Profile|null **/
	private $_profile;

    /** @var string plain password. Used for model validation **/
    public $password;

    /** @var string default username regexp **/
    public static $usernameRegexp = '/^[-a-zA-Z0-9_\.@]+$/';

    /**
     * __construct
	 *
     **/
    public function __construct()
    {
		$this->_passwordhelper = new PasswordHelper();
    }

    /**
     * getUserQuery
     *
     * @return \app\user\querys\UserQuery
     *
     * @throws \yii\base\InvalidConfigException
     **/
    protected function getUserQuery()
    {
        return $this->userQuery = $this->module->userQuery;
    }

	/**
     * getTokenQuery
     *
     * @return \app\user\querys\TokenQuery
     *
     * @throws \yii\base\InvalidConfigException
     **/
    protected function getTokenQuery()
    {
        return $this->tokenQuery = $this->module->tokenQuery;
    }

    /**
     * getMailer
     *
     * @return Mailer
     *
     * @throws \yii\base\InvalidConfigException
     **/
    protected function getMailer()
    {
        return Yii::getContainer()->get(Mailer::class);
    }

    /**
     * getIsConfirmed
     *
     * @return bool whether the user is confirmed or not
     **/
    public function getIsConfirmed()
    {
        return $this->confirmed_at != null;
    }

    /**
     * getIsBlocked
     *
     * @return bool whether the user is blocked or not
     **/
    public function getIsBlocked()
    {
        return $this->blocked_at != null;
    }

    /**
     * getIsAdmin
     *
     * @return bool whether the user is an admin or not
     **/
    public function getIsAdmin()
    {
        return true;
            //** */(Yii::getApp()->getAuthManager() && $this->module->adminPermission ?
            //    Yii::getApp()->authManager->checkAccess($this->id, $this->module->adminPermission) : false)
            //|| in_array($this->username, $this->module->admins);
    }

    /**
     * getProfile
     *
     * @return ActiveQuery
     **/
    public function getProfile()
    {
        return $this->hasOne($this->module->modelMap['ProfileModel'], ['user_id' => 'id']);
    }

    /**
     * setProfile
     *
     * @param Profile $profile
     **/
    public function setProfile(Profile $profile)
    {
		$this->_profile = $profile;
    }

    /**
     * getAccounts
     *
     * @return Account[] connected accounts ($provider => $account)
     **/
    public function getAccounts()
    {
        $connected = [];
        $accounts  = $this->hasMany($this->module->modelMap['AccountModel'], ['user_id' => 'id'])->all();

        /** @var Account $account */
        foreach ($accounts as $account) {
            $connected[$account->provider] = $account;
        }

        return $connected;
    }

    /**
     * getAccountByProvider
     *
     * returns connected account by provider
     *
     * @param  string $provider
     *
     * @return null|\app\user\models\AccountModel
     **/
    public function getAccountByProvider($provider)
    {
        $accounts = $this->getAccounts();
        return isset($accounts[$provider])
            ? $accounts[$provider]
            : null;
    }

    /**
     * getId
	 *
     **/
    public function getId()
    {
        return $this->getAttribute('id');
    }

    /**
     * getAuthKey
	 *
     **/
    public function getAuthKey()
    {
        return $this->getAttribute('auth_key');
    }

    /**
     * attributeLabels
	 *
     **/
    public function attributeLabels()
    {
        return [
            'username'          => Yii::t('user', 'Username'),
            'email'             => Yii::t('user', 'Email'),
            'registration_ip'   => Yii::t('user', 'Registration ip'),
            'unconfirmed_email' => Yii::t('user', 'New email'),
            'password'          => Yii::t('user', 'Password'),
            'created_at'        => Yii::t('user', 'Registration time'),
            'last_login_at'     => Yii::t('user', 'Last login'),
            'confirmed_at'      => Yii::t('user', 'Confirmation time'),
        ];
    }

	/**
     * behaviors
     *
	 * @return array behaviors config
	 **/
    public function behaviors(): array
    {
        return [
            TimestampBehavior::class,
        ];
    }

	/**
     * scenarios
     *
	 * @return array scenarios config
	 **/
    public function scenarios(): array
    {
        $scenarios = parent::scenarios();
        return ArrayHelper::merge($scenarios, [
            'register' => ['username', 'email', 'password'],
            'connect'  => ['username', 'email'],
            'create'   => ['username', 'email', 'password'],
            'update'   => ['username', 'email', 'password'],
            'settings' => ['username', 'email', 'password'],
        ]);
    }

    /**
	 * rules
	 *
     * @return array the validation rules
     **/
    public function rules(): array
    {
        return [
            // username rules
            'usernameTrim'     => ['username', 'trim'],
            'usernameRequired' => ['username', 'required', 'on' => ['register', 'create', 'connect', 'update']],
            'usernameMatch'    => ['username', 'match', 'pattern' => static::$usernameRegexp],
            'usernameLength'   => ['username', 'string', 'min' => 3, 'max' => 255],
            'usernameUnique'   => [
                'username',
                'unique',
                'message' => Yii::t('user', 'This username has already been taken')
            ],

            // email rules
            'emailTrim'     => ['email', 'trim'],
            'emailRequired' => ['email', 'required', 'on' => ['register', 'connect', 'create', 'update']],
            'emailPattern'  => ['email', 'email'],
            'emailLength'   => ['email', 'string', 'max' => 255],
            'emailUnique'   => [
                'email',
                'unique',
                'message' => Yii::t('user', 'This email address has already been taken')
            ],

            // password rules
            'passwordRequired' => ['password', 'required', 'on' => ['register']],
            'passwordLength'   => ['password', 'string', 'min' => 6, 'max' => 72, 'on' => ['register', 'create']],
        ];
    }

    /**
     * validateAuthKey
     *
     **/
    public function validateAuthKey($authKey)
    {
        return $this->getAttribute('auth_key') === $authKey;
    }

    /**
     * create
     *
     * creates new user account. If $this->module::enableGeneratingPassword is set true, this method
     * will generate password
     *
     * @return bool
     **/
    public function create()
    {
        if ($this->getIsNewRecord() === false) {
            throw new \RuntimeException('Calling "' . __CLASS__ . '::' . __METHOD__ . '" on existing user');
        }

        $transaction = $this->getDb()->beginTransaction();

        try {
            $this->password = ($this->password === null && $this->module->enableGeneratingPassword) ? $this->_passwordhelper->generate(8) : $this->password;

            $this->trigger(self::BEFORE_CREATE);

            if (!$this->save()) {
                $transaction->rollBack();
                return false;
            }

            $this->confirm();

            $this->mailer->sendWelcomeMessage($this, null, true);
            $this->trigger(self::AFTER_CREATE);

            $transaction->commit();

            return true;
        } catch (\Exception $e) {
            $transaction->rollBack();
            Yii::warning($e->getMessage());
            throw $e;
        }
    }

    /**
     * register
     *
     * this method is used to register new user account. If $this->module::enableConfirmation is set true, this method
     * will generate new confirmation token and use mailer to send it to the user
     *
     * @return bool
     **/
    public function register()
    {
        if ($this->getIsNewRecord() === false) {
            throw new \RuntimeException('Calling "' . __CLASS__ . '::' . __METHOD__ . '" on existing user');
        }

        $transaction = $this->getDb()->beginTransaction();

        try {
            $this->confirmed_at = $this->module->enableConfirmation ? null : time();
            $this->password     = $this->module->enableGeneratingPassword ? $this->_passwordhelper->generate(8) : $this->password;

            $this->trigger(self::BEFORE_REGISTER);

            if (!$this->save()) {
                $transaction->rollBack();
                return false;
            }

            if ($this->module->enableConfirmation) {
                /** @var Token $token */
                $token = Yii::createObject([
                    '__class' => TokenModel::class,
                    'type' => TokenModel::TYPE_CONFIRMATION
                ]);
                $token->link('user', $this);
            }

            $this->mailer->sendWelcomeMessage($this, isset($token) ? $token : null);
            $this->trigger(self::AFTER_REGISTER);

            $transaction->commit();

            return true;
        } catch (\Exception $e) {
            $transaction->rollBack();
            Yii::warning($e->getMessage());
            throw $e;
        }
    }

    /**
     * resendPassword
     *
     * generates a new password and sends it to the user
     *
     * @param string $code Confirmation code
     *
     * @return boolean
     **/
    public function resendPassword()
    {
        $this->password = $this->_passwordhelper->generate(8);
        $this->save(false, ['password_hash']);

        return $this->mailer->sendGeneratedPassword($this, $this->password);
    }

    /**
     * attemptEmailChange
     *
     * this method attempts changing user email. If user's "unconfirmed_email" field is empty is returns false, else if
     * somebody already has email that equals user's "unconfirmed_email" it returns false, otherwise returns true and
     * updates user's password
     *
     * @param string $code
     *
     * @return bool
     * @throws \Exception
     **/
    public function attemptEmailChange($code)
    {
        // TODO refactor method
		$this->getUserquery();
		$this->getTokenQuery();

        /** @var TokenModel $token */
        $token = $this->tokenQuery->findToken([
            'user_id' => $this->id,
            'code'    => $code,
        ])->andWhere(['in', 'type', [TokenModel::TYPE_CONFIRM_NEW_EMAIL, TokenModel::TYPE_CONFIRM_OLD_EMAIL]])->one();

        if (empty($this->unconfirmed_email) || $token === null || $token->isExpired) {
            $this->app->session->setFlash('danger', Yii::t('user', 'Your confirmation token is invalid or expired'));
        } else {
            $token->delete();
            if (empty($this->unconfirmed_email)) {
                $this->app->session->setFlash('danger', Yii::t('user', 'An error occurred processing your request'));
            } elseif ($this->userQuery->findUser(['email' => $this->unconfirmed_email])->exists() === false) {
                if ($this->module->emailChangeStrategy === $this->module::STRATEGY_SECURE) {
                    switch ($token->type) {
                        case TokenModel::TYPE_CONFIRM_NEW_EMAIL:
                            $this->flags |= self::NEW_EMAIL_CONFIRMED;
                            $this->app->session->setFlash(
                                'success',
                                $this->app->t(
                                    'user',
                                    'Awesome, almost there. Now you need to click the confirmation link sent to your old email address'
                                )
                            );
                            break;
                        case TokenModel::TYPE_CONFIRM_OLD_EMAIL:
                            $this->flags |= self::OLD_EMAIL_CONFIRMED;
                            $this->app->session->setFlash(
                                'success',
                                $this->app->t(
                                    'user',
                                    'Awesome, almost there. Now you need to click the confirmation link sent to your new email address'
                                )
                            );
                            break;
                    }
                }

                if ($this->module->emailChangeStrategy === $this->module::STRATEGY_DEFAULT
                    || ($this->flags & self::NEW_EMAIL_CONFIRMED && $this->flags & self::OLD_EMAIL_CONFIRMED)) {
                    $this->email = $this->unconfirmed_email;
                    $this->unconfirmed_email = null;
                    $this->app->session->setFlash('success', $this->app->t('user', 'Your email address has been changed'));
                }
                $this->save(false);
            }
        }
    }

    /**
     * confirm
     *
     * confirms the user by setting 'confirmed_at' field to current time
     **/
    public function confirm()
    {
        $this->trigger(self::BEFORE_CONFIRM);
		$result = (bool) $this->updateAttributes(['confirmed_at' => time()]);
        $this->trigger(self::AFTER_CONFIRM);

        return $result;
    }

    /**
     * resetPassword
     *
     * @param string $password
     *
     * @return bool
     **/
    public function resetPassword($password): bool
    {
        return (bool) $this->updateAttributes(['password_hash' => $this->_passwordhelper->hash($password)]);
    }

    /**
     * block
     *
     * blocks the user by setting 'blocked_at' field to current time and regenerates auth_key
     *
     * @return bool
     **/
    public function block(): bool
    {
        return (bool) $this->updateAttributes([
            'blocked_at' => time(),
            'auth_key'   => $this->app->security->generateRandomString(),
        ]);
    }

    /**
     * unblock
     *
     * unBlocks the user by setting 'blocked_at' field to null
     *
     * @return bool
     **/
    public function unblock(): bool
    {
        return (bool) $this->updateAttributes(['blocked_at' => null]);
    }

    /**
     * generateUsername
     *
     * generates new username based on email address, or creates new username
     * like "emailuser1"
     **/
    public function generateUsername()
    {
        // try to use name part of email
        $username = explode('@', $this->email)[0];
        $this->username = $username;
        if ($this->validate(['username'])) {

            return $this->username;
        }

        // valid email addresses are less restricitve than our
        // valid username regexp so fallback to 'user123' if needed:
        if (!preg_match(self::$usernameRegexp, $username)) {
            $username = 'user';
        }

        $this->username = $username;

        $max = $this->userQuery->max('id');

        // generate username like "user1", "user2", etc...
        do {
            $this->username = $username . ++$max;
        } while (!$this->validate(['username']));

        return $this->username;
    }

    /**
     * beforeSave
	 *
     **/
    public function beforeSave($insert)
    {
        if ($insert) {
            $this->setAttribute('auth_key', $this->app->security->generateRandomString());
            if ($this->app instanceof WebApplication) {
                $this->setAttribute('registration_ip', $this->app->request->userIP);
            }
        }

        if (!empty($this->password)) {
            $this->setAttribute('password_hash', $this->_passwordhelper->hash($this->password));
        }

        return parent::beforeSave($insert);
    }

    /**
     * afterSave
	 *
     **/
    public function afterSave($insert, $changedAttributes)
    {
        parent::afterSave($insert, $changedAttributes);
        if ($insert) {
            if ($this->_profile === null) {
                $this->_profile = Yii::createObject([
                    '__class' => $this->module->modelMap['ProfileModel']
                ]);
            }
            $this->_profile->link('user', $this);
        }
    }

    /**
     * tableName
	 *
     **/
    public static function tableName()
    {
        return '{{%user}}';
    }

    /**
     * findIdentity
	 *
     **/
    public static function findIdentity($id)
    {
        return static::findOne($id);
    }

    /**
     * findIdentityByAccessToken
	 *
     **/
    public static function findIdentityByAccessToken($token, $type = null)
    {
        throw new NotSupportedException('Method "' . __CLASS__ . '::' . __METHOD__ . '" is not implemented.');
    }
}
