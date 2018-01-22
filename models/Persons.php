<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "persons".
 *
 * @property integer $id
 * @property string $last_name
 * @property string $first_name
 * @property string $gender
 * @property string $blood_group
 * @property string $birthday
 * @property string $id_number
 * @property integer $is_student
 * @property string $adresse
 * @property string $phone
 * @property string $email
 * @property string $nif_cin
 * @property integer $cities
 * @property string $citizenship
 * @property string $mother_first_name
 * @property string $identifiant
 * @property string $matricule
 * @property integer $paid
 * @property string $date_created
 * @property string $date_updated
 * @property string $create_by
 * @property string $update_by
 * @property integer $active
 * @property string $image
 * @property string $comment
 *
 * @property AverageByPeriod[] $averageByPeriods
 * @property Balance[] $balances
 * @property Billings[] $billings
 * @property ContactInfo[] $contactInfos
 * @property Courses[] $courses
 * @property CustomFieldData[] $customFieldDatas
 * @property DecisionFinale[] $decisionFinales
 * @property DepartmentHasPerson[] $departmentHasPeople
 * @property EmployeeInfo[] $employeeInfos
 * @property GeneralAverageByPeriod[] $generalAverageByPeriods
 * @property Grades[] $grades
 * @property Homework[] $homeworks
 * @property HomeworkSubmission[] $homeworkSubmissions
 * @property LevelHasPerson[] $levelHasPeople
 * @property LoanOfMoney[] $loanOfMoneys
 * @property MenfpDecision[] $menfpDecisions
 * @property MenfpGrades[] $menfpGrades
 * @property PayrollSettings[] $payrollSettings
 * @property PersonHistory[] $personHistories
 * @property Cities $cities0
 * @property PersonsHasTitles[] $personsHasTitles
 * @property RaiseSalary[] $raiseSalaries
 * @property RecordInfraction[] $recordInfractions
 * @property RecordPresence[] $recordPresences
 * @property RoomHasPerson[] $roomHasPeople
 * @property ScholarshipHolder[] $scholarshipHolders
 * @property StudentDocuments[] $studentDocuments
 * @property StudentOtherInfo[] $studentOtherInfos
 */
class Persons extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'persons';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['last_name', 'first_name', 'blood_group', 'nif_cin', 'citizenship', 'comment'], 'required'],
            [['birthday', 'date_created', 'date_updated'], 'safe'],
            [['is_student', 'cities', 'paid', 'active'], 'integer'],
            [['last_name', 'gender', 'phone', 'email', 'citizenship', 'create_by', 'update_by'], 'string', 'max' => 45],
            [['first_name'], 'string', 'max' => 120],
            [['blood_group'], 'string', 'max' => 10],
            [['id_number', 'image'], 'string', 'max' => 50],
            [['adresse', 'comment'], 'string', 'max' => 255],
            [['nif_cin', 'identifiant', 'matricule'], 'string', 'max' => 100],
            [['mother_first_name'], 'string', 'max' => 55],
            [['cities'], 'exist', 'skipOnError' => true, 'targetClass' => Cities::className(), 'targetAttribute' => ['cities' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'last_name' => 'Last Name',
            'first_name' => 'First Name',
            'gender' => 'Gender',
            'blood_group' => 'Blood Group',
            'birthday' => 'Birthday',
            'id_number' => 'Id Number',
            'is_student' => 'Is Student',
            'adresse' => 'Adresse',
            'phone' => 'Phone',
            'email' => 'Email',
            'nif_cin' => 'Nif Cin',
            'cities' => 'Cities',
            'citizenship' => 'Citizenship',
            'mother_first_name' => 'Mother First Name',
            'identifiant' => 'Identifiant',
            'matricule' => 'Matricule',
            'paid' => 'Paid',
            'date_created' => 'Date Created',
            'date_updated' => 'Date Updated',
            'create_by' => 'Create By',
            'update_by' => 'Update By',
            'active' => 'Active',
            'image' => 'Image',
            'comment' => 'Comment',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAverageByPeriods()
    {
        return $this->hasMany(AverageByPeriod::className(), ['student' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getBalances()
    {
        return $this->hasMany(Balance::className(), ['student' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getBillings()
    {
        return $this->hasMany(Billings::className(), ['student' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getContactInfos()
    {
        return $this->hasMany(ContactInfo::className(), ['person' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCourses()
    {
        return $this->hasMany(Courses::className(), ['teacher' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCustomFieldDatas()
    {
        return $this->hasMany(CustomFieldData::className(), ['object_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getDecisionFinales()
    {
        return $this->hasMany(DecisionFinale::className(), ['student' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getDepartmentHasPeople()
    {
        return $this->hasMany(DepartmentHasPerson::className(), ['employee' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getEmployeeInfos()
    {
        return $this->hasMany(EmployeeInfo::className(), ['employee' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getGeneralAverageByPeriods()
    {
        return $this->hasMany(GeneralAverageByPeriod::className(), ['student' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getGrades()
    {
        return $this->hasMany(Grades::className(), ['student' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getHomeworks()
    {
        return $this->hasMany(Homework::className(), ['person_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getHomeworkSubmissions()
    {
        return $this->hasMany(HomeworkSubmission::className(), ['student' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getLevelHasPeople()
    {
        return $this->hasMany(LevelHasPerson::className(), ['students' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getLoanOfMoneys()
    {
        return $this->hasMany(LoanOfMoney::className(), ['person_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getMenfpDecisions()
    {
        return $this->hasMany(MenfpDecision::className(), ['student' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getMenfpGrades()
    {
        return $this->hasMany(MenfpGrades::className(), ['student' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPayrollSettings()
    {
        return $this->hasMany(PayrollSettings::className(), ['person_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPersonHistories()
    {
        return $this->hasMany(PersonHistory::className(), ['person_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCities0()
    {
        return $this->hasOne(Cities::className(), ['id' => 'cities']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPersonsHasTitles()
    {
        return $this->hasMany(PersonsHasTitles::className(), ['persons_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getRaiseSalaries()
    {
        return $this->hasMany(RaiseSalary::className(), ['person_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getRecordInfractions()
    {
        return $this->hasMany(RecordInfraction::className(), ['student' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getRecordPresences()
    {
        return $this->hasMany(RecordPresence::className(), ['student' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getRoomHasPeople()
    {
        return $this->hasMany(RoomHasPerson::className(), ['students' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getScholarshipHolders()
    {
        return $this->hasMany(ScholarshipHolder::className(), ['student' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getStudentDocuments()
    {
        return $this->hasMany(StudentDocuments::className(), ['id_student' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getStudentOtherInfos()
    {
        return $this->hasMany(StudentOtherInfo::className(), ['student' => 'id']);
    }
}
