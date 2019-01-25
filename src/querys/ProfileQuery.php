<?php

/**
 * ProfileQuery
 *
 **/

namespace app\user\querys;

use yii\activerecord\ActiveQuery;

class ProfileQuery extends ActiveQuery
{
    /**
     * findProfileById
     *
     * finds a profile by user id
     *
     * @param int $id
     *
     * @return null|array|\app\user\models\ProfileModel
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
