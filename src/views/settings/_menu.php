<?php

use yii\helpers\Html;
use app\user\widgets\UserMenu;

/**
 * @var app\user\models\User $user
 */

$user = $this->getApp()->user->identity;

?>

<div class="panel panel-default">
    <div class="panel-heading">
        <h3 class="panel-title">
            <?= Html::img($user->profile->getAvatarUrl(24), [
                'class' => 'img-rounded',
                'alt' => $user->username,
            ]) ?>
            <?= $user->username ?>
        </h3>
    </div>
    <div class="panel-body">
        <?= UserMenu::widget() ?>
    </div>
</div>
