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

<?= GridView::widget([
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
			],
		],
]);
