<?php
    require_once "utils.php";
    if(!isset($_GET['op'])){
        General::returnError("Vous deviez specifier une opération!");
        die();
    }
    if($_GET['op']=='add')
        if(!isset($_POST['nom']) || !isset($_POST['prenom']))
            General::returnError("Tous les champs ne sont pas donnés!");
        else
            General::handleAdd($_POST['prenom'],$_POST['nom']);
    else if($_GET['op']=='edit')
        if(!isset($_POST['nom']) || !isset($_POST['prenom']))
            General::returnError("Tous les champs ne sont pas donnés!");
        else
            General::handleEdit($_POST['id'],$_POST['prenom'],$_POST['nom']);
    else if($_GET['op']=='getAll')
            Student::getAll(General::connect());
    else if($_GET['op']=='delete')
        if(!isset($_POST['id']))
            General::returnError("Tous les champs ne sont pas donnés!");
        else
            General::handleDelete($_POST['id']);
?>