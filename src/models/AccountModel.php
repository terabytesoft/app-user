<?php

namespace app\user\models;

use app\user\clients\ClientInterface;
use app\user\finder\Finder;
use app\user\models\query\AccountQuery;
use app\user\traits\ModuleTrait;
use yii\activerecord\ActiveRecord;
use yii\authclient\ClientInterface as BaseClientInterface;
use yii\helpers\Json;
use yii\helpers\Url;
use yii\helpers\Yii;

/**
 * @property integer $id          Id
 * @property integer $user_id     User id, null if account is not bind to user
 * @property string  $provider    Name of service
 * @property string  $client_id   Account id
 * @property string  $data        Account properties returned by social network (json encoded)
 * @property string  $decodedData Json-decoded properties
 * @property string  $code
 * @property integer $created_at
 * @property string  $email
 * @property string  $username
 *
 * @property User    $user        User that this account is connected for.
 *
 */
class AccountModel extends ActiveRecord
{
    use ModuleTrait;

    /** @var Finder */
    protected static $finder;

    /** @var */
    private $_data;

    /** @inheritdoc */
    public static function tableName()
    {
        return '{{%social_account}}';
    }

    /**
     * @return User
     */
    public function getUser()
    {
        return $this->hasOne($this->module->modelMap['User'], ['id' => 'user_id']);
    }

    /**
     * @return bool Whether this social account is connected to user.
     */
    public function getIsConnected()
    {
        return $this->user_id != null;
    }

    /**
     * @return mixed Json decoded properties.
     */
    public function getDecodedData()
    {
        if ($this->_data == null) {
            $this->_data = Json::decode($this->data);
        }

        return $this->_data;
    }

    /**
     * Returns connect url.
     * @return string
     */
    public function getConnectUrl()
    {
        $code = $this->module->getApp()->security->generateRandomString();
        $this->updateAttributes(['code' => md5($code)]);

        return Url::to(['/user/registration/connect', 'code' => $code]);
    }

    public function connect(User $user)
    {
        return $this->updateAttributes([
            'username' => null,
            'email'    => null,
            'code'     => null,
            'user_id'  => $user->id,
        ]);
    }

    /**
     * @return AccountQuery
     */
    public static function find()
    {
        return Yii::createObject(AccountQuery::class, [get_called_class()]);
    }

    public static function create(BaseClientInterface $client)
    {
		/** @var Account $account */
        $account = Yii::createObject([
            '__class'      => static::class,
            'provider'   => $client->getId(),
            'client_id'  => $client->getUserAttributes()['id'],
            'data'       => Json::encode($client->getUserAttributes()),
        ]);

        if ($client instanceof ClientInterface) {
            $account->setAttributes([
                'username' => $client->getUsername(),
                'email'    => $client->getEmail(),
            ], false);
        }

        if (($user = static::fetchUser($account)) instanceof User) {
            $account->user_id = $user->id;
        }

        $account->save(false);

        return $account;
    }

    /**
     * Tries to find an account and then connect that account with current user.
     *
     * @param BaseClientInterface $client
     */
    public static function connectWithUser(BaseClientInterface $client)
    {
        if ($this->module->getApp()->user->isGuest) {
            $this->module->getApp()->session->setFlash('danger', $this->module->getApp()->t('user', 'Something went wrong'));

            return;
        }

        $account = static::fetchAccount($client);

        if ($account->user === null) {
            $account->link('user', $this->module->getApp()->user->identity);
            $this->module->getApp()->session->setFlash('success', $this->module->getApp()->t('user', 'Your account has been connected'));
        } else {
            $this->module->getApp()->session->setFlash(
                'danger',
                $this->module->getApp()->t('user', 'This account has already been connected to another user')
            );
        }
    }

    /**
     * Tries to find account, otherwise creates new account.
     *
     * @param BaseClientInterface $client
     *
     * @return Account
     * @throws \yii\base\InvalidConfigException
     */
    protected static function fetchAccount(BaseClientInterface $client)
    {
        $account = static::getFinder()->findAccount()->byClient($client)->one();

        if (null === $account) {
            $account = Yii::createObject([
                '__class'      => static::class,
                'provider'   => $client->getId(),
                'client_id'  => $client->getUserAttributes()['id'],
                'data'       => Json::encode($client->getUserAttributes()),
            ]);
            $account->save(false);
        }

        return $account;
    }

    /**
     * Tries to find user or create a new one.
     *
     * @param Account $account
     *
     * @return User|bool False when can't create user.
     */
    protected static function fetchUser(Account $account)
    {
        $user = static::getFinder()->findUserByEmail($account->email);

        if (null !== $user) {
            return $user;
        }

        $user = Yii::createObject([
            '__class'    => User::class,
            'scenario' => 'connect',
            'username' => $account->username,
            'email'    => $account->email,
        ]);

        if (!$user->validate(['email'])) {
            $account->email = null;
        }

        if (!$user->validate(['username'])) {
            $account->username = null;
        }

        return $user->create() ? $user : false;
    }

    /**
     * @return Finder
     */
    protected static function getFinder()
    {
        if (static::$finder === null) {
            static::$finder = Yii::$container->get(Finder::class);
        }

        return static::$finder;
    }
}
