<?php

namespace app\modules\v1\models;

use Yii;

/**
 * This is the model class for table "history".
 *
 * @property integer $id
 * @property string $db_name
 * @property string $ip_client
 * @property string $data_client
 * @property string $data_request
 * @property string $date_access
 */
class History extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'history';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['db_name', 'ip_client', 'data_client', 'data_request'], 'required'],
            [['data_client', 'data_request'], 'string'],
            [['date_access'], 'safe'],
            [['db_name'], 'string', 'max' => 255],
            [['ip_client'], 'string', 'max' => 32],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'db_name' => 'Db Name',
            'ip_client' => 'Ip Client',
            'data_client' => 'Data Client',
            'data_request' => 'Data Request',
            'date_access' => 'Date Access',
        ];
    }
}
