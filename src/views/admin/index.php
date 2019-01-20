<?php

use yii\dataview\GridView;
use yii\dataview\columns\ActionColumn;
use yii\bootstrap4\Html;
use yii\helpers\Url;
use yii\web\View;

/**
 * @var \yii\web\View $this
 * @var \yii\data\ActiveDataProvider $dataProvider
 * @var \dektrium\user\models\UserSearch $searchModel
 */

$this->title = $this->getApp()->t('user', 'Manage users');
$this->params['breadcrumbs'][] = $this->title;

?>

<?= $this->render('/_alert', ['module' => $this->getApp()->getModule('user')]) ?>

<?= $this->render('/admin/_menu') ?>

<?php echo GridView::widget([
		'dataProvider' => $dataProvider,
		'filterModel' => $searchModel,
		'layout' => "{items}\n{pager}",
		'columns' => [
			[
				'attribute' => 'id',
				'headerOptions' => ['style' => 'width:70px;'],
			],
			'username',
			'email:email',
			[
				'attribute' => 'registration_ip',
				'value' => function ($model) {
					return $model->registration_ip == null
						? '<span class="not-set">' . $this->getApp()->t('user', '(not set)') . '</span>'
						: $model->registration_ip;
				},
			],
			[
				'attribute' => 'created_at',
				'value' => function ($model) {
					if (extension_loaded('intl')) {
						return $this->getApp()->t('user', '{0, date, MMMM dd, YYYY HH:mm}', [$model->created_at]);
					} else {
						return date('Y-m-d G:i:s', $model->created_at);
					}
				},
			],
			[
				'attribute' => 'last_login_at',
				'value' => function ($model) {
					if (!$model->last_login_at || $model->last_login_at == 0) {
						return $this->getApp()->t('user', 'Never');
				  	} else if (extension_loaded('intl')) {
						return $this->getApp()->t('user', '{0, date, MMMM dd, YYYY HH:mm}', [$model->last_login_at]);
				  	} else {
						return date('Y-m-d G:i:s', $model->last_login_at);
				  	}
				},
			],
			[
				'header' => $this->getApp()->t('user', 'Confirmation'),
				'value' => function ($model) {
					if ($model->isConfirmed) {
						return '<div class="text-center">
									<span class="text-success">' . $this->getApp()->t('user', 'Confirmed') . '</span>
								</div>';
					} else {
						return Html::a($this->getApp()->t('user', 'Confirm'), ['confirm', 'id' => $model->id], [
							'class' => 'btn btn-xs btn-success btn-block',
							'data-method' => 'post',
							'data-confirm' => $this->getApp()->t('user', 'Are you sure you want to confirm this user?'),
						]);
					}
				},
				'format' => 'raw',
				'visible' => $this->getApp()->getModule('user')->enableConfirmation,
			],
			[
				'header' => $this->getApp()->t('user', 'Block status'),
				'value' => function ($model) {
					if ($model->isBlocked) {
						return Html::a($this->getApp()->t('user', 'Unblock'), ['block', 'id' => $model->id], [
							'class' => 'btn btn-xs btn-success btn-block',
							'data-method' => 'post',
							'data-confirm' => $this->getApp()->t('user', 'Are you sure you want to unblock this user?'),
						]);
					} else {
						return Html::a($this->getApp()->t('user', 'Block'), ['block', 'id' => $model->id], [
							'class' => 'btn btn-xs btn-danger btn-block',
							'data-method' => 'post',
							'data-confirm' => $this->getApp()->t('user', 'Are you sure you want to block this user?'),
						]);
					}
				},
				'format' => 'raw',
			],
			[
				'__class' => ActionColumn::class,
				'template' => '{switch} {resend_password} {update} {delete}',
				'buttons' => [
					'resend_password' => function ($url, $model, $key) {
						if ($model->isAdmin) {
							return '
						<a data-method="POST" data-confirm="' . $this->getApp()->t('user', 'Are you sure?') . '" href="' . Url::to(['resend-password', 'id' => $model->id]) . '">
						<span title="' . $this->getApp()->t('user', 'Generate and send new password to user') . '" class= "&#x2709">
						</span> </a>';
						}
					},
					'switch' => function ($url, $model) {
						if ($model->id != $this->getApp()->user->id && $this->getApp()->getModule('user')->enableImpersonateUser) {
							return Html::a('<span class="glyphicon glyphicon-user"></span>', ['/user/admin/switch', 'id' => $model->id], [
								'title' => $this->getApp()->t('user', 'Become this user'),
								'data-confirm' => $this->getApp()->t('user', 'Are you sure you want to switch to this user for the rest of this Session?'),
								'data-method' => 'POST',
							]);
						}
					}
				]
			],
		],
]);
