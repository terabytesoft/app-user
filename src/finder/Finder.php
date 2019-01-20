<?php

namespace app\user\finder;

use app\user\models\AccountModel;
use app\user\models\ProfileModel;
use app\user\models\UserModel;
use app\user\models\TokenModel;
use app\user\models\query\AccountQuery;
use yii\activerecord\ActiveQuery;
use yii\authclient\ClientInterface;
use yii\base\BaseObject;

use yii\helpers\Yii;

class Finder extends BaseObject
{
    /** @var ActiveQuery **/
    protected $userQuery;

    /** @var ActiveQuery **/
    protected $tokenQuery;

    /** @var AccountQuery **/
    protected $accountQuery;

    /** @var ActiveQuery **/
    protected $profileQuery;

    /**
     * __construct
     *
     **/
    public function __construct()
    {
        $this->setAccountQuery();
        $this->setUserQuery();
        $this->setTokenQuery();
        $this->setProfileQuery();
    }

    /**
     * getUserQuery
     *
     * @return ActiveQuery
     **/
    public function getUserQuery()
    {
        return $this->userQuery;
    }

    /**
     * getTokenQuery
     *
     * @return ActiveQuery
     **/
    public function getTokenQuery()
    {
        return $this->tokenQuery;
    }

    /**
     * getAccountQuery
     *
     * @return ActiveQuery
     */
    public function getAccountQuery()
    {
        return $this->accountQuery;
    }

    /**
     * getProfileQuery
     *
     * @return ActiveQuery
     */
    public function getProfileQuery()
    {
        return $this->profileQuery;
    }

    /**
     * setAccountQuery
     *
     * @param ActiveQuery $accountQuery
     **/
    public function setAccountQuery()
    {
        $model = new AccountModel();
        $this->accountQuery = new AccountQuery($model);
    }

    /**
     * setUserQuery
     *
     * @param ActiveQuery $userQuery
     **/
    public function setUserQuery()
    {
        $this->userQuery = new UserModel();
        $this->userQuery = $this->userQuery->find();
    }

    /**
     * setTokenQuery
     *
     *  @param ActiveQuery $tokenQuery
     **/
    public function setTokenQuery()
    {
        $this->tokenQuery = new TokenModel();
        $this->tokenQuery = $this->tokenQuery->find();
    }

    /**
     * setProfileQuery
     *
     * @param ActiveQuery $profileQuery
     **/
    public function setProfileQuery()
    {
        $this->profileQuery = new ProfileModel();
        $this->profileQuery = $this->profileQuery->find();
    }

    /**
     * findUserById
     *
     * finds a user by the given id
     *
     * @param int $id User id to be used on search
     *
     * @return array|UserModel
     */
    public function findUserById($id)
    {
        return $this->findUser(['id' => $id])->one();
    }

    /**
     * findUserByUsername
     *
     * finds a user by the given username
     *
     * @param string $username Username to be used on search
     *
     * @return array|UserModel
     */
    public function findUserByUsername($username)
    {
        return $this->findUser(['username' => $username])->one();
    }

    /**
     * findUserByEmail
     *
     * finds a user by the given email
     *
     * @param string $email Email to be used on search
     *
     * @return array|UserModel
     */
    public function findUserByEmail($email)
    {
        return $this->findUser(['email' => $email])->one();
    }

    /**
     * findUserByUsernameOrEmail
     *
     * finds a user by the given username or email
     *
     * @param string $usernameOrEmail Username or email to be used on search
     *
     * @return UserModel
     */
    public function findUserByUsernameOrEmail($usernameOrEmail)
    {
        if (filter_var($usernameOrEmail, FILTER_VALIDATE_EMAIL)) {
            return $this->findUserByEmail($usernameOrEmail);
        }

        return $this->findUserByUsername($usernameOrEmail);
    }

    /**
     * findUser
     *
     * finds a user by the given condition
     *
     * @param mixed $condition Condition to be used on search
     *
     * @return ActiveQuery
     */
    public function findUser($condition)
    {
        return $this->userQuery->where($condition);
    }

    /**
     * findAccount
     *
     * @return AccountQuery
     */
    public function findAccount()
    {
        return $this->accountQuery;
    }

    /**
     * findAccountById
     *
     * finds an account by id
     *
     * @param int $id
     *
     * @return null|AccountModel
     */
    public function findAccountById($id)
    {
        return $this->accountQuery->where(['id' => $id])->one();
    }

    /**
     * findToken
     *
     * finds a token by user id and code
     *
     * @param mixed $condition
     *
     * @return ActiveQuery
     */
    public function findToken($condition)
    {
        return $this->tokenQuery->where($condition);
    }

    /**
     * findTokenByParams
     *
     * finds a token by params
     *
     * @param integer $userId
     * @param string  $code
     * @param integer $type
     *
     * @return array|TokenModel
     */
    public function findTokenByParams($userId, $code, $type)
    {
        return $this->findToken([
            'user_id' => $userId,
            'code'    => $code,
            'type'    => $type,
        ])->one();
    }

    /**
     * findProfileById
     *
     * finds a profile by user id
     *
     * @param int $id
     *
     * @return null|array|ProfileModel
     */
    public function findProfileById($id)
    {
        return $this->findProfile(['user_id' => $id])->one();
    }

    /**
     * findProfile
     *
     * finds a profile
     *
     * @param mixed $condition
     *
     * @return ActiveQuery
     */
    public function findProfile($condition)
    {
        return $this->profileQuery->where($condition);
    }
}
