<?php
    require_once "partials/utils.php";
    if (session_id() == '' || !isset($_SESSION['conn'])){
        session_start();
    }
    $error = false;
    if(isset($_SESSION['login']))
        header("Location: ./index.php");
    if(isset($_POST['username'])){
        if(General::checkLogin($_POST['username'],$_POST['password'],General::connect())){
            $_SESSION['login'] = $_POST["username"];
            header("Location: ./index.php");
        }else {
            $error = true;
        }

    }
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8" />
    <link rel='icon' href='res/favicon.ico' type='image/x-icon'/ >
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Login</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" media="screen" href="css/login.css" />
    <script src="js/libs/jquery.min.js"></script>
    <script src="js/login.js"></script>
    <link rel="stylesheet" href="css/all.min.css"><!-- Font-Awesome -->
</head>
<body>
<div class="wrapper">
  <form method="post" action="login.php" class="login">
    <p class="title">Log in</p>
    
    <input name="username" type="text" placeholder="Username" autofocus/>
    <i class="fa fa-user"></i>
    <input name="password" type="password" placeholder="Password" />
    <i class="fa fa-key"></i>
    <?php if($error) {?>
    <p style="font-size:12px;text-align:center" class="text-danger">Nom d'utilisateur ou mot de passe incorrect</p>
    <?php } ?>
    <button>
      <i class="spinner"></i>
      <span class="state">Log in</span>
    </button>
  </form>
</div>
</body>
</html>