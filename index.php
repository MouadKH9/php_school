<?php
    require_once "partials/utils.php";
    if (session_id() == '' || !isset($_SESSION['conn'])){
        session_start();
    }
    if(!isset($_SESSION['login']))
        header("Location: ./login.php");
?>  
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Panneau de controle</title>
    <link rel='icon' href='res/favicon.ico' type='image/x-icon'>
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="css/index.css">
    <link rel="stylesheet" href="css/confirm.css">
    <link rel="stylesheet" href="css/all.min.css"><!-- Font-Awesome -->
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-light bg-primary">
        <div class="col-sm-3">
            <a class="navbar-brand" href="#">Etudiants</a>
        </div>
        <div class="col-sm-3 offset-sm-6">
        <a title="Deconnexion" style="float:right" href="partials/logout.php">
            <?php echo $_SESSION['login']?>
            <i class="fas fa-sign-out-alt"></i>
        </a>
        </div>
    </nav>
    <div class="container">
        <div class="row showme">
            <div class="table col-xs-12 col-sm-8 offset-sm-2">
            <div class="container controls">
                <div class="row">
                        <div class="container-fluid">
                            <div class="row">
                                <div class="col-sm-3">
                                    <button id="add" type="button" class="btn" data-toggle="modal" data-target="#form">
                                        <i class="fa fa-plus" aria-hidden="true"></i>
                                        Ajouter 
                                    </button>
                                </div>
                                <div class="form-group col-sm-4 offset-sm-1">
                                    <label >Trier :</label> 
                                    <select onchange="refresh(true)" class="form-control" id="sort">
                                        <option value="id" selected>Par id</option>
                                        <option value="nom">Par nom</option>
                                        <option value="prenom">Par prenom</option>
                                    </select>
                                </div>
                                <div class="col-sm-3 offset-sm-1">
                                    <input onkeyup="refresh()" placeholder="Recherche" class="form-control" type="text" id="search">
                                </div>
                            </div>
                    </div>
                </div>
            </div>
            <table class="table table-hover">
                <thead>
                    <tr>
                    <th scope="col">id</th>
                    <th scope="col">Nom</th>
                    <th scope="col">Prénom</th>
                    <th scope="col">Opérations</th>
                    </tr>
                </thead>
                <tbody>
                </tbody>
            </table>
            <div class="row center"><button id="show" class="col-sm-2 offset-sm-5">Show more..</button></div>
            <div class="row empty"><h6>Pas d'étudiants</h6></div>
        </div>
        </div>
    </div>
    <div class="black"></div>
    <div class="modal fade" id="form" tabindex="-1" role="dialog" aria-labelledby="title" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="title">Ajouter un étudiant</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
            <div class="row">
                <div style="width:100%" class="form">
                    <form>
                        <div class="form-group">
                            <label for="nom">Nom</label>
                            <input maxlength="32" name="nom" type="text" aria-described-by="error1" class="form-control" id="nom" placeholder="Nom">
                            <small id="error1" class="form-text text-danger">Le nom ne peut contenir que des lettres.</small>
                        </div>
                        <div class="form-group">
                            <label for="prenom">Prénom</label>
                            <input maxlength="32" name="prenom" type="text" class="form-control" id="prenom" placeholder="Prénom">
                            <small id="error1" class="form-text text-danger">Le prénom ne peut contenir que des lettres.</small>
                        </div>
                        
                    </form>
                </div>
            </div>
            </div>
            <div class="modal-footer">
            <button type="submit" class="valider btn btn-primary">
                            <i class="fa fa-check"></i>
                            <i class="fas fa-spinner"></i>
                            Valider
                        </button>    
            </div>
            </div>
        </div>
    </div>
    <div class="confirm">
        <h1>Confirmer votre action</h1>
        <p>Voulez-vous supprimer l'étudiant #<strong>i</strong> ?</p>
        <button id="cancel">Annuler</button>
        <button onclick="supp(this)" id="confirm" data-id="0">Confirmer</button>
    </div>
</body>
<script src="js/libs/jquery.min.js"></script>
<script src="js/libs/popper.min.js"></script>
<script src="js/libs/bootstrap.min.js"></script>
<script src="js/libs/scrollReveal.js"></script>
<script src="js/main.js"></script>
<script src="js/confirm.js"></script>
</html>