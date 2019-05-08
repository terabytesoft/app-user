<?php

/**
 * @var \TerabyteSoft\Module\User\Models\User
 */

?>

<?= $module->getApp()->t('user', 'Hello') ?>,

<?= $module->getApp()->t('user', 'Your account on {0} has a new password', [$module->getApp()->name]) ?>.
<?= $module->getApp()->t('user', 'We have generated a password for you') ?>:

<?= $user->password ?>

<?= $module->getApp()->t('user', 'If you did not make this request you can ignore this email') ?>.
