<?php

namespace app\controllers; 
use yii\rest\ActiveController; 
use app\models\Persons; 
use app\models\Grades; 

class UsersController extends ActiveController{
    public $modelClass = 'app\models\Users';
    
    public function behaviors()
    {
        return [
            [
                'class' => \yii\filters\ContentNegotiator::className(),
                'only' => ['index', 'view'],
                'formats' => [
                    'application/json' => \yii\web\Response::FORMAT_JSON,
                ],
            ],
        ];
    }
    
    public function actions() {
        $actions = parent::actions();
        unset($actions['create']); 
        return $actions; 
    }
    
    public function actionStudent(){
        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        
        $rows = (new \yii\db\Query())
                ->select(['persons.id', 'last_name','first_name','gender','birthday','active','rooms.room_name'])
                ->from('persons')
                ->join('INNER JOIN','room_has_person','room_has_person.students = persons.id')
                ->join('INNER JOIN','rooms','rooms.id = room_has_person.room')
                ->all();
        
        return $rows; 
       }
}
