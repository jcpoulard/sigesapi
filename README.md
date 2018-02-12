Liste des méthodes de l'API SIGES 
Version 1.02
Date de derniere modification : 11 fevrier 2018

Glossaire pour API et terminologie SIGES 

=================== CONTEXTE ET GENERALITES SUR L'API ==========================

SIGES est une application web de gestion des ecoles ecrit en PHP/MySQL avec le framework yii version 1, Les clients de logipam sont des ecoles utilisant SIGES et ont un hebergement sur les serveurs de LOGIPAM. 
Chaque client  asa propre base de donnees et sa propre instance de SIGES. L'API presentement developpe vise a faire consommer les donnees des bases des divers clients SIGES par une application mobile ou toute autres application faits par des Tird Party. 
L'API devrait donnees access a la base de donnees des que le nom d'utilisateur et le mot de passe d'un utilisatreur d'un ecole soit authentifie. 
Ce glossaire vise a donner une definition complete et comprehensible des termes et terminilogie adopte dans SIGES et dans l'API.  

SIGES : Système Integré de Gestion Etablissement Scolaire <br/>
users (utilisateurs) : Ensemble des personnes present dans SIGES (Administrateurs scolaire, professeurs, eleves et parents) <br/>

Base de donnees de l'API<br/>
id : element identifiant une table mysql de la base de donnees siges, tous les tables ont pour cle primaire un ID nomme "id", sauf indication speciale.<br/>
code_school : un code attribue a une ecole par l'API (En general le sigle ou le nom courant de l'ecole) <br/>
school_name : Nom de l'ecole au niveau de l'API <br/>
email: Dans le contexte de l'API, email de l'ecole <br/>
is_public : L'ecole est authorisé a consommer l'API <br/>
db_name : Nom de la base de donnees <br/>

<b>Eleves</b> <br/>
student : Object JSON representant un eleve dans l'API, il est retourne par la methode studentid de l'API (voir les details de cette methode). <br/>
id : identifiant unique de l'eleve dans la base de donnees <br/>
username : nom d'utilisateur de l'etudiant (De tous les utilisateurs de SIGES) <br/>
first_name : Prenom de l'eleve <br/>
last_name : Nom de famille de l'eleve<br/>
email : email de l'eleve <br/>
gender : Sexe de l'eleve (1: masculin et 0 : Feminin) <br/>
birthday : date de naissance de l'eleve au format Y-m-d (2012-12-31)<br/>
active : Determine si un eleve est actif (a droit de se connecter) dans SIGES (1: actif [a droit de se connecter], 0 : Inactif (N'a pas droit de se connecter) <br/>
profil_name : Nom du profil de l'eleve dans SIGES. <br/>
group_name : Nom du groupe de l'eleve dans SIGES. <br/>
 


1) URL de l'API 
http://slogipam.com/sigesapi/web/index.php/v1/

2) Méthode fournissant la liste des ecoles ainsi que le nom de leurs bases de données 
http://slogipam.com/sigesapi/web/index.php/v1/client
Aucun paramètre d'envoi necessaire 
retourne les valeurs JSON 
[
  {
    "id": 1,
    "code_school": "cnr",
    "school_db": "siges_cnr",
    "school_name": "College Normalien Reunis",
    "email": "cnr@logipam.com",
    "is_public": 1
  },
  {
    "id": 2,
    "code_school": "demo",
    "school_db": "siges_demo",
    "school_name": "Demo",
    "email": "info@logipam.com",
    "is_public": 1
  },
  {
    "id": 3,
    "code_school": "canado",
    "school_db": "siges_canado",
    "school_name": "Canado",
    "email": "",
    "is_public": 1
  }
]

3) Méthode fournissant les informations sur un élève dans une école du système 
http://slogipam.com/sigesapi/web/index.php/v1/client/studentid
Evoyer les données  via POST 
school_name, username, password 
Retourne un JSON avec ce format 
{
  "student": [
    {
      "id": "207",
      "username": "jean207",
      "first_name": "Jacky",
      "last_name": "Lindor",
      "email": "",
      "gender": "1",
      "birthday": "0000-00-00",
      "active": "1",
      "profil_name": "Guest",
      "group_name": "Student"
    }
  ],
  "db_name": "siges_demo"
}

Jeu de test à utiliser 
school_name = "Demo"
username = "jean207"
password = "test"

4) Méthode retournant l'année académique en cours 
http://slogipam.com/sigesapi/web/index.php/v1/client/currentacademicyear
paramètre POST -> db_name
Jeu de test à utiliser db_name = "siges_demo"
Retourne le JSON 
[
  {
    "id": "6"
  }
]

5) Méthode retournant les notes pour un élève au cours d'une année académique et d'une periode academique
http://slogipam.com/sigesapi/web/index.php/v1/client/studentgrades
paramètre GET -> [db_name, id_student, academic_year, academic_period]
Retourne les valeur JSON pour chaque note 
{
    "id": "38545",
    "student": "20",
    "subject_name": "Compte Rendu de Lecture",
    "short_subject_name": "CRDL",
    "grade_value": "6",
    "weight": "10",
    "name_period": "Période 1",
    "room_name": "Huitième Année",
    "short_room_name": "8e AF",
    "validate": "1",
    "publish": "1",
    "date_created": "2016-11-04 00:00:00",
    "date_updated": "2016-12-20 00:00:00",
    "comment": ""
  },
  
  Une note est visible pour un élève si les valeurs validate et publish sont egales à 1
  
6) Methode retournant les periodes academique au cours d'une annee académique
http://slogipam.com/sigesapi/web/index.php/v1/client/academicperiod
  parametre GET, [db_name, academic_year]
  retourne le JSON 
  
  {
    "id": "10",
    "name_period": "Période 4",
    "date_start": "2017-03-01",
    "date_end": "2017-04-13",
    "is_year": "0",
    "year": "8"
  },

7) Methode retournant les infractions commises par un élève au cours d'une année académique 
http://slogipam.com/sigesapi/web/index.php/v1/client/studentinfraction
paramètre GET, [db_name, id_student, academic_year]
retourne le JSON 

[
    {
        "id": "438",
        "student": "500",
        "name": "Indiscipline I",
        "value_deduction": "5",
        "record_by": "Joseph Mario Jules",
        "incident_date": "2016-09-21",
        "incident_description": "indiscipline legere",
        "decision_description": "",
        "general_comment": ""
    },
    {
        "id": "758",
        "student": "500",
        "name": "Sport",
        "value_deduction": "5",
        "record_by": "Gina Sully",
        "incident_date": "2016-10-27",
        "incident_description": "pas d'uniforme de sport",
        "decision_description": "",
        "general_comment": ""
    },
    
]

  