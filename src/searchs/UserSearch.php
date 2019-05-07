<?php

namespace TerabyteSoft\Module\User\Searchs;

use TerabyteSoft\Module\User\Traits\ModuleTrait;
use Yiisoft\ActiveRecord\ActiveQuery;
use Yiisoft\ActiveRecord\Data\ActiveDataProvider;
use yii\base\Model;
use yii\helpers\Yii;

/**
 * UserSearch represents the model behind the search form about User.
 *
 * Dependencies:
 * @property object db
 **/
class UserSearch extends Model
{
	use ModuleTrait;

    /** @var integer **/
    public $id;

    /** @var string **/
    public $username;

    /** @var string **/
    public $email;

    /** @var int **/
    public $created_at;

    /** @var int **/
    public $last_login_at;

    /** @var string **/
    public $registration_ip;

    /**
	 * rules
	 *
     * @return array the validation rules
     **/
    public function rules(): array
    {
        return [
            'fieldsSafe' => [['id', 'username', 'email', 'registration_ip', 'created_at', 'last_login_at'], 'safe'],
            'createdDefault' => ['created_at', 'default', 'value' => null],
            'lastloginDefault' => ['last_login_at', 'default', 'value' => null],
        ];
    }

    /** @inheritdoc **/
    public function attributeLabels()
    {
        return [
            'id'              => Yii::t('user', '#'),
            'username'        => Yii::t('user', 'Username'),
            'email'           => Yii::t('user', 'Email'),
            'created_at'      => Yii::t('user', 'Registration time'),
            'last_login_at'   => Yii::t('user', 'Last login'),
            'registration_ip' => Yii::t('user', 'Registration ip'),
        ];
    }

    /**
     * @param $params
     *
     * @return ActiveDataProvider
     **/
    public function search($params, ActiveQuery $userQuery)
    {
        $query = $userQuery;

		$db = $this->db;

        $dataProvider = new ActiveDataProvider(
			$db,
			$query
		);

		$dataProvider->setPagination([
		    'pageSize' => 10,
		]);

        if (!($this->load($params) && $this->validate())) {
            return $dataProvider;
        }

        $modelClass = $query->modelClass;
        $table_name = $modelClass::tableName();

        if ($this->created_at !== null) {
            $date = strtotime($this->created_at);
            $query->andFilterWhere(['between', $table_name . '.created_at', $date, $date + 3600 * 24]);
        }

        $query->andFilterWhere(['like', $table_name . '.username', $this->username])
              ->andFilterWhere(['like', $table_name . '.email', $this->email])
              ->andFilterWhere([$table_name . '.id' => $this->id])
              ->andFilterWhere([$table_name . '.registration_ip' => $this->registration_ip]);

        return $dataProvider;
    }
}
