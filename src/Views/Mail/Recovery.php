<?php

use yii\helpers\Html;
use yii\helpers\Yii;

/**
 * @var \TerabyteSoft\Module\User\Module $module
 * @var \TerabyteSoft\Module\User\Models\User $user
 * @var \TerabyteSoft\Module\User\Models\Token $token
 */

?>

<p style="font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif; font-size: 14px; line-height: 1.6; font-weight: normal; margin: 0 0 10px; padding: 0;">
    <?= $module->getApp()->t('user', 'Hello') ?>,
</p>

<p style="font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif; font-size: 14px; line-height: 1.6; font-weight: normal; margin: 0 0 10px; padding: 0;">
    <?= $module->getApp()->t('user', 'We have received a request to reset the password for your account on {0}', [$module->getApp()->name]) ?>.
    <?= $module->getApp()->t('user', 'Please click the link below to complete your password reset') ?>.
</p>

<p style="font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif; font-size: 14px; line-height: 1.6; font-weight: normal; margin: 0 0 10px; padding: 0;">
    <?= Html::a(Html::encode($token->url), $token->url); ?>
</p>

<p style="font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif; font-size: 14px; line-height: 1.6; font-weight: normal; margin: 0 0 10px; padding: 0;">
    <?= $module->getApp()->t('user', 'If you cannot click the link, please try pasting the text into your browser') ?>.
</p>

<p style="font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif; font-size: 14px; line-height: 1.6; font-weight: normal; margin: 0 0 10px; padding: 0;">
    <?= $module->getApp()->t('user', 'If you did not make this request you can ignore this email') ?>.
</p>
