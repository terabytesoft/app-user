<?php

namespace app\user\models;

use app\user\clients\ClientInterface;
use app\user\finder\Finder;
use app\user\models\UserModel;
use app\user\models\query\AccountQuery;
use app\user\traits\ModuleTrait;
use yii\activerecord\ActiveRecord;
use yii\authclient\ClientInterface as BaseClientInterface;
use yii\helpers\Json;
use yii\helpers\Url;
use yii\helpers\Yii;

/**
 * AccountModel
 *
 * @property integer $id Id
 * @property integer $user_id User id, null if account is not bind to user
 * @property string $provider Name of service
 * @property string $client_id Account id
 * @property string $data Account properties returned by social network (json encoded)
 * @property string $decodedData Json-decoded properties
 * @property string $code
 * @property integer $created_at
 * @property string $email
 * @property string $username
 * @property UserModels $user User that this account is connected for
 **/
class AccountModel extends ActiveRecord
{
    use ModuleTrait;

    /** @var Finder **/
    protected static $finder;

    /** @var **/
    private $_data;

    /**
     * tableName
     *
     **/
    public static function tableName()
    {
        return '{{%social_account}}';
    }

    /**
     * getUser
     *
     * @return \yii\activerecord\ActiveQuer
     **/
    public function getUser()
    {
        return $this->hasOne($this->module->modelMap['User'], ['id' => 'user_id']);
    }

    /**
     * getIsConnected
     *
     * @return bool whether this social account is connected to user
     **/
    public function getIsConnected()
    {
        return $this->user_id != null;
    }

    /**
     * getDecodedData
     *
     * @return mixed json decoded properties
     **/
    public function getDecodedData()
    {
        if ($this->_data == null) {
            $this->_data = Json::decode($this->data);
        }

        return $this->_data;
    }

    /**
     * getConnectUrl
     *
     * returns connect url
     *
     * @return string
     **/
    public function getConnectUrl()
    {
        $code = $this->module->getApp()->security->generateRandomString();
        $this->updateAttributes(['code' => md5($code)]);

        return Url::to(['/user/registration/connect', 'code' => $code]);
    }

    /**
     * connect
     *
     **/
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
     * find
     *
     * @return AccountQuery
     **/
    public static function find()
    {
        return Yii::createObject(AccountQuery::class, [get_called_class()]);
    }

    /**
     * create
     *
     **/
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
     * connectWithUser
     *
     * tries to find an account and then connect that account with current user
     *
     * @param BaseClientInterface $client
     **/
    public static function connectWithUser(BaseClientInterface $client)
    {
        if (Yii::getApp()->user->isGuest) {
            Yii::getApp()->session->setFlash('danger', Yii::getApp()->t('user', 'Something went wrong'));

            return;
        }

        $account = static::fetchAccount($client);

        if ($account->user === null) {
            $account->link('user', Yii::getApp()->user->identity);
            Yii::getApp()->session->setFlash('success', Yii::getApp()->t('user', 'Your account has been connected'));
        } else {
            Yii::getApp()->session->setFlash(
                'danger',
                Yii::getApp()->t('user', 'This account has already been connected to another user')
            );
        }
    }

    /**
     * fetchAccount
     *
     * tries to find account, otherwise creates new account
     *
     * @param BaseClientInterface $client
     *
     * @return AccountModel
     *
     * @throws \yii\base\InvalidConfigException
     **/
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
     * fetchUser
     *
     * tries to find user or create a new one
     *
     * @param AccountModel $account
     *
     * @return bool|UserModel False when can't create user
     **/
    protected static function fetchUser(Account $account)
    {
        $user = static::getFinder()->findUserByEmail($account->email);

        if (null !== $user) {
            return $user;
        }

        $user = Yii::createObject([
            '__class'    => UserModel::class,
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
     * getFinder
     *
     * @return Finder
     **/
    protected static function getFinder()
    {
        if (static::$finder === null) {
            static::$finder = Yii::$container->get(Finder::class);
        }

        return static::$finder;
    }
}
