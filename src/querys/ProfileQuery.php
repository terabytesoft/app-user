<?php

/**
 * ProfileQuery
 *
 **/

namespace TerabyteSoft\Module\User\Querys;

use Yiisoft\ActiveRecord\ActiveQuery;

class ProfileQuery extends ActiveQuery
{
    /**
     * findProfileById
     *
     * finds a profile by user id
     *
     * @param int $id
     *
     * @return null|array|\TerabyteSoft\Module\User\Models\ProfileModel
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
        return $this->where($condition);
	}
}
