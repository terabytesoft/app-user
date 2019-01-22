<?php

use yii\bootstrap4\Html;
use yii\dataview\GridView;
use yii\dataview\columns\ActionColumn;
use yii\helpers\Url;
use yii\web\View;

/**
 * @var \yii\web\View $this
 * @var \yii\activerecord\data\ActiveDataProvider $dataProvider
 * @var \app\user\models\UserSearch $searchModel
 */

$this->title = $this->app->t('user', 'Manage users');
$this->params['breadcrumbs'][] = $this->title;

?>

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
						? '<span class="not-set">' . $this->app->t('user', '(not set)') . '</span>'
						: $model->registration_ip;
				},
			],
			[
				'attribute' => 'created_at',
				'value' => function ($model) {
					if (extension_loaded('intl')) {
						return $this->app->t('user', '{0, date, MMMM dd, YYYY HH:mm}', [$model->created_at]);
					} else {
						return date('Y-m-d G:i:s', $model->created_at);
					}
				},
			],
			[
				'attribute' => 'last_login_at',
				'value' => function ($model) {
					if (!$model->last_login_at || $model->last_login_at == 0) {
						return $this->app->t('user', 'Never');
				  	} else if (extension_loaded('intl')) {
						return $this->app->t('user', '{0, date, MMMM dd, YYYY HH:mm}', [$model->last_login_at]);
				  	} else {
						return date('Y-m-d G:i:s', $model->last_login_at);
				  	}
				},
			],
			[
				'header' => $this->app->t('user', 'Confirmation'),
				'value' => function ($model) {
					if ($model->isConfirmed) {
						return '<div class="text-center">
									<span class="text-success">' . $this->app->t('user', 'Confirmed') . '</span>
								</div>';
					} else {
						return Html::a($this->app->t('user', 'Confirm'), ['confirm', 'id' => $model->id], [
							'class' => 'btn btn-xs btn-success btn-block',
							'data-method' => 'post',
							'data-confirm' => $this->app->t('user', 'Are you sure you want to confirm this user?'),
						]);
					}
				},
				'format' => 'raw',
				'visible' => $this->app->getModule('user')->enableConfirmation,
			],
			[
				'header' => $this->app->t('user', 'Block status'),
				'value' => function ($model) {
					if ($model->isBlocked) {
						return Html::a($this->app->t('user', 'Unblock'), ['block', 'id' => $model->id], [
							'class' => 'btn btn-xs btn-success btn-block',
							'data-method' => 'post',
							'data-confirm' => $this->app->t('user', 'Are you sure you want to unblock this user?'),
						]);
					} else {
						return Html::a($this->app->t('user', 'Block'), ['block', 'id' => $model->id], [
							'class' => 'btn btn-xs btn-danger btn-block',
							'data-method' => 'post',
							'data-confirm' => $this->app->t('user', 'Are you sure you want to block this user?'),
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
						<a data-method="POST" data-confirm="' . $this->app->t('user', 'Are you sure?') . '" href="' . Url::to(['resend-password', 'id' => $model->id]) . '">
						<span title="' . $this->app->t('user', 'Generate and send new password to user') . '" class= "&#x2709">
						</span> </a>';
						}
					},
					'switch' => function ($url, $model) {
						if ($model->id != $this->app->user->id && $this->app->getModule('user')->enableImpersonateUser) {
							return Html::a('<span class="glyphicon glyphicon-user"></span>', ['/user/admin/switch', 'id' => $model->id], [
								'title' => $this->app->t('user', 'Become this user'),
								'data-confirm' => $this->app->t('user', 'Are you sure you want to switch to this user for the rest of this Session?'),
								'data-method' => 'POST',
							]);
						}
					}
				]
			],
		],
]);

