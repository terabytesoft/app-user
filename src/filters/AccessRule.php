<?php

namespace TerabyteSoft\Module\User\Filters;

use TerabyteSoft\Module\User\Traits\ModuleTrait;

/**
 * AccessRule
 *
 * Dependencies:
 * @property \TerabyteSoft\Module\User\Module module
 * @property \yii\web\Application app
 **/
class AccessRule extends \yii\web\filters\AccessRule
{
    use ModuleTrait;

    /**
     * matchRole
     *
     * @inheritdoc
     **/
    protected function matchRole($user)
    {
        if (empty($this->roles)) {
            return true;
        }

        foreach ($this->roles as $role) {
            if ($role === '?') {
                if ($this->app->user->isGuest) {
                    return true;
                }
            } elseif ($role === '@') {
                if (!$this->app->user->isGuest) {
                    return true;
                }
            } elseif ($role === 'admin') {
                if (!$this->app->user->isGuest && $this->app->user->identity->isAdmin) {
                    return true;
                }
            } elseif ($user->can($role)) {
                return true;
            }
        }

        return false;
    }
}
