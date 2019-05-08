<?php

/**
 * @var \TerabyteSoft\Module\User\Module $module
 * @var \TerabyteSoft\Module\User\Models\User   $user
 * @var \TerabyteSoft\Module\User\Token  $token
 */

?>

<?= $module->getApp()->t('user', 'Hello') ?>,

<?= $module->getApp()->t('user', 'We have received a request to reset the password for your account on {0} - ' . $module->getApp()->name) ?>.
<?= $module->getApp()->t('user', 'Please click the link below to complete your password reset') ?>.

<?= $token->url ?>

<?= $module->getApp()->t('user', 'If you cannot click the link, please try pasting the text into your browser') ?>.
<?= $module->getApp()->t('user', 'If you did not make this request you can ignore this email') ?>.
