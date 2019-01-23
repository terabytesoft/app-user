<?php

/**
 * profile/show
 *
 * Profile info
 *
 * View web application user
 **/

use assets\fontawesome\dev\css\NpmSolidAsset;
use yii\bootstrap4\Html;

/**
 * @property \app\user\models\UserModel $user
 * @var \app\user\models\ProfileModel $profile
 * @var \yii\web\View $this
 **/

$this->title = $this->app->t('user', 'Profile Details');
$this->params['breadcrumbs'][] = empty($profile->name) ? $profile->user->username : $profile->name;

NpmSolidAsset::register($this);

?>

<?= Html::beginTag('div', ['class' => 'row']) ?>

	<?= Html::beginTag('div', ['class' => 'col-md-3']) ?>

        <?= Html::img($profile->getAvatarUrl(230), [
            'class' => 'img-rounded img-responsive',
            'title' => $profile->name,
            ]) ?>

	<?= Html::endTag('div') ?>

	<?= Html::beginTag(
		'div',
		[
			'id' => 'form-admin-info',
			'class' => 'col-md-9 d-flex flex-column justify-content-around mb-3',
		]
	) ?>

		<?= Html::tag('h2', '<b>' . Html::encode($this->title) . '</b>', ['class' => 'text-center']) ?>

		<strong>
			<?= Html::encode(
				empty($profile->name) ?
				$this->app->t('user', 'Username:') :
				$this->app->t('user', 'Name:')
			) ?>
		</strong>
		<?= Html::beginTag('div', ['class' => 'alert alert-info flex-fill p-2', 'role' => 'alert']) ?>

			<?= Html::encode(empty($profile->name) ? $profile->user->username : $profile->name) ?>

		<?= Html::endTag('div') ?>

		<strong><?= Html::encode($this->app->t('user', 'Email - (Public):')) ?></strong>
		<?= Html::beginTag('div', ['class' => 'alert alert-info flex-fill p-2', 'role' => 'alert']) ?>
			<?= Html::tag('i', '', ['class' => 'fas fa-envelope']) ?>
			<?= Html::a(
				Html::encode(empty($profile->public_email) ? '(not set)' : 'mailto:' . $profile->public_email),
				Html::encode(empty($profile->public_email) ? 'javascript:;' : 'mailto:' . $profile->public_email)
			) ?>
		<?= Html::endTag('div') ?>

		<strong><?= Html::encode($this->app->t('user', 'Website:')) ?></strong>
		<?= Html::beginTag('div', ['class' => 'alert alert-info flex-fill p-2', 'role' => 'alert']) ?>
            <?= Html::tag('i', '', ['class' => 'fas fa-globe']) ?>
			<?= Html::a(
				Html::encode(empty($profile->website) ? '(not set)' : $profile->website),
				Html::encode(empty($profile->website) ? 'javascript:;' : $profile->website)
			) ?>
		<?= Html::endTag('div') ?>

		<strong><?= Html::encode($this->app->t('user', 'Location:')) ?></strong>
		<?= Html::beginTag('div', ['class' => 'alert alert-info flex-fill p-2', 'role' => 'alert']) ?>
			<?= Html::tag('i', '', ['class' => 'fas fa-map-marked']) ?>
			<?= Html::encode(empty($profile->location) ? '(not set)' : $profile->location) ?>
		<?= Html::endTag('div') ?>

		<strong><?= Html::encode($this->app->t('user', 'Time Zone:')) ?></strong>
		<?= Html::beginTag('div', ['class' => 'alert alert-info flex-fill p-2', 'role' => 'alert']) ?>
			<?= Html::tag('i', '', ['class' => 'fas fa-user-clock']) ?>
			<?= Html::encode(empty($profile->timezone) ? '(not set)' : $profile->timezone) ?>
		<?= Html::endTag('div') ?>

		<strong><?= Html::encode($this->app->t('user', 'Gravatar Email:')) ?></strong>
		<?= Html::beginTag('div', ['class' => 'alert alert-info flex-fill p-2', 'role' => 'alert']) ?>
			<?= Html::tag('i', '', ['class' => 'fas fa-image']) ?>
			<?= Html::encode(empty($profile->gravatar_email) ? '(not set)' : $profile->gravatar_email) ?>
		<?= Html::endTag('div') ?>

		<strong><?= Html::encode($this->app->t('user', 'Bio:')) ?></strong>
		<?= Html::beginTag('div', ['class' => 'alert alert-info flex-fill p-2', 'role' => 'alert']) ?>
			<?= Html::tag('i', '', ['class' => 'fas fa-atlas']) ?>
			<?= Html::encode(empty($profile->bio) ? '(not set)' : $profile->bio) ?>
		<?= Html::endTag('div') ?>

		<strong><?= Html::encode($this->app->t('user', 'Register:')) ?></strong>
		<?= Html::beginTag('div', ['class' => 'alert alert-info flex-fill p-2', 'role' => 'alert']) ?>
			<?= Html::tag('i', '', ['class' => 'fas fa-registered']) ?>
			<?= Html::encode(empty($profile->user->created_at) ?
				'(not set)' :
				$this->app->t('user', 'Joined on {0, date}', [$profile->user->created_at]))
			?>
		<?= Html::endTag('div') ?>

	<?= Html::endTag('div') ?>

<?php echo Html::endTag('div');
