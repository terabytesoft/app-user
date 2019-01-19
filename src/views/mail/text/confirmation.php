<?php

/**
 * @var app\user\models\User   $user
 * @var app\user\models\Token  $token
 */

?>

<?= $module->getApp()->t('user', 'Hello') ?>,

<?= $module->getApp()->t('user', 'Thank you for signing up on {0}', [$module->getApp()->name]) ?>.
<?= $module->getApp()->t('user', 'In order to complete your registration, please click the link below') ?>.

<?= $token->url ?>

<?= $module->getApp()->t('user', 'If you cannot click the link, please try pasting the text into your browser') ?>.

<?= $module->getApp()->t('user', 'If you did not make this request you can ignore this email') ?>.
