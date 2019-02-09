<?php

/**
 * index
 *
 * View web application user
 **/

use yii\bootstrap4\Html;

$this->title = $this->app->t('user', 'Index');

?>

<?= Html::beginTag('div', ['class' => 'row align-items-center h-77vh']) ?>
    <?= Html::beginTag('div', ['class' => 'col-6 mx-auto']) ?>
        <?= Html::beginTag('div', ['class' => 'jumbotron text-center']) ?>
            <?= Html::tag('h1', 'app-user', ['class' => 'display-4']) ?>
            <?= Html::tag(
                'p',
                $this->app->t('user', '<b>' . 'Flexible user registration and authentication module.' . '</b>'),
                ['class' => 'lead']
            ) ?>
            <?= Html::beginTag('p', ['class' => 'lead']) ?>
                <?= Html::a(
					$this->app->t(
						'user',
						'Learn more'
					),
					'https://github.com/terabytesoft/app-user',
					['class' => 'btn btn-primary btn-lg', 'rel' => 'external', 'role' => 'button']
				) ?>
            <?= Html::endTag('p') ?>
        <?= Html::endTag('div') ?>
    <?= Html::endTag('div') ?>
<?php echo Html::endTag('div');
