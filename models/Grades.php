<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "grades".
 *
 * @property integer $id
 * @property integer $student
 * @property integer $course
 * @property integer $evaluation
 * @property double $grade_value
 * @property integer $validate
 * @property integer $publish
 * @property string $comment
 * @property string $date_created
 * @property string $date_updated
 * @property string $create_by
 * @property string $update_by
 *
 * @property Courses $course0
 * @property EvaluationByYear $evaluation0
 * @property Persons $student0
 */
class Grades extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'grades';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['student', 'course', 'evaluation', 'comment'], 'required'],
            [['student', 'course', 'evaluation', 'validate', 'publish'], 'integer'],
            [['grade_value'], 'number'],
            [['date_created', 'date_updated'], 'safe'],
            [['comment'], 'string', 'max' => 255],
            [['create_by', 'update_by'], 'string', 'max' => 45],
            [['course'], 'exist', 'skipOnError' => true, 'targetClass' => Courses::className(), 'targetAttribute' => ['course' => 'id']],
            [['evaluation'], 'exist', 'skipOnError' => true, 'targetClass' => EvaluationByYear::className(), 'targetAttribute' => ['evaluation' => 'id']],
            [['student'], 'exist', 'skipOnError' => true, 'targetClass' => Persons::className(), 'targetAttribute' => ['student' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'student' => 'Student',
            'course' => 'Course',
            'evaluation' => 'Evaluation',
            'grade_value' => 'Grade Value',
            'validate' => 'Validate',
            'publish' => 'Publish',
            'comment' => 'Comment',
            'date_created' => 'Date Created',
            'date_updated' => 'Date Updated',
            'create_by' => 'Create By',
            'update_by' => 'Update By',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCourse0()
    {
        return $this->hasOne(Courses::className(), ['id' => 'course']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getEvaluation0()
    {
        return $this->hasOne(EvaluationByYear::className(), ['id' => 'evaluation']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getStudent0()
    {
        return $this->hasOne(Persons::className(), ['id' => 'student']);
    }
}
