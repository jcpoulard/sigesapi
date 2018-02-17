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
id_student : Refere a l'id d'un eleve dans le SIGES <br/>

<b>Generalites</b><br/>
liste_period : valeur de retour de l'API retournant l'ensemble des periodes academique pour une année en cours. <br/>
academic_period : id d'une periode academique <br/>
 
<b>Student Grades</b><br/>
Definition des valeur de retour de la methode http://slogipam.com/sigesapi/web/index.php/v1/client/studentgrades
student_grade : contient les notes de toutes les matieres d'un eleve pour une periode academique donnees 
id : ID d'une note 
student : ID de l'eleve 
subject_name : Nom de la matiere (nom en forme longue) 
short_subject_name : Nom court de la matiere
grade_value : valeur de la note
weight : coefficient de la note 
name_period : Nom de la periode d'examen 
room_name : Nom de la salle de classe 
short_room_name : Nom en forme courte de la salle de classe 
validate : si la note est deja valider par l'administration elle est a 1, si non a 0 (Une note valider ne peut plus etre modifie par un prof)
publish : Si la note est deja publier elle a 1 si non a 0 (Une note non publiee est invisible aux eleves) 
date_created : Date de creation (saisi de la note) 
date_update : Date updated (modification de la note) 
comment : Commentaire sur la note 

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
code_school, username, password 
Retourne un JSON avec ce format 
{
    "student_info": [
        {
            "id": "248",
            "username": "carlens248",
            "first_name": "Gabriel",
            "last_name": "Alexandre",
            "email": "",
            "gender": "0",
            "birthday": "2008-11-01",
            "active": "2",
            "profil_name": "Guest",
            "group_name": "Student"
        }
    ],
    "db_name": "siges_demo"
}

<b>Jeu de test à utiliser</b>
 
code_school = "demo"
username = "carlens248"
password = "password"

4) Méthode retournant l'année académique en cours 
http://slogipam.com/sigesapi/web/index.php/v1/client/currentacademicyear
paramètre POST -> db_name
Jeu de test à utiliser db_name = "siges_demo"
Retourne le JSON 
{
    "academic_year": [
        {
            "id": "11"
        }
    ]
}

5) Méthode retournant les notes pour un élève au cours d'une année académique et d'une periode academique
http://slogipam.com/sigesapi/web/index.php/v1/client/studentgrades
paramètre GET -> [db_name, id_student, academic_year, academic_period]
Retourne les valeur JSON pour chaque note 

