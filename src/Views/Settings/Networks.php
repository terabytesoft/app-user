<?php

/**
 * Networks
 **/

use TerabyteSoft\Module\User\Widgets\Connect;
use Yiisoft\Yii\Bootstrap4\Html;

/**
 * @var $form \Yiisoft\Yii\Bootstrap4\ActiveForm
 * @var $this \yii\web\View
 **/

$this->title = $this->app->t('ModuleUser', 'Social Accounts Form');
$this->params['breadcrumbs'][] = $this->title;

?>

<?= Html::beginTag('div', ['class' => 'row']) ?>

	<?= Html::beginTag('div', ['class' => 'col-md-3']) ?>
        <?= $this->render('_Menu') ?>
	<?= Html::endTag('div') ?>

	<?= Html::beginTag('div', ['class' => 'col-md-9']) ?>

		<?= Html::tag('h2', '<b>' . Html::encode($this->title) . '</b>', ['class' => 'text-center']) ?>

		<?= Html::beginTag('div', ['class' => 'alert alert-info align-middle', 'role' => 'alert']) ?>
            <?= $this->app->t('ModuleUser', 'You can connect multiple accounts to be able to log in using them') ?>
		<?= Html::endTag('div') ?>

        <?php $auth = Connect::begin([
			'accounts' => $user->accounts,
			'autoRender' => false,
            'baseAuthUrl' => ['/user/security/auth'],
            'popupMode' => false,
        ]) ?>

			<?php foreach ($auth->getClients() as $client) : ?>

				<?= Html::beginTag(
					'div',
					[
						'class' => 'align-items-center border border-success d-flex flex-row justify-content-between mb-3'
					]
				) ?>
					<?= Html::beginTag('div', ['class' => 'p-2']) ?>
                        <?= Html::tag('span', '', ['class' => 'auth-icon ' . $client->getName()]) ?>
					<?= Html::endTag('div') ?>

					<?= Html::beginTag('div', ['class' => 'flex-fill p-2']) ?>
                       	<strong><?= $client->getTitle() ?></strong>
					<?= Html::endTag('div') ?>

					<?= Html::beginTag('div', ['class' => 'p-3 w-25']) ?>
                        <?= $auth->isConnected($client) ?
                           	Html::a($this->app->t('ModuleUser', 'Disconnect'), $auth->createClientUrl($client), [
                               		'class' => 'btn btn-block btn-danger',
                                	'data-method' => 'POST',
                                ]) :
                                Html::a($this->app->t('ModuleUser', 'Connect'), $auth->createClientUrl($client), [
                                	'class' => 'btn btn-block btn-success',
								])
						?>
					<?= Html::endTag('div') ?>

				<?= Html::endTag('div') ?>

			<?php endforeach ?>

        <?php Connect::end() ?>

	<?= Html::endTag('div') ?>

<?php echo Html::endTag('div');
