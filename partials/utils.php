<?php
    class Student{
        var $id;
        var $nom;
        var $prenom;
        /**
         * Constructeur pour initialiser les attributs
         */
        function __construct($id,$prenom,$nom){
            $this->id = $id;
            $this->prenom = $prenom;
            $this->nom = $nom;
        }
        /**
        * Ajouter un etudiant
        */
        public static function add($firstName,$lastName,$conn){
            $stmt = $conn->prepare("INSERT INTO etudiants (nom,prenom) VALUES (? , ?)");
            if(!$stmt) return -2;
            $stmt->bind_param("ss",$lastName,$firstName);
            $stmt->execute();
            $ret = $stmt->affected_rows;
            $stmt->close();
            return $ret;
        }
        /**
         * Modifier les donnees d'un etudiant
         */
        public static function edit($id,$firstName,$lastName,$conn){
            $stmt = $conn->prepare("UPDATE etudiants SET nom = ? , prenom = ? WHERE id = ?");
            if(!$stmt) return -2;
            $stmt->bind_param("ssi",$lastName,$firstName,$id);
            $stmt->execute();
            $ret = $stmt->affected_rows;
            $stmt->close();
            return 1;
        }
        /*
            Retourne la liste des etudiants en format JSON
        */
        public static function getAll($conn){
            if(!isset($_GET['sort'])) $sort = "id";
            else $sort = $_GET['sort'];
            if(!isset($_GET['limit'])) $limit = 20;
            else $limit = $_GET['limit'];
            if(!isset($_GET['search'])) $search = "";
            else $search = "WHERE nom LIKE '%".$_GET['search']
                ."%' OR prenom LIKE '%".$_GET['search']."%'";
            if($res = $conn->query("SELECT * FROM etudiants  $search ORDER BY `etudiants`.`$sort` LIMIT $limit")){
                $data = array();
                while($row = $res->fetch_assoc()){
                    $tmp = new Student($row['id'],$row['prenom'],$row['nom']);
                    array_push($data,$tmp);
                }
                $tmp = $conn->query("SELECT COUNT(*) as count FROM `etudiants`");
                $tmp = $tmp->fetch_assoc();
                $ret = array('status' => 'ok','data' => $data,"count"=>$tmp['count'] );

                echo json_encode($ret);
            }
            else
                General::returnError("Erreur lors de recuperations des etudiants " . $conn->error);
        }

        /**
         * Supprimer un etudiant
         */
        public static function delete($id,$conn){
            $stmt = $conn->prepare("DELETE FROM etudiants WHERE id = ? ");
            if(!$stmt) return -2;
            $stmt->bind_param("i",$id);
            $stmt->execute();
            $ret = $stmt->affected_rows;
            $stmt->close();
            return $ret;
        }


    }
    class General{

        /**
         * Connection a la BDD
         */
        public static function connect(){
            $conn = new mysqli("localhost","root","","school");
            if($conn->connect_error)
                exit('Erreur lors de la connexion a la database');
            return $conn;
        }

         /**
         * On verifie le login d'un admin
         */
        public static function checkLogin($username,$password,$conn){
            $res = $conn->query("SELECT * FROM admins WHERE username = '$username'");
            while ($row = $res->fetch_assoc())
                if(password_verify($password,$row['password'])) return true;
            return false;
        }

        /**
         * Afficher (comme reponse) un JSON d'erreur
         */
        public static function returnError($msg){
            $data = array("status"=>"error","msg"=>$msg);
            echo json_encode($data);
        }

        /**
         * Afficher (comme reponse) un JSON de success
         */
        public static function returnSuccess(){
            $data = array("status"=>"ok");
            echo json_encode($data);
        }

        public static function handleAdd($prenom,$nom){

            if(Student::add($prenom,$nom,General::connect()) > 0)
                General::returnSuccess();
            else
                General::returnError("Erreur lors de l'ajout d'etudiant");
        }
        public static function handleEdit($id,$prenom,$nom){

            if(Student::edit($id,$prenom,$nom,General::connect()) > 0)
                General::returnSuccess();
            else
                General::returnError("Erreur lors de l'ajout d'etudiant");
        }

        public static function handleDelete($id){
            if(Student::delete($id,General::connect()) > 0)
                General::returnSuccess();
            else
                General::returnError("Erreur lors du suppression d'etudiant");
        }
    }
?>
