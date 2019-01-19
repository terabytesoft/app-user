<?php

namespace app\user\widgets;

use app\user\traits\ModuleTrait;
use yii\authclient\ClientInterface;
use yii\authclient\widgets\AuthChoice;
use yii\authclient\widgets\AuthChoiceAsset;
use yii\helpers\Html;
use yii\helpers\Url;

/**
 * Connect
 *
 * @property self $app
 **/
class Connect extends AuthChoice implements \yii\di\Initiable
{
    use ModuleTrait;

    /**
     * @var array|null An array of user's accounts
     **/
    public $accounts;

    /**
     * @inheritdoc
     **/
    public $options = [];

    /**
     * init
     *
     * @inheritdoc
     **/
    public function init(): void
    {
        AuthChoiceAsset::register($this->app->view);
        if ($this->popupMode) {
            $this->app->view->registerJs("\$('#" . $this->getId() . "').authchoice();");
        }
        $this->options['id'] = $this->getId();
        echo Html::beginTag('div', $this->options);
    }

    /**
     * createClientUrl
     *
     * @inheritdoc
     **/
    public function createClientUrl($provider)
    {
        if ($this->isConnected($provider)) {
            return Url::to(['/user/settings/disconnect', 'id' => $this->accounts[$provider->getId()]->id]);
        } else {
            return parent::createClientUrl($provider);
        }
    }

    /**
     * isConnected
     *
     * Checks if provider already connected to user.
     *
     * @param ClientInterface $provider
     *
     * @return bool
     **/
    public function isConnected(ClientInterface $provider)
    {
        return $this->accounts != null && isset($this->accounts[$provider->getId()]);
    }
}
