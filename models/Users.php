<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "users".
 *
 * @property string $id
 * @property string $username
 * @property string $password
 * @property integer $active
 * @property integer $person_id
 * @property string $full_name
 * @property string $create_by
 * @property string $update_by
 * @property string $date_created
 * @property string $date_updated
 * @property integer $profil
 * @property integer $group_id
 * @property integer $is_parent
 * @property integer $user_id
 * @property string $last_ip
 * @property string $last_activity
 *
 * @property Profil $profil0
 * @property Groups $group
 */
class Users extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'users';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['username', 'password', 'active', 'person_id', 'full_name', 'user_id', 'last_ip', 'last_activity'], 'required'],
            [['active', 'person_id', 'profil', 'group_id', 'is_parent', 'user_id'], 'integer'],
            [['date_created', 'date_updated', 'last_activity'], 'safe'],
            [['username'], 'string', 'max' => 20],
            [['password'], 'string', 'max' => 128],
            [['full_name'], 'string', 'max' => 255],
            [['create_by', 'update_by'], 'string', 'max' => 64],
            [['last_ip'], 'string', 'max' => 100],
            [['username'], 'unique'],
            [['profil'], 'exist', 'skipOnError' => true, 'targetClass' => Profil::className(), 'targetAttribute' => ['profil' => 'id']],
            [['group_id'], 'exist', 'skipOnError' => true, 'targetClass' => Groups::className(), 'targetAttribute' => ['group_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'username' => 'Username',
            'password' => 'Password',
            'active' => 'Active',
            'person_id' => 'Person ID',
            'full_name' => 'Full Name',
            'create_by' => 'Create By',
            'update_by' => 'Update By',
            'date_created' => 'Date Created',
            'date_updated' => 'Date Updated',
            'profil' => 'Profil',
            'group_id' => 'Group ID',
            'is_parent' => 'Is Parent',
            'user_id' => 'User ID',
            'last_ip' => 'Last Ip',
            'last_activity' => 'Last Activity',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProfil0()
    {
        return $this->hasOne(Profil::className(), ['id' => 'profil']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getGroup()
    {
        return $this->hasOne(Groups::className(), ['id' => 'group_id']);
    }
}
