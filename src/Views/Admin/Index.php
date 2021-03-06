<?php

/**
 * admin/index
 *
 * GridView list users
 *
 * View web application user
 **/

use TerabyteSoft\Module\User\Assets\AdminIndexAsset;
use TerabyteSoft\Assets\Fontawesome\Dev\Css\NpmAllAsset;
use Yiisoft\Yii\Bootstrap4\Html;
use Yiisoft\Yii\DataView\GridView;
use Yiisoft\Yii\DataView\Columns\ActionColumn;
use Yiisoft\Yii\DataView\Columns\CheckboxColumn;
use Yiisoft\Yii\JQuery\GridViewAsset;
use yii\helpers\Url;
use yii\web\View;

/**
 * @var \TerabyteSoft\Module\User\Models\UserSearch $searchModel
 * @var \Yiisoft\ActiveRecord\data\ActiveDataProvider $dataProvider
 * @var \yii\web\View $this
 **/

$this->title = $this->app->t('ModuleUser', 'Manage Users');
$this->params['breadcrumbs'][] = $this->title;

AdminIndexAsset::register($this);
GridViewAsset::register($this);
NpmAllAsset::register($this);

$columns = 	[
	[
		'attribute' => 'id',
		'contentOptions' => ['class' => 'form-admin-index-field-id'],
		'filterInputOptions' => ['class' => 'form-control'],
		'label' => $this->app->t('ModuleUser', 'id'),
	],
	[
		'attribute' => 'username',
		'contentOptions' => ['class' => 'form-admin-index-field-username'],
		'filterInputOptions' => ['class' => 'form-control'],
		'label' => $this->app->t('ModuleUser', 'Username'),
	],
	[
		'attribute' => 'email',
		'contentOptions' => ['class' => 'form-admin-index-field-email'],
		'filterInputOptions' => ['class' => 'form-control'],
		'label' => $this->app->t('ModuleUser', 'Email'),
	],
	[
		'attribute' => 'registration_ip',
		'contentOptions' => ['class' => 'form-admin-index-field-registration_ip'],
		'filterInputOptions' => ['class' => 'form-control'],
		'label' => $this->app->t('ModuleUser', 'Ip'),
		'value' => function ($model) {
			return $model->registration_ip === null
				? $this->app->t('ModuleUser', '(not set)')
				: $model->registration_ip;
		},
	],
	[
		'attribute' => 'created_at',
		'contentOptions' => ['class' => 'form-admin-index-field-created_at'],
		'filterInputOptions' => ['class' => 'form-control'],
		'label' => $this->app->t('ModuleUser', 'Register Time'),
		'value' => function ($model) {
			if (extension_loaded('intl')) {
				return $this->app->t('ModuleUser', '{0, date, yyyy-MM-dd HH:mm}', [$model->created_at]);
			} else {
				return date('Y-m-d G:i:s', $model->created_at);
			}
		},
	],
	[
		'attribute' => 'last_login_at',
		'contentOptions' => ['class' => 'form-admin-index-field-last_login_at'],
		'filterInputOptions' => ['class' => 'form-control'],
		'label' => $this->app->t('ModuleUser', 'Last Login'),
		'value' => function ($model) {
			if (!$model->last_login_at || $model->last_login_at == 0) {
				return $this->app->t('ModuleUser', 'Never');
		  	} elseif (extension_loaded('intl')) {
				return $this->app->t('ModuleUser', '{0, date, yyyy-MM-dd HH:mm}', [$model->last_login_at]);
			} else {
				return date('Y-m-d G:i:s', $model->last_login_at);
			}
		},
	],
	[
		'contentOptions' => ['class' => 'form-admin-index-field-confirm'],
		'format' => 'raw',
		'header' => $this->app->t('ModuleUser', 'Confirm'),
		'value' => function ($model) {
			if ($model->isConfirmed) {
				return Html::tag(
					'span',
					Html::tag('i', '', [
						'class' => 'fas fa-user-check fa-2x'
					]),
					[
						'class' => 'text-success',
						'title' => $this->app->t('ModuleUser', 'Confirmed')
					]
				);
			} else {
				return Html::a(
					Html::tag('i', '', [
						'class' => 'fas fa-user-times fa-2x',
					]),
					['confirm', 'id' => $model->id],
					[
						'class' => 'text-danger',
						'data-confirm' => $this->app->t('ModuleUser', 'Are you sure you want to confirm this user?'),
						'data-method' => 'POST',
						'title' => $this->app->t('ModuleUser', 'Not confirmed'),
					]
				);
			}
		},
		'visible' => $this->app->getModule('user')->accountConfirmation,
	],
	[
		'contentOptions' => ['class' => 'form-admin-index-field-block'],
		'format' => 'raw',
		'header' => $this->app->t('ModuleUser', 'Block'),
		'value' => function ($model) {
			if ($model->isBlocked) {
				return Html::a(
					Html::tag('i', '', [
						'class' => 'fas fa-user-alt fa-2x',
					]),
					['block', 'id' => $model->id],
					[
						'class' => 'text-success',
						'data-confirm' => $this->app->t('ModuleUser', 'Are you sure you want to unblock this user?'),
						'data-method' => 'POST',
						'title' => $this->app->t('ModuleUser', 'Unblock'),
					]
				);
			} else {
				return Html::a(
					Html::tag('i', '', [
						'class' => 'fas fa-user-lock fa-2x',
					]),
					['block', 'id' => $model->id],
					[
						'class' => 'text-danger',
						'data-confirm' => $this->app->t('ModuleUser', 'Are you sure you want to block this user?'),
						'data-method' => 'post',
						'title' => $this->app->t('ModuleUser', 'Block'),
					]
				);
			}
		},
	],
	[
		'__class' => ActionColumn::class,
		'buttons' => [
			'delete' => function ($url, $model) {
				return Html::a(
					Html::tag('i', '', [
						'class' => 'fas fa-circle fa-stack-2x',
					]) .
					Html::tag('i', '', [
						'class' => 'fas fa-trash fa-stack-1x fa-inverse',
					]),
					$url,
					[
						'class' => 'border-0 fa-stack text-danger',
						'data-method' => 'POST',
						'data-confirm' => $this->app->t('ModuleUser', 'Are you sure to delete this user?'),
						'title' => $this->app->t('ModuleUser', 'Delete'),
					]
				);
			},
			'info' => function ($url, $model) {
				return Html::a(
					Html::tag('i', '', [
						'class' => 'fas fa-circle fa-stack-2x',
					]) .
					Html::tag('i', '', [
						'class' => 'fas fa-eye fa-stack-1x fa-inverse',
					]),
					$url,
					[
						'class' => 'border-0 fa-stack text-info',
						'title' => $this->app->t('ModuleUser', 'Info'),
					]
				);
			},
			'resend-password' => function ($url, $model, $key) {
				if ($this->app->user->identity->isAdmin) {
					return Html::a(
						Html::tag('i', '', [
							'class' => 'fas fa-circle fa-stack-2x',
						]) .
						Html::tag('i', '', [
							'class' => 'fas fa-envelope fa-stack-1x fa-inverse',
						]),
						$url,
						[
							'class' => 'border-0 fa-stack text-dark',
							'data-confirm' => $this->app->t('ModuleUser', 'Are you sure, send new password ?'),
							'data-method' => 'POST',
							'title' => $this->app->t('ModuleUser', 'Generate and send new password to user'),
						]
					);
				}
			},
			'switch' => function ($url, $model) {
				if ($this->app->getModule('user')->accountImpersonateUser) {
					return Html::a(
						Html::tag('i', '', [
							'class' => 'fas fa-user-circle fa-stack-2x',
						]),
						$url,
						[
							'class' => 'border-0 fa-stack text-warning',
							'title' => $this->app->t('ModuleUser', 'Become this user'),
							'data-confirm' => $this->app->t('ModuleUser', 'Are you sure you want to switch to this user for the rest of this Session?'),
							'data-method' => 'POST',
						]
					);
				}
			},
			'update' => function ($url, $model) {
				return Html::a(
					Html::tag('i', '', [
						'class' => 'fas fa-circle fa-stack-2x',
					]) .
					Html::tag('i', '', [
						'class' => 'fas fa-edit fa-stack-1x fa-inverse',
					]),
					$url,
					[
						'class' => 'border-0 fa-stack text-success',
						'title' => $this->app->t('ModuleUser', 'Update'),
					]
				);
			},
		],
		'contentOptions' => ['class' => 'd-flex'],
		'header' => $this->app->t('ModuleUser', 'User Actions'),
		'headerOptions' => ['class' => 'text-center'],
		'template' => '{delete} {info} {resend-password} {switch} {update}',
	]
];

