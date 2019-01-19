<?php

/**
 * @var app\user\models\User
 */

?>

<?= $module->getApp()->t('user', 'Hello') ?>,

<?= $module->getApp()->t('user', 'Your account on {0} has been created', [$module->getApp()->name]) ?>.
<?php if ($module->enableGeneratingPassword) : ?>
<?= $module->getApp()->t('user', 'We have generated a password for you') ?>:
<?= $user->password ?>
<?php endif ?>

<?php if ($token !== null) : ?>
<?= $module->getApp()->t('user', 'In order to complete your registration, please click the link below') ?>.

<?= $token->url ?>

<?= $module->getApp()->t('user', 'If you cannot click the link, please try pasting the text into your browser') ?>.
<?php endif ?>

<?= $module->getApp()->t('user', 'If you did not make this request you can ignore this email') ?>.
