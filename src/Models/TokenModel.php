<?php

namespace TerabyteSoft\Module\User\Models;

use TerabyteSoft\Module\User\Traits\ModuleTrait;
use Yiisoft\ActiveRecord\ActiveRecord;
use yii\helpers\Url;

/**
 * Token Active Record model.
 *
 * Database fields:
 * @property integer $user_id
 * @property string  $code
 * @property integer $created_at
 * @property integer $type
 * @property string  $url
 * @property bool    $isExpired
 *
 * Dependencies:
 * @property \TerabyteSoft\Module\User\Module module
 * @property \yii\web\Application app
 */
class TokenModel extends ActiveRecord
{
    use ModuleTrait;

    const TYPE_CONFIRMATION      = 0;
    const TYPE_RECOVERY          = 1;
    const TYPE_CONFIRM_NEW_EMAIL = 2;
    const TYPE_CONFIRM_OLD_EMAIL = 3;

    /**
	 * getUser
	 *
     * @return \Yiisoft\ActiveRecord\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne($this->module->modelMap['UserModel'], ['id' => 'user_id']);
    }

    /**
	 * getUrl
	 *
     * @return string
     */
    public function getUrl()
    {
        switch ($this->type) {
            case self::TYPE_CONFIRMATION:
                $route = '/user/registration/confirm';
                break;
            case self::TYPE_RECOVERY:
                $route = '/user/recovery/reset';
                break;
            case self::TYPE_CONFIRM_NEW_EMAIL:
            case self::TYPE_CONFIRM_OLD_EMAIL:
                $route = '/user/settings/confirm';
                break;
            default:
                throw new \RuntimeException();
        }

        return Url::to([$route, 'id' => $this->user_id, 'code' => $this->code], true);
    }

    /**
     * @return bool Whether token has expired.
     */
    public function getIsExpired()
    {
        switch ($this->type) {
            case self::TYPE_CONFIRMATION:
            case self::TYPE_CONFIRM_NEW_EMAIL:
            case self::TYPE_CONFIRM_OLD_EMAIL:
                $expirationTime = $this->module->tokenConfirmWithin;
                break;
            case self::TYPE_RECOVERY:
                $expirationTime = $this->module->tokenRecoverWithin;
                break;
            default:
                throw new \RuntimeException();
        }

        return ($this->created_at + $expirationTime) < time();
    }

    /** @inheritdoc */
    public function beforeSave($insert)
    {
        if ($insert) {
            static::deleteAll(['user_id' => $this->user_id, 'type' => $this->type]);
            $this->setAttribute('created_at', time());
            $this->setAttribute('code', $this->app->security->generateRandomString());
        }

        return parent::beforeSave($insert);
    }

    /** @inheritdoc */
    public static function tableName()
    {
        return '{{%token}}';
    }

    /** @inheritdoc */
    public static function primaryKey()
    {
        return ['user_id', 'code', 'type'];
    }
}