?>

<?= Html::beginTag('div', ['class' => 'form-admin-index']) ?>

    <?= Html::tag('h2', '<b>' . Html::encode($this->title) . '</b>', ['class' => 'form-admin-index-title']) ?>

    <?= Html::tag('hr', '', ['class' => 'mb-4']) ?>

    <?= $this->render('_Menu') ?>

    <?php echo GridView::widget([
	    'id' => 'form-admin-index',
	    'as clientScript' => [
		    '__class' => \Yiisoft\Yii\JQuery\GridViewClientScript::class,
	    ],
	    'columns' => $columns,
	    'dataProvider' => $dataProvider,
	    'filterModel' => $searchModel,
	    'layout' => "{items}\n{pager}",
	    'options' => [
		    'class' => 'grid-font-consolas'
	    ],
	    'pager' => [
		    'activePageCssClass' => 'page-item active',
		    'disabledListItemSubTagOptions' => [
			    'tag' => 'a',
			    'class' => 'page-link'
		    ],
		    'disabledPageCssClass' => 'page-item disabled',
		    'linkOptions' => [
			    'class' => 'page-link'
		    ],
		    'options' => [
			    'class' => 'pagination float-right ml-auto'
		    ],
	    ],
	    'tableOptions' => [
		    'class' => 'table table-sm table-hover'
	    ],
    ]); ?>

<?php echo Html::endTag('div');