{
    "student_grade": [
        {
            "id": "14969",
            "student": "248",
            "subject_name": "Couture et dessin",
            "short_subject_name": "COED",
            "grade_value": "5",
            "weight": "10",
            "name_period": "Periode 1",
            "room_name": "Première Année",
            "short_room_name": "1ère AF",
            "validate": "1",
            "publish": "1",
            "date_created": "2017-10-02 00:00:00",
            "date_updated": "2017-10-02 00:00:00",
            "comment": ""
        },
        {
            "id": "14987",
            "student": "248",
            "subject_name": "Instruction Religieuse",
            "short_subject_name": "INRE",
            "grade_value": "6",
            "weight": "10",
            "name_period": "Periode 1",
            "room_name": "Première Année",
            "short_room_name": "1ère AF",
            "validate": "1",
            "publish": "1",
            "date_created": "2017-10-02 00:00:00",
            "date_updated": "2017-10-02 00:00:00",
            "comment": ""
        },
        {
            "id": "15005",
            "student": "248",
            "subject_name": "Sport / écriture",
            "short_subject_name": "SP/",
            "grade_value": "8",
            "weight": "10",
            "name_period": "Periode 1",
            "room_name": "Première Année",
            "short_room_name": "1ère AF",
            "validate": "1",
            "publish": "1",
            "date_created": "2017-10-02 00:00:00",
            "date_updated": "2017-10-02 00:00:00",
            "comment": ""
        },
        {
            "id": "15022",
            "student": "248",
            "subject_name": "Production écrite (Français)",
            "short_subject_name": "PR",
            "grade_value": "3",
            "weight": "10",
            "name_period": "Periode 1",
            "room_name": "Première Année",
            "short_room_name": "1ère AF",
            "validate": "1",
            "publish": "1",
            "date_created": "2017-10-02 00:00:00",
            "date_updated": "2017-10-02 00:00:00",
            "comment": ""
        },
        {
            "id": "15040",
            "student": "248",
            "subject_name": "Physique et hygiène",
            "short_subject_name": "PHEH",
            "grade_value": "8",
            "weight": "10",
            "name_period": "Periode 1",
            "room_name": "Première Année",
            "short_room_name": "1ère AF",
            "validate": "1",
            "publish": "1",
            "date_created": "2017-10-02 00:00:00",
            "date_updated": "2017-10-02 00:00:00",
            "comment": ""
        },
        {
            "id": "15058",
            "student": "248",
            "subject_name": "Sciences naturelles",
            "short_subject_name": "SCNA",
            "grade_value": "8",
            "weight": "10",
            "name_period": "Periode 1",
            "room_name": "Première Année",
            "short_room_name": "1ère AF",
            "validate": "1",
            "publish": "1",
            "date_created": "2017-10-02 00:00:00",
            "date_updated": "2017-10-02 00:00:00",
            "comment": ""
        },
        {
            "id": "15076",
            "student": "248",
            "subject_name": "Civique et morale",
            "short_subject_name": "CIEM",
            "grade_value": "16",
            "weight": "20",
            "name_period": "Periode 1",
            "room_name": "Première Année",
            "short_room_name": "1ère AF",
            "validate": "1",
            "publish": "1",
            "date_created": "2017-10-02 00:00:00",
            "date_updated": "2017-10-02 00:00:00",
            "comment": ""
        },
        {
            "id": "15095",
            "student": "248",
            "subject_name": "Connaissances Générales",
            "short_subject_name": "COG",
            "grade_value": "7",
            "weight": "10",
            "name_period": "Periode 1",
            "room_name": "Première Année",
            "short_room_name": "1ère AF",
            "validate": "1",
            "publish": "1",
            "date_created": "2017-10-02 00:00:00",
            "date_updated": "2017-10-02 00:00:00",
            "comment": ""
        },
        {
            "id": "15111",
            "student": "248",
            "subject_name": "Géographie d'Haiti",
            "short_subject_name": "G",
            "grade_value": "5",
            "weight": "10",
            "name_period": "Periode 1",
            "room_name": "Première Année",
            "short_room_name": "1ère AF",
            "validate": "1",
            "publish": "1",
            "date_created": "2017-10-02 00:00:00",
            "date_updated": "2017-10-02 00:00:00",
            "comment": ""
        },
        {
            "id": "15129",
            "student": "248",
            "subject_name": "Histoire d'Haiti",
            "short_subject_name": "HID'",
            "grade_value": "4",
            "weight": "10",
            "name_period": "Periode 1",
            "room_name": "Première Année",
            "short_room_name": "1ère AF",
            "validate": "1",
            "publish": "1",
            "date_created": "2017-10-02 00:00:00",
            "date_updated": "2017-10-02 00:00:00",
            "comment": ""
        },
        {
            "id": "15147",
            "student": "248",
            "subject_name": "Géométrie",
            "short_subject_name": "GEO",
            "grade_value": "2",
            "weight": "10",
            "name_period": "Periode 1",
            "room_name": "Première Année",
            "short_room_name": "1ère AF",
            "validate": "1",
            "publish": "1",
            "date_created": "2017-10-02 00:00:00",
            "date_updated": "2017-10-02 00:00:00",
            "comment": ""
        },
        {
            "id": "15166",
            "student": "248",
            "subject_name": "Problèmes",
            "short_subject_name": "PROB",
            "grade_value": "4",
            "weight": "10",
            "name_period": "Periode 1",
            "room_name": "Première Année",
            "short_room_name": "1ère AF",
            "validate": "1",
            "publish": "1",
            "date_created": "2017-10-02 00:00:00",
            "date_updated": "2017-10-02 00:00:00",
            "comment": ""
        },
        {
            "id": "15184",
            "student": "248",
            "subject_name": "Raisonnement logique NOC",
            "short_subject_name": "RALN",
            "grade_value": "8",
            "weight": "10",
            "name_period": "Periode 1",
            "room_name": "Première Année",
            "short_room_name": "1ère AF",
            "validate": "1",
            "publish": "1",
            "date_created": "2017-10-02 00:00:00",
            "date_updated": "2017-10-02 00:00:00",
            "comment": ""
        },
        {
            "id": "15199",
            "student": "248",
            "subject_name": "Vocabulaire Analyse et conjugaison",
            "short_subject_name": "VAEC",
            "grade_value": "4",
            "weight": "10",
            "name_period": "Periode 1",
            "room_name": "Première Année",
            "short_room_name": "1ère AF",
            "validate": "1",
            "publish": "1",
            "date_created": "2017-10-02 00:00:00",
            "date_updated": "2017-10-02 00:00:00",
            "comment": ""
        },
        {
            "id": "15219",
            "student": "248",
            "subject_name": "Lecture expliquée",
            "short_subject_name": "LEEX",
            "grade_value": "9",
            "weight": "10",
            "name_period": "Periode 1",
            "room_name": "Première Année",
            "short_room_name": "1ère AF",
            "validate": "1",
            "publish": "1",
            "date_created": "2017-10-02 00:00:00",
            "date_updated": "2017-10-02 00:00:00",
            "comment": ""
        },
        {
            "id": "15238",
            "student": "248",
            "subject_name": "Production orale",
            "short_subject_name": "PROR",
            "grade_value": "8",
            "weight": "10",
            "name_period": "Periode 1",
            "room_name": "Première Année",
            "short_room_name": "1ère AF",
            "validate": "1",
            "publish": "1",
            "date_created": "2017-10-02 00:00:00",
            "date_updated": "2017-10-02 00:00:00",
            "comment": ""
        },
        {
            "id": "15257",
            "student": "248",
            "subject_name": "Langues",
            "short_subject_name": "LANG",
            "grade_value": "5",
            "weight": "10",
            "name_period": "Periode 1",
            "room_name": "Première Année",
            "short_room_name": "1ère AF",
            "validate": "1",
            "publish": "1",
            "date_created": "2017-10-02 00:00:00",
            "date_updated": "2017-10-02 00:00:00",
            "comment": ""
        }
    ]
}
  
  Une note est visible pour un élève si les valeurs validate et publish sont egales à 1
  
6) Methode retournant les periodes academique au cours d'une annee académique
http://slogipam.com/sigesapi/web/index.php/v1/client/academicperiod
  parametre GET, [db_name, academic_year]
  academic_year : id de l'annee academique en cours  
  retourne le JSON avec la liste_period 
  
  {
    "liste_period": [
        {
            "id": "12",
            "name_period": "Periode 1",
            "date_start": "2017-09-05",
            "date_end": "2017-10-31",
            "is_year": "0",
            "year": "11"
        },
        {
            "id": "13",
            "name_period": "Période 2",
            "date_start": "2017-11-07",
            "date_end": "2017-12-16",
            "is_year": "0",
            "year": "11"
        },
        {
            "id": "14",
            "name_period": "periode 3",
            "date_start": "2018-01-09",
            "date_end": "2018-03-20",
            "is_year": "0",
            "year": "11"
        },
        {
            "id": "15",
            "name_period": "periode 4",
            "date_start": "2018-03-21",
            "date_end": "2018-06-15",
            "is_year": "0",
            "year": "11"
        }
    ]
}

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

  