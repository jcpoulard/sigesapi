<?php

namespace app\modules\v1\models;

use Yii;

/**
 * This is the model class for table "client".
 *
 * @property integer $id
 * @property string $code_school
 * @property string $school_db
 * @property string $school_name
 * @property string $email
 * @property integer $is_public
 */
class Client extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'client';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['code_school', 'school_db', 'school_name'], 'required'],
            [['is_public'], 'integer'],
            [['code_school'], 'string', 'max' => 64],
            [['school_db', 'email'], 'string', 'max' => 128],
            [['school_name'], 'string', 'max' => 255],
            [['code_school', 'email'], 'unique', 'targetAttribute' => ['code_school', 'email'], 'message' => 'The combination of Code School and Email has already been taken.'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'code_school' => 'Code School',
            'school_db' => 'School Db',
            'school_name' => 'School Name',
            'email' => 'Email',
            'is_public' => 'Is Public',
        ];
    }
}
