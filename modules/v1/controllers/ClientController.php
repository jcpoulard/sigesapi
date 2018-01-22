<?php

namespace app\modules\v1\controllers; 
use yii\rest\ActiveController; 
use yii\db\Connection; 
use Yii; 

class ClientController extends ActiveController{
    public $modelClass = 'app\modules\v1\models\Client';
    
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
        $db_name = "siges_cnr";
        $rows = (new \yii\db\Query())
                ->select(['persons.id','last_name','first_name'])
                ->from("$db_name.persons")
                ->all(); 
        
        /*
        $rows = (new \yii\db\Query())
                ->select(['persons.id', 'last_name','first_name','gender','birthday','active','rooms.room_name'])
                ->from('persons')
                ->join('INNER JOIN','room_has_person','room_has_person.students = persons.id')
                ->join('INNER JOIN','rooms','rooms.id = room_has_person.room')
                ->all();
      */
        return $rows; 
       }
       
       public function getSchoolDb($schoolName){
           $schoolDb = (new \yii\db\Query())
                   ->select(['school_db'])
                   ->from('client')
                   ->where(['school_name'=>$schoolName])
                   ->one(); 
           
           return $schoolDb['school_db']; 
       }
       /**
        * Retourne les informations sur les eleves avec le nom de la base de donnees 
        * @return type
        * 
        */
       public function actionStudentid(){
          \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
          $is_key_exist = True;
          $valarray = Yii::$app->request->post(); 
          //$db_name = "Demo";
          if(!empty($valarray)){
              if(!array_key_exists('school_name', $valarray)){
                  $is_key_exist = False;
              }
              if(!array_key_exists('username', $valarray)){
                  $is_key_exist = False;
              }
              if(!array_key_exists('password', $valarray)){
                  $is_key_exist = False;
              }
          if($is_key_exist) {   
          $school_name = $valarray['school_name'];
         // print_r($school_name);
          $username = $valarray['username'];
          $password = $valarray['password'];
          $db_name = $this->getSchoolDb($school_name);
          $studentInfos = (new \yii\db\Query())
                            ->select([$db_name.'.persons.id',$db_name.'.users.username',$db_name.'.persons.first_name',$db_name.'.persons.last_name',$db_name.'.persons.email',$db_name.'.persons.gender',$db_name.'.persons.birthday',$db_name.'.persons.active',$db_name.'.profil.profil_name',$db_name.'.groups.group_name'])
                            ->from("$db_name.users")
                            ->join("INNER JOIN","$db_name.persons","$db_name.persons.id = $db_name.users.person_id")
                            ->join("INNER JOIN","$db_name.profil","$db_name.profil.id = $db_name.users.profil")
                            ->join("INNER JOIN","$db_name.groups","$db_name.groups.id = $db_name.users.group_id")
                            ->where(['username'=>$username,'password'=>md5($password)])
                            ->all(); 
            return array_merge(['student'=>$studentInfos],['db_name'=>$db_name]);                
          }else{
             $studentInfos = ['error'=>'404','errmsg'=>'At least of the Post value not found or spell incorrectly!']; 
             return array_merge(['student'=>$studentInfos],['db_name'=>$db_name]);
          }
           
          }else{
              $studentInfos = ['error'=>'404','errmsg'=>'All the Post value not found !'];
              return array_merge(['student'=>$studentInfos],['db_name'=>$db_name]);
          }
           
           
       }
       
       /**
        * Retourne la note d'un eleve sachant l'annee academique et la periode academique 
        * @return string
        */
       public function actionStudentgrades(){
           \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
           
           $valarray = Yii::$app->request->get();
           $is_key_exist = True;
           if(!empty($valarray)){
               if(!array_key_exists('db_name', $valarray)){
                  $is_key_exist = False;
              }
              if(!array_key_exists('id_student', $valarray)){
                  $is_key_exist = False;
              }
              if(!array_key_exists('academic_year', $valarray)){
                  $is_key_exist = False;
              }
              if(!array_key_exists('academic_period', $valarray)){
                  $is_key_exist = False;
              }
               if($is_key_exist){
                   $db_name = $valarray['db_name'];
                   $id_student = $valarray['id_student'];
                   $academic_year = $valarray['academic_year'];
                   $academic_period = $valarray['academic_period'];
                   $student_grades = (new \yii\db\Query())
                                    ->select(['grades.id','grades.student','subjects.subject_name', 'subjects.short_subject_name','grades.grade_value','courses.weight','academicperiods.name_period','rooms.room_name', 'rooms.short_room_name','grades.validate','grades.publish','grades.date_created','grades.date_updated','grades.comment'])
                                    ->from("$db_name.grades")
                                    ->join("INNER JOIN","$db_name.courses","courses.id = grades.course")
                                    ->join("INNER JOIN","$db_name.subjects","subjects.id = courses.subject")
                                    ->join("INNER JOIN","$db_name.evaluation_by_year","evaluation_by_year.id = grades.evaluation")
                                    ->join("INNER JOIN","$db_name.academicperiods","academicperiods.id = evaluation_by_year.academic_year")
                                    ->join("INNER JOIN","$db_name.rooms","rooms.id = courses.room")
                                    ->where(['grades.student'=>$id_student,'courses.academic_period'=>$academic_year,'academicperiods.id'=>$academic_period])
                                    ->all();
               }else{
                   $student_grades = ['error'=>'404','errmsg'=>'At least of the Post value not found or spell incorrectly!'];
               }
           }else{
               $student_grades = ['error'=>'404','errmsg'=>'All the Post value not found !'];
           }
           return $student_grades;
       }
       
       
       /**
        * Retourne les infractions commises par un eleve au cours d'une année académique 
        * @return string
        */
       public function actionStudentinfraction(){
           \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
           
           $valarray = Yii::$app->request->get();
           $is_key_exist = True;
           if(!empty($valarray)){
               if(!array_key_exists('db_name', $valarray)){
                  $is_key_exist = False;
              }
              if(!array_key_exists('id_student', $valarray)){
                  $is_key_exist = False;
              }
              if(!array_key_exists('academic_year', $valarray)){
                  $is_key_exist = False;
              }
              
               if($is_key_exist){
                   $db_name = $valarray['db_name'];
                   $id_student = $valarray['id_student'];
                   $academic_year = $valarray['academic_year'];
                   $student_infractions = (new \yii\db\Query())
                                    ->select(['record_infraction.id','record_infraction.student','infraction_type.name','record_infraction.value_deduction', 'record_infraction.record_by', 'record_infraction.incident_date', 'record_infraction.incident_description', 'record_infraction.decision_description', 'record_infraction.general_comment'])
                                    ->from("$db_name.record_infraction")
                                    ->join("INNER JOIN","$db_name.infraction_type","infraction_type.id = record_infraction.infraction_type")
                                    ->where(['record_infraction.student'=>$id_student,'record_infraction.academic_period'=>$academic_year])
                                    ->all();
               }else{
                   $student_infractions = ['error'=>'404','errmsg'=>'At least of the Post value not found or spell incorrectly!'];
               }
           }else{
               $student_infractions = ['error'=>'404','errmsg'=>'All the Post value not found !'];
           }
           return $student_infractions;
       }
       
       /**
        * Return the current academic year id 
        * @return string
        */
       public function actionCurrentacademicyear(){
           \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
           
           $valarray = Yii::$app->request->post(); 
           if(!empty($valarray)){
               if(array_key_exists('db_name', $valarray)){
                   $db_name = $valarray['db_name'];
                   $academicYear = (new \yii\db\Query())
                                    ->select('id')
                                    ->from("$db_name.academicperiods")
                                    ->where("date_start <= NOW() AND date_end >= NOW() AND is_year = 1")
                                    ->all();
               }else{
                   $academicYear = ['error'=>'404','errmsg'=>'At least of the Post value not found or spell incorrectly!'];
               }
           }else{
               $academicYear = ['error'=>'404','errmsg'=>'All the Post value not found !'];
           }
           return $academicYear;
       }
       
       /**
        *  Retourne la liste des périodes académique au cours d'une année académique 
        * 
        * @return type
        */
       public function actionAcademicperiod(){
           \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
           $valarray = Yii::$app->request->get();
           $is_key_exist = True;
           if(!empty($valarray)){
               if(!array_key_exists('db_name', $valarray)){
                  $is_key_exist = False;
              }
              if(!array_key_exists('academic_year', $valarray)){
                  $is_key_exist = False;
              }
              
               if($is_key_exist){
                   $db_name = $valarray['db_name'];
                   $academic_year = $valarray['academic_year'];
                   $academicPeriod = (new \yii\db\Query())
                                    ->select(['id','name_period','date_start','date_end','is_year','year'])
                                    ->from("$db_name.academicperiods")
                                    ->where("year = $academic_year AND is_year = 0")
                                    ->all();
               }
           }
           
           return $academicPeriod; 
           
       }
       
       
    
}
