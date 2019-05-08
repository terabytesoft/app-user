<?php

/**
 * TokenQuery
 *
 **/

namespace TerabyteSoft\Module\User\Querys;

use Yiisoft\ActiveRecord\ActiveQuery;

class TokenQuery extends ActiveQuery
{
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
        return $this->where($condition);
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
     * @return array|\TerabyteSoft\Module\User\Models\TokenModel
     */
    public function findTokenByParams($userId, $code, $type)
    {
        return $this->findToken([
            'user_id' => $userId,
            'code'    => $code,
            'type'    => $type,
        ])->one();
    }
}
