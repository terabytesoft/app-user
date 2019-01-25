<?php

namespace app\user\models;

use app\user\clients\ClientInterface;
use app\user\models\UserModel;
use app\user\traits\ModuleTrait;
use yii\activerecord\ActiveRecord;
use yii\authclient\ClientInterface as BaseClientInterface;
use yii\helpers\Json;
use yii\helpers\Url;
use yii\helpers\Yii;

/**
 * AccountModel
 *
 * Database fields:
 * @property integer $id Id
 * @property integer $user_id - null if account is not bind to user
 * @property string  $provider - name of service
 * @property string  $client_id
 * @property string  $data - account properties returned by social network (json encoded)
 * @property string  $decodedData - json-decoded properties
 * @property string  $code
 * @property integer $created_at
 * @property string  $email
 * @property string  $username
 *
 * Defined relations:
 * @property \app\user\models\UserModels $user - that this account is connected for social accounts
 *
 * Dependencies:
 * @property \yii\web\Application app
 * @property object container
 * @property \app\user\Module module
 **/
class AccountModel extends ActiveRecord
{
	use ModuleTrait;

	protected $accountQuery;
	protected $userQuery;

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
     * @return \yii\activerecord\ActiveQuery
     **/
    public function getUser()
    {
        return $this->hasOne($this->module->modelMap['UserModel'], ['id' => 'user_id']);
    }

	/**
     * getaccountQuery
     *
     * @return \app\user\querys\AccountQuery
     *
     * @throws \yii\base\InvalidConfigException
     **/
    protected function getAccountQuery()
    {
        return $this->accountQuery = $this->module->accountQuery;
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
        $code = $this->app->security->generateRandomString();
        $this->updateAttributes(['code' => md5($code)]);

        return Url::to(['/user/registration/connect', 'code' => $code]);
    }

    /**
     * connect
     *
     **/
    public function connect(UserModel $user)
    {
        return $this->updateAttributes([
            'username' => null,
            'email'    => null,
            'code'     => null,
            'user_id'  => $user->id,
        ]);
	}

    /**
     * create
     *
     **/
    public function create(BaseClientInterface $client)
    {
		/** @var Account $account **/
        $account = Yii::createObject([
            '__class'    => static::class,
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

        if (($user = $this->fetchUser($account)) instanceof UserModel) {
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
    public function connectWithUser(BaseClientInterface $client)
    {
        if (Yii::getApp()->user->isGuest) {
            Yii::getApp()->session->setFlash('danger', Yii::getApp()->t('user', 'Something went wrong'));

            return;
        }

        $account = $this->fetchAccount($client);

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
    protected function fetchAccount(BaseClientInterface $client)
    {
		$this->accountQuery = $this->getAccountQuery();
        $account = $this->accountQuery->byClient($client)->one();

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
    protected function fetchUser(AccountModel $account)
    {
		$this->userQuery = $this->getUserQuery();
        $user = $this->userQuery->findUserByEmail($account->email);

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
}
