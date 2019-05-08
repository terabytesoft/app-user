<?php

use yii\helpers\Html;
use yii\helpers\Yii;

/**
 * @var TerabyteSoft\Module\User\Module $module
 * @var TerabyteSoft\Module\User\Models\User $user
 * @var TerabyteSoft\Module\User\Models\Password $password
 */

?>

<p style="font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif; font-size: 14px; line-height: 1.6; font-weight: normal; margin: 0 0 10px; padding: 0;">
    <?= $module->getApp()->t('user', 'Hello') ?>,
</p>

<p style="font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif; font-size: 14px; line-height: 1.6; font-weight: normal; margin: 0 0 10px; padding: 0;">
    <?= $module->getApp()->t('user', 'Your account on {0} has a new password', [$module->getApp()->name]) ?>.
    <?= $module->getApp()->t('user', 'We have generated a password for you') ?>: <strong><?= $user->password ?></strong>
</p>

<p style="font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif; font-size: 14px; line-height: 1.6; font-weight: normal; margin: 0 0 10px; padding: 0;">
    <?= $module->getApp()->t('user', 'If you did not make this request you can ignore this email') ?>.
</p>
