<?php

/**
 * UserQuery
 *
 **/

namespace TerabyteSoft\Module\User\Querys;

use Yiisoft\ActiveRecord\ActiveQuery;

class UserQuery extends ActiveQuery
{
    /**
     * findUserById
     *
     * finds a user by the given id
     *
     * @param int $id User id to be used on search
     *
     * @return array|\Yiisoft\ActiveRecord\ActiveRecord
     */
    public function findUserById($id)
    {
        return $this->findUser(['id' => $id])->one();
    }

    /**
     * findUserByUsernameOrEmail
     *
     * finds a user by the given username or email
     *
     * @param string $usernameOrEmail Username or email to be used on search
     *
     * @return array|\Yiisoft\ActiveRecord\ActiveRecord
     */
    public function findUserByUsernameOrEmail($usernameOrEmail)
    {
        if (filter_var($usernameOrEmail, FILTER_VALIDATE_EMAIL)) {
            return $this->findUserByEmail($usernameOrEmail);
        }

        return $this->findUserByUsername($usernameOrEmail);
	}

    /**
     * findUserByUsername
     *
     * finds a user by the given username
     *
     * @param string $username Username to be used on search
     *
     * @return array|\Yiisoft\ActiveRecord\ActiveRecord
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
     * @return array|\Yiisoft\ActiveRecord\ActiveRecord
     */
    public function findUserByEmail($email)
    {
        return $this->findUser(['email' => $email])->one();
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
        return $this->where($condition);
    }
}
